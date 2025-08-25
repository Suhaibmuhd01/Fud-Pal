<?php
session_start();

include 'includes/config.php';
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';
// $pic =  $_SESSION['pic'] . '.' . $_SESSION['pictype'];
// $profile_picture = $pic ?? 'assets/images/user-solid.svg';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Pragma: no-cache");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FUD Pal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- js -->
    <script rel="text/javascript" src="assets/js/script.js"></script>
    <script rel="tex/javascript" src="./assets/js/main.js"></script>

    </script>
    <script rel="tex/javascript" src="./assets/js/map.js"> </script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    }
                }
            }
        }
    }

    // Dark mode detection
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.classList.add('dark');
    }
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (event.matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
    </script>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    /* Sidebar styles */
    .sidebar {
        transition: all 0.3s ease-in-out;
    }

    .sidebar.collapsed {
        transform: translateX(-100%);
    }

    @media (min-width: 768px) {
        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.expanded {
            margin-left: 0;
        }
    }

    /* Mobile menu styles */
    .mobile-menu {
        transition: transform 0.3s ease-in-out;
    }

    .notification-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        background-color: #EF4444;
        border-radius: 50%;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #10B981;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #047857;
    }

    /* Card hover effect */
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Hamburger menu */
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

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="fixed top-0 left-0 h-full w-3/4 bg-green-600 text-white z-50 mobile-menu -translate-x-full md:hidden overflow-y-auto">
        <div class="p-4 border-b border-green-500 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-users text-xl"></i>
                <h1 class="text-xl font-bold">FUD Pal</h1>
            </div>
            <button id="close-mobile-menu" class="text-white focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-4 border-b border-green-500">
            <div class="flex items-center space-x-3">
                <div class="relative">


                    <img src="pages/profile_image.php?regnum=<?php echo urlencode($_SESSION['regnum']); ?>&t=<?php echo time(); ?>"
                        class="w-12 h-12 rounded-full object-cover" alt="Profile Picture">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <!--  -->
                </div>
            </div>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="dashboard.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-white bg-opacity-10">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="pages/map.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Campus Map</span>
                    </a>
                </li>
                <li>
                    <a href="pages/past_questions.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-question-circle"></i>
                        <span>Past Questions</span>
                    </a>
                </li>
                <li>
                    <a href="pages/reg_guide.php class=" flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white
                        hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Reg Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="pages/guidelines.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Student Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="pages/faqs.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-info-circle"></i>
                        <span>FAQs</span>
                    </a>
                </li>
                <li>
                    <a href="pages/forum/"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-comments"></i>
                        <span>Community Forum</span>
                    </a>
                </li>
                <li>
                    <a href="pages/profile/"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a href="pages/notifications.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 ml-auto">3</span>
                    </a>
                </li>
                <li class="mt-6 border-t border-green-500 pt-4">
                    <a href="logout.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Desktop Sidebar -->
    <div id="sidebar" class="sidebar fixed top-0 left-0 h-full w-64 bg-green-600 text-white z-30 hidden md:block">
        <div class="p-4 border-b border-green-500">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-users text-xl"></i>
                <h1 class="text-xl font-bold">FUD Pal</h1>
            </div>
        </div>

        <div class="p-4 border-b border-green-500">
            <div class="flex items-center space-x-3">
                <div class="relative">

                </div>
                <div>
                    <?php
                    $fullname = $_SESSION['fullname'] ?? 'Student';
                    $regnum = $_SESSION['regnum'] ?? '';
                    ?>
                    <h3 class="font-semibold">
                        <img src="assets/images/user-solid.svg" alt="Profile"
                            class="w-12 h-12 rounded-full border-4 border-white mt-4 md:mt-0">
                    </h3>
                    <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                </div>
            </div>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="dashboard.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-white bg-opacity-10">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="pages/map.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Campus Map</span>
                    </a>
                </li>
                <li>
                    <a href="pages/past_questions.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-question-circle"></i>
                        <span>Past Questions</span>
                    </a>
                </li>
                <li>
                    <a href="pages/guidelines.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Student Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="pages/reg_guide.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Reg Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="pages/faqs.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-info-circle"></i>
                        <span>FAQs</span>
                    </a>
                </li>
                <li>
                    <a href="pages/forum/"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-comments"></i>
                        <span>Community Forum</span>
                    </a>
                </li>
                <li>
                    <a href="pages/profile/"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a href="pages/notifications.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 ml-auto">3</span>
                    </a>
                </li>
                <li class="mt-6 border-t border-green-500 pt-4">
                    <a href="logout.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="main-content md:ml-64 min-h-screen">
        <!-- Top Navigation Bar -->
        <header class="bg-green-600 text-white sticky top-0 z-20 shadow-md">
            <div class="container mx-auto px-4 py-3">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <button id="toggle-menu" class="hamburger mr-4 md:hidden focus:outline-none">
                            <span class="hamburger-top"></span>
                            <span class="hamburger-middle"></span>
                            <span class="hamburger-bottom"></span>
                        </button>
                        <h1 class="text-xl font-bold md:hidden">Dashboard</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notifications-dropdown-toggle" class="focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="notification-dot"></span>
                            </button>
                            <div id="notifications-dropdown"
                                class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-10 hidden">
                                <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-gray-800 dark:text-white font-semibold">Notifications</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <a href="#"
                                        class="block p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <p class="text-sm text-gray-800 dark:text-white">New announcement: Course
                                            registration deadline extended</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2 hours ago</p>
                                    </a>
                                    <a href="#"
                                        class="block p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <p class="text-sm text-gray-800 dark:text-white">New past question uploaded for
                                            CSC 302</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Yesterday</p>
                                    </a>
                                    <a href="#" class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <p class="text-sm text-gray-800 dark:text-white">Your forum post received a
                                            reply</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2 days ago</p>
                                    </a>
                                </div>
                                <div class="p-3 border-t border-gray-200 dark:border-gray-700 text-center">
                                    <a href="pages/notifications.php"
                                        class="text-sm text-green-600 dark:text-green-400 hover:underline">View all
                                        notifications</a>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <button id="user-dropdown-toggle" class="flex items-center space-x-2 focus:outline-none">
                                <span class="hidden md:block">
                                    <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                                </span>
                                <i class="fas fa-chevron-down text-xs hidden md:block"></i>
                            </button>
                            <div id="user-dropdown"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-10 hidden">
                                <a href="pages/profile.php"
                                    class="block p-3 text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 rounded-t-lg">
                                    <i class="fas fa-user mr-2"></i> My Profile
                                </a>
                                <a href="pages/profile/edit.php"
                                    class="block p-3 text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <a href="logout.php"
                                    class="block p-3 text-gray-800 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 rounded-b-lg">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="container mx-auto px-4 py-6">
            <!-- Welcome Banner -->
            <div class="bg-green-600 text-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>

                        <h2 class="text-2xl font-bold mb-2">
                            Welcome back, <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Student'); ?>!
                        </h2>
                        <p class="opacity-90">Access everything you need for your campus life at FUD.</p>
                    </div>
                    <img src="assets/images/user-solid.svg" alt="Profile"
                        class="w-20 h-20 rounded-full border-4 border-white mt-4 md:mt-0">
                </div>
            </div>

            <!-- Quick Access Cards -->
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Quick Access</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Campus Map Card -->
                <a href="pages/map.php"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex items-start space-x-4 card-hover">
                    <div class="rounded-lg bg-green-100 dark:bg-green-900 p-3">
                        <i class="fas fa-map-marker-alt text-xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-white">Campus Map</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Find your way around campus</p>
                    </div>
                </a>

                <!-- Past Questions Card -->
                <a href="pages/past_questions.php"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex items-start space-x-4 card-hover">
                    <div class="rounded-lg bg-blue-100 dark:bg-blue-900 p-3">
                        <i class="fas fa-question-circle text-xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-white">Past Questions</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Access exam preparations</p>
                    </div>
                </a>

                <!-- Guidelines Card -->
                <a href="pages/reg_guide.php"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex items-start space-x-4 card-hover">
                    <div class="rounded-lg bg-purple-100 dark:bg-purple-900 p-3">
                        <i class="fas fa-book text-xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-white">Guidelines</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">View Central registration process</p>
                    </div>
                </a>
                <a href="pages/guidelines.php"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex items-start space-x-4 card-hover">
                    <div class="rounded-lg bg-purple-100 dark:bg-purple-900 p-3">
                        <i class="fas fa-book text-xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-white">Guidelines</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">View Course registration process</p>
                    </div>
                </a>

                <!-- Forum Card -->
                <a href="pages/forum/"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex items-start space-x-4 card-hover">
                    <div class="rounded-lg bg-amber-100 dark:bg-amber-900 p-3">
                        <i class="fas fa-comments text-xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-white">Forum</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Connect with peers</p>
                    </div>
                </a>
            </div>

            <!-- Recent Announcements & Upcoming Events -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Announcements -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Announcements</h3>
                        <a href="#" class="text-sm text-green-600 dark:text-green-400 hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Course Registration Extended
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">The deadline for 2023/2024 course
                                registration has been extended to November 15th.</p>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-clock mr-1"></i> May 10, 2025.
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Wi-Fi Network Upgrade</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">The campus Wi-Fi network will be
                                upgraded this weekend. Expect temporary outages.</p>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-clock mr-1"></i> May 03, 2025
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Library Hours Extended</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">The library will be open until 8AM
                                - 10PM during the exam period to support student studies.</p>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-clock mr-1"></i> MAY 12, 2025
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Upcoming Events</h3>
                        <a href="#" class="text-sm text-green-600 dark:text-green-400 hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="p-4 flex">
                            <a href="https://jtd.startupjigawa.com/" target="_blank">
                                <div
                                    class="mr-4 bg-green-100 dark:bg-green-900 rounded-lg p-3 text-center min-w-[60px]">
                                    <p class="text-sm font-semibold text-green-800 dark:text-green-200">june</p>
                                    <p class="text-lg font-bold text-green-800 dark:text-green-200">13-15</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-white mb-1">TechDay 2025</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Showcase of student tech
                                        projects and innovations.</p>
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Dutse complex theatre.
                                    </div>
                            </a>
                        </div>
                    </div>
                    <div class="p-4 flex">
                        <div class="mr-4 bg-green-100 dark:bg-green-900 rounded-lg p-3 text-center min-w-[60px]">
                            <p class="text-sm font-semibold text-green-800 dark:text-green-200">NOV</p>
                            <p class="text-lg font-bold text-green-800 dark:text-green-200">15</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Career Development Workshop
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Resume building and interview
                                skills workshop for final year students.</p>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-map-marker-alt mr-1"></i> Main Auditorium
                            </div>
                        </div>
                    </div>
                    <div class="p-4 flex">
                        <div class="mr-4 bg-green-100 dark:bg-green-900 rounded-lg p-3 text-center min-w-[60px]">
                            <p class="text-sm font-semibold text-green-800 dark:text-green-200">NOV</p>
                            <p class="text-lg font-bold text-green-800 dark:text-green-200">20</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Cultural Day Celebration</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Annual cultural festival featuring
                                traditional dances, food, and attire.</p>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-map-marker-alt mr-1"></i> Sports Complex
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Statistics and Student Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Academic Calendar -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md col-span-1">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Academic Calendar</h3>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="h-2 w-2 rounded-full bg-green-500 mr-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Current Semester</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">First Semester 2024/2025</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="h-2 w-2 rounded-full bg-yellow-500 mr-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Mid-Semester Break</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Null</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="h-2 w-2 rounded-full bg-red-500 mr-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">First semester Exams Begin
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">January 12, 2025</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="h-2 w-2 rounded-full bg-blue-500 mr-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Semester Ends</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">June 06, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Activity Charts -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md col-span-2">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Campus Resources Usage</h3>
            </div>
            <div class="p-2">
                <canvas id="resourcesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Forum Discussions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-8">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Forum Discussions</h3>
            <a href="pages/forum/" class="text-sm text-green-600 dark:text-green-400 hover:underline">View All</a>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <div class="p-4 flex items-start space-x-3">
                <img src="https://i.imgur.com/8Km9tLL.jpg" alt="User Avatar"
                    class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Tips for CSC 304 Exam?</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">I'm preparing for the upcoming CSC304 exam.
                        Any tips on what to focus on?</p>
                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                        <span class="mr-3"><i class="fas fa-user mr-1"></i> Inuwa </span>
                        <span class="mr-3"><i class="fas fa-comments mr-1"></i> 12 replies</span>
                        <span><i class="fas fa-clock mr-1"></i> 2 hours ago</span>
                    </div>
                </div>
            </div>

            <div class="p-4 flex items-start space-x-3">
                <img src="https://i.imgur.com/8Km9tLL.jpg" alt="User Avatar"
                    class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Best Places to Study on Campus</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Looking for quiet places to study apart
                        from the library. Any recommendations?</p>
                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                        <span class="mr-3"><i class="fas fa-user mr-1"></i> Ahmad zubairu</span>
                        <span class="mr-3"><i class="fas fa-comments mr-1"></i> 8 replies</span>
                        <span><i class="fas fa-clock mr-1"></i> 1 day ago</span>
                    </div>
                </div>
            </div>

            <div class="p-4 flex items-start space-x-3">
                <img src="https://i.imgur.com/8Km9tLL.jpg" alt="User Avatar"
                    class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-1">Group Project for Software Engineering
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Looking for teammates for the final project
                        in Software Engineering class.</p>
                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                        <span class="mr-3"><i class="fas fa-user mr-1"></i> Muhammad manzo</span>
                        <span class="mr-3"><i class="fas fa-comments mr-1"></i> 5 replies</span>
                        <span><i class="fas fa-clock mr-1"></i> 2 days ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 shadow-md py-4 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm">&copy; <span id="year"></span> FUD Pal. All rights
                    reserved.</p>
                <div class="flex space-x-4 mt-3 md:mt-0">
                    <a href="https://facebook.com/fud-pal"
                        class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="x.com/suhaibmuhd22/"
                        class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com/iam_suhaib_mb"
                        class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>