---
title: Retry Decision Matrix
canonical_path: /docs/guides/webhook-retry-headers-and-responses/
---

# Retry decision matrix

Canonical guide: https://sendpromptly.com/docs/guides/webhook-retry-headers-and-responses/

## Safe defaults
| Endpoint outcome | Your response | Provider behavior | Why |
|---|---:|---|---|
| Accepted + durable | **2xx** | stop retrying | you’ve taken responsibility |
| Validation failure (schema mismatch) | **4xx** | usually stop | retry won’t fix bad payload |
| Auth/signature failure | **401/403** | stop | wrong secret / header mapping |
| Rate limited | **429** (+ Retry-After) | retry later | backpressure |
| Transient dependency error | **5xx** or timeout | retry | recoverable |

## Operational notes
- ACK fast (queue work). Don’t “work harder” in the request.
- Idempotency is required for safe retries.
