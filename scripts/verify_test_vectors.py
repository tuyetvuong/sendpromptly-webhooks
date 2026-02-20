#!/usr/bin/env python3
import json, hmac, hashlib, sys
from pathlib import Path

VECTORS = Path(__file__).resolve().parents[1] / "schemas" / "signature-test-vectors" / "v1-hmac-sha256.json"

def main():
    doc = json.loads(VECTORS.read_text(encoding="utf-8"))
    secret = doc["secret_example"]
    ok = True
    for v in doc["vectors"]:
        msg = (v["timestamp"] + "." + v["raw_body"]).encode("utf-8")
        expected = hmac.new(secret.encode("utf-8"), msg, hashlib.sha256).hexdigest()
        if expected != v["expected_signature_hex"]:
            ok = False
            print("Mismatch:", v["name"])
    if not ok:
        sys.exit(1)
    print("OK: all test vectors match")

if __name__ == "__main__":
    main()
