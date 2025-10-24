<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if ($user_id && isset($_POST['subjects'])) {
 // Delete old subjects
 mysqli_query($conn, "DELETE FROM user_subjects WHERE user_id = $user_id");

 // Insert new subjects
 foreach ($_POST['subjects'] as $subject) {
  $subject = mysqli_real_escape_string($conn, $subject);
  if (!empty($subject)) {
   $query = "INSERT INTO user_subjects (user_id, subject_name) VALUES ($user_id, '$subject')";
   mysqli_query($conn, $query);
  }
 }
 $_SESSION['flash'] = "Subjects updated successfully.";
} else {
 $_SESSION['flash'] = "No subjects received or user not logged in.";
}
