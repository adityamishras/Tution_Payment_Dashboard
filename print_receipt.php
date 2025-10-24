<?php
// Set default timezone to India Standard Time (IST)
date_default_timezone_set('Asia/Kolkata');

include 'config.php'; // Ensure this connects to your database

if (isset($_GET['payment_id'])) {
 $payment_id = mysqli_real_escape_string($conn, $_GET['payment_id']);
 $query = "SELECT * FROM fee_payments WHERE payment_id = '$payment_id' LIMIT 1";
 $result = mysqli_query($conn, $query);

 if (!$result || mysqli_num_rows($result) === 0) {
  die("<div style='text-align: center; margin-top: 50px; font-family: sans-serif; color: #ef4444; font-size: 1.5rem;'>❌ No matching payment found.</div>");
 }

 $data = mysqli_fetch_assoc($result);

 // Format date/time
 $paid_date = date("d M Y", strtotime($data['paid_on'] ?? date('Y-m-d'))); // Fallback to current date if paid_on is null
 $paid_time = date("h:i A", strtotime($data['paid_at'] ?? '00:00:00'));
} else {
 die("<div style='text-align: center; margin-top: 50px; font-family: sans-serif; color: #ef4444; font-size: 1.5rem;'>❌ Invalid request.</div>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Tuition Fee Receipt - <?php echo htmlspecialchars($data['payment_id']); ?></title>
 <script src="https://cdn.tailwindcss.com"></script>
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <style>
  body {
   font-family: 'Poppins', sans-serif;
   background-color: #f3f4f6;
   /* Light gray for background */
   color: #374151;
   /* Dark gray for general text */
  }

  /* Styles for printing */
  @media print {
   body {
    background-color: #fff;
    /* White background for print */
    margin: 0;
    padding: 0;
   }

   .no-print {
    display: none !important;
   }

   .print-area {
    width: 100%;
    margin: 0;
    padding: 0;
    box-shadow: none;
    border: none;
    border-radius: 0;
   }

   /* Ensure text is black for printing */
   .print-area h1,
   .print-area h2,
   .print-area p,
   .print-area span,
   .print-area strong {
    color: #000 !important;
   }

   /* Ensure amount is black */
   .amount-display {
    color: #000 !important;
   }

   /* Status badge to print clearly */
   .status-badge {
    background-color: transparent !important;
    color: #000 !important;
    border: 1px solid #000;
    /* Add border for visibility */
    padding: 0.25rem 0.5rem;
    /* Adjust padding */
   }
  }
 </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
 <div class="max-w-3xl w-full mx-auto bg-white p-8 sm:p-10 rounded-xl shadow-2xl border border-gray-200 print-area">
  <div class="text-center mb-8">
   <h1 class="text-4xl font-extrabold text-indigo-700 mb-3">Tuition Fee Receipt</h1>
   <p class="text-gray-600 text-lg">Thank you for your payment!</p>
   <p class="text-gray-500 text-sm mt-1">Your official payment confirmation for services rendered.</p>
  </div>

  <div class="border-t border-b border-gray-300 py-6 mb-8 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-base">
   <div>
    <p class="mb-2"><strong class="text-gray-700">Payment ID:</strong> <span
      class="text-indigo-600 font-semibold"><?php echo htmlspecialchars($data['payment_id']); ?></span></p>
    <p class="mb-2"><strong class="text-gray-700">Date Paid:</strong> <?php echo $paid_date; ?></p>
    <p><strong class="text-gray-700">Time Paid:</strong> <?php echo $paid_time; ?> IST</p>
   </div>
   <div class="md:text-right">
    <p class="mb-2"><strong class="text-gray-700">Status:</strong>
     <span
      class="status-badge px-3 py-1 text-sm font-semibold rounded-full
                                <?php echo ($data['status'] === 'Paid') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
      <?php echo htmlspecialchars($data['status']); ?>
     </span>
    </p>
    <p><strong class="text-gray-700">Amount Paid:</strong>
     <span
      class="text-4xl font-bold text-green-700 amount-display">₹<?php echo htmlspecialchars(number_format($data['amount'], 2)); ?></span>
    </p>
   </div>
  </div>

  <div class="mb-8">
   <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
    <i class="fa-solid fa-user-circle mr-3 text-indigo-500"></i>Student Details
   </h2>
   <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-base">
    <p><strong class="text-gray-700">Name:</strong> <?php echo htmlspecialchars($data['student_name'] ?? 'N/A'); ?></p>
    <p><strong class="text-gray-700">Email:</strong> <?php echo htmlspecialchars($data['email'] ?? 'N/A'); ?></p>
    <p><strong class="text-gray-700">Phone:</strong> <?php echo htmlspecialchars($data['phone'] ?? 'N/A'); ?></p>
   </div>
  </div>

  <div class="mt-10 pt-6 border-t border-gray-300">
   <p class="text-sm text-gray-600 italic text-center">
    <i class="fa-solid fa-info-circle mr-2 text-blue-500"></i>This is a system-generated receipt. No signature is
    required.
   </p>
   <p class="text-sm text-gray-500 text-center mt-2">
    Thank you for your continued support!
   </p>
  </div>

  <div class="text-center mt-10 no-print">
   <button onclick="window.print()"
    class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-105 mr-4">
    <i class="fas fa-print mr-2"></i> Print Receipt
   </button>
   <a href="dashboard.php"
    class="inline-flex items-center px-8 py-3 bg-gray-500 text-white rounded-full shadow-lg hover:bg-gray-600 transition-all duration-300 ease-in-out transform hover:scale-105">
    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
   </a>
  </div>
 </div>
</body>

</html>