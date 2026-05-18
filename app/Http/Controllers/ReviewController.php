<?php

namespace App\Http\Controllers;

use App\Mail\ReviewOtpMail;
use App\Models\EmailSubscriber;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $key = 'review-submit:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'message' => 'Troppe richieste. Riprova tra qualche minuto.',
            ], 429);
        }
        RateLimiter::hit($key, 600);

        $data = $request->validate([
            'name'              => ['required', 'string', 'max:60'],
            'surname'           => ['nullable', 'string', 'max:60'],
            'email'             => ['required', 'email:rfc', 'max:120'],
            'rating'            => ['required', 'integer', 'min:1', 'max:5'],
            'text'              => ['required', 'string', 'min:10', 'max:1500'],
            'consent_marketing' => ['nullable', 'boolean'],
        ], [
            'name.required'    => 'Il nome è obbligatorio.',
            'name.max'         => 'Il nome è troppo lungo (max 60 caratteri).',
            'surname.max'      => 'Il cognome è troppo lungo (max 60 caratteri).',
            'email.required'   => "L'email è obbligatoria.",
            'email.email'      => "Inserisci un indirizzo email valido.",
            'email.max'        => "L'email è troppo lunga.",
            'rating.required'  => 'Seleziona una valutazione da 1 a 5 stelle.',
            'rating.min'       => 'La valutazione deve essere tra 1 e 5.',
            'rating.max'       => 'La valutazione deve essere tra 1 e 5.',
            'text.required'    => 'Scrivi il testo della recensione.',
            'text.min'         => 'La recensione deve contenere almeno 10 caratteri.',
            'text.max'         => 'La recensione è troppo lunga (max 1500 caratteri).',
        ]);

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $review = Review::create([
            'name'              => trim($data['name']),
            'surname'           => isset($data['surname']) ? trim($data['surname']) : null,
            'email'             => strtolower(trim($data['email'])),
            'rating'            => $data['rating'],
            'text'              => trim($data['text']),
            'otp_code'          => $code,
            'otp_expires_at'    => now()->addMinutes(15),
            'consent_marketing' => (bool) ($data['consent_marketing'] ?? false),
        ]);

        try {
            Mail::to($review->email)->send(new ReviewOtpMail($code, $review->name));
        } catch (\Throwable $e) {
            report($e);
            $review->delete();
            return response()->json([
                'message' => "Impossibile inviare l'email. Verifica l'indirizzo e riprova.",
            ], 500);
        }

        return response()->json([
            'review_id' => $review->id,
            'message'   => 'Codice di verifica inviato. Controlla la tua email.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'review_id' => ['required', 'integer'],
            'otp'       => ['required', 'string', 'size:6'],
        ]);

        $review = Review::find($data['review_id']);
        if (! $review) {
            return response()->json(['message' => 'Recensione non trovata.'], 404);
        }

        if ($review->email_verified_at) {
            return response()->json(['message' => 'Email già verificata.'], 400);
        }

        if (! $review->otp_expires_at || $review->otp_expires_at->isPast()) {
            return response()->json(['message' => 'Codice scaduto. Invia di nuovo la recensione.'], 400);
        }

        if ($review->otp_attempts >= 5) {
            return response()->json(['message' => 'Troppi tentativi errati. Invia di nuovo la recensione.'], 429);
        }

        if (! hash_equals((string) $review->otp_code, (string) $data['otp'])) {
            $review->increment('otp_attempts');
            return response()->json(['message' => 'Codice errato.'], 400);
        }

        $review->update([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
        ]);

        if ($review->consent_marketing) {
            $this->subscribeFromReview($review, $request);
        }

        return response()->json([
            'message' => 'Grazie! La tua recensione è stata inviata e sarà pubblicata dopo la revisione.',
        ]);
    }

    private function subscribeFromReview(Review $review, Request $request): void
    {
        $existing = EmailSubscriber::where('email', $review->email)->first();

        if ($existing) {
            if ($existing->unsubscribed_at) {
                return;
            }
            if (! $existing->consent_at) {
                $existing->update([
                    'name'       => $existing->name ?: trim($review->name . ' ' . ($review->surname ?? '')),
                    'source'     => 'review',
                    'consent_ip' => $request->ip(),
                    'consent_at' => now(),
                ]);
            }
            return;
        }

        EmailSubscriber::create([
            'email'             => $review->email,
            'name'              => trim($review->name . ' ' . ($review->surname ?? '')),
            'source'            => 'review',
            'consent_ip'        => $request->ip(),
            'consent_at'        => now(),
            'unsubscribe_token' => Str::random(48),
        ]);
    }

    public function resendOtp(Request $request)
    {
        $key = 'review-resend:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json(['message' => 'Troppe richieste.'], 429);
        }
        RateLimiter::hit($key, 300);

        $data = $request->validate(['review_id' => ['required', 'integer']]);

        $review = Review::find($data['review_id']);
        if (! $review || $review->email_verified_at) {
            return response()->json(['message' => 'Operazione non valida.'], 400);
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $review->update([
            'otp_code'       => $code,
            'otp_expires_at' => now()->addMinutes(15),
            'otp_attempts'   => 0,
        ]);

        try {
            Mail::to($review->email)->send(new ReviewOtpMail($code, $review->name));
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['message' => 'Impossibile inviare il codice.'], 500);
        }

        return response()->json(['message' => 'Nuovo codice inviato.']);
    }
}
