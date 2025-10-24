<?php
// Connect to DB
$host = "localhost";
$username = "root";
$password = "";
$dbname = "tuition_db";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
 // Log error in a real application, don't expose sensitive info
 error_log("Database connection failed for search: " . mysqli_connect_error());
 echo json_encode(['error' => 'Database connection failed']);
 exit();
}

header('Content-Type: application/json'); // Set header for JSON response

$search_query = $_GET['query'] ?? ''; // Get search query from URL parameter

if (empty($search_query)) {
 echo json_encode([]); // Return empty array if no query
 exit();
}

// Sanitize the input to prevent SQL injection
$search_query = mysqli_real_escape_string($conn, $search_query);

// Search for students by name or student_id (roll number)
// LIMIT 10 to prevent returning too many results
$sql_search = "SELECT uid, name, student_id, class FROM students WHERE name LIKE '%$search_query%' OR student_id LIKE '%$search_query%' ORDER BY name ASC LIMIT 10";
$result_search = mysqli_query($conn, $sql_search);

$students = [];
if ($result_search) { // Check if query was successful
 while ($row = mysqli_fetch_assoc($result_search)) {
  $students[] = [
   'uid' => $row['uid'],
   'name' => $row['name'],
   'student_id' => $row['student_id'],
   'class' => $row['class']
  ];
 }
} else {
 // Log SQL error if query failed
 error_log("SQL Error in search_students.php: " . mysqli_error($conn));
}

echo json_encode($students); // Encode results as JSON

mysqli_close($conn); // Close the database connection