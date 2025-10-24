<?php
include 'header.php';
include 'config.php'; // Database connection
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
$user_id = $_SESSION['user_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? 'Student';
?>


<?php include 'navbar.php'; ?>
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6 pt-20">
  <div class="max-w-6xl mx-auto">

    <?php
    $query = "SELECT profile_photo, email FROM tuition_students WHERE id = " . $user_id . " LIMIT 1";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $data['profile_photo'] = $data['profile_photo'] ?? 'default.png'; // Default profile photo if not set
    ?>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow mb-6 flex items-center space-x-6">
      <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-indigo-500 dark:border-indigo-400 flex-shrink-0">
        <img src="uploads/profile/<?php echo htmlspecialchars($data['profile_photo'] ?? 'default.png'); ?>" alt="Profile"
          class="w-full h-full object-cover">
      </div>

      <div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
          Welcome back, <?php echo htmlspecialchars($user_name); ?> <i
            class="fa-solid fa-hand-sparkles ml-1 text-yellow-500"></i>
        </h1>
        <p class="text-gray-600 dark:text-gray-300 mt-1">
          <?php echo htmlspecialchars($data['email'] ?? ''); ?>
        </p>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Here’s your dashboard overview.</p>
      </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <div
        class="bg-indigo-100 dark:bg-indigo-800 text-indigo-900 dark:text-white p-5 rounded-xl shadow-md flex flex-col justify-between">
        <div>
          <h2 class="text-lg font-semibold mb-2 flex items-center"><i
              class="fa-solid fa-book mr-2 text-indigo-700 dark:text-indigo-300"></i>Your Notes</h2>
          <p class="text-sm">Access uploaded notes, materials & more.</p>
        </div>
        <a href="notes.php"
          class="inline-block mt-4 px-5 py-2 rounded-full font-medium bg-gradient-to-br from-indigo-500 to-indigo-700 text-white shadow-lg border border-indigo-400 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 text-center">
          View Notes
        </a>
      </div>

      <div
        class="bg-green-100 dark:bg-green-800 text-green-900 dark:text-white p-5 rounded-xl shadow-md flex flex-col justify-between">
        <div>
          <h2 class="text-lg font-semibold mb-2 flex items-center"><i
              class="fa-solid fa-user mr-2 text-green-700 dark:text-green-300"></i>Your Profile</h2>
          <p class="text-sm">Update your information and preferences.</p>
        </div>
        <a href="profile.php"
          class="inline-block mt-4 px-5 py-2 rounded-full font-medium bg-gradient-to-br from-green-500 to-green-700 text-white shadow-lg border border-green-400 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75 text-center">
          Edit Profile
        </a>
      </div>

      <div
        class="bg-red-100 dark:bg-red-800 text-red-900 dark:text-white p-5 rounded-xl shadow-md flex flex-col justify-between">
        <div>
          <h2 class="text-lg font-semibold mb-2 flex items-center"><i
              class="fa-solid fa-right-from-bracket mr-2 text-red-700 dark:text-red-300"></i>Logout</h2>
          <p class="text-sm">End your session securely.</p>
        </div>
        <a href="logout.php"
          class="inline-block mt-4 px-5 py-2 rounded-full font-medium bg-gradient-to-br from-red-500 to-red-700 text-white shadow-lg border border-red-400 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 text-center">
          Logout
        </a>
      </div>

    </div>

    <div
      class="mt-10 bg-yellow-100 dark:bg-yellow-800 text-yellow-900 dark:text-white p-6 rounded-xl shadow-md flex items-center justify-between flex-wrap gap-4">
      <div>
        <h2 class="text-xl font-semibold mb-2 flex items-center"><i
            class="fa-solid fa-credit-card mr-3 text-yellow-700 dark:text-yellow-300"></i>Pay Tuition Fees</h2>
        <p class="text-sm">Easily pay your monthly tuition fees online.</p>
      </div>
      <a href="pay_fee.php"
        class="flex-shrink-0 px-6 py-3 rounded-full font-semibold bg-gradient-to-br from-yellow-500 to-yellow-700 text-white shadow-xl border border-yellow-400 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-75 text-center">
        Pay Now
      </a>
    </div>

    <div class="mt-6 bg-blue-100 dark:bg-blue-800 text-blue-900 dark:text-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-4 flex items-center"><i
          class="fa-solid fa-bullhorn mr-3 text-blue-700 dark:text-blue-300"></i>Announcements</h2>
      <ul class="list-disc list-inside text-sm space-y-2">
        <li><i class="fa-solid fa-circle-info text-blue-600 dark:text-blue-400 mr-2"></i>New study materials for Mathematics
          have been uploaded.</li>
        <li><i class="fa-solid fa-bell text-blue-600 dark:text-blue-400 mr-2"></i>Reminder: Tuition fees for July are due by
          the 25th.</li>
        <li><i class="fa-solid fa-calendar-alt text-blue-600 dark:text-blue-400 mr-2"></i>Upcoming holiday: Institute will
          be closed on August 15th.</li>
      </ul>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 text-gray-800 dark:text-white p-6 rounded-xl shadow-xl">
      <h2 class="text-2xl font-semibold mb-6 flex items-center"><i
          class="fa-solid fa-receipt mr-3 text-purple-600 dark:text-purple-400"></i>Payment History</h2>

      <?php
      $history_query = "SELECT * FROM fee_payments WHERE student_id = '$user_id' ORDER BY paid_on ASC";
      $history_result = mysqli_query($conn, $history_query);
      ?>

      <?php if (mysqli_num_rows($history_result) > 0): ?>
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Date
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Time
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                  Payment ID</th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Amount
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Status
                </th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Action
                </th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <?php while ($row = mysqli_fetch_assoc($history_result)): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                    <?php echo htmlspecialchars($row['paid_on']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                    <?php
                    // Convert 24-hour time to 12-hour format with AM/PM
                    $time_24hr = $row['paid_at'];
                    $time_12hr = date("h:i A", strtotime($time_24hr));
                    echo htmlspecialchars($time_12hr);
                    ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                    <?php echo htmlspecialchars($row['payment_id']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                    ₹<?php echo htmlspecialchars(number_format($row['amount'], 2)); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <span
                      class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php echo ($row['status'] === 'Paid') ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100'; ?>">
                      <?php echo htmlspecialchars($row['status']); ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                    <form action="print_receipt.php" method="POST" target="_blank">
                      <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($row['payment_id']); ?>">
                      <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <i class="fas fa-print mr-2"></i> Print
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-gray-600 dark:text-gray-300 px-4 py-3">No payment history found.</p>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php include 'footer.php'; ?>