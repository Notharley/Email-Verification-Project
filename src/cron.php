<?php
require_once 'functions.php';

function fetchGitHubTimeline() {
    // Placeholder content — you can fetch real data via GitHub API later
    return "<ul>
        <li><b>testuser1</b> pushed to <i>main</i> at <code>example-repo</code></li>
        <li><b>testuser2</b> opened a pull request on <code>example-repo</code></li>
    </ul>";
}

function formatGitHubData($data) {
    return "
    <html>
    <body>
        <h2>GitHub Timeline Updates</h2>
        $data
        <br><br>
        <a id='unsubscribe-button' href='http://localhost:8000/unsubscribe.php'>Unsubscribe</a>
    </body>
    </html>
    ";
}

function sendGitHubUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) {
        echo "No registered users.\n";
        return;
    }

    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $data = fetchGitHubTimeline();
    $formatted = formatGitHubData($data);

    foreach ($emails as $email) {
        $subject = "Latest GitHub Timeline Updates";
        $headers = "From: no-reply@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";

        // Simulate mail debug mode
        echo "Sent to: $email<br>$formatted<hr>";

        // Uncomment if mail() works on your system
        // mail($email, $subject, $formatted, $headers);
    }
}

// Run all tasks
sendGitHubUpdatesToSubscribers();
