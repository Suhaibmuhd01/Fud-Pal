<?php
// Start session
session_start();

// Database connection
function connectDB()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "fudpal_db";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        return [
            'success' => false,
            'message' => 'Database connection failed: ' . $conn->connect_error
        ];
    }

    return $conn;
}

// Function to sanitize input data
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $regnum = sanitizeInput($_POST['regnum']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? (int)$_POST['remember'] : 0;

    // Validate inputs
    if (empty($regnum) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Registration number and password are required'
        ]);
        exit;
    }

    // Connect to the database
    $conn = connectDB();

    if (!is_object($conn)) {
        echo json_encode($conn);
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE regnum = ?");
    $stmt->bind_param("s", $regnum);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['regnum'] = $regnum;
            $_SESSION['email'] = $user['email'];
            $_SESSION['department'] = $user['department'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['pic'] = $user['profile_picture'];
            $_SESSION['pictype'] = $user['profile_picture_type'] . '.jpg';
            $_SESSION['logged_in'] = true;

            // Set remember me cookie if requested
            if ($remember === 1) {
                // Generate a secure token
                $token = bin2hex(random_bytes(32));

                // Store token in database
                $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $stmt->bind_param("si", $token, $user['id']);
                $stmt->execute();

                // Set cookie that expires in 30 days
                // setcookie('fudpal_remember', $token, time() + (86400 * 30), "/", "", true, true);
                // cookie reduced to three days for security reasons
                setcookie('rememberme', $token, time() + 259200, "/"); // 3 days
            }

            // Log login activity
            $ip = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $stmt = $conn->prepare("INSERT INTO login_logs (user_id, ip_address, user_agent) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user['id'], $ip, $user_agent);
            $stmt->execute();

            echo json_encode([
                'success' => true,
                'redirect' => 'dashboard.php'
            ]);
        } else {
            // Incorrect password
            echo json_encode([
                'success' => false,
                'message' => 'Invalid registration number or password'
            ]);
        }
    } else {
        // User not found
        echo json_encode([
            'success' => false,
            'message' => 'Invalid registration number or password'
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
