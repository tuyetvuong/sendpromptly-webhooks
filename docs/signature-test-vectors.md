---
title: Signature Verification Test Vectors
canonical_path: /docs/guides/webhook-signature-verification-cookbook/
---

# Signature verification test vectors (HMAC-SHA256)

Canonical guide: https://sendpromptly.com/docs/guides/webhook-signature-verification-cookbook/

Repo file:
- `schemas/signature-test-vectors/v1-hmac-sha256.json`

## Contract (SendPromptly-style)
- `X-SP-Timestamp`: unix timestamp (seconds)
- `X-SP-Signature: v1=<hex>`
- `string_to_sign = "{timestamp}.{raw_body}"`
- `signature = HMAC_SHA256(secret, string_to_sign)` as **hex**

## Quick verify
```bash
python3 scripts/verify_test_vectors.py
```
