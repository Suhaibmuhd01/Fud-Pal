<?php
session_start();
require_once "../config/db_config.php";
$conn = connectDB();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}
$id = $_SESSION["admin_id"];
$msg = "";

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $reg_number = $_POST["reg_number"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $faculty = $_POST["faculty"];
    $department = $_POST["department"];
    $level = $_POST["level"];
    $session = $_POST["session"];
    $profile_image = $_FILES["profile_image"]["name"] ?? "";
    if ($profile_image) {
        $target = "../uploads/profile_pics/" . basename($profile_image);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target);
        $sql = "UPDATE admin SET name=?, reg_number=?, email=?, phone=?, faculty=?, department=?, level=?, session=?, profile_image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $name, $reg_number, $email, $phone, $faculty, $department, $level, $session, $profile_image, $id);
    } else {
        $sql = "UPDATE admin SET name=?, reg_number=?, email=?, phone=?, faculty=?, department=?, level=?, session=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $name, $reg_number, $email, $phone, $faculty, $department, $level, $session, $id);
    }
    if ($stmt->execute()) $msg = "Profile updated!";
    else $msg = "Update failed.";
}

// Fetch admin info
$sql = "SELECT * FROM admin WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.9s cubic-bezier(.39,.575,.565,1.000) both;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-lg mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg animate-fade-in">
        <h2 class="text-3xl font-extrabold mb-6 text-green-600 text-center flex items-center gap-2 justify-center"><i class="fas fa-user-edit"></i> Admin Profile</h2>
        <?php if ($msg): ?>
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4 transition animate-fade-in text-center font-medium"><?= $msg ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div class="flex flex-col items-center gap-4 mb-6">
                <img src="../pages/profile_image.php<?= htmlspecialchars($admin["profile_image"]) ?>" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-green-200 shadow-lg transition duration-300 hover:scale-105">
                <label class="block w-full text-center">
                    <span class="block text-gray-700 font-medium mb-1">Change Profile Image</span>
                    <input type="file" name="profile_image" accept="image/*" class="block mx-auto text-center file:rounded-full file:border-none file:bg-green-100 file:text-green-700 file:font-semibold file:py-1 file:px-3 file:cursor-pointer ">
                </label>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($admin["name"]) ?>" placeholder="Name" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Reg Number</label>
                <input type="text" name="reg_number" value="<?= htmlspecialchars($admin["reg_number"]) ?>" placeholder="Reg Number" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($admin["email"]) ?>" placeholder="Email" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($admin["phone"]) ?>" placeholder="Phone" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Faculty</label>
                <input type="text" name="faculty" value="<?= htmlspecialchars($admin["faculty"]) ?>" placeholder="Faculty" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Department</label>
                <input type="text" name="department" value="<?= htmlspecialchars($admin["department"]) ?>" placeholder="Department" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Level</label>
                    <input type="text" name="level" value="<?= htmlspecialchars($admin["level"]) ?>" placeholder="Level" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Session</label>
                    <input type="text" name="session" value="<?= htmlspecialchars($admin["session"]) ?>" placeholder="Session" class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                </div>
            </div>
            <button type="submit" class="w-full px-4 py-2 mt-4 border border-transparent rounded-lg shadow-sm text-lg font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all transform hover:scale-105">Update Profile</button>
        </form>
    </div>
</body>
</html>
