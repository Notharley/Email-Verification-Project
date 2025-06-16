<?php
require_once 'functions.php';

$step = 1;
$unsubscribeEmail = '';
$unsubscribeCode = '';
$generatedCode = '';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        // Step 1: User submits email
        $unsubscribeEmail = trim($_POST['unsubscribe_email']);
        $generatedCode = generateVerificationCode();
        $_SESSION['unsubscribe_email'] = $unsubscribeEmail;
        $_SESSION['unsubscribe_code'] = $generatedCode;
        sendVerificationEmail($unsubscribeEmail, $generatedCode);
        $step = 2;
        echo "<p style='color: green;'>Unsubscribe code sent. (DEBUG: $generatedCode)</p>";
    } elseif (isset($_POST['unsubscribe_verification_code'])) {
        // Step 2: User submits verification code
        $unsubscribeCode = trim($_POST['unsubscribe_verification_code']);
        if (
            isset($_SESSION['unsubscribe_code']) &&
            $unsubscribeCode === $_SESSION['unsubscribe_code']
        ) {
            unsubscribeEmail($_SESSION['unsubscribe_email']);
            echo "<p style='color: green;'>Successfully unsubscribed!</p>";
            session_destroy();
        } else {
            echo "<p style='color: red;'>Invalid code. Please try again.</p>";
            $step = 2;
        }
    }
}
?>

<h2>Unsubscribe from GitHub Updates</h2>

<?php if ($step === 1): ?>
<form method="POST">
    <label>Enter your email:</label><br>
    <input type="email" name="unsubscribe_email" required>
    <br><br>
    <button id="submit-unsubscribe" type="submit">Unsubscribe</button>
</form>
<?php elseif ($step === 2): ?>
<form method="POST">
    <label>Enter the verification code sent to your email:</label><br>
    <input type="text" name="unsubscribe_verification_code" required>
    <br><br>
    <button id="verify-unsubscribe" type="submit">Verify</button>
</form>
<?php endif; ?>
