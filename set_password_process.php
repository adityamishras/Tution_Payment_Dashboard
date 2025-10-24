<?php
session_start();
include("config.php"); // database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 $email = $_POST['email'];
 $raw_password = $_POST['password'];
 $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

 // Get student ID from email
 $query = "SELECT id FROM tuition_students WHERE email = ?";
 $stmt = $conn->prepare($query);
 $stmt->bind_param("s", $email);
 $stmt->execute();
 $result = $stmt->get_result();

 if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $student_id = $row['id'];

  // Check if login record exists
  $check = $conn->prepare("SELECT * FROM tuition_students WHERE id = ?");
  $check->bind_param("i", $student_id);
  $check->execute();
  $check_result = $check->get_result();

  if ($check_result->num_rows == 0) {
   // Insert new password
   $insert = $conn->prepare("INSERT INTO tuition_students (id, email, password) VALUES (?, ?, ?)");
   $insert->bind_param("iss", $student_id, $email, $hashed_password);
   if ($insert->execute()) {
    echo "Password created successfully!";
   } else {
    echo "Error: " . $conn->error;
   }
  } else {
   // ✅ Update password if already exists
   $update = $conn->prepare("UPDATE tuition_students SET password = ? WHERE id = ?");
   $update->bind_param("si", $hashed_password, $student_id);
   if ($update->execute()) {
    echo "Password updated successfully!";
   } else {
    echo "Error: " . $conn->error;
   }
  }
 } else {
  echo "Email not found. Please register first.";
 }
}
$conn->close();
