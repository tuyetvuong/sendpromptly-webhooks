---
title: Idempotent Inbox Pattern
canonical_path: /docs/guides/webhook-idempotency-dedupe/
---

# Idempotent inbox pattern

Canonical guide: https://sendpromptly.com/docs/guides/webhook-idempotency-dedupe/

## Minimal workflow
1) Verify signature
2) Insert a row with a **UNIQUE** key (prefer `X-SP-Message-Id`)
3) If UNIQUE violation → duplicate → return **2xx**
4) Queue async processing
5) Mark completed / DLQ poison events

See Laravel migration + job stub:
- `examples/laravel-drop-in/create_webhook_inbox_table.php`
- `examples/laravel-drop-in/ProcessSendPromptlyWebhook.php`
