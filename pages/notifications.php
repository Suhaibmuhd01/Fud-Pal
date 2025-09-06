<?php
session_start();
include '../config/db_config.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';

// Handle mark as read action
if (isset($_POST['mark_read']) && isset($_POST['notification_id'])) {
    $notification_id = (int)$_POST['notification_id'];
    markNotificationAsRead($notification_id);
    header("Location: notifications.php");
    exit;
}

// Get all notifications for the user
$notifications = getUserNotifications(50); // Get more notifications for the page
$unread_count = getUnreadNotificationCount($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - FUD PAL</title>
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
        
        .notification-item {
            transition: all 0.3s ease;
        }
        
        .notification-item:hover {
            transform: translateX(5px);
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
            <span class="w4 h4 mt-0">
                <i class="fa-arrow-left" onclick="window.history.back()"> </i>
            </span>
            <div class="flex items-center space-x-2">
                <i class="fas fa-users"></i>
                <h1 class="text-xl font-bold">FUD PAL</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-xl"></i>
                    <?php if ($unread_count > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </div>
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
                        <img src="profile_image.php?regnum=<?php echo urlencode($regnum); ?>&t=<?php echo time(); ?>"
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
                    <li><a href="../dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                    <li><a href="map.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-map-marker-alt"></i><span>Campus Map</span></a></li>
                    <li><a href="past_questions.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-question-circle"></i><span>Past Questions</span></a></li>
                    <li><a href="reg_guide.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Registration Guide</span></a></li>
                    <li><a href="guidelines.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Course Reg Guidelines</span></a></li>
                    <li><a href="faqs.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-info-circle"></i><span>FAQs</span></a></li>
                    <li><a href="forums/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-comments"></i><span>Community Forum</span></a></li>
                    <li><a href="profile/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-user"></i><span>Profile</span></a></li>
                </ul>
                <div class="mt-8 px-4">
                    <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
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
                    <i class="fas fa-bell text-green-600 mr-3"></i> Notifications
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Stay updated with important announcements and messages.
                </p>
            </div>

            <!-- Notification Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <i class="fas fa-bell text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo count($notifications); ?></h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Notifications</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                            <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo $unread_count; ?></h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Unread</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?php echo count($notifications) - $unread_count; ?></h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Read</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">All Notifications</h2>
                    <?php if ($unread_count > 0): ?>
                        <button id="mark-all-read" class="text-sm text-green-600 dark:text-green-400 hover:underline">
                            Mark All as Read
                        </button>
                    <?php endif; ?>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if (empty($notifications)): ?>
                        <div class="p-8 text-center">
                            <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">No Notifications</h3>
                            <p class="text-gray-500 dark:text-gray-500">You're all caught up! Check back later for updates.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notification): ?>
                            <div class="notification-item p-4 <?php echo $notification['is_read'] ? 'bg-gray-50 dark:bg-gray-800' : 'bg-blue-50 dark:bg-blue-900'; ?> hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                 data-id="<?php echo $notification['id']; ?>">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <?php if (!$notification['is_read']): ?>
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                                        <?php else: ?>
                                            <div class="w-3 h-3 bg-gray-300 rounded-full mt-2"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            <?php echo htmlspecialchars($notification['message']); ?>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?php echo timeAgo($notification['created_at']); ?>
                                        </p>
                                        <?php if ($notification['link']): ?>
                                            <a href="<?php echo htmlspecialchars($notification['link']); ?>" 
                                               class="text-xs text-green-600 dark:text-green-400 hover:underline mt-1 inline-block">
                                                View Details <i class="fas fa-external-link-alt ml-1"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!$notification['is_read']): ?>
                                        <div class="flex-shrink-0">
                                            <forsm method="post" class="inline">
                                                <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                                <button type="submit" name="mark_read" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">
                                                    <i class="fas fa-check text-sm"></i>
                                                </button>
                                            </forsm>
                                        </div>
                                    <?php endif; ?>
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

            // Mark all as read functionality
            $('#mark-all-read').click(function() {
                $.post('notification_actions.php', { action: 'mark_all_read' }, function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }, 'json');
            });

            // Click notification to mark as read
            $('.notification-item').click(function() {
                const notificationId = $(this).data('id');
                const isRead = $(this).hasClass('bg-gray-50') || $(this).hasClass('dark:bg-gray-800');
                
                if (!isRead) {
                    $.post('notification_actions.php', { 
                        action: 'mark_read', 
                        notification_id: notificationId 
                    }, function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    }, 'json');
                }
            });
        });
    </script>
</body>
</html>