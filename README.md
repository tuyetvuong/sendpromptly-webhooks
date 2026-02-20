# ⚡ SendPromptly Webhooks — Reference Implementations & Test Vectors

**Product:** https://sendpromptly.com/  
**Developer docs:** https://sendpromptly.com/docs/  
**Guides:** https://sendpromptly.com/docs/guides/  
**API reference:** https://sendpromptly.com/api/reference/

This repo is intentionally **copy/paste friendly**:
- Signed webhook **test vectors** (HMAC-SHA256) you can unit-test against
- Drop-in verification snippets (Laravel / Node / Python)
- Idempotency “inbox table” pattern (replay-safe)
- Retry decision matrix + operational checklist
- Postman collection that auto-signs requests

## 🎯 Canonical guides (money-site deep links)
- Signature cookbook (headers + algorithm + vectors): https://sendpromptly.com/docs/guides/webhook-signature-verification-cookbook/
- Idempotency + dedupe (Laravel): https://sendpromptly.com/docs/guides/webhook-idempotency-dedupe/
- Retry headers + responses: https://sendpromptly.com/docs/guides/webhook-retry-headers-and-responses/
- Replay from delivery log (safely): https://sendpromptly.com/docs/guides/webhook-delivery-log-replay/
- Webhooks overview: https://sendpromptly.com/docs/webhooks/

## ✅ Quick start (local test loop)
1) From repo root, pick a receiver:
   - Node: `examples/node-express`
   - Python: `examples/python-flask`
   - Laravel snippets: `examples/laravel-drop-in`

2) Run Node receiver (terminal 1):
   ```bash
   cd examples/node-express
   cp .env.example .env
   npm i
   npm run start
   ```

3) From repo root, send a signed webhook (terminal 2):
   ```bash
   cd /path/to/sendpromptly-webhooks
   export SP_WEBHOOK_SECRET=whsec_replace_me
   ./scripts/send_local_webhook.sh --url http://localhost:3000/webhooks/sendpromptly \
     --body '{"event_key":"order.created","payload":{"order_id":"O-1001"}}'
   ```

4) From repo root, validate your implementation with test vectors:
   ```bash
   python3 ./scripts/verify_test_vectors.py
   ```

## 🔒 Signature test vectors
- JSON file: `schemas/signature-test-vectors/v1-hmac-sha256.json`
- Contract:
  - `X-SP-Timestamp` (unix seconds)
  - `X-SP-Signature: v1=<hex>`
  - `signature = HMAC_SHA256(secret, "{timestamp}.{raw_body}")` (hex)

## 🌐 GitHub Pages (for shareable docs)
This repo includes a small GitHub Pages site under `/docs` with:
- `<link rel="canonical">` pointing to `sendpromptly.com`
- `noindex,follow` by default (so it won’t compete in SERPs)

Setup steps are in: **`README-USAGE.md`**.

## 🔁 Backlink playbook
See: `docs/backlink-playbook.md`

---
Built by Devicode: https://devicode.com/
