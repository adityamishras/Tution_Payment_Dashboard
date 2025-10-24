<?php include 'header.php'; ?>

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8 px-4 sm:px-10">
 <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8">

  <h2 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mb-6 text-center">Student Login</h2>

  <?php if (!empty($login_error)): ?>
  <div class="bg-red-100 text-red-700 dark:bg-red-700 dark:text-white rounded p-3 mb-4 text-sm">
   <?php echo $login_error; ?>
  </div>
  <?php endif; ?>

  <form action="login_process.php" method="POST" class="space-y-5">

   <div>
    <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Email:</label>
    <input type="email" name="email" id="email" required placeholder="Enter your email"
     class="mt-1 w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
   </div>

   <div>
    <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Password:</label>
    <input type="password" name="password" id="password" required placeholder="Enter your password"
     class="mt-1 w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
   </div>

   <div class="text-right text-sm">
    <a href="forgot_password.php" class="text-indigo-600 hover:underline dark:text-indigo-400">Forgot password?</a>
   </div>

   <div>
    <button type="submit"
     class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded shadow transition">
     Login
    </button>
   </div>

  </form>

  <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
   Don't have an account?
   <a href="register.php" class="text-indigo-600 hover:underline dark:text-indigo-400">Register here</a>
  </div>

 </div>
</div>

<?php include 'footer.php'; ?>