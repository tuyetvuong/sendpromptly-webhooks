<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifySendPromptlySignature
{
    public function handle(Request $request, Closure $next)
    {
        $secret = config('services.sendpromptly.webhook_secret');
        if (!$secret) {
            abort(500, 'missing_webhook_secret');
        }

        $ts = $request->header('X-SP-Timestamp');
        $sigHeader = $request->header('X-SP-Signature'); // "v1=<hex>"
        if (!$ts || !$sigHeader || !str_contains($sigHeader, '=')) {
            abort(400, 'missing_signature_headers');
        }

        // Timestamp tolerance (replay window)
        $toleranceSeconds = 300;
        $now = time();
        if (!ctype_digit((string)$ts) || abs($now - (int)$ts) > $toleranceSeconds) {
            abort(400, 'stale_webhook');
        }

        // IMPORTANT: raw body only
        $raw = $request->getContent();

        [, $providedSig] = explode('=', $sigHeader, 2);
        $signed = $ts . '.' . $raw;
        $expected = hash_hmac('sha256', $signed, $secret);

        abort_unless(hash_equals($expected, $providedSig), 401, 'invalid_signature');

        return $next($request);
    }
}
