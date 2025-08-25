<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "fudpal_db";

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Global site settings
define('SITE_NAME', 'FUD Pal');
define('SITE_URL', 'http://localhost/fudpal');
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/fudpal/uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>