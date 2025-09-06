<?php
session_start();
include '../../config/db_config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';

$message = '';
$success = false;

// Get user details
$conn = connectDB();
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: ../../login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_fullname = trim($_POST['fullname'] ?? '');
    $new_email = trim($_POST['email'] ?? '');
    $new_phone = trim($_POST['phone'] ?? '');
    $new_faculty = trim($_POST['faculty'] ?? '');
    $new_department = trim($_POST['department'] ?? '');
    
    if (empty($new_fullname) || empty($new_email) || empty($new_phone) || empty($new_faculty) || empty($new_department)) {
        $message = 'All fields are required.';
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format.';
    } else {
        // Check if email is already taken by another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $new_email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = 'Email address is already taken by another user.';
        } else {
            // Update user information
            $stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, faculty = ?, department = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $new_fullname, $new_email, $new_phone, $new_faculty, $new_department, $user_id);
            
            if ($stmt->execute()) {
                // Update session variables
                $_SESSION['fullname'] = $new_fullname;
                $_SESSION['email'] = $new_email;
                $_SESSION['faculty'] = $new_faculty;
                $_SESSION['department'] = $new_department;
                
                $message = 'Profile updated successfully!';
                $success = true;
                
                // Refresh user data
                $user['fullname'] = $new_fullname;
                $user['email'] = $new_email;
                $user['phone'] = $new_phone;
                $user['faculty'] = $new_faculty;
                $user['department'] = $new_department;
            } else {
                $message = 'Failed to update profile. Please try again.';
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - FUD PAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981',
                        secondary: '#D97706',
                        danger: '#EF4444',
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
        
        .hamburger {
            cursor: pointer;
            width: 24px;
            height: 24px;
            transition: all 0.25s;
            position: relative;
        }
        
        .hamburger-top,
        .hamburger-middle,
        .hamburger-bottom {
            position: absolute;
            top: 0;
            left: 0;
            width: 24px;
            height: 2px;
            background: white;
            transform: rotate(0);
            transition: all 0.5s;
        }
        
        .hamburger-middle {
            transform: translateY(7px);
        }
        
        .hamburger-bottom {
            transform: translateY(14px);
        }
        
        .open .hamburger-top {
            transform: rotate(45deg) translateY(6px) translateX(6px);
        }
        
        .open .hamburger-middle {
            display: none;
        }
        
        .open .hamburger-bottom {
            transform: rotate(-45deg) translateY(6px) translateX(-6px);
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <!-- Mobile Header -->
    <header class="md:hidden bg-green-600 text-white sticky top-0 z-20 shadow-md">
        <div class="container px-4 py-3 mx-auto flex justify-between items-center">
            <button id="menu-btn" class="hamburger focus:outline-none">
                <span class="hamburger-top"></span>
                <span class="hamburger-middle"></span>
                <span class="hamburger-bottom"></span>
            </button>
            <div class="flex items-center space-x-2">
                <i class="fas fa-users"></i>
                <h1 class="text-xl font-bold">FUD PAL</h1>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:sticky top-0 left-0 z-30 w-64 h-screen bg-green-600 text-white shadow-lg overflow-y-auto">
            <div class="md:flex hidden items-center justify-between p-4 border-b border-green-500">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-users text-2xl"></i>
                    <h2 class="text-xl font-bold">FUD PAL</h2>
                </div>
            </div>
            
            <div class="flex md:hidden items-center justify-between p-4 border-b border-green-500">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-users text-2xl"></i>
                    <h2 class="text-xl font-bold">FUD PAL</h2>
                </div>
                <button id="close-sidebar-mobile" class="text-2xl focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4 border-b border-green-500">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="../profile_image.php?regnum=<?php echo urlencode($regnum); ?>&t=<?php echo time(); ?>"
                            alt="Profile" class="w-14 h-14 rounded-full object-cover border-4 border-white shadow-lg">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-base text-white"><?php echo htmlspecialchars($fullname); ?></span>
                        <span class="text-xs text-green-200"><?php echo htmlspecialchars($regnum); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="py-4">
                <ul class="space-y-1">
                    <li><a href="../../dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                    <li><a href="../map.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-map-marker-alt"></i><span>Campus Map</span></a></li>
                    <li><a href="../past_questions.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-question-circle"></i><span>Past Questions</span></a></li>
                    <li><a href="../reg_guide.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Registration Guide</span></a></li>
                    <li><a href="../guidelines.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Course Reg Guidelines</span></a></li>
                    <li><a href="../faqs.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-info-circle"></i><span>FAQs</span></a></li>
                    <li><a href="../forums/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-comments"></i><span>Forum</span></a></li>
                    <li><a href="index.php" class="flex items-center space-x-3 px-4 py-3 bg-green-700 text-white"><i class="fas fa-user"></i><span>Profile</span></a></li>
                </ul>
                <div class="mt-8 px-4">
                    <a href="../../logout.php" class="flex items-center space-x-3 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-4 md:p-8 w-full md:w-[calc(100%-16rem)]">
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="index.php" class="text-green-600 dark:text-green-400 hover:underline mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Profile
                    </a>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-edit text-green-600 mr-3"></i> Edit Profile
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Update your personal information and account details.
                </p>
            </div>

            <!-- Edit Profile Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="p-6">
                    <?php if ($message): ?>
                        <div class="mb-6 p-4 rounded-lg <?php echo $success ? 'bg-green-100 text-green-700 border-green-300' : 'bg-red-100 border-red-300 text-red-700'; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="fullname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name
                                </label>
                                <input type="text" id="fullname" name="fullname" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    value="<?php echo htmlspecialchars($user['fullname']); ?>">
                            </div>
                            
                            <div>
                                <label for="regnum" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Registration Number
                                </label>
                                <input type="text" id="regnum" name="regnum" readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400"
                                    value="<?php echo htmlspecialchars($user['regnum']); ?>">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Registration number cannot be changed</p>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>
                            
                            <div>
                                <label for="faculty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Faculty
                                </label>
                                <select id="faculty" name="faculty" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select Faculty</option>
                                    <option value="Computing" <?php echo $user['faculty'] === 'Computing' ? 'selected' : ''; ?>>Faculty of Computing</option>
                                    <option value="Sciences" <?php echo $user['faculty'] === 'Sciences' ? 'selected' : ''; ?>>Faculty of Sciences</option>
                                    <option value="Education" <?php echo $user['faculty'] === 'Education' ? 'selected' : ''; ?>>Faculty of Education</option>
                                    <option value="Agriculture" <?php echo $user['faculty'] === 'Agriculture' ? 'selected' : ''; ?>>Faculty of Agriculture</option>
                                    <option value="Management" <?php echo $user['faculty'] === 'Management' ? 'selected' : ''; ?>>Faculty of Management Sciences</option>
                                    <option value="Arts" <?php echo $user['faculty'] === 'Arts' ? 'selected' : ''; ?>>Faculty of Arts & Social Sciences</option>
                                    <option value="Clinical" <?php echo $user['faculty'] === 'Clinical' ? 'selected' : ''; ?>>Faculty of Clinical Science</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Department
                                </label>
                                <input type="text" id="department" name="department" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    value="<?php echo htmlspecialchars($user['department']); ?>">
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="index.php" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                <p>&copy; <span id="year"></span> FUD PAL. All rights reserved.</p>
            </footer>
        </main>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

    <script>
        $(document).ready(function() {
            const currentYear = new Date().getFullYear();
            $('#year').text(currentYear);

            // Mobile menu toggle
            $('#menu-btn').click(function() {
                $(this).toggleClass('open');
                $('#sidebar').toggleClass('open');
                $('#sidebar-overlay').toggleClass('hidden');
                $('body').toggleClass('overflow-hidden');
            });

            $('#close-sidebar-mobile, #sidebar-overlay').click(function() {
                $('#menu-btn').removeClass('open');
                $('#sidebar').removeClass('open');
                $('#sidebar-overlay').addClass('hidden');
                $('body').removeClass('overflow-hidden');
            });

            $(window).resize(function() {
                if (window.innerWidth >= 768) {
                    $('#sidebar-overlay').addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                }
            });
        });
    </script>
</body>
</html>