<?php
session_start();
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';
$profile_picture = $_SESSION['profile_picture'] ?? '../assets/images/user-solid.svg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Map - FUD Pal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>

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

        /* Sidebar styling */
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

        /* Map container */
        #map {
            height: 100%;
            width: 100%;
            min-height: 400px;
            border-radius: 0.5rem;
        }

        /* Place cards */
        .place-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .place-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Location marker pulse animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #10B981;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }

        /* Dark mode styles */
        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }

        /* Notification dot */
        .notification-dot {
            position: absolute;
            top: 0px;
            right: 0px;
            width: 8px;
            height: 8px;
            background-color: #EF4444;
            border-radius: 50%;
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
                <h1 class="text-xl font-bold">FUD Pal</h1>
            </div>

            <div class="flex items-center space-x-4">
                <a href="notifications.php" class="relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="notification-dot"></span>
                </a>
                <a href="profile.php">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-green-600">
                        <i class="fas fa-user"></i>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed md:sticky top-0 left-0 z-30 w-64 h-screen bg-green-600 text-white shadow-lg overflow-y-auto">
            <!-- Sidebar Header (visible on desktop) -->
            <div class="md:flex hidden items-center justify-between p-4 border-b border-green-500">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-users text-2xl"></i>
                    <h2 class="text-xl font-bold">FUD Pal</h2>
                </div>
                <button id="close-sidebar" class="md:hidden text-2xl focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Mobile Sidebar Header -->
            <div class="flex md:hidden items-center justify-between p-4 border-b border-green-500">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-users text-2xl"></i>
                    <h2 class="text-xl font-bold">FUD Pal</h2>
                </div>
                <button id="close-sidebar-mobile" class="text-2xl focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- User Profile Summary -->
            <div class="p-4 border-b border-green-500">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-green-600 text-xl">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <?php
                        $fullname = $_SESSION['fullname'] ?? 'Student';
                        $regnum = $_SESSION['regnum'] ?? '';
                        ?>
                        <h3 class="font-semibold"><?php echo htmlspecialchars($fullname); ?></h3>
                        <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                        <!-- <img src="../assets//images//user-solid.svg"> -->
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="py-4">
                <ul class="space-y-1">
                    <li>
                        <a href="../dashboard.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="map2.php" class="flex items-center space-x-3 px-4 py-3 bg-green-700 text-white">
                            <i class="fas fa-map-marker-alt w-6"></i>
                            <span>Campus Map</span>
                        </a>
                    </li>
                    <li>
                        <a href="past_questions.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-question-circle w-6"></i>
                            <span>Past Questions</span>
                        </a>
                    </li>
                    <li>
                        <a href="reg_guide.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-book w-6"></i>
                            <span>Registration Guide</span>
                        </a>
                    </li>
                    <li>
                        <a href="faqs.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-info-circle w-6"></i>
                            <span>FAQs</span>
                        </a>
                    </li>
                    <li>
                        <a href="forum.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-comments w-6"></i>
                            <span>Forum</span>
                        </a>
                    </li>
                    <li>
                        <a href="notifications.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-bell w-6"></i>
                            <span>Notifications</span>
                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="profile.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-user w-6"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                </ul>

                <div class="mt-8 px-4">
                    <a href="../logout.php"
                        class="flex items-center space-x-3 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-4 md:p-8 w-full md:w-[calc(100%-16rem)]">
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-map-marker-alt text-green-600 mr-3"></i> Campus Map
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Explore Federal University Dutse campus locations and find your way around easily.
                </p>
            </div>

            <!-- Search Box -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input id="search-box" type="text"
                        class="pl-10 pr-4 py-3 w-full rounded-lg text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Search for a location (e.g. Admin Block, Library, Faculty of Computing)">
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    <button
                        class="location-filter bg-green-100 hover:bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded-full px-4 py-2 text-sm font-medium transition"
                        data-category="All Locations">
                        All Locations
                    </button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition"
                        data-category="Academic Buildings">
                        Academic Buildings
                    </button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition"
                        data-category="Administrative">
                        Administrative
                    </button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition"
                        data-category="Hostels">
                        Hostels
                    </button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition"
                        data-category="Amenities">
                        Amenities
                    </button>
                </div>
            </div>

            <!-- Map and Places List -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Places List -->
                <div class="lg:col-span-1 order-2 lg:order-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-4 bg-green-600 text-white">
                            <h2 class="text-lg font-semibold">Campus Locations</h2>
                        </div>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[500px] overflow-y-auto"
                            id="places-list">
                            <!-- Places will be populated here -->
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Administrative Block</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Main administrative offices,
                                    including Registry and Bursary.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded">Administrative</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">University Library</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Central library with study areas and
                                    research resources.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Computing</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Computer Science,
                                    Software Engineering, Cyber Security, and IT.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Male Hostel Block A</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for male
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Female Hostel Block B</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for female
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">University Cafeteria</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Main dining facility serving meals
                                    to students and staff.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-2 py-1 rounded">Amenity</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Sport Complex</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Facilities for various sports
                                    activities and events.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-2 py-1 rounded">Amenity</span>
                                    <button
                                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-directions"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Container -->
                <div class="lg:col-span-2 order-1 lg:order-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 h-full">
                        <div id="map" class="h-[500px]"></div>

                        <!-- Map Controls -->
                        <div class="mt-4 flex justify-between">
                            <button id="my-location"
                                class="flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="fas fa-location-arrow"></i>
                                <span>My Location</span>
                            </button>

                            <div class="flex space-x-2">
                                <button id="zoom-in"
                                    class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white p-2 rounded-lg transition focus:outline-none">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button id="zoom-out"
                                    class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white p-2 rounded-lg transition focus:outline-none">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Info Section -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">About FUD Campus Map</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    The Federal University Dutse (FUD) Campus Map helps you navigate the university grounds with ease.
                    Find academic buildings, administrative offices, hostels, and other important locations quickly.
                </p>

                <div class="mt-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Legend</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-blue-500 rounded-full"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Academic Buildings</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Administrative</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-amber-500 rounded-full"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Hostels</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-purple-500 rounded-full"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Amenities</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Tips</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 space-y-2">
                        <li>Use the search box to quickly find specific locations</li>
                        <li>Click on any marker on the map to see details about that location</li>
                        <li>Use the "My Location" button to see your current position on campus</li>
                        <li>Filter locations by category using the buttons above the map</li>
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow-md py-4 mt-8 animate__animated animate__fadeInUp">
                <div class="max-w-2xl mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                        <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm text-center">
                            &copy; <span id="year"></span> FUD Pal. All rights reserved.
                        </p>
                        <div class="flex justify-center space-x-4 mt-2 md:mt-0 text-end">
                            <a href="facebook.com/fud-pal/"
                                class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="x.com/fsuhaibmuhd22/"
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
        </main>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

    <script>
        $(document).ready(function() {
            const currentYear = new Date().getFullYear();
            $('#year').text(currentYear);
        })
    </script>

    <script>
        $(document).ready(function() {
            // Mobile menu toggle
            $('#menu-btn').click(function() {
                $(this).toggleClass('open');
                $('#sidebar').toggleClass('open');
                $('#sidebar-overlay').toggleClass('hidden');
                $('body').toggleClass('overflow-hidden');
            });

            // location filter
            $('.location-filter').click(function() {
                $('.location-filter').removeClass(
                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200');
                $('.location-filter').addClass(
                    'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200');
                $(this).removeClass('bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200');
                $(this).addClass('bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200');

                // Filter markers on the map based on category
                const category = $(this).data('category');
                filterMarkers(category);
            });

            // Close sidebar on mobile
            $('#close-sidebar-mobile, #sidebar-overlay').click(function() {
                $('#menu-btn').removeClass('open');
                $('#sidebar').removeClass('open');
                $('#sidebar-overlay').addClass('hidden');
                $('body').removeClass('overflow-hidden');
            });

            // Handle window resize to reapply sidebar state if needed
            $(window).resize(function() {
                if (window.innerWidth >= 768) {
                    $('#sidebar-overlay').addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                }
            });

            // Location filters
            $('.location-filter').click(function() {
                $('.location-filter').removeClass(
                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200');
                $('.location-filter').addClass(
                    'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200');
                $(this).removeClass('bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200');
                $(this).addClass('bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200');

                // Filter markers on the map based on category
                const category = $(this).text().trim();
                filterMarkers(category);
            });

            // Initialize map
            initMap();
        });

        // Mock data for campus locations
        const locations = [{
                name: "Administrative Block",
                description: "Main administrative offices, including Registry and Bursary.",
                category: "Administrative",
                position: {
                    lat: 11.7868,
                    lng: 9.3380
                }
            },
            {
                name: "University Library",
                description: "Central library with study areas and research resources.",
                category: "Academic Buildings",
                position: {
                    lat: 11.7873,
                    lng: 9.3386
                }
            },
            {
                name: "Faculty of Computing",
                description: "Departments of Computer Science, Software Engineering, Cyber Security, and IT.",
                category: "Academic Buildings",
                position: {
                    lat: 11.7880,
                    lng: 9.3375
                }
            },
            {
                name: "Male Hostel Block A",
                description: "On-campus accommodation for male students.",
                category: "Hostels",
                position: {
                    lat: 11.7865,
                    lng: 9.3396
                }
            },
            {
                name: "Female Hostel Block B",
                description: "On-campus accommodation for female students.",
                category: "Hostels",
                position: {
                    lat: 11.7860,
                    lng: 9.3390
                }
            },
            {
                name: "University Cafeteria",
                description: "Main dining facility serving meals to students and staff.",
                category: "Amenities",
                position: {
                    lat: 11.7875,
                    lng: 9.3398
                }
            },
            {
                name: "Sport Complex",
                description: "Facilities for various sports activities and events.",
                category: "Amenities",
                position: {
                    lat: 11.7890,
                    lng: 9.3395
                }
            }
        ];

        let map;
        let markers = [];

        function initMap() {
            // Create the map centered on FUD
            const fudCoordinates = {
                lat: 11.7873,
                lng: 9.3385
            };
            map = new google.maps.Map(document.getElementById("map"), {
                center: fudCoordinates,
                zoom: 16,
                mapTypeId: "roadmap",
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                streetViewControl: true,
                fullscreenControl: true,
                gestureHandling: "cooperative"
            });

            // Add markers for all locations
            locations.forEach(location => {
                addMarker(location);
            });

            // Set up search box functionality
            const searchBox = document.getElementById('search-box');
            searchBox.addEventListener('input', function() {
                const searchTerm = searchBox.value.toLowerCase();

                // Filter locations based on search term
                if (searchTerm) {
                    markers.forEach((marker, i) => {
                        const locationName = locations[i].name.toLowerCase();
                        const locationDesc = locations[i].description.toLowerCase();

                        if (locationName.includes(searchTerm) || locationDesc.includes(searchTerm)) {
                            marker.setVisible(true);
                        } else {
                            marker.setVisible(false);
                        }
                    });
                } else {
                    // Show all markers if search box is empty
                    markers.forEach(marker => {
                        marker.setVisible(true);
                    });
                }
            });

            // Set up zoom controls
            document.getElementById('zoom-in').addEventListener('click', function() {
                const currentZoom = map.getZoom();
                map.setZoom(currentZoom + 1);
            });

            document.getElementById('zoom-out').addEventListener('click', function() {
                const currentZoom = map.getZoom();
                map.setZoom(currentZoom - 1);
            });

            // Set up "My Location" button
            document.getElementById('my-location').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLocation = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };

                            // Add a marker for the user's location
                            const userMarker = new google.maps.Marker({
                                position: userLocation,
                                map: map,
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillColor: '#4285F4',
                                    fillOpacity: 1,
                                    strokeColor: '#ffffff',
                                    strokeWeight: 2,
                                    scale: 8
                                },
                                title: "Your Location"
                            });

                            // Add a pulsing effect
                            const pulsingDot = document.createElement('div');
                            pulsingDot.className = 'pulse';

                            // Center the map on the user's location
                            map.setCenter(userLocation);
                            map.setZoom(18);
                        },
                        function(error) {
                            alert("Error accessing your location: " + error.message);
                        }
                    );
                } else {
                    alert("Geolocation is not supported by your browser.");
                }
            });
        }

        function addMarker(location) {
            // Set marker color based on category
            let markerColor;
            switch (location.category) {
                case "Academic Buildings":
                    markerColor = "blue";
                    break;
                case "Administrative":
                    markerColor = "green";
                    break;
                case "Hostels":
                    markerColor = "orange";
                    break;
                case "Amenities":
                    markerColor = "purple";
                    break;
                default:
                    markerColor = "red";
            }

            // Create marker
            const marker = new google.maps.Marker({
                position: location.position,
                map: map,
                title: location.name,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillColor: markerColor,
                    fillOpacity: 0.9,
                    strokeColor: '#ffffff',
                    strokeWeight: 2,
                    scale: 10
                },
                animation: google.maps.Animation.DROP
            });

            markers.push(marker);

            // Create info window with location details
            const infoContent = `
                <div class="p-2">
                    <h3 class="font-semibold text-lg">${location.name}</h3>
                    <p class="text-sm">${location.description}</p>
                    <div class="mt-2">
                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">${location.category}</span>
                    </div>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: infoContent
            });

            // Show info window when marker is clicked
            marker.addListener('click', function() {
                // Close any open info windows
                markers.forEach(m => {
                    if (m.infoWindow) {
                        m.infoWindow.close();
                    }
                });

                infoWindow.open(map, marker);
                marker.infoWindow = infoWindow;

                // Center the map on the clicked marker
                map.panTo(marker.getPosition());
            });

            // Make place cards in the list clickable
            $(document).on('click', '.place-card', function() {
                const placeName = $(this).find('h3').text();

                // Find the corresponding marker
                markers.forEach((marker, i) => {
                    if (locations[i].name === placeName) {
                        google.maps.event.trigger(marker, 'click');
                    }
                });
            });
        }

        function filterMarkers(category) {
            if (category === "All Locations") {
                markers.forEach(marker => {
                    marker.setVisible(true);
                });
            } else {
                markers.forEach((marker, i) => {
                    if (locations[i].category === category) {
                        marker.setVisible(true);
                    } else {
                        marker.setVisible(false);
                    }
                });
            }
        }
    </script>
</body>

</html>