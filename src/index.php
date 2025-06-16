<?php
require_once 'functions.php';

session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $code = generateVerificationCode();
            $_SESSION['verification_code'] = $code;
            $_SESSION['email'] = $email;
            sendVerificationEmail($email, $code);
            $message = 'Verification code sent to your email.';
        } else {
            $message = 'Invalid email format.';
        }
    }

    if (isset($_POST['verification_code'])) {
        $input_code = trim($_POST['verification_code']);
        if (isset($_SESSION['verification_code']) && $input_code === $_SESSION['verification_code']) {
            registerEmail($_SESSION['email']);
            $message = 'Email verified and registered successfully!';
            unset($_SESSION['verification_code'], $_SESSION['email']);
        } else {
            $message = 'Invalid verification code.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h2>Email Subscription</h2>

    <form method="post">
        <label for="email">Enter your email:</label><br>
        <input type="email" name="email" required><br>
        <button type="submit" id="submit-email">Submit</button>
    </form>

    <br><br>

    <form method="post">
        <label for="verification_code">Enter Verification Code:</label><br>
        <input type="text" name="verification_code" maxlength="6" required><br>
        <button type="submit" id="submit-verification">Verify</button>
    </form>

    <p><?= htmlspecialchars($message) ?></p>
</body>
</html>
