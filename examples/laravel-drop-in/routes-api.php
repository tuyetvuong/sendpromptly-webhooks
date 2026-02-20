<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\WebhookInbox;
use App\Jobs\ProcessSendPromptlyWebhook;

Route::post('/webhooks/sendpromptly', function (Request $request) {
    $msgId = $request->header('X-SP-Message-Id');
    $eventKey = $request->header('X-SP-Event-Key');
    $ts = $request->header('X-SP-Timestamp');
    $sig = $request->header('X-SP-Signature');

    // Idempotency gate: UNIQUE message_id
    try {
        $row = WebhookInbox::create([
            'message_id' => $msgId ?? ('msg_missing_' . uniqid()),
            'event_key' => $eventKey,
            'signature' => $sig,
            'timestamp' => is_numeric($ts) ? (int)$ts : null,
            'payload' => $request->json()->all(),
            'raw_body' => $request->getContent(),
            'status' => 'pending',
        ]);
    } catch (\Illuminate\Database\QueryException $e) {
        // Duplicate delivery: ACK and stop.
        return response('duplicate', 200);
    }

    // ACK fast (queue the work)
    ProcessSendPromptlyWebhook::dispatch($row->id);

    return response('ok', 200);
})->middleware(['sendpromptly.signature']);
