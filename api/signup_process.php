<?php
// Start session
session_start();

// Database connection
function connectDB() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "fudpal_db";
    
    // Check if database exists, if not create it
    $conn = new mysqli($host, $username, $password);
    if ($conn->connect_error) {
        return [
            'success' => false,
            'message' => 'Database connection failed: ' . $conn->connect_error
        ];
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating database: ' . $conn->error
        ];
    }
    
    // Close connection and reconnect to the new database
    $conn->close();
    
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        return [
            'success' => false,
            'message' => 'Database connection failed: ' . $conn->connect_error
        ];
    }
    
    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        regnum VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        faculty VARCHAR(100) NOT NULL,
        department VARCHAR(100) NOT NULL,
        level INT(3) NOT NULL,
        session VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        security_question VARCHAR(100) NOT NULL,
        security_answer VARCHAR(255) NOT NULL,
        profile_picture VARCHAR(255) DEFAULT 'default.jpg',
        remember_token VARCHAR(255) DEFAULT NULL,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating users table: ' . $conn->error
        ];
    }
    
    // Create login_logs table
    $sql = "CREATE TABLE IF NOT EXISTS login_logs (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        ip_address VARCHAR(50) NOT NULL,
        user_agent TEXT NOT NULL,
        login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating login_logs table: ' . $conn->error
        ];
    }
    
    // Create announcements table
    $sql = "CREATE TABLE IF NOT EXISTS announcements (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        created_by INT(11) NOT NULL,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating announcements table: ' . $conn->error
        ];
    }
    
    // Create past_questions table
    $sql = "CREATE TABLE IF NOT EXISTS past_questions (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        course_code VARCHAR(20) NOT NULL,
        department VARCHAR(100) NOT NULL,
        level INT(3) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        uploaded_by INT(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating past_questions table: ' . $conn->error
        ];
    }
    
    // Create forum_topics table
    $sql = "CREATE TABLE IF NOT EXISTS forum_topics (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        created_by INT(11) NOT NULL,
        category VARCHAR(100) NOT NULL,
        views INT(11) DEFAULT 0,
        is_closed TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating forum_topics table: ' . $conn->error
        ];
    }
    
    // Create forum_replies table
    $sql = "CREATE TABLE IF NOT EXISTS forum_replies (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        topic_id INT(11) NOT NULL,
        content TEXT NOT NULL,
        created_by INT(11) NOT NULL,
        is_best_answer TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (topic_id) REFERENCES forum_topics(id) ON DELETE CASCADE,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating forum_replies table: ' . $conn->error
        ];
    }
    
    // Create notifications table
    $sql = "CREATE TABLE IF NOT EXISTS notifications (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        message TEXT NOT NULL,
        link VARCHAR(255) DEFAULT NULL,
        is_read TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        return [
            'success' => false,
            'message' => 'Error creating notifications table: ' . $conn->error
        ];
    }
    
    return $conn;
}

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $fullname = sanitizeInput($_POST['fullname']);
    $regnum = sanitizeInput($_POST['regnum']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $faculty = sanitizeInput($_POST['faculty']);
    $department = sanitizeInput($_POST['department']);
    $level = (int)$_POST['level'];
    $session = sanitizeInput($_POST['session']);
    $password = $_POST['password'];
    $security_question = sanitizeInput($_POST['security_question']);
    $security_answer = sanitizeInput($_POST['security_answer']);
    
    // Validate inputs
    if (empty($fullname) || empty($regnum) || empty($email) || empty($phone) || 
        empty($faculty) || empty($department) || empty($level) || empty($session) || 
        empty($password) || empty($security_question) || empty($security_answer)) {
        
        echo json_encode([
            'success' => false,
            'message' => 'All fields are required'
        ]);
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email format'
        ]);
        exit;
    }
    
    // Validate registration number format
    if (!preg_match('/^[A-Z]{2,5}\/[A-Z]{2,5}\/\d{2}\/\d{4}$/', $regnum)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid registration number format'
        ]);
        exit;
    }
    
    // Validate password strength
    if (strlen($password) < 8) {
        echo json_encode([
            'success' => false,
            'message' => 'Password must be at least 8 characters long'
        ]);
        exit;
    }
    
    // Connect to database
    $conn = connectDB();
    
    if (!is_object($conn)) {
        echo json_encode($conn); // Return error message if connection failed
        exit;
    }
    
    // Check if registration number already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE regnum = ?");
    $stmt->bind_param("s", $regnum);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Registration number already exists'
        ]);
        $stmt->close();
        $conn->close();
        exit;
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Email address already exists'
        ]);
        $stmt->close();
        $conn->close();
        exit;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO users (fullname, regnum, email, phone, faculty, department, level, session, password, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssissss", $fullname, $regnum, $email, $phone, $faculty, $department, $level, $session, $hashed_password, $security_question, $security_answer);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registration failed: ' . $stmt->error
        ]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    // Not a POST request
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>