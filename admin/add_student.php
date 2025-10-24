<!DOCTYPE html>
<html lang="en" class="">

<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title><?= isset($title) ? $title : "Tuition Management System" ?></title>
 <script src="https://cdn.tailwindcss.com"></script>
 <link rel="stylesheet" href="../assets/style.css">

</head>

<body
 class="min-h-screen bg-yellow-50 dark:bg-gray-900 text-gray-800 dark:text-white flex items-center justify-center transition duration-300">

 <!-- Dark Mode Toggle Switch -->
 <label class="absolute top-4 right-4 inline-flex items-center cursor-pointer z-50">
  <input type="checkbox" id="toggleDark" class="sr-only peer">
  <div
   class="relative w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-400 dark:peer-focus:ring-yellow-700 rounded-full peer dark:border-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600 dark:peer-checked:bg-yellow-500">
  </div>
  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Dark Mode</span>
 </label>


 <form action="register.php" method="POST" enctype="multipart/form-data"
  class="bg-white dark:bg-gray-800 shadow-xl rounded-xl w-[95%] max-w-5xl h-[95vh] p-6 grid grid-cols-1 md:grid-cols-2 gap-6 overflow-hidden">

  <!-- Left Side -->
  <div class="flex flex-col justify-between space-y-4">
   <div>
    <label class="block text-sm font-medium">Full Name</label>
    <input type="text" name="name" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
   </div>

   <div>
    <label class="block text-sm font-medium">Email</label>
    <input type="email" name="email" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
   </div>


   <div>
    <label class="block text-sm font-medium">Mobile Number</label>
    <input type="text" name="phone" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
   </div>



   <div>
    <label class="block text-sm font-medium">Password</label>
    <input type="password" name="password" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
   </div>
  </div>

  <!-- Right Side -->
  <div class="flex flex-col justify-between space-y-4">


   <div>
    <label class="block text-sm font-medium">Class</label>
    <select name="class" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
     <option value="">Select Class</option>
     <?php for ($i = 6; $i <= 12; $i++): ?>
      <option value="Class <?= $i ?>">Class <?= $i ?></option>
     <?php endfor; ?>
    </select>
   </div>

   <div>
    <label class="block text-sm font-medium">Profile Image</label>
    <input type="file" name="image" accept="image/*" required
     class="mt-1 w-full px-3 py-1 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 file:bg-yellow-100 file:text-yellow-700 file:border-0 file:rounded">
   </div>

   <div>
    <label class="block text-sm font-medium mb-1">Gender</label>
    <div class="flex gap-4 mt-1">
     <label class="inline-flex items-center">
      <input type="radio" name="gender" value="Male" required class="text-yellow-600 dark:bg-gray-700">
      <span class="ml-2">Male</span>
     </label>
     <label class="inline-flex items-center">
      <input type="radio" name="gender" value="Female" class="text-yellow-600 dark:bg-gray-700">
      <span class="ml-2">Female</span>
     </label>
     <label class="inline-flex items-center">
      <input type="radio" name="gender" value="Other" class="text-yellow-600 dark:bg-gray-700">
      <span class="ml-2">Other</span>
     </label>
    </div>
   </div>
   <div>
    <label class="block text-sm font-medium">Start Year</label>
    <select name="start_year" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
     <option value="">Select Year</option>
     <?php
     $currentYear = date('Y');
     for ($i = $currentYear; $i >= 2000; $i--) {
      echo "<option value=\"$i\">$i</option>";
     }
     ?>
    </select>
   </div>


   <div>
    <label class="block text-sm font-medium">Confirm Password</label>
    <input type="password" name="confirm_password" required
     class="mt-1 w-full px-4 py-2 border rounded-xl bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
   </div>
  </div>

  <!-- Submit -->
  <div class="col-span-1 md:col-span-2 text-center mt-2">
   <button type="submit"
    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 rounded-xl transition duration-200 dark:bg-yellow-500 dark:hover:bg-yellow-600">
    Register
   </button>
   <p class="mt-2 text-sm">Already registered? <a href="login.php"
     class="text-yellow-600 hover:underline dark:text-yellow-400">Login here</a></p>
  </div>
 </form>

 <script src="../assets/script.js"></script>
</body>

</html>