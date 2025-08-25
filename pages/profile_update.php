<?php

session_start();
include '../includes/config.php';

header('Content-Type: application/json');

$regnum = $_SESSION['regnum'] ?? '';
if (!$regnum) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}

$fullname = $_POST['fullname'] ?? '';
$faculty = $_POST['faculty'] ?? '';
$department = $_POST['department'] ?? '';

if (!$fullname || !$faculty || !$department) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

$update_img = false;
$img_blob = null;
$img_type = null;

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    $type = mime_content_type($_FILES['profile_picture']['tmp_name']);
    if (!in_array($type, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Only JPG, PNG, GIF allowed.']);
        exit;
    }
    if ($_FILES['profile_picture']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Image must be < 2MB.']);
        exit;
    }
    $img_blob = file_get_contents($_FILES['profile_picture']['tmp_name']);
    $img_type = $type;
    $update_img = true;
}

if ($update_img) {
    $stmt = $conn->prepare("UPDATE users SET fullname=?, faculty=?, department=?, profile_picture=?, profile_picture_type=? WHERE regnum=?");
    $stmt->bind_param("ssssss", $fullname, $faculty, $department, $img_blob, $img_type, $regnum);
} else {
    $stmt = $conn->prepare("UPDATE users SET fullname=?, faculty=?, department=? WHERE regnum=?");
    $stmt->bind_param("ssss", $fullname, $faculty, $department, $regnum);
}

if ($stmt->execute()) {
    // Optionally update session variables
    $_SESSION['fullname'] = $fullname;
    $_SESSION['faculty'] = $faculty;
    $_SESSION['department'] = $department;
    echo json_encode(['success' => true, 'message' => 'Profile updated!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed.']);
}
$stmt->close();