import os, time, hmac, hashlib
from flask import Flask, request
from dotenv import load_dotenv

load_dotenv()
app = Flask(__name__)

SECRET = os.getenv("SP_WEBHOOK_SECRET", "")
PORT = int(os.getenv("PORT", "5000"))

def timing_safe_equal(a: str, b: str) -> bool:
    return hmac.compare_digest(a.encode("utf-8"), b.encode("utf-8"))

@app.post("/webhooks/sendpromptly")
def webhook():
    if not SECRET:
        return ("Missing SP_WEBHOOK_SECRET", 500)

    ts = request.headers.get("X-SP-Timestamp")
    sig_header = request.headers.get("X-SP-Signature")  # v1=<hex>
    msg_id = request.headers.get("X-SP-Message-Id")

    if not ts or not sig_header or "=" not in sig_header:
        return ("Missing signature headers", 400)

    provided = sig_header.split("=", 1)[1]
    raw_body = request.get_data(cache=False, as_text=True)  # raw bytes -> utf-8 text

    # Timestamp tolerance
    tolerance = 300
    now = int(time.time())
    try:
        ts_num = int(ts)
    except ValueError:
        return ("Bad timestamp", 400)

    if abs(now - ts_num) > tolerance:
        return ("Stale webhook", 400)

    signed = f"{ts}.{raw_body}".encode("utf-8")
    expected = hmac.new(SECRET.encode("utf-8"), signed, hashlib.sha256).hexdigest()

    if not timing_safe_equal(expected, provided):
        return ("Invalid signature", 401)

    print("✅ Verified webhook", {"ts": ts, "msg_id": msg_id, "bytes": len(raw_body)})
    return ("ok", 200)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=PORT, debug=True)
