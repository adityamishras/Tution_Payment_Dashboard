<?php
session_start();
$flash_message = "";
if (isset($_SESSION['flash'])) {
       $flash_message = $_SESSION['flash'];
       unset($_SESSION['flash']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title><?php
              if (isset($title)) {
                     echo $title;
              } else {
                     echo "Tuition Management System";
              }
              ?></title>
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 <script src="https://cdn.tailwindcss.com" rel="stylesheet"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">