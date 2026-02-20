    <?php
    /**
     * Compute SendPromptly-style webhook signature.
     * Usage:
     *   php compute_signature.php --secret=... --timestamp=... --body='...'
     */
    $opts = getopt("", ["secret:", "timestamp:", "body:"]);
    if (!isset($opts["secret"], $opts["timestamp"], $opts["body"])) {
        fwrite(STDERR, "Usage: php compute_signature.php --secret=... --timestamp=... --body='...'
");
        exit(1);
    }

    $secret = $opts["secret"];
    $ts = $opts["timestamp"];
    $body = $opts["body"];

    $signed = $ts . "." . $body;
    $sig = hash_hmac("sha256", $signed, $secret);
    echo "v1=" . $sig . PHP_EOL;
