<?php
session_start();
include("config.php"); // adjust the path if needed

$login_error = '';

// Handle login logic
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 $email = trim($_POST['email']);
 $password = $_POST['password'];

 if (empty($email) || empty($password)) {
  $login_error = "Please fill in all fields.";
 } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $login_error = "Invalid email format.";
 } else {
  // Escape for SQL safety
  $email = mysqli_real_escape_string($conn, $email);
  $query = "SELECT * FROM tuition_students WHERE email = '$email' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) === 1) {
   $user = mysqli_fetch_assoc($result);

   if (password_verify($password, $user['password'])) {
    // Success: Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['fullname'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_phone'] = $user['phone'];

    header("Location: dashboard.php");
    exit;
   } else {
    $login_error = "Incorrect password.";
   }
  } else {
   $login_error = "No account found with that email.";
  }
 }
}
