<?php
// 1. Connect to DB
$host = "localhost";
$username = "root";
$password = "";
$dbname = "tuition_db";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}

// 2. Get form values
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$class = $_POST['class'];
$gender = $_POST['gender'];
$start_year = date("Y");

// 3. Validate passwords
if ($password !== $confirm_password) {
 die("Passwords do not match.");
}

// 4. Upload image
$image_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_path = "uploads/" . $image_name;
move_uploaded_file($image_tmp, $image_path);

// 5. Generate student ID
$sql_count = "SELECT COUNT(*) as total FROM students WHERE start_year = '$start_year'";
$result = mysqli_query($conn, $sql_count);
$row = mysqli_fetch_assoc($result);
$count = $row['total'];

$serial = $count + 1;
$student_id = $start_year . str_pad($serial, 3, "0", STR_PAD_LEFT);

// 6. Insert into database
$sql_insert = "INSERT INTO students (student_id, name, email, phone, password, class, gender, image, start_year)
               VALUES ('$student_id', '$name', '$email', '$phone', '$password', '$class', '$gender', '$image_path', '$start_year')";

if (mysqli_query($conn, $sql_insert)) {
 echo "Registration successful! Student ID: $student_id";
} else {
 echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
