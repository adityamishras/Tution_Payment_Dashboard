<?php
// Connect to DB
$host = "localhost";
$username = "root";
$password = "";
$dbname = "tuition_db";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}

// Fetch all students
$sql = "SELECT * FROM students ORDER BY uid DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <title>Registered Students</title>
 <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
 <div class="max-w-7xl mx-auto bg-white p-6 shadow-md rounded-xl">
  <h1 class="text-2xl font-bold mb-4">Registered Students</h1>

  <table class="w-full table-auto border-collapse border border-gray-300">
   <thead class="bg-gray-200">
    <tr>
     <th class="border border-gray-300 px-4 py-2">UID</th>
     <th class="border border-gray-300 px-4 py-2">Student ID</th>
     <th class="border border-gray-300 px-4 py-2">Name</th>
     <th class="border border-gray-300 px-4 py-2">Email</th>
     <th class="border border-gray-300 px-4 py-2">Phone</th>
     <th class="border border-gray-300 px-4 py-2">Class</th>
     <th class="border border-gray-300 px-4 py-2">Gender</th>
     <th class="border border-gray-300 px-4 py-2">Start Year</th>
     <th class="border border-gray-300 px-4 py-2">Image</th>
    </tr>
   </thead>
   <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr class="hover:bg-gray-100">
     <td class="border border-gray-300 px-4 py-2"><?= $row['uid'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['student_id'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['name'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['email'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['phone'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['class'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['gender'] ?></td>
     <td class="border border-gray-300 px-4 py-2"><?= $row['start_year'] ?></td>
     <td class="border border-gray-300 px-4 py-2">
      <img src="<?= $row['image'] ?>" alt="Profile" class="h-10 w-10 rounded-full object-cover">
     </td>
    </tr>
    <?php endwhile; ?>
    <?php else: ?>
    <tr>
     <td colspan="9" class="text-center py-4">No students registered yet.</td>
    </tr>
    <?php endif; ?>
   </tbody>
  </table>
 </div>
</body>

</html>

<?php
mysqli_close($conn);
?>