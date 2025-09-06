<?php
session_start();

include '../../config/db_config.php';
include '../../utils/notification_functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';

// Get forum topics
$conn = connectDB();
$sql = "SELECT ft.*, u.fullname as author_name, 
        (SELECT COUNT(*) FROM forum_replies fr WHERE fr.topic_id = ft.id) as reply_count
        FROM forum_topics ft 
        JOIN users u ON ft.created_by = u.id 
        ORDER BY ft.created_at DESC";
$result = $conn->query($sql);
$topics = [];
while ($row = $result->fetch_assoc()) {
    $topics[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Forum - FUD PAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
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
        
        .topic-card {
            transition: all 0.3s ease;
        }
        
        .topic-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            <div class="flex items-center space-x-4">
                <a href="../notifications.php" class="relative">
                    <i class="fas fa-bell text-xl"></i>
                </a>
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
                            alt="Profile" class="w-14 h-14 aspect-square rounded-full object-cover border-4 border-white shadow-lg">
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
                    <li><a href="index.php" class="flex items-center space-x-3 px-4 py-3 bg-green-700 text-white"><i class="fas fa-comments"></i><span>Forum</span></a></li>
                    <li><a href="../profile/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-user"></i><span>Profile</span></a></li>
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
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-comments text-green-600 mr-3"></i> Community Forum
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Connect with fellow students, ask questions, and share knowledge.
                </p>
            </div>

            <!-- Forum Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <i class="fas fa-comments text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo count($topics); ?></h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Topics</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <i class="fas fa-users text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Active</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Community</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                            <i class="fas fa-reply text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                <?php 
                                $total_replies = 0;
                                foreach ($topics as $topic) {
                                    $total_replies += $topic['reply_count'];
                                }
                                echo $total_replies;
                                ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Replies</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create New Topic Button -->
            <div class="mb-6">
                <a href="create.php" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Topic
                </a>
            </div>

            <!-- Forum Topics -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Discussions</h2>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if (empty($topics)): ?>
                        <div class="p-8 text-center">
                            <i class="fas fa-comments text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">No Topics Yet</h3>
                            <p class="text-gray-500 dark:text-gray-500 mb-4">Be the first to start a discussion!</p>
                            <a href="create.php" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Create First Topic
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($topics as $topic): ?>
                            <div class="topic-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="../profile_image.php?regnum=<?php echo urlencode($topic['author_name']); ?>&t=<?php echo time(); ?>"
                                            alt="Author" class="w-12 h-12 rounded-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400">
                                                <a href="topic.php?id=<?php echo $topic['id']; ?>" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    <?php echo htmlspecialchars($topic['title']); ?>
                                                </a>
                                            </h3>
                                            <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full">
                                                <?php echo htmlspecialchars($topic['category']); ?>
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                            <?php echo htmlspecialchars(substr($topic['content'], 0, 150)) . (strlen($topic['content']) > 150 ? '...' : ''); ?>
                                        </p>
                                        <div class="flex items-center justify-between mt-3">
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <i class="fas fa-user mr-1"></i>
                                                    <?php echo htmlspecialchars($topic['author_name']); ?>
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-reply mr-1"></i>
                                                    <?php echo $topic['reply_count']; ?> replies
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    <?php echo $topic['views']; ?> views
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                <?php echo timeAgo($topic['created_at']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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

            $('#close-sidebar-mobile', '#sidebar-overlay').click(function() {
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