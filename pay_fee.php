<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$student_name = $_SESSION['user_name'] ?? 'Student';
$email        = $_SESSION['user_email'] ?? 'student@example.com';
$phone        = $_SESSION['user_phone'] ?? '9999999999';
$user_id      = $_SESSION['user_id'];

// Default amount (₹100 if nothing entered yet)
$amount = 10000; // 10000 paise = ₹100

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
  $enteredAmount = (int) $_POST['amount']; // in rupees
  if ($enteredAmount > 0) {
    $amount = $enteredAmount * 100; // convert to paise
  }
}

// Razorpay API key
$razorpay_key = "rzp_test_REf7zSNCNImeOu";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pay Tuition Fee</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4">
  <div
    class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 md:p-12 max-w-md w-full transform transition-all duration-300 ease-in-out hover:scale-105">

    <div class="text-center mb-8">
      <div class="text-6xl text-purple-600 dark:text-purple-400 mb-4 animate-pulse">
        <i class="fas fa-credit-card"></i>
      </div>
      <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Pay Tuition Fee</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Securely powered by Razorpay.</p>
    </div>

    <div class="bg-purple-50 dark:bg-purple-900 p-6 rounded-2xl mb-8">
      <h2 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-4">Student Details</h2>
      <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-3">
        <li class="flex items-center">
          <i class="fas fa-user-circle mr-3 text-purple-600 dark:text-purple-400"></i>
          <span class="font-medium">Student:</span> <?php echo htmlspecialchars($student_name); ?>
        </li>
        <li class="flex items-center">
          <i class="fas fa-envelope mr-3 text-purple-600 dark:text-purple-400"></i>
          <span class="font-medium">Email:</span> <?php echo htmlspecialchars($email); ?>
        </li>
        <li class="flex items-center">
          <i class="fas fa-phone mr-3 text-purple-600 dark:text-purple-400"></i>
          <span class="font-medium">Phone:</span> <?php echo htmlspecialchars($phone); ?>
        </li>
      </ul>
    </div>

    <form action="" method="POST" id="paymentForm" class="space-y-6">
      <div>
        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
          Enter Amount (₹)
        </label>
        <div class="relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="text-gray-500 text-xl font-bold">₹</span>
          </div>
          <input type="number" name="amount" id="amount" placeholder="e.g., 5000" value="<?php echo ($amount / 100); ?>"
            min="1" required
            class="block w-full pl-10 pr-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:ring-4 focus:ring-purple-300 focus:border-purple-500 transition-all duration-200">
        </div>
      </div>

      <button type="submit"
        class="w-full py-4 rounded-xl text-lg text-white font-bold bg-gradient-to-r from-purple-600 to-indigo-700 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-75">
        Proceed to Pay
      </button>

      <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($user_id); ?>">
    </form>
  </div>

  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])): ?>
    <script>
      var options = {
        "key": "<?php echo htmlspecialchars($razorpay_key); ?>",
        "amount": "<?php echo htmlspecialchars($amount); ?>",
        "currency": "INR",
        "name": "My Tuition",
        "description": "Tuition Fee Payment",
        "prefill": {
          "name": "<?php echo htmlspecialchars($student_name); ?>",
          "email": "<?php echo htmlspecialchars($email); ?>",
          "contact": "<?php echo htmlspecialchars($phone); ?>"
        },
        "theme": {
          "color": "#6366f1"
        },
        "handler": function(response) {
          var form = document.getElementById('paymentForm');
          form.action = 'verify_payment.php';
          var input1 = document.createElement('input');
          input1.type = 'hidden';
          input1.name = 'razorpay_payment_id';
          input1.value = response.razorpay_payment_id;
          form.appendChild(input1);
          form.submit();
        }
      };
      var rzp = new Razorpay(options);
      rzp.on('payment.failed', function(response) {
        alert(response.error.description);
      });
      rzp.open();
    </script>
  <?php endif; ?>
</body>

</html>