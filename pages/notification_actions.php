<?php
session_start();
include '../config/db_config.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

if ($action === 'mark_read' && isset($_POST['notification_id'])) {
    $notification_id = (int)$_POST['notification_id'];
    
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $notification_id, $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to mark as read']);
    }
    
    $stmt->close();
    $conn->close();
    
} elseif ($action === 'mark_all_read') {
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to mark all as read']);
    }
    
    $stmt->close();
    $conn->close();
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>