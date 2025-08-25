<?php
session_start();
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';
$profile_picture = $_SESSION['profile_picture'] ?? 'https://i.imgur.com/8Km9tLL.jpg';


// session_start();
// if (!isset($_SESSION['user_id'])) {
//     $redirect = urlencode($_SERVER['REQUEST_URI']);
//     header("Location: login.php?redirect=$redirect");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Questions - FUD Pal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

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

        /* Card styles */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        /* DataTables custom styling */
        table.dataTable thead th,
        table.dataTable thead td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark table.dataTable thead th,
        .dark table.dataTable thead td {
            border-bottom: 1px solid #4b5563;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 12px 10px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 1rem;
            color: #4b5563;
        }

        .dark .dataTables_wrapper .dataTables_length,
        .dark .dataTables_wrapper .dataTables_filter,
        .dark .dataTables_wrapper .dataTables_info,
        .dark .dataTables_wrapper .dataTables_processing,
        .dark .dataTables_wrapper .dataTables_paginate {
            color: #e5e7eb;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 0.25rem 2rem 0.25rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: #fff;
        }

        .dark .dataTables_wrapper .dataTables_length select {
            background-color: #374151;
            border-color: #4b5563;
            color: #e5e7eb;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            margin-left: 0.5rem;
        }

        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #374151;
            border-color: #4b5563;
            color: #e5e7eb;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem;
            margin-left: 0.25rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: #fff;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #374151;
            border-color: #4b5563;
            color: #e5e7eb !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(to bottom, #10B981 0%, #059669 100%);
            color: white !important;
            border: 1px solid #059669;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(to bottom, #f3f4f6 0%, #e5e7eb 100%);
            color: #111827 !important;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(to bottom, #4b5563 0%, #374151 100%);
            color: #e5e7eb !important;
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
                        $profile_picture = $_SESSION['profile_picture'] ?? 'https://i.imgur.com/8Km9tLL.jpg';
                        ?>
                        <h3 class="font-semibold"><?php echo htmlspecialchars($fullname); ?></h3>
                        <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                        <!--              <img src="pages/profile_image.php?regnum=<?php echo urlencode($_SESSION['regnum']); ?>" ...> -->
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
                        <a href="map2.php"
                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors">
                            <i class="fas fa-map-marker-alt w-6"></i>
                            <span>Campus Map</span>
                        </a>
                    </li>
                    <li>
                        <a href="past_questions.php"
                            class="flex items-center space-x-3 px-4 py-3 bg-green-700 text-white">
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
                        <a href="pages/guidelines.php"
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                            <i class="fas fa-book"></i>
                            <span>Student Guidelines</span>
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
                        <a href="/forums/"
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
                        <a href="/profile"
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
                    <i class="fas fa-question-circle text-amber-600 mr-3"></i> Past Questions Repository
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Access previous examination questions to help you prepare for your exams.
                </p>
            </div>

            <!-- Filters and Upload Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 md:mb-0">Find Past Questions
                    </h2>

                    <button id="upload-btn"
                        class="flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-upload"></i>
                        <span>Upload Past Question</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label for="faculty-filter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Faculty</label>
                        <select id="faculty-filter"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">All Faculties</option>
                            <option value="computing">Faculty of Computing</option>
                            <option value="sciences">Faculty of Sciences</option>
                            <option value="education">Faculty of Education</option>
                            <option value="clinical">Faculty of clinical Science</option>
                            <option value="agriculture">Faculty of Agriculture</option>
                            <option value="management">Faculty of Management Sciences</option>
                            <option value="arts">Faculty of Arts & Social Sciences</option>
                        </select>
                    </div>

                    <div>
                        <label for="department-filter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                        <select id="department-filter"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            disabled>
                            <option value="">All Departments</option>
                        </select>
                    </div>

                    <div>
                        <label for="level-filter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                        <select id="level-filter"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">All Levels</option>
                            <option value="100">100 Level</option>
                            <option value="200">200 Level</option>
                            <option value="300">300 Level</option>
                            <option value="400">400 Level</option>
                            <option value="500">500 Level</option>
                        </select>
                    </div>

                    <div>
                        <label for="session-filter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session</label>
                        <select id="session-filter"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">All Sessions</option>
                            <option value="2024/2025">2019/2020</option>
                            <option value="2024/2025">2020/2021</option>
                            <option value="2024/2025">2021/2022</option>
                            <option value="2024/2025">2022/2023</option>
                            <option value="2024/2025">2023/2024</option>
                            <option value="2024/2025">2024/2025</option>

                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button id="apply-filters"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Past Questions Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 overflow-x-auto">
                <table id="past-questions-table" class="w-full">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Department</th>
                            <th>Level</th>
                            <th>Session</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CSC101</td>
                            <td>Introduction to Computer Science</td>
                            <td>Computer Science</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CSC102</td>
                            <td>Problem Solving and Programming</td>
                            <td>Computer Science</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>MTH101</td>
                            <td>Elementary Mathematics I</td>
                            <td>Mathematics</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>MTH102</td>
                            <td>Calculus</td>
                            <td>Mathematics</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>PHY101</td>
                            <td>General Physics I</td>
                            <td>Physics</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>PHY102</td>
                            <td>General Physics II</td>
                            <td>Physics</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>BIO101</td>
                            <td>Biology I</td>
                            <td>Chemistry</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CHM101</td>
                            <td>General Chemistry I</td>
                            <td>Chemistry</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CHM101</td>
                            <td>General Chemistry I</td>
                            <td>Chemistry</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CHM102</td>
                            <td>Organic Chemistry</td>
                            <td>Chemistry</td>
                            <td>100</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CSC201</td>
                            <td>Computer Programming I</td>
                            <td>Computer Science</td>
                            <td>200</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CSC202</td>
                            <td>Computer Programming II (JAVA Programming)</td>
                            <td>IT, CSC &CYB</td>
                            <td>200</td>
                            <td>2023/2024</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>CSC204</td>
                            <td>Data Structures and Algorithms</td>
                            <td>All computing</td>
                            <td>200</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CSC208</td>
                            <td>Discrete structure</td>
                            <td>All compting</td>
                            <td>200</td>
                            <td>2022/2023</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CSC210</td>
                            <td>System Analysis and Design</td>
                            <td>Computer Science</td>
                            <td>200</td>
                            <td>2023/2024</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>MTH202</td>
                            <td>Linear Algebra</td>
                            <td>Mathematics/td>
                            <td>200</td>
                            <td>2023/2024</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT306</td>
                            <td>Computer organisation & Architecture</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>CIT305</td>
                            <td>Computer Crime, Forensic and Auditing</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT202</td>
                            <td>Introduction to IT Project Management</td>
                            <td>Information Techonolgy</td>
                            <td>200</td>
                            <td>2023/2024</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CSE201</td>
                            <td>Computer organisation & Architecture</td>
                            <td>IT & Software</td>
                            <td>200</td>
                            <td>2023/2024</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT306</td>
                            <td>Computer organisation & Architecture</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT306</td>
                            <td>Computer organisation & Architecture</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT306</td>
                            <td>Computer organisation & Architecture</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT306</td>
                            <td>Computer organisation & Architecture</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT306</td>
                            <td>Computer organisation & Architecture</td>
                            <td>Information Techonolgy</td>
                            <td>300</td>
                            <td>2024/2025</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>CIT201</td>
                            <td>Computer Networking</td>
                            <td>Information Technology</td>
                            <td>200</td>
                            <td>2023/2024</td>
                            <td>
                                <div class="flex space-x-2">
                                    <button
                                        class="view-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="download-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Upload Modal -->
            <div id="upload-modal" class="fixed inset-0 z-50 hidden">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md w-full p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Upload Past Question</h3>
                            <button id="close-modal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form action="upload_past_question.php" id="upload-form" enctype="multipart/form-data">
                            <div class="space-y-4">
                                <div>
                                    <label for="course-code"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course
                                        Code</label>
                                    <input type="text" id="course-code" name="course_code"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="e.g. CSC101" required>
                                </div>

                                <div>
                                    <label for="course-title"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course
                                        Title</label>
                                    <input type="text" id="course-title" name="course_title"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="e.g. Introduction to Computer Science" required>
                                </div>

                                <div>
                                    <label for="upload-faculty"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Faculty</label>
                                    <select id="upload-faculty" name="faculty"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                        <option value="">Select Faculty</option>
                                        <option value="computing">Faculty of Computing</option>
                                        <option value="sciences">Faculty of Sciences</option>
                                        <option value="agriculture">Faculty of Agriculture</option>
                                        <option value="management">Faculty of Management Sciences</option>
                                        <option value="arts">Faculty of Arts & Social Sciences</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="upload-department"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                                    <select id="upload-department" name="department"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required disabled>
                                        <option value="">Select Department</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="upload-level"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Level</label>
                                    <select id="upload-level" name="level"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                        <option value="">Select Level</option>
                                        <option value="100">100 Level</option>
                                        <option value="200">200 Level</option>
                                        <option value="300">300 Level</option>
                                        <option value="400">400 Level</option>
                                        <option value="500">500 Level</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="upload-session"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Session</label>
                                    <select id="upload-session" name="session"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                        <option value="">Select Session</option>
                                        <option value="2022/2023">2022/2023</option>
                                        <option value="2021/2022">2021/2022</option>
                                        <option value="2020/2021">2020/2021</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="file-upload"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">File
                                        Upload (PDF only)</label>
                                    <div
                                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-file-pdf text-gray-400 text-3xl mb-3"></i>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="file-upload"
                                                    class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-green-600 dark:text-green-400 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                    <span>Upload a file</span>
                                                    <input id="file-upload" name="file_upload" type="file"
                                                        class="sr-only" accept=".pdf">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF up to 10MB</p>
                                        </div>
                                    </div>
                                    <div id="file-name" class="mt-2 text-sm text-gray-500 dark:text-gray-400 hidden">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" id="cancel-upload"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- View Modal -->
            <div id="view-modal" class="fixed inset-0 z-50 hidden">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-4xl w-full p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 id="view-title" class="text-lg font-semibold text-gray-800 dark:text-white">CSC101 -
                                Introduction to Computer Science</h3>
                            <button id="close-view-modal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 h-[60vh] overflow-y-auto">
                            <iframe id="pdf-viewer" src="#" class="w-full h-full" frameborder="0"></iframe>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button id="download-from-view"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="fas fa-download mr-2"></i> Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                <p>&copy; <span id="year"></span> FUD Pal. All rights reserved.</p>
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

            // Initialize DataTable
            $('#past-questions-table').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });

            // Faculty and department data
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
                arts: [
                    'English Language',
                    'History',
                    'Political Science',
                    'Sociology'
                ]
            };

            // Populate departments based on faculty selection (for filter)
            $('#faculty-filter').change(function() {
                const faculty = $(this).val();
                const departmentSelect = $('#department-filter');

                // Clear current options
                departmentSelect.html('<option value="">All Departments</option>');

                if (faculty) {
                    // Enable department select
                    departmentSelect.prop('disabled', false);

                    // Add departments for selected faculty
                    const departments = departmentsByFaculty[faculty] || [];
                    departments.forEach(function(department) {
                        departmentSelect.append(
                            `<option value="${department.toLowerCase().replace(/\s+/g, '_')}">${department}</option>`
                        );
                    });
                } else {
                    // Disable department select if no faculty selected
                    departmentSelect.prop('disabled', true);
                }
            });

            // Populate departments based on faculty selection (for upload)
            $('#upload-faculty').change(function() {
                const faculty = $(this).val();
                const departmentSelect = $('#upload-department');

                // Clear current options
                departmentSelect.html('<option value="">Select Department</option>');

                if (faculty) {
                    // Enable department select
                    departmentSelect.prop('disabled', false);

                    // Add departments for selected faculty
                    const departments = departmentsByFaculty[faculty] || [];
                    departments.forEach(function(department) {
                        departmentSelect.append(
                            `<option value="${department.toLowerCase().replace(/\s+/g, '_')}">${department}</option>`
                        );
                    });
                } else {
                    // Disable department select if no faculty selected
                    departmentSelect.prop('disabled', true);
                }
            });

            //    file upload
            $('#upload-form').submit(function(e) {
                e.preventDefault();
                var $submitBtn = $(this).find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Uploading...');
                var formData = new FormData(this);

                $.ajax({
                    url: 'upload_past_question.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let res = {};
                        try {
                            res = typeof response === 'object' ? response : JSON.parse(
                                response);
                        } catch (e) {}
                        if (res.success) {
                            $('#upload-modal').addClass('hidden');
                            $('#upload-form')[0].reset();
                            $('#file-name').addClass('hidden');
                            showPopup(true, res.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            showPopup(false, res.message || 'Upload failed.');
                        }
                    },
                    error: function() {
                        showPopup(false, 'An error occurred while uploading.');
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('Upload');
                    }
                });
            });


            // popup logics to show success or error message. 
            function showPopup(success, message) {
                $('#popup-title').text(success ? 'Congratulations!' : 'Error');
                $('#popup-message').text(message);
                $('#upload-popup').removeClass('hidden');
                // Add animated confetti for success
                if (success) {
                    $('#popup-animation').html(
                        '<img src="https://cdn.pixabay.com/animation/2022/10/13/14/44/14-44-47-282_512.gif" class="w-24 h-24 mx-auto mb-2" alt="Confetti">'
                    );
                } else {
                    $('#popup-animation').html(
                        '<i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-2"></i>');
                }
            }

            $('#close-popup').click(function() {
                $('#upload-popup').addClass('hidden');
            });

            // Upload modal handlers
            $('#upload-btn').click(function() {
                $('#upload-modal').removeClass('hidden');
            });

            $('#close-modal, #cancel-upload').click(function() {
                $('#upload-modal').addClass('hidden');
                $('#upload-form')[0].reset();
                $('#file-name').addClass('hidden');
            });

            // View button handlers
            $('.view-btn').click(function() {
                // Get course details (this would fetch the actual PDF)
                const row = $(this).closest('tr');
                const courseCode = row.find('td:eq(0)').text();
                const courseTitle = row.find('td:eq(1)').text();

                // Set modal title and content
                $('#view-title').text(`${courseCode} - ${courseTitle}`);

                // In a real implementation, this would be the path to the actual PDF
                $('#pdf-viewer').attr('src', 'https://mozilla.github.io/pdf.js/web/viewer.html'
                    //  "uploads/past_questions/uploads/past_questions/682db3753e8c4.pdf"
                );

                // Show modal
                $('#view-modal').removeClass('hidden');
            });

            $('#close-view-modal').click(function() {
                $('#view-modal').addClass('hidden');
                $('#pdf-viewer').attr('src', '#');
            });

            // Download button handler
            $('.download-btn, #download-from-view').click(function() {
                // In a real implementation, this would trigger a file download
                alert('Download started! the file would be downloaded soon.');
            });
        });
    </script>
    <!-- Success/Error Popup -->
    <div id="upload-popup" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 flex flex-col items-center relative animate__animated animate__bounceIn">
            <button id="close-popup"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            <div id="popup-animation" class="mb-4"></div>
            <h2 id="popup-title" class="text-2xl font-bold mb-2"></h2>
            <p id="popup-message" class="text-gray-700 dark:text-gray-300 mb-4"></p>
        </div>
    </div>
</body>

</html>