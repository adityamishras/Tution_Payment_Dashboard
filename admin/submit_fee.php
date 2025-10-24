<?php
include("../php/config.php");

$student_id = $_POST['student_id'];
$amount = $_POST['amount'];
$payment_mode = $_POST['payment_mode'];
$paid_on = date('Y-m-d');
$status = 'Paid';

// Sanitize input
$student_id = mysqli_real_escape_string($conn, $student_id);
$amount = mysqli_real_escape_string($conn, $amount);
$payment_mode = mysqli_real_escape_string($conn, $payment_mode);
$status = mysqli_real_escape_string($conn, $status);

// Step 1: Get uid from students table
$sql_get_uid = "SELECT uid FROM students WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $sql_get_uid);

if ($row = mysqli_fetch_assoc($result)) {
        $uid = $row['uid'];

        // Step 2: Insert into fees
        $sql_insert_fees = "INSERT INTO fees (uid, student_id, amount, paid_on, payment_mode, status)
                        VALUES ('$uid', '$student_id', '$amount', '$paid_on', '$payment_mode', '$status')";

        if (mysqli_query($conn, $sql_insert_fees)) {
                echo "Fees recorded successfully.";
        } else {
                echo "Insert Error: " . mysqli_error($conn);
        }
} else {
        echo "Student not found with ID: $student_id";
}

mysqli_close($conn);
