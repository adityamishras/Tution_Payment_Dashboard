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

// Fetch all students for the dashboard table
$sql_students = "SELECT * FROM students ORDER BY uid DESC";
$result_students = mysqli_query($conn, $sql_students);

// Count total students for the dashboard card
$sql_count_students = "SELECT COUNT(*) AS total FROM students";
$result_count_students = mysqli_query($conn, $sql_count_students);
$row_count_students = mysqli_fetch_assoc($result_count_students);
$total_students = $row_count_students['total'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Tuition Dashboard</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <style>
 @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

 body {
  font-family: 'Inter', sans-serif;
 }
 </style>
</head>

<body class="bg-gray-100 text-gray-800">
 <div class="flex h-screen overflow-hidden">
  <!-- Sidebar -->
  <aside id="sidebar" class="w-64 bg-white shadow-md flex-shrink-0">
   <div class="h-full flex flex-col p-6 border-r border-gray-200">
    <div class="flex justify-between items-center mb-6">
     <h1 class="text-2xl font-bold text-blue-600">Tuition Admin</h1>
    </div>
    <nav class="flex-1">
     <ul class="space-y-3">
      <li><a href="#"
        class="block text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 ease-in-out">Dashboard</a>
      </li>
      <li><a href="add_student.php"
        class="block text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 ease-in-out">Students</a>
      </li>
      <li><a href="fees_payment.php"
        class="block text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 ease-in-out">Fees</a>
      </li>
      <li><a href="#"
        class="block text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 ease-in-out">Attendance</a>
      </li>
      <li><a href="#"
        class="block text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 ease-in-out">Settings</a>
      </li>
     </ul>
    </nav>
   </div>
  </aside>

  <!-- Main Content -->
  <div class="flex flex-col flex-1">
   <!-- Header -->
   <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center">
     <h2 class="text-2xl font-semibold text-gray-800">Tuition Dashboard</h2>
    </div>
    <div class="flex items-center space-x-4">
     <div class="relative">
      <button class="flex items-center space-x-2 focus:outline-none">
       <img class="w-8 h-8 rounded-full" src="https://placehold.co/100x100/aabbcc/ffffff?text=T" alt="User Avatar">
       <span class="text-gray-700 text-sm hidden md:block">Tuition Admin</span>
      </button>
     </div>
    </div>
   </header>

   <!-- Content Area -->
   <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-10 bg-gray-100">
    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
     <!-- Total Students Card -->
     <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h3 class="text-lg font-medium text-gray-600">Total Students</h3>
      <p class="mt-1 text-3xl font-bold text-blue-600"><?php echo $total_students; ?></p>
      <p class="text-sm text-gray-500 mt-2">All Classes</p>
     </div>
     <!-- Pending Fees Card -->
     <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h3 class="text-lg font-medium text-gray-600">Pending Fees</h3>
      <p class="mt-1 text-3xl font-bold text-red-600">₹ 25000</p>
      <p class="text-sm text-gray-500 mt-2">Outstanding</p>
     </div>
     <!-- Placeholder Cards (can be customized or removed) -->
     <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h3 class="text-lg font-medium text-gray-600">Today's Classes</h3>
      <p class="mt-1 text-3xl font-bold text-green-600">6</p>
      <p class="text-sm text-gray-500 mt-2">Scheduled Today</p>
     </div>
     <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h3 class="text-lg font-medium text-gray-600">Present Today</h3>
      <p class="mt-1 text-3xl font-bold text-purple-600">98</p>
      <p class="text-sm text-gray-500 mt-2">Marked Attendance</p>
     </div>
    </div>

    <!-- All Registered Students Table -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8">
     <h3 class="text-xl font-semibold mb-4 text-gray-800">All Registered Students</h3>
     <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
       <thead class="bg-gray-50">
        <tr>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Year</th>
         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
        </tr>
       </thead>
       <tbody class="bg-white divide-y divide-gray-200">
        <?php if (mysqli_num_rows($result_students) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result_students)): ?>
        <tr class="hover:bg-gray-100">
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['student_id']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['name']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['email']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['phone']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['class']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['gender']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['start_year']) ?></td>
         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
          <img src="<?= htmlspecialchars($row['image']) ?>" alt="Profile" class="h-10 w-10 rounded-full object-cover">
         </td>
        </tr>
        <?php endwhile; ?>
        <?php else: ?>
        <tr>
         <td colspan="8" class="text-center py-4 text-gray-700">No students registered yet.</td>
        </tr>
        <?php endif; ?>
       </tbody>
      </table>
     </div>
    </div>
   </main>
  </div>
 </div>
 <script>
 document.addEventListener('DOMContentLoaded', function() {
  // No JavaScript is needed for dynamic elements since modals and dark mode are removed.
  // This script block remains for general DOMContentLoaded best practice but contains no active logic.
 });
 </script>
</body>

</html>
<?php
mysqli_close($conn);
?>