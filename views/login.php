<?php
session_start();
require 'C:/xampp/htdocs/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $database = new Database();
    $db = $database->getConnection();

    // Retrieve user
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Generate and store 2FA code in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['2fa_code'] = rand(100000, 999999);

          // Generate OTP
          $otp = rand(100000, 999999);
          $_SESSION['otp'] = $otp;
          $_SESSION['user_data'] = [
              'email' => $email,
              'password' => $password
          ];

          // Send OTP via PHPMailer
          $mail = new PHPMailer(true);
          try {
              //Server settings
              $mail->isSMTP();                                           // Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
              $mail->Username   = 'eoringe372@gmail.com';                // SMTP username
              $mail->Password   = 'wdjk opaf jhdx wjjr';                 // SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
              $mail->Port       = 587;                                   // TCP port to connect to

              //Recipients
              $mail->setFrom('eoringe372@gmail.com', 'Emmanuel\'s Website');
              $mail->addAddress($email);                                 // Add the recipient's email address

              // Content
              $mail->isHTML(true);                                       // Set email format to HTML
              $mail->Subject = 'Your OTP Code';
              $mail->Body    = 'Your OTP code is: ' . $otp;

              $mail->send();
              header("Location: verify_2fa.php");
              exit;
          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
