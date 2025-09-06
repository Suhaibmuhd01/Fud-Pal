<?php
require_once "../config/db_config.php";
$conn = connectDB();
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $reg_number = $_POST["reg_number"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $faculty = $_POST["faculty"];
    $department = $_POST["department"];
    $level = $_POST["level"];
    $session = $_POST["session"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $security_question = $_POST["security_question"];
    $security_answer = $_POST["security_answer"];
    $profile_image = $_FILES["profile_image"]["name"] ?? "default.png";
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if ($profile_image && $profile_image !== "default.png") {
            $target = "../uploads/profile_pics/" . basename($profile_image);
            move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target);
        }
        $sql = "INSERT INTO admin (name, reg_number, email, phone, faculty, department, level, session, password, security_question, security_answer, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $name, $reg_number, $email, $phone, $faculty, $department, $level, $session, $hash, $security_question, $security_answer, $profile_image);
        if ($stmt->execute()) {
            $success = "Account created! You can now login.";
        } else {
            $error = "Signup failed. Email or reg number may already exist.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Signup</title>
    <link href="../assets/css/tailwind.css" rel="stylesheet">
       <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Signup</h2>
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="name" placeholder="Name" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="text" name="reg_number" placeholder="Reg Number" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="text" name="phone" placeholder="Phone" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="text" name="faculty" placeholder="Faculty" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="text" name="department" placeholder="Department" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="text" name="level" placeholder="Level" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="text" name="session" placeholder="Session" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <input type="password" name="confirm" placeholder="Confirm Password" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <select name="security_question" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
                <option value="">Select Security Question</option>
                <option value="mother_name">What is your mother's maiden name?</option>
                <option value="pet_name">What was the name of your first pet?</option>
                <option value="birth_city">What city were you born in?</option>
                <option value="school_name">What was the name of your primary school?</option>
                <option value="favorite_color">What is your favorite color?</option>
            </select>
            <input type="text" name="security_answer" placeholder="Security Answer" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
            <label class="block">Profile Image (optional): <input type="file" name="profile_image" accept="image/*" class="mt-1"></label>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Sign Up</button>
        </form>
        <div class="mt-4 text-center">
            <a href="login.php" class="text-blue-600 hover:underline">Already have an account?</a>
        </div>
    </div>
</body>
</html>