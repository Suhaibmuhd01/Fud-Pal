<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Map - FUD PAL</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
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
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
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

        .place-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .place-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

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

        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }

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
                <h1 class="text-xl font-bold">FUD PAL</h1>
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
                        <img src="<?php echo isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../assets/images/user-solid.svg'; ?>"
                            alt="Profile"
                            class="w-14 h-14 rounded-full object-cover border-4 border-white shadow-lg transition duration-300 hover:scale-105">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-base text-white"> <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Student'); ?> </span>
                        <span class="text-xs text-green-200"> <?php echo htmlspecialchars($_SESSION['regnum'] ?? ''); ?> </span>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <nav class="py-4">
                <ul class="space-y-1">
                    <li><a href="../dashboard.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-home"></i><span>Dashboard</span></a></li>
                    <li><a href="map2.php" class="flex items-center space-x-3 px-4 py-3 bg-green-700 text-white"><i
                                class="fas fa-map-marker-alt w-6"></i><span>Campus Map</span></a></li>
                    <li><a href="past_questions.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-question-circle w-6"></i><span>Past Questions</span></a></li>
                    <li><a href="reg_guide.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-book w-6"></i><span>Registration Guide</span></a></li>
                    <li><a href="guidelines.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-book w-6"></i><span>Student Guidelines</span></a></li>
                    <li><a href="faqs.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-info-circle w-6"></i><span>FAQs</span></a></li>
                    <li><a href="forum.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-comments w-6"></i><span>Forum</span></a></li>
                    <li><a href="notifications.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-bell w-6"></i><span>Notifications</span><span
                                class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span></a></li>
                    <li><a href="profile.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i
                                class="fas fa-user w-6"></i><span>Profile</span></a></li>
                </ul>
                <div class="mt-4 px-4">
                    <a href="../logout.php"
                        class="flex items-center space-x-3  text-white rounded-lg hover:bg-red-700 transition-colors">
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
                        class="location-filter bg-green-100 hover:bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded-full px-4 py-2 text-sm font-medium transition">All
                        Locations</button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition">Academic</button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition">Administrative</button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition">Hostel</button>
                    <button
                        class="location-filter bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2 text-sm font-medium transition">Amenities</button>
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
                            <!-- Place cards -->
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Senate Building</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Main administrative offices,
                                    including Registry and Bursary.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded">Administrative</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">University Library</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Central library with study areas and
                                    research resources.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Computing</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Computer Science,
                                    Software Engineering, Cyber Security, and IT.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Agriculture</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Agricultural Science,
                                    Animal Science, Fishery, Agricultural Extension, Crop Science.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Science</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments Mathematics, Physics
                                    Zoology,Botany, Chemistry, EMT,</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Life Science
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Biochemistry, Food
                                    science and Technology, Microbiology and Biotechnology, Plant Biology, Biological
                                    Science, Animal & Environmetal Biology</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Physical Science
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Chemistry,
                                    Environmetal Science, Mathematics, Industrial Mathematics, Physics</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>

                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Education
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of </p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Arts and Social
                                    Science</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Sociology,
                                    Political science,
                                    English and Linguistics, Economics and Development studies .</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Basic medical Science
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Nursing, Anatomy,
                                    Physiology, Biochemistry, Public and Environmtal Health.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty of Basic Clinical
                                    Science</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of Haematology, clinical
                                    pharmacology.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Faculty Clinical Science</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Departments of community
                                    medicine,internal medicine, surgery, Gynaecology .</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded">Academic</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Male Hostel Block A</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for male
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Male Hostel Block B</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for male
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Male Hostel Block C</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for male
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Female Hostel Block A</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for male
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Female Hostel Block B</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">On-campus accommodation for female
                                    students.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 px-2 py-1 rounded">Hostel</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">University Cafeteria</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Main dining facility serving meals
                                    to students and staff.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-2 py-1 rounded">Amenities</span>
                                </div>
                            </div>
                            <div class="place-card p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                <h3 class="font-semibold text-gray-800 dark:text-white">Sport Complex</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Facilities for various sports
                                    activities and events.</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span
                                        class="text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-2 py-1 rounded">Amenities</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Map Container -->
                <div class="lg:col-span-2 order-1 lg:order-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 h-full">
                        <div class="rounded-lg overflow-hidden" style="height:500px;">
                            <iframe width="100%" height="500" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d31255.2047439917!2d9.374924799999999!3d11.7014528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sng!4v1747603967467!5m2!1sen!2sng"
                                style="border:1px solid #ccc; border-radius: 0.5rem;">
                            </iframe>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            <a href="https://www.openstreetmap.org/?mlat=11.7873&amp;mlon=9.3385#map=17/11.7873/9.3385"
                                target="_blank" rel="noopener" class="underline">View Larger Map</a>
                        </p>
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
                            <span class="text-sm text-gray-700 dark:text-gray-300">Academic</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Administrative</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-amber-500 rounded-full"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Hostel</span>
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
                        <li>Use the "View Larger Map" link to open the map in a new tab</li>
                        <li>Filter locations by category using the buttons above the map</li>
                    </ul>
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

            // Search/filter locations
            $('#search-box').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                let found = false;
                $('#places-list .place-card').each(function() {
                    const name = $(this).find('h3').text().toLowerCase();
                    const desc = $(this).find('p').first().text().toLowerCase();
                    if (name.includes(searchTerm) || desc.includes(searchTerm)) {
                        $(this).show();
                        if (!found && searchTerm.length > 0) {
                            $('html, body').animate({
                                scrollTop: $(this).offset().top - 100
                            }, 300);
                            $(this).addClass('ring-2 ring-green-500');
                            setTimeout(() => $(this).removeClass('ring-2 ring-green-500'), 1500);
                            found = true;
                        }
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Location filter buttons
            $('.location-filter').click(function() {
                $('.location-filter').removeClass(
                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200');
                $('.location-filter').addClass(
                    'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200');
                $(this).removeClass('bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200');
                $(this).addClass('bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200');
                const category = $(this).text().trim();
                $('#places-list .place-card').each(function() {
                    const cat = $(this).find('span.text-xs').text().trim();
                    if (category === "All Locations" || cat === category) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

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