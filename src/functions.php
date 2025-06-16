<?php

function generateVerificationCode() {
    return strval(rand(100000, 999999));
}

function sendVerificationEmail($email, $code) {
    $subject = "Your Verification Code";
    $message = "<p>Your verification code is: <strong>$code</strong></p>";
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-Type: text/html\r\n";

    // For local testing: show the code instead of sending email
    echo "<div style='padding:10px;border:2px solid green;margin:10px 0;'>
            <strong>Debug Mode:</strong> Verification code sent to <b>$email</b>: <strong>$code</strong>
          </div>";

    // Uncomment below only if SMTP is correctly working
    // mail($email, $subject, $message, $headers);
}


function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!in_array($email, $emails)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
    }
}
