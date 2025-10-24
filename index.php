<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <title>Student Registration</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Bootstrap CSS (optional, for styling) -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

 <div class="container mt-5">
  <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card shadow-lg p-4 rounded-3">
     <h3 class="text-center mb-4">Student Registration Form</h3>

     <!-- Flash message -->
     <?php session_start();
     if (isset($_SESSION['flash'])): ?>
      <div class="alert alert-info">
       <?= $_SESSION['flash'];
       unset($_SESSION['flash']); ?>
      </div>
     <?php endif; ?>

     <form action="register.php" method="POST">

      <!-- Full Name -->
      <div class="mb-3">
       <label class="form-label">Full Name *</label>
       <input type="text" name="fullname" class="form-control" required>
      </div>

      <!-- Email -->
      <div class="mb-3">
       <label class="form-label">Email *</label>
       <input type="email" name="email" class="form-control" required>
      </div>

      <!-- Phone -->
      <div class="mb-3">
       <label class="form-label">Phone *</label>
       <input type="text" name="phone" class="form-control" required>
      </div>

      <!-- Date of Birth -->
      <div class="mb-3">
       <label class="form-label">Date of Birth</label>
       <input type="date" name="dob" class="form-control">
      </div>

      <!-- Gender -->
      <div class="mb-3">
       <label class="form-label">Gender</label>
       <select name="gender" class="form-select">
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
       </select>
      </div>

      <!-- Class -->
      <div class="mb-3">
       <label class="form-label">Class/Grade *</label>
       <input type="text" name="class" class="form-control" required>
      </div>

      <!-- School -->
      <div class="mb-3">
       <label class="form-label">School</label>
       <input type="text" name="school" class="form-control">
      </div>

      <!-- Subjects -->
      <div class="mb-3">
       <label class="form-label">Subjects</label>
       <input type="text" name="subjects" class="form-control" placeholder="e.g. Math, Science, English">
      </div>

      <!-- Address -->
      <div class="mb-3">
       <label class="form-label">Address</label>
       <textarea name="address" class="form-control" rows="3"></textarea>
      </div>

      <!-- Parent Name -->
      <div class="mb-3">
       <label class="form-label">Parent's Name</label>
       <input type="text" name="parent_name" class="form-control">
      </div>

      <!-- Parent Phone -->
      <div class="mb-3">
       <label class="form-label">Parent's Phone</label>
       <input type="text" name="parent_phone" class="form-control">
      </div>

      <!-- Submit -->
      <div class="d-grid">
       <button type="submit" class="btn btn-primary btn-lg">Register</button>
      </div>

     </form>
    </div>
   </div>
  </div>
 </div>

 <!-- Bootstrap JS (optional) -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>