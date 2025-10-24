<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Collect Fees</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  body {
   font-family: 'Inter', sans-serif;
  }

  /* Style for readonly inputs to make them look consistent but indicate they are not editable */
  input[readonly] {
   @apply bg-gray-50 cursor-not-allowed;
  }
 </style>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

 <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-md">
  <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">Collect Student Fees</h1>

  <form method="POST" action="submit_fee.php" class="space-y-6">
   <!-- Search Bar for Student -->
   <div class="mb-6">
    <label for="search_student" class="block text-sm font-medium text-gray-700 mb-1">Search Student by Name or
     ID</label>
    <div class="flex space-x-2">
     <input type="text" id="search_student" placeholder="Enter name or student ID"
      class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
     <button type="button" id="searchStudentBtn"
      class="px-4 py-2.5 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
      Search
     </button>
    </div>
    <div id="searchResults" class="mt-2 bg-gray-50 border border-gray-200 rounded-lg max-h-48 overflow-y-auto hidden">
     <!-- Search results will be loaded here -->
     <p class="p-3 text-gray-500 text-sm text-center">No results yet. Type and search.</p>
    </div>
   </div>

   <!-- Hidden input to store the actual database ID of the selected student -->
   <input type="hidden" id="student_db_id" name="student_id" required>

   <!-- Display fields for selected student's details -->
   <div>
    <label for="selected_student_name" class="block text-sm font-medium text-gray-700 mb-1">Selected Student
     Name</label>
    <input type="text" id="selected_student_name" readonly placeholder="Student Name"
     class="mt-1 block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm sm:text-sm">
   </div>

   <div>
    <label for="selected_student_id" class="block text-sm font-medium text-gray-700 mb-1">Selected Student ID (Roll
     No.)</label>
    <input type="text" id="selected_student_id" readonly placeholder="Student ID"
     class="mt-1 block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm sm:text-sm">
   </div>

   <div>
    <label for="selected_student_class" class="block text-sm font-medium text-gray-700 mb-1">Selected Student
     Class</label>
    <input type="text" id="selected_student_class" readonly placeholder="Student Class"
     class="mt-1 block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm sm:text-sm">
   </div>

   <div>
    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (₹)</label>
    <input type="number" id="amount" name="amount" placeholder="e.g., 5000" required
     class="mt-1 block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
   </div>

   <div>
    <label for="payment_mode" class="block text-sm font-medium text-gray-700 mb-1">Payment Mode</label>
    <select id="payment_mode" name="payment_mode" required
     class="mt-1 block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
     <option value="Cash">Cash</option>
     <option value="UPI">UPI</option>
     <option value="Card">Card</option>
     <option value="Bank Transfer">Bank Transfer</option>
    </select>
   </div>

   <div class="text-center pt-4">
    <button type="submit"
     class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
     Record Payment
    </button>
   </div>
  </form>
 </div>

 <script>
  document.addEventListener('DOMContentLoaded', function() {
   const searchStudentInput = document.getElementById('search_student');
   const searchStudentBtn = document.getElementById('searchStudentBtn');
   const searchResultsDiv = document.getElementById('searchResults');

   // New input fields for displaying selected student details
   const studentDbIdInput = document.getElementById('student_db_id');
   const selectedStudentNameInput = document.getElementById('selected_student_name');
   const selectedStudentIdInput = document.getElementById('selected_student_id');
   const selectedStudentClassInput = document.getElementById('selected_student_class');

   // Function to clear selected student fields
   function clearSelectedStudentFields() {
    studentDbIdInput.value = '';
    selectedStudentNameInput.value = '';
    selectedStudentIdInput.value = '';
    selectedStudentClassInput.value = '';
   }

   // Clear fields when search input changes
   searchStudentInput.addEventListener('input', clearSelectedStudentFields);

   searchStudentBtn.addEventListener('click', async function() {
    const query = searchStudentInput.value.trim();
    if (query.length === 0) {
     searchResultsDiv.innerHTML =
      '<p class="p-3 text-gray-500 text-sm text-center">कृपया छात्र का नाम या आईडी दर्ज करें।</p>';
     searchResultsDiv.classList.remove('hidden');
     return;
    }

    searchResultsDiv.innerHTML = '<p class="p-3 text-gray-500 text-sm text-center">खोज रहा है...</p>';
    searchResultsDiv.classList.remove('hidden');
    clearSelectedStudentFields(); // Clear fields before new search

    try {
     // This AJAX call expects a PHP file at php/search_students.php
     // You will need to create this file on your server and ensure it returns 'class'
     const response = await fetch(`search_students.php?query=${encodeURIComponent(query)}`);
     const students = await response.json();

     if (students.length > 0) {
      searchResultsDiv.innerHTML = '';
      students.forEach(student => {
       const resultItem = document.createElement('div');
       resultItem.classList.add('p-3', 'cursor-pointer', 'hover:bg-blue-100', 'border-b', 'border-gray-200',
        'last:border-b-0');
       resultItem.innerHTML =
        `<span class="font-medium">${student.name}</span> <span class="text-gray-500 text-xs">(ID: ${student.student_id})</span>`;

       // Store all relevant data in dataset for easy access
       resultItem.dataset.studentId = student.id; // Database ID
       resultItem.dataset.studentRollNo = student.student_id; // Roll Number
       resultItem.dataset.studentName = student.name;
       resultItem.dataset.studentClass = student.class || 'N/A'; // Handle missing class gracefully

       resultItem.addEventListener('click', function() {
        // Populate the new input fields
        studentDbIdInput.value = this.dataset.studentId;
        selectedStudentNameInput.value = this.dataset.studentName;
        selectedStudentIdInput.value = this.dataset.studentRollNo;
        selectedStudentClassInput.value = this.dataset.studentClass;

        searchResultsDiv.classList.add('hidden'); // Hide results after selection
        searchStudentInput.value = this.dataset.studentName; // Show selected name in search box
       });
       searchResultsDiv.appendChild(resultItem);
      });
     } else {
      searchResultsDiv.innerHTML = '<p class="p-3 text-gray-500 text-sm text-center">कोई छात्र नहीं मिला।</p>';
     }

    } catch (error) {
     console.error('Error fetching students:', error);
     searchResultsDiv.innerHTML =
      '<p class="p-3 text-red-500 text-sm text-center">छात्रों को खोजने में त्रुटि हुई।</p>';
    }
   });

   // Optional: Hide search results when clicking outside
   document.addEventListener('click', function(event) {
    if (!searchResultsDiv.contains(event.target) && event.target !== searchStudentInput && event.target !==
     searchStudentBtn) {
     searchResultsDiv.classList.add('hidden');
    }
   });
  });
 </script>

</body>

</html>