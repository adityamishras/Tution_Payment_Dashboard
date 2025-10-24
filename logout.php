<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Delete remember me cookies if set
setcookie('remember_email', '', time() - 3600, "/");
setcookie('remember_token', '', time() - 3600, "/");

// Redirect to login page
header("Location: login.php");
exit;
