#!/usr/bin/env python3
"""Compute SendPromptly-style webhook signature.

Contract:
  - headers: X-SP-Timestamp, X-SP-Signature: v1=<hex>
  - string_to_sign = "{timestamp}.{raw_body}"
  - signature = HMAC-SHA256(secret, string_to_sign) as hex
"""
import argparse, hmac, hashlib, sys

def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--secret", required=True, help="Webhook signing secret")
    ap.add_argument("--timestamp", required=True, help="Unix timestamp (seconds)")
    ap.add_argument("--body", required=True, help="Raw request body string (exact bytes as received)")
    args = ap.parse_args()

    msg = f"{args.timestamp}.{args.body}".encode("utf-8")
    sig = hmac.new(args.secret.encode("utf-8"), msg, hashlib.sha256).hexdigest()
    print(f"v1={sig}")

if __name__ == "__main__":
    main()
