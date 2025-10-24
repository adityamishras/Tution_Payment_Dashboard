<?php
include 'header.php'; ?>
<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 p-4">
 <div
  class="w-full max-w-sm bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105">
  <div class="text-center mb-8">
   <div class="flex justify-center mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-600 dark:text-purple-400" fill="none"
     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
     <path stroke-linecap="round" stroke-linejoin="round"
      d="M15 7a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h6z" />
     <path stroke-linecap="round" stroke-linejoin="round" d="M12 11h.01" />
    </svg>
   </div>
   <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Create Your Password</h2>
   <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Secure your account by setting a new password.</p>
  </div>

  <form action="set_password_process.php" method="post" class="space-y-6">
   <div>
    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Enter Your Registered
     Email</label>
    <input type="email" name="email" id="email" required
     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
     placeholder="youremail@example.com">
   </div>

   <div>
    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Create New
     Password</label>
    <input type="password" name="password" id="password" required
     class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
     placeholder="••••••••">
   </div>

   <button type="submit"
    class="w-full py-3 rounded-full text-white font-bold bg-gradient-to-r from-purple-600 to-indigo-700 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-75">
    Set Password
   </button>
  </form>
 </div>
</div>
<?php include 'footer.php'; ?>