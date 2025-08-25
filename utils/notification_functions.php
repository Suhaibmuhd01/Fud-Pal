<?php

// Sanitize input data
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Redirect to specified URL
function redirect($url)
{
    header("Location: $url");
    exit;
}

// Get unread notification count
function getUnreadNotificationCount()
{
    global $conn;

    if (!isLoggedIn()) {
        return 0;
    }

    $userId = $_SESSION['user_id'];
    $sql = "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'];
}

// Generate page title
function pageTitle($title = '')
{
    if (empty($title)) {
        return SITE_NAME;
    }
    return $title . ' | ' . SITE_NAME;
}

// Format date
function formatDate($date, $format = 'd M Y, h:i A')
{
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

// Create URL-friendly slug
function createSlug($string)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}

// Get time ago (e.g., "2 hours ago")
function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;

    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $mins = round($diff / 60);
        return $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = round($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = round($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('j M Y', $time);
    }
}

// Get user details by ID
function getUserById($userId)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

// Log user activity
function logActivity($userId, $action, $details = '')
{
    global $conn;

    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $sql = "INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $userId, $action, $details, $ip, $userAgent);
    $stmt->execute();
}

// Add notification
function addNotification($userId, $message, $link = null)
{
    global $conn;

    $sql = "INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $message, $link);
    return $stmt->execute();
}

// Get user notifications
function getUserNotifications($limit = 5)
{
    global $conn;

    if (!isLoggedIn()) {
        return [];
    }

    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    return $notifications;
}

// Mark notification as read
function markNotificationAsRead($notificationId)
{
    global $conn;

    $sql = "UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $userId = $_SESSION['user_id'];
    $stmt->bind_param("ii", $notificationId, $userId);
    return $stmt->execute();
}
