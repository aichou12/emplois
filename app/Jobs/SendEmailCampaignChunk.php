<?php

namespace App\Jobs;

use App\Mail\AdminCampaignEmail;
use App\Models\AdminEmailCampaign;
use App\Models\AdminEmailCampaignRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaignChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public int $campaignId, public array $recipientIds)
    {
    }

    public function handle(): void
    {
        $campaign = AdminEmailCampaign::find($this->campaignId);
        if (!$campaign) {
            return;
        }

        if ($campaign->status === 'queued') {
            $campaign->update(['status' => 'sending']);
        }

        AdminEmailCampaignRecipient::query()
            ->where('campaign_id', $campaign->id)
            ->whereIn('id', $this->recipientIds)
            ->where('status', 'pending')
            ->orderBy('id')
            ->get()
            ->each(function (AdminEmailCampaignRecipient $recipient) use ($campaign) {
                try {
                    Mail::to($recipient->email)->send(new AdminCampaignEmail($campaign->subject, $campaign->body));
                    $recipient->update(['status' => 'sent', 'sent_at' => now(), 'error_message' => null]);
                } catch (\Throwable $exception) {
                    report($exception);
                    $recipient->update([
                        'status' => 'failed',
                        'error_message' => mb_substr($exception->getMessage(), 0, 4000),
                    ]);
                }
            });

        $campaign->refresh();
        $campaign->sent_count = $campaign->recipients()->where('status', 'sent')->count();
        $campaign->failed_count = $campaign->recipients()->where('status', 'failed')->count();
        $pendingCount = $campaign->recipients()->where('status', 'pending')->count();
        if ($pendingCount === 0) {
            $campaign->status = $campaign->failed_count > 0 ? 'completed_with_errors' : 'sent';
            $campaign->completed_at = now();
        }
        $campaign->save();
    }
}
