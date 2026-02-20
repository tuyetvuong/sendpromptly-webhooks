#!/usr/bin/env node
/**
 * Compute SendPromptly-style webhook signature.
 * Contract:
 *  - headers: X-SP-Timestamp, X-SP-Signature: v1=<hex>
 *  - string_to_sign = `${timestamp}.${rawBody}`
 *  - signature = HMAC-SHA256(secret, string_to_sign) as hex
 */
const crypto = require("crypto");

function parseArg(flag) {
  const idx = process.argv.indexOf(flag);
  return idx >= 0 ? process.argv[idx + 1] : null;
}

const secret = parseArg("--secret");
const ts = parseArg("--timestamp");
const body = parseArg("--body");

if (!secret || !ts || body === null) {
  console.error("Usage: node compute_signature.js --secret <secret> --timestamp <ts> --body '<rawBody>'");
  process.exit(1);
}

const signed = `${ts}.${body}`;
const sig = crypto.createHmac("sha256", secret).update(signed, "utf8").digest("hex");
console.log(`v1=${sig}`);
