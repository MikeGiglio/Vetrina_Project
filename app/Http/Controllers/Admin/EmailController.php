<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendCampaignEmailJob;
use App\Models\EmailCampaign;
use App\Models\EmailSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function index()
    {
        $campaigns = EmailCampaign::with('creator')
            ->orderByDesc('created_at')
            ->paginate(10);

        $stats = [
            'total'        => EmailSubscriber::count(),
            'active'       => EmailSubscriber::whereNull('unsubscribed_at')->count(),
            'unsubscribed' => EmailSubscriber::whereNotNull('unsubscribed_at')->count(),
        ];

        return view('admin.email.index', compact('campaigns', 'stats'));
    }

    public function subscribers(Request $request)
    {
        $filter = $request->query('filter', 'active');

        $query = EmailSubscriber::query();
        if ($filter === 'active') {
            $query->whereNull('unsubscribed_at');
        } elseif ($filter === 'unsubscribed') {
            $query->whereNotNull('unsubscribed_at');
        }

        $subscribers = $query->orderByDesc('created_at')->paginate(25)->withQueryString();

        $counts = [
            'all'          => EmailSubscriber::count(),
            'active'       => EmailSubscriber::whereNull('unsubscribed_at')->count(),
            'unsubscribed' => EmailSubscriber::whereNotNull('unsubscribed_at')->count(),
        ];

        return view('admin.email.subscribers', compact('subscribers', 'filter', 'counts'));
    }

    public function storeSubscriber(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc', 'max:150'],
            'name'  => ['nullable', 'string', 'max:120'],
        ]);

        $email = strtolower(trim($data['email']));

        $existing = EmailSubscriber::where('email', $email)->first();
        if ($existing) {
            if ($existing->unsubscribed_at) {
                return back()->with('error', 'Questa email si è precedentemente disiscritta. Non può essere re-iscritta senza il suo consenso esplicito.');
            }
            return back()->with('error', 'Questa email è già presente nella lista.');
        }

        EmailSubscriber::create([
            'email'             => $email,
            'name'              => isset($data['name']) ? trim($data['name']) : null,
            'source'            => 'manual',
            'consent_ip'        => $request->ip(),
            'consent_at'        => now(),
            'unsubscribe_token' => Str::random(48),
        ]);

        return back()->with('success', 'Iscritto aggiunto.');
    }

    public function importSubscribers(Request $request)
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $handle = fopen($request->file('csv')->getRealPath(), 'r');
        if (! $handle) {
            return back()->with('error', 'Impossibile leggere il file.');
        }

        $added = 0;
        $skipped = 0;
        $firstLine = true;

        while (($row = fgetcsv($handle)) !== false) {
            if (! $row || count($row) === 0) continue;

            $email = strtolower(trim($row[0] ?? ''));
            if ($firstLine && (! filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $firstLine = false;
                continue;
            }
            $firstLine = false;

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skipped++;
                continue;
            }

            $name = isset($row[1]) ? trim($row[1]) : null;

            if (EmailSubscriber::where('email', $email)->exists()) {
                $skipped++;
                continue;
            }

            EmailSubscriber::create([
                'email'             => $email,
                'name'              => $name ?: null,
                'source'            => 'import',
                'consent_ip'        => $request->ip(),
                'consent_at'        => now(),
                'unsubscribe_token' => Str::random(48),
            ]);
            $added++;
        }

        fclose($handle);

        return back()->with('success', "Import completato: $added aggiunti, $skipped saltati.");
    }

    public function destroySubscriber(EmailSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Iscritto eliminato.');
    }

    public function compose()
    {
        $activeCount = EmailSubscriber::whereNull('unsubscribed_at')->count();
        return view('admin.email.compose', compact('activeCount'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'subject'         => ['required', 'string', 'max:200'],
            'body'            => ['required', 'string', 'max:100000'],
            'body_format'     => ['required', 'in:html,text'],
            'confirm'         => ['accepted'],
            'recipients_mode' => ['required', 'in:all,specific'],
            'emails'          => ['nullable', 'array', 'max:2000'],
            'emails.*'        => ['nullable', 'email:rfc', 'max:150'],
        ]);

        if ($data['recipients_mode'] === 'all') {
            $subscribers = EmailSubscriber::whereNull('unsubscribed_at')->get();
            $skippedUnsub = 0;
            $createdNew   = 0;
        } else {
            [$subscribers, $skippedUnsub, $createdNew] = $this->resolveSpecificRecipients($data['emails'] ?? [], $request);
        }

        if ($subscribers->isEmpty()) {
            return back()->with('error',
                $data['recipients_mode'] === 'specific'
                    ? 'Nessun destinatario valido (tutti vuoti, non validi o disiscritti).'
                    : 'Nessun iscritto attivo a cui inviare.'
            )->withInput();
        }

        $campaign = EmailCampaign::create([
            'subject'          => $data['subject'],
            'body'             => $data['body'],
            'body_format'      => $data['body_format'],
            'created_by'       => auth()->id(),
            'total_recipients' => $subscribers->count(),
            'status'           => 'queued',
        ]);

        $delaySeconds = 3;
        foreach ($subscribers as $i => $subscriber) {
            SendCampaignEmailJob::dispatch($campaign->id, $subscriber->id)
                ->delay(now()->addSeconds($i * $delaySeconds));
        }

        $msg = "Campagna in coda: {$campaign->total_recipients} email verranno inviate progressivamente.";
        if ($skippedUnsub > 0) {
            $msg .= " {$skippedUnsub} indirizzo/i disiscritto/i sono stati saltati.";
        }
        if ($createdNew > 0) {
            $msg .= " {$createdNew} nuovo/i iscritto/i aggiunto/i alla lista.";
        }

        return redirect()->route('admin.email.index')->with('success', $msg);
    }

    private function resolveSpecificRecipients(array $rawEmails, Request $request): array
    {
        $emails = collect($rawEmails)
            ->map(fn ($e) => strtolower(trim((string) $e)))
            ->filter(fn ($e) => $e !== '' && filter_var($e, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();

        if ($emails->isEmpty()) {
            return [collect(), 0, 0];
        }

        $existing     = EmailSubscriber::whereIn('email', $emails)->get()->keyBy('email');
        $skippedUnsub = 0;
        $createdNew   = 0;
        $recipients   = collect();

        foreach ($emails as $email) {
            $sub = $existing->get($email);

            if ($sub) {
                if ($sub->unsubscribed_at) {
                    $skippedUnsub++;
                    continue;
                }
                $recipients->push($sub);
                continue;
            }

            $new = EmailSubscriber::create([
                'email'             => $email,
                'source'            => 'manual',
                'consent_ip'        => $request->ip(),
                'consent_at'        => now(),
                'unsubscribe_token' => Str::random(48),
            ]);
            $recipients->push($new);
            $createdNew++;
        }

        return [$recipients, $skippedUnsub, $createdNew];
    }

    public function showCampaign(EmailCampaign $campaign)
    {
        return view('admin.email.campaign', compact('campaign'));
    }
}
