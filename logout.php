<?php

session_start();

// Clear the remember me cookie if it exists
if (isset($_COOKIE['fudpal_remember'])) {
    setcookie('fudpal_remember', '', time() - 3600, '/'); // Set expiration time to past time
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect user to login page
header("Location: login.php");
exit;
