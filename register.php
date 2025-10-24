<?php
session_start();
include("config.php"); // $conn = mysqli_connect(...)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

       // Sanitize inputs
       $fullname      = mysqli_real_escape_string($conn, trim($_POST['fullname'] ?? ''));
       $email         = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
       $phone         = mysqli_real_escape_string($conn, trim($_POST['phone'] ?? ''));
       $dob           = mysqli_real_escape_string($conn, trim($_POST['dob'] ?? ''));
       $gender        = mysqli_real_escape_string($conn, trim($_POST['gender'] ?? ''));
       $class_grade   = mysqli_real_escape_string($conn, trim($_POST['class'] ?? ''));
       $school        = mysqli_real_escape_string($conn, trim($_POST['school'] ?? ''));
       $subjects      = mysqli_real_escape_string($conn, trim($_POST['subjects'] ?? ''));
       $address       = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
       $parent_name   = mysqli_real_escape_string($conn, trim($_POST['parent_name'] ?? ''));
       $parent_phone  = mysqli_real_escape_string($conn, trim($_POST['parent_phone'] ?? ''));

       // Validate required fields
       if (empty($fullname) || empty($email) || empty($phone) || empty($class_grade)) {
              $_SESSION['flash'] = "Please fill in all required fields.";
              header("Location: index.php");
              exit();
       }

       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $_SESSION['flash'] = "Invalid email format.";
              header("Location: index.php");
              exit();
       }

       // Check if email already exists
       $check_email = mysqli_query($conn, "SELECT id FROM tuition_students WHERE email='$email'");
       if (!$check_email) {
              die("Query failed: " . mysqli_error($conn));
       }

       if (mysqli_num_rows($check_email) > 0) {
              $_SESSION['flash'] = "Email already registered. Please use a different email.";
              header("Location: index.php");
              exit();
       }

       // Generate random password
       $raw_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
       $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

       // Insert into database
       $sql = "INSERT INTO tuition_students 
        (fullname, email, phone, dob, gender, class_grade, school, subjects, address, parent_name, parent_phone, password) 
        VALUES 
        ('$fullname', '$email', '$phone', '$dob', '$gender', '$class_grade', '$school', '$subjects', '$address', '$parent_name', '$parent_phone', '$hashed_password')";

       if (mysqli_query($conn, $sql)) {
              $_SESSION['student_email'] = $email;
              $_SESSION['student_name'] = $fullname;
              $_SESSION['student_phone'] = $phone;
              $_SESSION['student_id'] = mysqli_insert_id($conn);
              $_SESSION['student_password'] = $raw_password;

              require 'send_email.php'; // Call email script

              $_SESSION['flash'] = "Registration successful! A confirmation email has been sent.";
       } else {
              $_SESSION['flash'] = "Registration failed! Error: " . mysqli_error($conn);
       }

       mysqli_close($conn);
       header("Location: index.php");
       exit();
} else {
       $_SESSION['flash'] = "Invalid request method.";
       header("Location: index.php");
       exit();
}
