<?php
session_start();
include 'config.php';

// Set default timezone to India Standard Time (IST)
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['razorpay_payment_id'])) {
 $payment_id = $_POST['razorpay_payment_id'];
 $student_id = $_POST['student_id'];
 $student_name = $_SESSION['user_name'] ?? 'N/A';
 $email = $_SESSION['user_email'] ?? 'N/A';
 $phone = $_SESSION['user_phone'] ?? 'N/A';

 // IMPORTANT: In a real application, the amount should be fetched from your database
 // or validated against the actual order details, not hardcoded here.
 // This hardcoded amount (500) is for demonstration only.
 $amount = 500; // Example fixed amount in INR
 $status = "Paid";
 $date = date("Y-m-d"); // Current date in IST
 $time = date("H:i:s"); // Current time in IST (24-hour format)

 // Sanitize inputs to prevent SQL injection before using them in the query
 // Make sure $conn is available from config.php
 $student_id_safe = mysqli_real_escape_string($conn, $student_id);
 $payment_id_safe = mysqli_real_escape_string($conn, $payment_id);
 $student_name_safe = mysqli_real_escape_string($conn, $student_name);
 $email_safe = mysqli_real_escape_string($conn, $email);
 $phone_safe = mysqli_real_escape_string($conn, $phone);
 $amount_safe = mysqli_real_escape_string($conn, $amount); // Ensure amount is treated safely if coming from POST
 $status_safe = mysqli_real_escape_string($conn, $status);
 $date_safe = mysqli_real_escape_string($conn, $date);
 $time_safe = mysqli_real_escape_string($conn, $time);


 // Save payment with session data
 $sql = "INSERT INTO fee_payments (student_id, payment_id, student_name, email, phone, amount, status, paid_on, paid_at)
             VALUES ('$student_id_safe', '$payment_id_safe', '$student_name_safe', '$email_safe', '$phone_safe', '$amount_safe', '$status_safe', '$date_safe', '$time_safe')";
?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Status</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/path/to/your/favicon.ico" type="image/x-icon">
  <style>
   /* Optional: Add a subtle animation for better user experience */
   @keyframes fadeInScale {
    from {
     opacity: 0;
     transform: scale(0.95);
    }

    to {
     opacity: 1;
     transform: scale(1);
    }
   }

   .animate-fadeInScale {
    animation: fadeInScale 0.3s ease-out forwards;
   }
  </style>
 </head>

 <body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4">
  <div
   class="max-w-lg w-full mx-auto p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl space-y-6 text-center border border-gray-200 dark:border-gray-700 animate-fadeInScale">
   <?php if (mysqli_query($conn, $sql)): ?>
    <div class="flex items-center justify-center w-20 h-20 mx-auto bg-green-100 dark:bg-green-700 rounded-full shadow-md">
     <svg class="w-12 h-12 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2"
      viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
     </svg>
    </div>
    <h2 class="text-3xl font-extrabold text-green-700 dark:text-green-400">Payment Successful!</h2>
    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
     Thank you, <span
      class="font-semibold text-indigo-600 dark:text-indigo-400"><?php echo htmlspecialchars($student_name); ?></span>!
     Your payment of <span
      class="font-bold text-xl text-green-800 dark:text-green-200">₹<?php echo htmlspecialchars(number_format($amount, 2)); ?></span>
     has been successfully recorded.
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400">
     <span class="font-medium">Payment ID:</span> <strong
      class="text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($payment_id); ?></strong>
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400">
     <span class="font-medium">Transaction Date:</span> <strong
      class="text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($date); ?></strong>
     at <strong class="text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars(date("h:i A", strtotime($time))); ?>
      IST</strong>
    </p>
    <a href="dashboard.php" class="inline-flex items-center justify-center mt-6 px-8 py-3 bg-green-600 text-white font-semibold rounded-full shadow-lg
                      hover:bg-green-700 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105
                      focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-75">
     <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
    </a>
    <a href="print_receipt.php?payment_id=<?php echo htmlspecialchars($payment_id); ?>" target="_blank" class="inline-flex items-center justify-center mt-4 sm:ml-4 px-8 py-3 bg-indigo-600 text-white font-semibold rounded-full shadow-lg
                      hover:bg-indigo-700 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105
                      focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-75">
     <i class="fas fa-print mr-2"></i> Print Receipt
    </a>

   <?php else: ?>
    <div class="flex items-center justify-center w-20 h-20 mx-auto bg-red-100 dark:bg-red-700 rounded-full shadow-md">
     <svg class="w-12 h-12 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" stroke-width="2"
      viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
       d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
     </svg>
    </div>
    <h2 class="text-3xl font-extrabold text-red-700 dark:text-red-400">Payment Failed!</h2>
    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
     Sorry, your payment could not be processed or recorded at this moment.
    </p>
    <p class="text-sm text-red-500 dark:text-red-400">
     Error: <?php echo htmlspecialchars(mysqli_error($conn)); ?>
    </p>
    <a href="dashboard.php" class="inline-flex items-center justify-center mt-6 px-8 py-3 bg-red-600 text-white font-semibold rounded-full shadow-lg
                      hover:bg-red-700 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105
                      focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-75">
     <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
    </a>
   <?php endif; ?>
  </div>
 </body>

 </html>

<?php
} else {
 // Payment not successful or cancelled (no razorpay_payment_id received)
?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Cancelled</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/path/to/your/favicon.ico" type="image/x-icon">
  <style>
   @keyframes fadeInScale {
    from {
     opacity: 0;
     transform: scale(0.95);
    }

    to {
     opacity: 1;
     transform: scale(1);
    }
   }

   .animate-fadeInScale {
    animation: fadeInScale 0.3s ease-out forwards;
   }
  </style>
 </head>

 <body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4">
  <div
   class="max-w-lg w-full mx-auto p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl space-y-6 text-center border border-gray-200 dark:border-gray-700 animate-fadeInScale">
   <div
    class="flex items-center justify-center w-20 h-20 mx-auto bg-yellow-100 dark:bg-yellow-700 rounded-full shadow-md">
    <svg class="w-12 h-12 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" stroke-width="2"
     viewBox="0 0 24 24">
     <path stroke-linecap="round" stroke-linejoin="round"
      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
    </svg>
   </div>
   <h2 class="text-3xl font-extrabold text-yellow-700 dark:text-yellow-400">Payment Cancelled or Failed!</h2>
   <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
    It seems your payment was not completed or was cancelled. Please try again.
   </p>
   <a href="pay_fee.php" class="inline-flex items-center justify-center mt-6 px-8 py-3 bg-yellow-600 text-white font-semibold rounded-full shadow-lg
                  hover:bg-yellow-700 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105
                  focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-75">
    <i class="fas fa-redo-alt mr-2"></i> Try Again
   </a>
   <a href="dashboard.php" class="inline-flex items-center justify-center mt-4 sm:ml-4 px-8 py-3 bg-gray-600 text-white font-semibold rounded-full shadow-lg
                  hover:bg-gray-700 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105
                  focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-75">
    <i class="fas fa-arrow-left mr-2"></i> Go to Dashboard
   </a>
  </div>
 </body>

 </html>
<?php
}
?>