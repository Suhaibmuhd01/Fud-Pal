<?php
session_start();
require_once "../config/db_config.php";
$conn = connectDB();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}

// Handle post submission
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["announcement"])) {
        $title = $_POST["title"];
        $body = $_POST["body"];
        $sql = "INSERT INTO announcements (title, body, created_by) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $body, $_SESSION["admin_id"]);
        if ($stmt->execute()) $msg = "Announcement posted!";
        else $msg = "Failed to post announcement.";
    }
    if (isset($_POST["event"])) {
        $event_title = $_POST["event_title"];
        $event_date = $_POST["event_date"];
        $event_desc = $_POST["event_desc"];
        $sql = "INSERT INTO events (title, event_date, description, created_by) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $event_title, $event_date, $event_desc, $_SESSION["admin_id"]);
        if ($stmt->execute()) $msg = "Event posted!";
        else $msg = "Failed to post event.";
    }
}

// Fetch admin info
$admin = $conn->query("SELECT * FROM admin WHERE id=" . intval($_SESSION["admin_id"]))->fetch_assoc();
// Fetch announcements & events
$announcements = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 5");
$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FUD PAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981',
                        secondary: '#D97706',
                        danger: '#EF4444',
                        dark: {
                            primary: '#065F46',
                            secondary: '#B45309',
                        },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <!-- Header -->
    <header class="w-full bg-green-600 text-white py-4 shadow-lg flex text-center justify-between px-6">
        <div class="flex items-center gap-3 md:ml-64">
            <img src="../assets/images/FudPal.png" alt="Admin" class="w-11 h-11 object-cover">
            <span class="font-bold text-xl text-center">FUD PAL Admin Dashboard</span>
        </div>
        <nav class="hidden md:flex gap-6">
            <div class="flex items-center space-x-4">
                <!-- Notification Dropdown -->
                <div class="relative">
                    <button id="notif-btn" class="relative focus:outline-none">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 block w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white text-gray-800 rounded shadow-lg z-50">
                        <div class="p-4 border-b font-bold text-gray-700">Notifications</div>
                        <div class="max-h-64 overflow-y-auto">
                            <div class="p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">No new notifications.</div>
                        </div>
                        <div class="p-2 text-center border-t bg-gray-50">
                            <a href="notifications.php" class="text-green-600 hover:underline text-sm">View all</a>
                        </div>
                    </div>
                </div>
                <!-- Profile Dropdown -->
                <div class="relative ml-2">
                    <button id="profile-btn" class="flex items-center gap-1 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-green-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="ml-1 font-semibold hidden md:inline text-gray-800">
                            <?= htmlspecialchars($admin['name'] ?? 'Admin') ?>
                        </span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-44 bg-white text-gray-800 rounded shadow-lg z-50">
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">View Profile</a>
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                        <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100 text-danger">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Hamburger for mobile -->
        <button id="hamburger" class="md:hidden block text-white focus:outline-none">
            <i class="fas fa-bars fa-2x"></i>
        </button>
    </header>
    <!-- Sidebar for desktop -->
    <div class="flex min-h-screen">
        <aside class="hidden md:flex md:fixed md:top-0 md:left-0 md:h-screen flex-col w-64 bg-green-600 text-white py-6 px-4 space-y-6 shadow-lg z-40">
            <div class="flex items-center gap-3 mb-6">
                <img src="../pages/profile_image.php?=<?= htmlspecialchars($admin['profile_image'] ?? 'default.png') ?>" alt="Admin" class="w-12 h-12 rounded-full border-2 border-white object-cover">
                <div>
                    <div class="font-bold text-lg"><?= htmlspecialchars($admin['name'] ?? 'Admin') ?></div>
                </div>
            </div>
            <hr />
            <nav class="flex flex-col gap-2">
                <a href="dashboard.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="profile.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-user-edit"></i> Edit Profile</a>
                <a href="manage_users.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-users"></i> Manage Users</a>
                <a href="logout.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-danger transition"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
            <aside class="hidden md:flex flex-col w-64 bg-green-600 text-white py-6 px-4 space-y-6 shadow-lg fixed top-0 left-0 h-full z-40">
                <div class="flex items-center gap-3 mb-6">
                    <img src="../pages/profile_image.php?=<?= htmlspecialchars($admin['profile_image'] ?? 'default.png') ?>" alt="Admin" class="w-12 h-12 rounded-full border-2 border-white object-cover">
                    <div>
                        <div class="font-bold text-lg"><?= htmlspecialchars($admin['name'] ?? 'Admin') ?></div>
                    </div>
                </div>
                <nav class="flex flex-col gap-2">
                    <a href="dashboard.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="analytics.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-chart-bar"></i> Analytics</a>
                    <a href="roles.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-user-shield"></i> Roles & Permissions</a>
                    <a href="bulk_actions.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-tasks"></i> Bulk User Actions</a>
                    <a href="moderation.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-gavel"></i> Moderation</a>
                    <a href="notifications.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-bell"></i> Notifications</a>
                    <a href="audit_logs.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-clipboard-list"></i> Audit Logs</a>
                    <a href="backup.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-database"></i> Backup & Restore</a>
                    <a href="support.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-headset"></i> Support Tickets</a>
                    <a href="settings.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-cogs"></i> Settings</a>
                    <a href="file_manager.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-folder-open"></i> File Manager</a>
                    <a href="profile.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-user-edit"></i> Edit Profile</a>
                    <a href="manage_users.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-dark-primary transition"><i class="fas fa-users"></i> Manage Users</a>
                    <a href="logout.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-danger transition"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </nav>
            </aside>
        <!-- Main content -->
        <main class="flex-1 p-2 sm:p-6 max-w-7xl w-full mx-auto md:ml-64">
            <!-- Mobile nav -->
            <div class="md:hidden flex justify-between items-center bg-primary text-white px-4 py-3 rounded mb-4">
                <span class="font-bold text-lg">Admin Dashboard</span>
                <a href="profile.php" class="text-xs underline text-white hover:text-dark-secondary">Edit Profile</a>
            </div>
            <!-- Welcome message -->
            <div class="bg-dark-primary text-white rounded-xl p-6 mb-6 flex flex-col sm:flex-row items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Welcome, <?= htmlspecialchars($admin['name'] ?? 'Admin') ?>!</h1>
                    <p class="text-sm">Manage your announcements, events, users, and resources from this dashboard.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="profile.php" class="bg-primary text-white px-4 py-2 rounded hover:bg-dark-secondary transition">Edit Profile</a>
                </div>
            </div>
            <!-- Upload Past Questions -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8 animate-fade-in">
                <h2 class="text-2xl font-bold mb-4 text-green-600 flex items-center gap-2"><i class="fas fa-upload"></i> Upload Past Question</h2>
                <form method="POST" action="upload_past_question.php" enctype="multipart/form-data" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course Code</label>
                        <input type="text" name="course_code" placeholder="e.g. CSC101" required
                            class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course Title</label>
                        <input type="text" name="title" placeholder="e.g. Introduction to Computer Science" required
                            class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Faculty</label>
                        <select name="faculty" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                            <option value="">Select Faculty</option>
                            <option value="computing">Faculty of Computing</option>
                            <option value="sciences">Faculty of Sciences</option>
                            <option value="agriculture">Faculty of Agriculture</option>
                            <option value="management">Faculty of Management Sciences</option>
                            <option value="arts">Faculty of Arts & Social Sciences</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <select name="department" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition" disabled>
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                            <select name="level" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                                <option value="">Select Level</option>
                                <option value="100">100 Level</option>
                                <option value="200">200 Level</option>
                                <option value="300">300 Level</option>
                                <option value="400">400 Level</option>
                                <option value="500">500 Level</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                            <select name="session" required class="w-full rounded-lg border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600 transition">
                                <option value="">Select Session</option>
                                <option value="2022/2023">2022/2023</option>
                                <option value="2021/2022">2021/2022</option>
                                <option value="2020/2021">2020/2021</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Upload (PDF only)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-file-pdf text-green-600 text-3xl mb-3"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="pdf_file" class="relative cursor-pointer rounded-md font-medium text-green-700 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Upload a file</span>
                                        <input id="pdf_file" name="pdf_file" type="file" class="sr-only" accept="application/pdf" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">Upload</button>
                    </div>
                </form>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-primary flex items-center gap-2"><i class="fas fa-bullhorn"></i> Post Announcement</h2>
            <?php if ($msg): ?>
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $msg ?></div>
            <?php endif; ?>
            <form method="POST" class="space-y-3">
                <input type="hidden" name="announcement" value="1">
                <input type="text" name="title" placeholder="Title" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary">
                <textarea name="body" placeholder="Announcement body" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary"></textarea>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition">Post</button>
            </form>
            <h3 class="mt-8 text-lg font-semibold text-primary"><i class="fas fa-list"></i> Recent Announcements</h3>
            <ul class="mt-2 space-y-2">
                <?php while ($row = $announcements->fetch_assoc()): ?>
                    <li class="bg-gray-50 p-3 rounded shadow flex flex-col gap-1">
                        <strong class="text-primary"><?= htmlspecialchars($row["title"]) ?></strong>
                        <p><?= htmlspecialchars($row["body"]) ?></p>
                        <span class="text-xs text-gray-500"><?= date("M d, Y", strtotime($row["created_at"])) ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-primary flex items-center gap-2"><i class="fas fa-calendar-plus"></i> Post Event</h2>
            <form method="POST" class="space-y-3">
                <input type="hidden" name="event" value="1">
                <input type="text" name="event_title" placeholder="Event Title" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary">
                <input type="date" name="event_date" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary">
                <textarea name="event_desc" placeholder="Event Description" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-primary"></textarea>
                <button type="submit" class="bg-secondary text-white px-4 py-2 rounded hover:bg-primary transition">Post</button>
            </form>
            <h3 class="mt-8 text-lg font-semibold text-primary"><i class="fas fa-list"></i> Upcoming Events</h3>
            <ul class="mt-2 space-y-2">
                <?php while ($row = $events->fetch_assoc()): ?>
                    <li class="bg-gray-50 p-3 rounded shadow flex flex-col gap-1">
                        <strong class="text-primary"><?= htmlspecialchars($row["title"]) ?></strong>
                        <p><?= htmlspecialchars($row["description"]) ?></p>
                        <span class="text-xs text-gray-500"><?= date("M d, Y", strtotime($row["event_date"])) ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Analytics -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold mb-2 text-primary flex items-center gap-2"><i class="fas fa-chart-bar"></i> Analytics</h3>
            <p class="mb-1">Total Users: <span class="font-bold text-secondary"><?= $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0] ?></span></p>
            <p class="mb-1">Total Announcements: <span class="font-bold text-secondary"><?= $conn->query("SELECT COUNT(*) FROM announcements")->fetch_row()[0] ?></span></p>
            <p class="mb-1">Total Events: <span class="font-bold text-secondary"><?= $conn->query("SELECT COUNT(*) FROM events")->fetch_row()[0] ?></span></p>
        </div>
        <!-- Manage Users -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold mb-2 text-primary flex items-center gap-2"><i class="fas fa-users"></i> Manage Users</h3>
            <form method="GET" action="manage_users.php" class="flex gap-2 mb-2">
                <input type="text" name="search" placeholder="Search users..." class="px-2 py-1 border rounded w-full focus:outline-none focus:ring focus:ring-primary">
                <button type="submit" class="bg-primary text-white px-3 py-1 rounded hover:bg-secondary">Search</button>
            </form>
            <a href="manage_users.php" class="text-primary underline mt-2 block">View All Users</a>
        </div>
    </div>
    <!-- More features -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold mb-2 text-primary flex items-center gap-2"><i class="fas fa-cogs"></i> Quick Actions</h3>
            <ul class="list-disc ml-6 text-gray-700">
                <li><a href="profile.php" class="text-primary hover:underline">Edit Profile</a></li>
                <li><a href="manage_users.php" class="text-primary hover:underline">Manage Users</a></li>
                <li><a href="dashboard.php" class="text-primary hover:underline">Refresh Dashboard</a></li>
                <li><a href="logout.php" class="text-danger hover:underline">Logout</a></li>
                    <li><a href="analytics.php" class="text-primary hover:underline">View Analytics</a></li>
                    <li><a href="roles.php" class="text-primary hover:underline">Manage Roles & Permissions</a></li>
                    <li><a href="bulk_actions.php" class="text-primary hover:underline">Bulk User Actions</a></li>
                    <li><a href="moderation.php" class="text-primary hover:underline">Moderate Content</a></li>
                    <li><a href="notifications.php" class="text-primary hover:underline">Send Notifications</a></li>
                    <li><a href="audit_logs.php" class="text-primary hover:underline">View Audit Logs</a></li>
                    <li><a href="backup.php" class="text-primary hover:underline">Backup & Restore</a></li>
                    <li><a href="support.php" class="text-primary hover:underline">Support Tickets</a></li>
                    <li><a href="settings.php" class="text-primary hover:underline">System Settings</a></li>
                    <li><a href="file_manager.php" class="text-primary hover:underline">File Manager</a></li>
                    <li><a href="profile.php" class="text-primary hover:underline">Edit Profile</a></li>
                    <li><a href="manage_users.php" class="text-primary hover:underline">Manage Users</a></li>
                    <li><a href="dashboard.php" class="text-primary hover:underline">Refresh Dashboard</a></li>
                    <li><a href="logout.php" class="text-danger hover:underline">Logout</a></li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold mb-2 text-primary flex items-center gap-2"><i class="fas fa-info-circle"></i> Help & Support</h3>
            <p class="text-gray-700">Need help? Contact support or check the <a href="../pages/faqs.php" class="text-primary underline">FAQs</a>.</p>
        </div>
    </div>
        <!-- Dashboard widgets for analytics and audit logs -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="font-bold mb-2 text-green-700 flex items-center gap-2"><i class="fas fa-chart-bar"></i> User Analytics</h3>
                <p class="text-gray-700">See <a href="analytics.php" class="text-primary underline">Analytics</a> for more details.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="font-bold mb-2 text-green-700 flex items-center gap-2"><i class="fas fa-clipboard-list"></i> Audit Logs</h3>
                <p class="text-gray-700">See <a href="audit_logs.php" class="text-primary underline">Audit Logs</a> for admin activity history.</p>
            </div>
        </div>
            <!-- Footer -->
            <footer class="w-full bg-green-700 text-white py-4 mt-8 text-center shadow-md">
                &copy; <?= date('Y') ?> FUD PAL Admin. All rights reserved.
            </footer>
        </main>
    </div>
<script>

// Hamburger menu toggle for mobile
document.getElementById('hamburger')?.addEventListener('click', function() {
    const sidebar = document.querySelector('aside');
    if (sidebar) {
        sidebar.classList.toggle('hidden');
    }
});

// Department options mapped by faculty, copied and expanded from the user past questions page.
const departmentsByFaculty = {
    computing: [
        'Computer Science',
        'Information Technology',
        'Software Engineering',
        'Cyber Security'
    ],
    sciences: [
        'Physics',
        'Chemistry',
        'Biology',
        'Mathematics',
        'Biochemistry'
    ],
    agriculture: [
        'Crop Science',
        'Animal Science',
        'Agricultural Economics',
        'Agricultural Extension'
    ],
    management: [
        'Accounting',
        'Business Administration',
        'Economics',
        'Banking and Finance'
    ],
    BMS: [
        'Physiology',
        'Anatomy',
        'Nursing',
        'Public Health',
 
    ],
    management: [
        'Accounting',
        'Business Administration',
        'Economics',
        'Banking and Finance'
    ],
    management: [
        'Accounting',
        'Business Administration',
        'Economics',
        'Banking and Finance'
    ],
    arts: [
        'English Language',
        'History',
        'Political Science',
        'Sociology'
    ]
};
const facultySelect = document.querySelector('select[name="faculty"]');
const deptSelect = document.querySelector('select[name="department"]');
facultySelect && facultySelect.addEventListener('change', function() {
    const value = facultySelect.value;
    deptSelect.innerHTML = '<option value="">Select Department</option>';
    if (departmentsByFaculty[value]) {
        deptSelect.disabled = false;
        departmentsByFaculty[value].forEach(function(dept) {
            deptSelect.innerHTML += `<option value="${dept.toLowerCase().replace(/\s+/g,'_')}">${dept}</option>`;
        });
    } else {
        deptSelect.disabled = true;
    }
});
</script>
</body>
</html>