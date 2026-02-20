# Laravel drop-in (SendPromptly-style signed webhooks)

This folder is intentionally **copy/paste-friendly**. It is not a full Laravel app.

## Files
- `VerifySendPromptlySignature.php` — middleware (raw-body + HMAC + timestamp tolerance)
- `create_webhook_inbox_table.php` — inbox table migration (idempotency)
- `WebhookInbox.php` — model for inbox rows
- `routes-api.php` — example route + controller closure
- `ProcessSendPromptlyWebhook.php` — job stub (ACK-fast pattern)

## Recommended receiver flow (production)
1) Verify signature (middleware)
2) Insert inbox row with UNIQUE key (idempotency)
3) Return **2xx** quickly (ACK)
4) Process async (queue)
5) Mark complete / DLQ on poison events

See the canonical docs:
- Signature cookbook: https://sendpromptly.com/docs/guides/webhook-signature-verification-cookbook/
- Idempotency + dedupe: https://sendpromptly.com/docs/guides/webhook-idempotency-dedupe/
- Retry headers + responses: https://sendpromptly.com/docs/guides/webhook-retry-headers-and-responses/
