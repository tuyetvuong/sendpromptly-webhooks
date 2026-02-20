const express = require("express");
const crypto = require("crypto");
require("dotenv").config();

const app = express();
const PORT = process.env.PORT || 3000;
const SECRET = process.env.SP_WEBHOOK_SECRET || "";

// IMPORTANT: Use raw body for signature verification.
// This keeps exact bytes (no JSON parsing/re-encoding).
app.post("/webhooks/sendpromptly", express.raw({ type: "*/*" }), (req, res) => {
  try {
    const ts = req.header("X-SP-Timestamp");
    const sigHeader = req.header("X-SP-Signature"); // "v1=<hex>"
    const msgId = req.header("X-SP-Message-Id") || null;

    if (!SECRET) return res.status(500).send("Missing SP_WEBHOOK_SECRET");
    if (!ts || !sigHeader || !sigHeader.includes("=")) return res.status(400).send("Missing signature headers");

    const provided = sigHeader.split("=", 2)[1];
    const rawBody = req.body.toString("utf8");

    // Timestamp tolerance (replay window)
    const toleranceSeconds = 300;
    const now = Math.floor(Date.now() / 1000);
    const tsNum = parseInt(ts, 10);
    if (!Number.isFinite(tsNum) || Math.abs(now - tsNum) > toleranceSeconds) {
      return res.status(400).send("Stale webhook");
    }

    const signed = `${ts}.${rawBody}`;
    const expected = crypto.createHmac("sha256", SECRET).update(signed, "utf8").digest("hex");

    // Constant-time compare
    const a = Buffer.from(expected, "utf8");
    const b = Buffer.from(provided, "utf8");
    if (a.length !== b.length || !crypto.timingSafeEqual(a, b)) {
      return res.status(401).send("Invalid signature");
    }

    // Idempotency sketch (demo)
    // In real systems: store msgId (or payload event id) in DB with UNIQUE constraint.
    console.log("✅ Verified webhook", { ts, msgId, bytes: req.body.length });

    // ACK fast. Do not block on heavy work.
    return res.status(200).send("ok");
  } catch (e) {
    console.error(e);
    return res.status(500).send("error");
  }
});

app.listen(PORT, () => console.log(`Listening on http://localhost:${PORT}`));
