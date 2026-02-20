#!/usr/bin/env bash
set -euo pipefail

# Send a locally-signed webhook to a receiver (Node/Python/Laravel).
#
# Requires:
#   - jq (optional; only used to compact JSON if you choose)
#
# Usage:
#   SP_WEBHOOK_SECRET=whsec_xxx ./scripts/send_local_webhook.sh \
#     --url http://localhost:3000/webhooks/sendpromptly \
#     --body '{"event_key":"order.created","payload":{"order_id":"O-1001"}}'
#
# Notes:
#   - Signature must be computed over the EXACT body bytes you send.
#   - Do NOT reformat JSON between signing and sending.

URL=""
BODY=""

while [[ $# -gt 0 ]]; do
  case "$1" in
    --url) URL="$2"; shift 2;;
    --body) BODY="$2"; shift 2;;
    *) echo "Unknown arg: $1"; exit 1;;
  esac
done

if [[ -z "${URL}" || -z "${BODY}" ]]; then
  echo "Usage: SP_WEBHOOK_SECRET=... $0 --url <url> --body '<rawBody>'"
  exit 1
fi

if [[ -z "${SP_WEBHOOK_SECRET:-}" ]]; then
  echo "Missing env var: SP_WEBHOOK_SECRET"
  exit 1
fi

TS="$(date +%s)"
SIG="$(python3 ./scripts/compute_signature.py --secret "${SP_WEBHOOK_SECRET}" --timestamp "${TS}" --body "${BODY}")"

echo "POST ${URL}"
echo "X-SP-Timestamp: ${TS}"
echo "X-SP-Signature: ${SIG}"

curl -i -X POST "${URL}"       -H "Content-Type: application/json"       -H "X-SP-Timestamp: ${TS}"       -H "X-SP-Signature: ${SIG}"       -H "X-SP-Message-Id: msg_local_$(date +%s)"       --data "${BODY}"
