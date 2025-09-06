<?php

// Sanitize input data
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Redirect to specified URL
function redirect($url)
{
    header("Location: $url");
    exit;
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

// Removed sections

// Add notification

// Get user notifications

// Mark notification as read
