<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();

$email = $_SESSION['student_email'] ?? null;
$name  = $_SESSION['student_name'] ?? "Student";
$password = $_SESSION['student_password'] ?? 'N/A';

if (!$email) {
 return; // Do not continue if email is not available
}

$mail = new PHPMailer(true);

try {
 //Server settings
 $mail->isSMTP();
 $mail->Host       = 'smtp.gmail.com';
 $mail->SMTPAuth   = true;
 $mail->Username   = 'adityakumarsmishra@gmail.com';       // Replace with your Gmail
 $mail->Password   = 'irfs khqd lbol avku';    // App password from environment variable
 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
 $mail->Port       = 465;

 //Recipients
 $mail->setFrom('yourgmail@gmail.com', 'Tuition Admin');
 $mail->addAddress($email, $name);

 // Content
 $mail->CharSet = 'UTF-8';
 $mail->isHTML(true);
 $mail->Subject = 'Tuition Registration Successful';

 $mail->Body = '
<div style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px;">
  <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
    <h2 style="font-size: 24px; color: #4f46e5; margin-bottom: 20px;">Registration Successful 🎉</h2>
    <p style="font-size: 16px; color: #111827;">Hello <strong>' . htmlspecialchars($name) . '</strong>,</p>
    <p style="font-size: 16px; color: #374151; margin-top: 10px;">
      Thank you for registering with our tuition center. Your registration has been received successfully.
    </p>
    <p style="font-size: 16px; color: #374151;">
      We will contact you shortly with further details.
    </p>
    <p style="font-size: 16px; color: #374151;">
       Your login password is: <strong>' . htmlspecialchars($password) . '</strong>
     </p>
    <p style="font-size: 16px; color: #111827; margin-top: 30px;">Best Regards,<br><strong>Tuition Team</strong></p>
  </div>
</div>';

 $mail->AltBody = "Hello $name,\n\nYour registration is successful.\n\nThanks!\nTuition Team";


 $mail->send();
 // echo 'Email sent successfully'; // Not needed here
} catch (Exception $e) {
 // Log error if needed
 // echo "Mailer Error: {$mail->ErrorInfo}";
}
// Clear session variables after sending email
unset($_SESSION['student_email']);
unset($_SESSION['student_name']);
unset($_SESSION['student_password']);
