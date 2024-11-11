<?php
session_start();

// Check if OTP is set in session, redirect to login if not
if (!isset($_SESSION['otp'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    // Verify the entered OTP
    if ($entered_otp == $_SESSION['otp']) {
        // OTP is correct, log the user in
        echo "OTP verified! Welcome to your dashboard.";

        // Optionally, clear OTP from session
        unset($_SESSION['otp']);
        unset($_SESSION['user_data']);

        // Redirect to dashboard or main page
        //header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
</head>
<body>
    <h2>Enter OTP</h2>
    <form action="verify_2fa.php" method="POST">
        <label>OTP:</label>
        <input type="text" name="otp" required><br>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
