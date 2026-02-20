---
title: Launch Kit (Show HN / Product Hunt)
canonical_path: /docs/guides/
---

# Launch kit (resource-first)

The key: **share a solution**, not a product pitch.

## Show HN draft
**Title:** Show HN: A guide + boilerplate for reliable webhook consumers (signatures, idempotency, retries)

**Body (post):**
- Many webhook docs show the happy path but skip failure modes (raw body bugs, replays, duplicate deliveries, retry storms).
- This repo includes:
  - HMAC-SHA256 signature test vectors
  - Drop-in middleware (Laravel / Node / Python)
  - Idempotent inbox pattern + replay-safe checklist
  - Postman collection that auto-signs requests

Repo: (your GitHub URL)  
Canonical docs: https://sendpromptly.com/docs/guides/

## Product Hunt positioning
**Tagline:** The missing manual for secure, replay-safe, idempotent webhooks.

**Maker comment (first reply):**
We built a reference kit for webhook consumers: signature verification test vectors + copy/paste middleware + retry-safe idempotency patterns.
It’s designed to reduce “why is this broken?” debugging time and make replays safe.

What language should we add next (Go/Ruby/Rust/C#)?
