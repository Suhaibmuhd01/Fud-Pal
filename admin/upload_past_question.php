<?php
session_start();
require_once "../config/db_config.php";
$conn = connectDB();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $course_code = $_POST["course_code"];
    $admin_id = $_SESSION["admin_id"];
    $pdf_file = $_FILES["pdf_file"]["name"] ?? "";
    if ($pdf_file) {
        $target = "../uploads/past_questions/" . basename($pdf_file);
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target)) {
            $sql = "INSERT INTO past_questions (title, course_code, file_path, uploaded_by) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $title, $course_code, $pdf_file, $admin_id);
            if ($stmt->execute()) {
                $msg = "Past question uploaded successfully!";
            } else {
                $msg = "Database error.";
            }
        } else {
            $msg = "File upload failed.";
        }
    } else {
        $msg = "No file selected.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Past Question - FUD PAL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-primary mb-6 flex items-center gap-2"><i class="fas fa-upload"></i> Upload Past Question</h1>
        <?php if ($msg): ?>
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $msg ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="title" placeholder="Title" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary">
            <input type="text" name="course_code" placeholder="Course Code" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary">
            <input type="file" name="pdf_file" accept="application/pdf" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition">Upload</button>
        </form>
    </div>
</body>
</html>
