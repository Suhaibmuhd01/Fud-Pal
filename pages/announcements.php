<?php
session_start();
include '../config/db_config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';

// Fetch all announcements
$conn = connectDB();
$stmt = $conn->prepare("SELECT a.*, u.fullname as author_name FROM announcements a JOIN users u ON a.created_by = u.id ORDER BY a.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - FUD PAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- tailwind cdn link -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- custom js  -->
    <script src="../assets/js/script.js"></script>


    <style>
        body { font-family: 'Poppins', sans-serif; }
        .announcement-card { transition: box-shadow 0.3s, transform 0.3s; }
        .announcement-card:hover { box-shadow: 0 8px 24px rgba(16,185,129,0.15); transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <header class="md:hidden bg-green-600 text-white sticky top-0 z-20 shadow-md">
        <div class="container px-4 py-3 mx-auto flex justify-between items-center">
            <button id="menu-btn" class="hamburger focus:outline-none">
                <span class="hamburger-top"></span>
                <span class="hamburger-middle"></span>
                <span class="hamburger-bottom"></span>
            </button>
            <div class="flex items-center space-x-2">
                <i class="fas fa-bullhorn"></i>
                <h1 class="text-xl font-bold">Announcements</h1>
            </div>
        </div>
    </header>
    <div class="flex min-h-screen">
        <!-- Desktop Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:sticky top-0 left-0 z-30 w-64 h-screen bg-green-600 text-white shadow-lg overflow-y-auto hidden md:block">
            <div class="p-4 border-b border-green-500">
                <div class="flex items-center justify-center space-x-2">
                    <i class="fas fa-bullhorn text-xl"></i>
                    <span class="text-xl font-bold">FUD PAL</span>
                </div>
            </div>
            <div class="p-4 border-b border-green-500">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="profile_image.php?regnum=<?php echo urlencode($regnum); ?>&t=<?php echo time(); ?>" alt="Profile" class="w-14 h-14 aspect-square rounded-full object-cover border-4 border-white shadow-lg">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-base text-white"><?php echo htmlspecialchars($fullname); ?></span>
                        <span class="text-xs text-green-200"><?php echo htmlspecialchars($regnum); ?></span>
                    </div>
                </div>
            </div>
            <nav class="py-4">
                <ul class="space-y-1">
                    <li><a href="../dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                    <li><a href="map.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-map-marker-alt"></i><span>Campus Map</span></a></li>
                    <li><a href="past_questions.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-question-circle"></i><span>Past Questions</span></a></li>
                    <li><a href="reg_guide.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Registration Guide</span></a></li>
                    <li><a href="guidelines.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Course Reg Guidelines</span></a></li>
                    <li><a href="faqs.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-info-circle"></i><span>FAQs</span></a></li>
                    <li><a href="../forums/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-comments"></i><span>Forum</span></a></li>
                    <li><a href="notifications.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-bell"></i><span>Notifications</span></a></li>
                    <li><a href="../profile/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-user"></i><span>Profile</span></a></li>
                </ul>
                <div class="mt-8 px-4">
                    <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>
        <!-- Mobile Sidebar -->
        <div id="mobile-sidebar" class="sidebar fixed top-0 left-0 h-full w-64 bg-green-600 text-white z-50 -translate-x-full md:hidden">
            <div class="flex items-center justify-between p-4 border-b border-green-500">
                <div class="flex items-center">
                    <i class="fas fa-bullhorn text-xl"></i>
                    <span class="text-xl font-bold ml-2">FUD PAL</span>
                </div>
                <button id="close-mobile-menu" class="focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 border-b border-green-500">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="../profile_image.php?regnum=<?php echo urlencode($regnum); ?>&t=<?php echo time(); ?>" alt="Profile" class="w-14 h-14 aspect-square rounded-full object-cover border-4 border-white shadow-lg">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-base text-white"><?php echo htmlspecialchars($fullname); ?></span>
                        <span class="text-xs text-green-200"><?php echo htmlspecialchars($regnum); ?></span>
                    </div>
                </div>
            </div>
            <nav class="py-4">
                <ul class="space-y-1">
                    <li><a href="../dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                    <li><a href="map.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-map-marker-alt"></i><span>Campus Map</span></a></li>
                    <li><a href="past_questions.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-question-circle"></i><span>Past Questions</span></a></li>
                    <li><a href="reg_guide.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Registration Guide</span></a></li>
                    <li><a href="guidelines.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Course Reg Guidelines</span></a></li>
                    <li><a href="faqs.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-info-circle"></i><span>FAQs</span></a></li>
                    <li><a href="../forums/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-comments"></i><span>Forum</span></a></li>
                    <li><a href="notifications.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-bell"></i><span>Notifications</span></a></li>
                    <li><a href="../profile/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-user"></i><span>Profile</span></a></li>
                </ul>
                <div class="mt-8 px-4">
                    <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <main class="flex-grow p-4 md:p-8 w-full md:w-[calc(100%-16rem)]">
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-bullhorn text-green-600 mr-3"></i> Announcements
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Stay updated with the latest news and updates from the admin.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($announcements)): ?>
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-bullhorn text-5xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">No Announcements Yet</h3>
                        <p class="text-gray-500 dark:text-gray-500">Check back later for updates from the admin.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="announcement-card bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-2">
                                <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full mr-2">
                                    <?php echo htmlspecialchars($announcement['author_name']); ?>
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo date('M d, Y h:i A', strtotime($announcement['created_at'])); ?>
                                </span>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                <?php echo htmlspecialchars($announcement['title']); ?>
                            </h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                <?php echo nl2br(htmlspecialchars($announcement['content'])); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <footer class="w-full text-center text-gray-500 dark:text-gray-400 text-sm mt-auto py-4 bg-white dark:bg-gray-800 shadow-md fixed bottom-0">
        <p>&copy; <span id="year"></span> FUD PAL. All rights reserved.</p>
    </footer>
    <script>
        $(document).ready(function() {
            const currentYear = new Date().getFullYear();
            $('#year').text(currentYear);
            // Mobile sidebar logic
            $('#menu-btn').on('click', function() {
                $('#mobile-sidebar').removeClass('-translate-x-full').addClass('translate-x-0');
            });
            $('#close-mobile-menu').on('click', function() {
                $('#mobile-sidebar').addClass('-translate-x-full').removeClass('translate-x-0');
            });
            // Optional: close sidebar when overlay is clicked
            $('#sidebar-overlay').on('click', function() {
                $('#mobile-sidebar').addClass('-translate-x-full').removeClass('translate-x-0');
            });
        });
    </script>
</body>
</html>
