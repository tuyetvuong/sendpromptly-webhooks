<?php

namespace App\Jobs;

use App\Models\WebhookInbox;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSendPromptlyWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $inboxId) {}

    public function handle(): void
    {
        $row = WebhookInbox::findOrFail($this->inboxId);

        // TODO: implement your business logic here.
        // Keep it retry-safe. If you throw, make sure you're not re-applying side effects.

        $row->status = 'completed';
        $row->processed_at = now();
        $row->save();
    }
}
