# Usage & Publishing Notes

This file covers practical setup for this repo's shareable docs and local webhook loop.

## Local validation checklist
Run these from repo root:

```bash
python3 ./scripts/verify_test_vectors.py
```

```bash
SP_WEBHOOK_SECRET=whsec_replace_me ./scripts/send_local_webhook.sh \
  --url http://localhost:3000/webhooks/sendpromptly \
  --body '{"event_key":"order.created","payload":{"order_id":"O-1001"}}'
```

## GitHub Pages setup (`/docs`)
1. Push this repository to GitHub.
2. Open `Settings` -> `Pages`.
3. Set Source to `Deploy from a branch`.
4. Choose branch `main` and folder `/docs`.
5. Save and wait for Pages to build.

## Why this does not compete with canonical docs
- `docs/_layouts/default.html` sets canonical tags to `https://sendpromptly.com`.
- `docs/_layouts/default.html` defaults to `noindex,follow`.

This keeps the Pages site useful for sharing while preserving SEO authority on `sendpromptly.com`.
