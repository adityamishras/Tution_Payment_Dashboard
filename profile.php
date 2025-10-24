<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";

// Fetch student data
$sql = "SELECT * FROM tuition_students WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("User data not found for the logged-in user.");
}

// Existing data with fallback
$fullname = $data['fullname'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$dob = $data['dob'] ?? '';
$gender = $data['gender'] ?? '';
$class = $data['class'] ?? '';
$school = $data['school'] ?? '';
$subjects = $data['subjects'] ?? '';
$address = $data['address'] ?? '';
$parent_name = $data['parent_name'] ?? '';
$parent_phone = $data['parent_phone'] ?? '';
$profile_photo = $data['profile_photo'] ?? 'default.png';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $profile_photo_updated_path = $profile_photo;

    // Handle photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 2 * 1024 * 1024; // 2MB

        $img_name = $_FILES['profile_photo']['name'];
        $img_tmp = $_FILES['profile_photo']['tmp_name'];
        $img_size = $_FILES['profile_photo']['size'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        if (in_array($img_ext, $allowed_exts) && $img_size <= $max_file_size) {
            $upload_dir = "uploads/profile/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $new_img_name = "profile_{$user_id}_" . time() . ".{$img_ext}";
            $destination_path = $upload_dir . $new_img_name;

            if (move_uploaded_file($img_tmp, $destination_path)) {
                $profile_photo_updated_path = $new_img_name;
                if ($profile_photo !== 'default.png' && file_exists($upload_dir . $profile_photo)) {
                    unlink($upload_dir . $profile_photo);
                }
            } else {
                $success_msg = "Failed to upload new profile photo.";
            }
        } else {
            $success_msg = "Invalid file type or size. Only PNG/JPG/GIF up to 2MB allowed.";
        }
    }

    // Escape all POST values
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $dob = mysqli_real_escape_string($conn, $_POST['dob'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $class = mysqli_real_escape_string($conn, $_POST['class'] ?? '');
    $school = mysqli_real_escape_string($conn, $_POST['school'] ?? '');
    $subjects = mysqli_real_escape_string($conn, $_POST['subjects'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $parent_name = mysqli_real_escape_string($conn, $_POST['parent_name'] ?? '');
    $parent_phone = mysqli_real_escape_string($conn, $_POST['parent_phone'] ?? '');

    // Update SQL
    $update_sql = "UPDATE tuition_students SET
        fullname='$fullname',
        email='$email',
        phone='$phone',
        dob='$dob',
        gender='$gender',
        class_grade='$class',
        school='$school',
        subjects='$subjects',
        address='$address',
        parent_name='$parent_name',
        parent_phone='$parent_phone',
        profile_photo='$profile_photo_updated_path'
        WHERE id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success_msg = "Profile updated successfully!";
        $_SESSION['user_name'] = $fullname;

        // Re-fetch updated data
        $result = mysqli_query($conn, "SELECT * FROM tuition_students WHERE id = '$user_id'");
        $data = mysqli_fetch_assoc($result);
        $profile_photo = $data['profile_photo'] ?? 'default.png';
    } else {
        $success_msg = "Failed to update profile: " . mysqli_error($conn);
    }
}
?>

<!-- HTML Section Below -->
<?php include 'navbar.php'; ?>
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6 pt-20">
    <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg my-9">

        <h2
            class="text-3xl font-extrabold mb-8 text-gray-800 dark:text-white flex items-center justify-center sm:justify-start">
            <i class="fa-solid fa-user-circle mr-3 text-indigo-600 dark:text-indigo-400"></i> Edit Your Profile
        </h2>

        <?php if (!empty($success_msg)): ?>
            <div id="successMessage"
                class="relative bg-gradient-to-r from-green-400 to-green-600 text-white px-6 py-3 rounded-lg mb-6 shadow-md text-center flex items-center justify-between">
                <span><?php echo htmlspecialchars($success_msg); ?></span>
                <button type="button" id="closeSuccessMessage" class="text-white hover:text-gray-200 focus:outline-none ml-4">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Profile Image Upload -->
                <div class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-inner">
                    <div class="relative w-40 h-40 mb-5">
                        <img src="uploads/profile/<?php echo htmlspecialchars($profile_photo); ?>" alt="Profile Photo"
                            class="rounded-full w-full h-full object-cover border-4 border-indigo-500 dark:border-indigo-400 shadow-md cursor-pointer transition-transform duration-200 hover:scale-105"
                            id="profileImageThumbnail">
                        <label for="profile_photo_input"
                            class="absolute h-12 w-12 bottom-0 right-0 bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-3 rounded-full cursor-pointer hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-300 transform hover:scale-110">
                            <i class="fas fa-camera text-lg"></i>
                            <input type="file" id="profile_photo_input" name="profile_photo" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Upload a new photo</p>
                    <p class="mt-1 text-xs text-gray-400">PNG, JPG, GIF (Max 2MB)</p>
                </div>

                <!-- Form Fields -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php
                    function renderInputField($name, $placeholder, $value, $type = "text", $required = false)
                    {
                        $req = $required ? 'required' : '';
                        echo "
                            <div>
                                <label for='{$name}' class='block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1'>{$placeholder}</label>
                                <input type='{$type}' id='{$name}' name='{$name}' placeholder='{$placeholder}' value='" . htmlspecialchars($value) . "' {$req}
                                    class='w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm
                                           bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                           focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out'>
                            </div>";
                    }

                    renderInputField('fullname', 'Full Name', $fullname, 'text', true);
                    renderInputField('email', 'Email Address', $email, 'email', true);
                    renderInputField('phone', 'Phone Number', $phone, 'text', true);
                    renderInputField('dob', 'Date of Birth', $dob, 'date', true);
                    ?>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                        <select id="gender" name="gender"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out">
                            <option value="Male" <?php if ($gender === "Male") echo "selected"; ?>>Male</option>
                            <option value="Female" <?php if ($gender === "Female") echo "selected"; ?>>Female</option>
                            <option value="Other" <?php if ($gender === "Other") echo "selected"; ?>>Other</option>
                        </select>
                    </div>

                    <?php
                    renderInputField('class', 'Class/Grade', $class);
                    renderInputField('school', 'School Name', $school);
                    renderInputField('subjects', 'Subjects (e.g., Math, Physics)', $subjects);
                    ?>

                    <!-- Address -->
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Full Address"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm
           bg-white dark:bg-gray-700 text-gray-900 dark:text-white
           focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out resize-none"><?php echo htmlspecialchars($address); ?></textarea>
                    </div>


                    <?php
                    renderInputField('parent_name', "Parent's Name", $parent_name);
                    renderInputField('parent_phone', "Parent's Phone", $parent_phone);
                    ?>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-10 flex justify-center">
                <button type="submit"
                    class="px-8 py-3 rounded-full font-semibold text-lg bg-gradient-to-br from-indigo-600 to-purple-700 text-white shadow-xl hover:shadow-2xl border border-indigo-500 transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-110 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="fa-solid fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="relative bg-white dark:bg-gray-800 p-2 rounded-lg shadow-sm max-w-2xl max-h-screen overflow-hidden">
        <button id="closeModal"
            class="absolute top-5 right-5 text-gray-700 dark:text-gray-300 text-3xl font-bold hover:text-white-400  focus:outline-none">&times;</button>
        <img src="" alt="Expanded Profile Photo" id="expandedImage"
            class="w-auto max-w-full max-h-[90vh] object-contain rounded-lg">
    </div>
</div>


<!-- JavaScript -->
<script>
    // Profile image modal
    const thumbnail = document.getElementById('profileImageThumbnail');
    const modal = document.getElementById('imageModal');
    const expanded = document.getElementById('expandedImage');
    const closeBtn = document.getElementById('closeModal');

    thumbnail?.addEventListener('click', () => {
        expanded.src = thumbnail.src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    closeBtn?.addEventListener('click', () => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    });

    modal?.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    // Success message
    const successBox = document.getElementById('successMessage');
    const successClose = document.getElementById('closeSuccessMessage');
    successClose?.addEventListener('click', () => {
        successBox.style.display = 'none';
    });
</script>

<?php include 'footer.php'; ?>