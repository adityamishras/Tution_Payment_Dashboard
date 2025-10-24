<?php
// Database configuration
$host = 'localhost';
$dbname = 'tuition_db';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
 echo "Connection failed: " . mysqli_connect_error();
} else {
 echo "Connected";
}
