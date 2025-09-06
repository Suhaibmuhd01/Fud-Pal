<?php
session_start();
include '../includes/config.php';

$regnum = $_GET['regnum'] ?? '';
if (!$regnum) {
    // Return default image
    header('Content-Type: image/svg+xml');
    readfile('../assets/images/user-solid.svg');
    exit;
}

$stmt = $conn->prepare("SELECT profile_picture, profile_picture_type FROM users WHERE regnum = ?");
$stmt->bind_param("s", $regnum);
$stmt->execute();
$stmt->bind_result($profile_picture, $profile_picture_type);

if ($stmt->fetch() && $profile_picture) {
    header('Content-Type: ' . $profile_picture_type);
    echo $profile_picture;
} else {
    // Return default image
    header('Content-Type: image/svg+xml');
    readfile('../assets/images/user-solid.svg');
}

$stmt->close();
$conn->close();
?>