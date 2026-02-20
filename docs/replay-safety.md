---
title: Replay Safety Checklist
canonical_path: /docs/guides/webhook-delivery-log-replay/
---

# Replay safety checklist

Canonical guide: https://sendpromptly.com/docs/guides/webhook-delivery-log-replay/

## Before you replay
- Confirm your handler is idempotent (unique key / inbox row)
- Confirm the bugfix is deployed
- Confirm the replay window (what range of deliveries)
- Confirm side effects are safe (no double-charge, no double-email)

## During replay
- Start small (1–10) then scale
- Monitor error rate and queue depth
- Stop if you see duplicates

## After replay
- Audit: count of replays vs completions
- Preserve correlation IDs in logs
