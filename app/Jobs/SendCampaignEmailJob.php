<?php

namespace App\Jobs;

use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailSubscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmailJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;
    public int $timeout = 120;

    public function __construct(
        public int $campaignId,
        public int $subscriberId,
    ) {
    }

    public function handle(): void
    {
        $campaign   = EmailCampaign::find($this->campaignId);
        $subscriber = EmailSubscriber::find($this->subscriberId);

        if (! $campaign || ! $subscriber) {
            return;
        }

        if ($subscriber->unsubscribed_at) {
            return;
        }

        if (in_array($campaign->status, ['queued', 'sending'], true) && ! $campaign->started_at) {
            $campaign->update(['status' => 'sending', 'started_at' => now()]);
        }

        Mail::to($subscriber->email)->send(new CampaignMail($campaign, $subscriber));

        DB::transaction(function () use ($campaign) {
            $fresh = EmailCampaign::lockForUpdate()->find($campaign->id);
            $fresh->increment('sent_count');
            if (($fresh->sent_count + $fresh->failed_count) >= $fresh->total_recipients) {
                $fresh->update(['status' => 'sent', 'finished_at' => now()]);
            }
        });
    }

    public function failed(\Throwable $e): void
    {
        DB::transaction(function () {
            $fresh = EmailCampaign::lockForUpdate()->find($this->campaignId);
            if (! $fresh) {
                return;
            }
            $fresh->increment('failed_count');
            if (($fresh->sent_count + $fresh->failed_count) >= $fresh->total_recipients) {
                $fresh->update([
                    'status'      => $fresh->sent_count > 0 ? 'sent' : 'failed',
                    'finished_at' => now(),
                ]);
            }
        });
    }
}
