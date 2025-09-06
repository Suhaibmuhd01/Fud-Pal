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
    <title>Course Registration Guide - FUD PAL</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
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

        /* Custom animation for loading spinner */
        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            animation: spinner 0.6s linear infinite;
        }

        /* Step indicator styles */
        .step-connector {
            position: absolute;
            top: 14px;
            left: 14px;
            bottom: -14px;
            width: 2px;
            background-color: #E5E7EB;
            z-index: 0;
        }

        .dark .step-connector {
            background-color: #4B5563;
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

        /* Dark mode styles */
        .dark body {
            background-color: #1F2937;
            color: #F3F4F6;
        }

        .dark .bg-white {
            background-color: #374151;
        }

        .dark .text-gray-800 {
            color: #E5E7EB;
        }

        .dark .border-gray-200 {
            border-color: #4B5563;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Mobile menu overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar"
        class="sidebar fixed top-0 left-0 h-full w-64 bg-green-600 text-white z-50 -translate-x-full md:hidden">
        <div class="flex items-center justify-between p-4 border-b border-green-500">
            <div class="flex items-center">
                <i class="fas fa-users text-xl mr-2"></i>
                <h2 class="font-bold text-lg">FUD PAL</h2>
            </div>
            <button id="close-mobile-menu" class="focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-4 border-b border-green-500">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="profile_image.php?regnum=<?php echo urlencode($_SESSION['regnum']); ?>" ...
                        alt="Profile Picture" class="w-10 h-10 rounded-full object-cover border-2 border-white">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-semibold"><?php echo htmlspecialchars($fullname); ?></h3>
                    <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                </div>
            </div>
        </div>
        <nav>
            <ul class="space-y-1">
                <li>
                    <a href="../dashboard.php" class="flex items-center px-4 py-3 hover:bg-green-700 transition-colors">
                        <i class="fas fa-home w-6"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="map.php" class="flex items-center px-4 py-3 hover:bg-green-700 transition-colors">
                        <i class="fas fa-map-marker-alt w-6"></i>
                        <span>Map</span>
                    </a>
                </li>
                <li>
                    <a href="past_questions.php"
                        class="flex items-center px-4 py-3 hover:bg-green-700 transition-colors">
                        <i class="fas fa-question-circle w-6"></i>
                        <span>Past Questions</span>
                    </a>
                </li>
                <li>
                    <a href="reg_guide.php" class="flex items-center px-4 py-3 bg-green-700">
                        <i class="fas fa-book w-6"></i>
                        <span>Registration Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="guidelines.php" class="flex items-center px-4 py-3 bg-green-700">
                        <i class="fas fa-book w-6"></i>
                        <span>Course Reg Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="faqs.php" class="flex items-center px-4 py-3 hover:bg-green-700 transition-colors">
                        <i class="fas fa-info-circle w-6"></i>
                        <span>FAQs</span>
                    </a>
                </li>
                <li>
                    <a href="forums/" class="flex items-center px-4 py-3 hover:bg-green-700 transition-colors">
                        <i class="fas fa-comments w-6"></i>
                        <span>Community Forum</span>
                    </a>
                </li>
                <li>
                    <a href="profile.php" class="flex items-center px-4 py-3 hover:bg-green-700 transition-colors">
                        <i class="fas fa-user w-6"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-green-500">
            <a href="../logout.php" class="flex items-center text-white">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div id="sidebar" class="sidebar fixed top-0 left-0 h-full w-64 bg-green-600 text-white z-30 hidden md:block">
        <div class="p-4 border-b border-green-500">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-users text-xl"></i>
                <h1 class="text-xl font-bold">FUD PAL</h1>
            </div>
        </div>
        <div class="p-4 border-b border-green-500">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="profile_image.php?regnum=<?php echo urlencode($regnum); ?>&t=<?php echo time(); ?>"
                        alt="Profile"
                        class="w-14 h-14 rounded-full object-cover border-4 border-white shadow-lg transition duration-300 hover:scale-105">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-base text-white"> <?php echo htmlspecialchars($fullname); ?> </span>
                    <span class="text-xs text-green-200"> <?php echo htmlspecialchars($regnum); ?> </span>
                </div>
            </div>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="../dashboard.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="map.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Campus Map</span>
                    </a>
                </li>
                <li>
                    <a href="past_questions.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-question-circle"></i>
                        <span>Past Questions</span>
                    </a>
                </li>
                <li>
                    <a href="reg_guide.php" class="flex items-center px-4 py-3">
                        <i class="fas fa-book w-6"></i>
                        <span>Reg Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="guidelines.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-green-700 text-white hover:bg-green-700 hover:text-white transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Course Reg Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="faqs.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-info-circle"></i>
                        <span>FAQs</span>
                    </a>
                </li>
                <li>
                    <a href="forums/"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-comments"></i>
                        <span>Community Forum</span>
                    </a>
                </li>
                <li>
                    <a href="profile/"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="mt-6 border-t border-green-500 pt-4">
                    <a href="../logout.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Main content -->
    <div class="md:ml-64 min-h-screen flex flex-col">
        <!-- Content Area -->
        <div class="flex-1 p-4 md:p-8">
            <!-- Introduction Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="md:w-3/4">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Course Registration Guide</h2>
                        <p class="text-gray-600 dark:text-gray-300">
                            This guide provides step-by-step instructions for course registration at Federal University
                            Dutse. It covers the entire process from login to confirmation, including important
                            deadlines and requirements.
                        </p>
                    </div>
                    <div class="md:w-1/4 mt-4 md:mt-0 flex justify-center md:justify-end">
                        <div
                            class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-400">
                            <i class="fas fa-book text-4xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Dates Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="100">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Important Dates for 2024/2025 Session
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">Registration Start</h4>
                                <p class="text-sm text-blue-600 dark:text-blue-400">Feb 04, 2025</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Course registration portal opens for all
                            levels</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <div
                                class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-400 mr-3">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">Registration Deadline</h4>
                                <p class="text-sm text-red-600 dark:text-red-400">Feb 28, 2025</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Last day to register without late fee</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <div
                                class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center text-yellow-600 dark:text-yellow-400 mr-3">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">Late Registration</h4>
                                <p class="text-sm text-yellow-600 dark:text-yellow-400">May 05 - May 11, 2025</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Registration with late fee penalty</p>
                    </div>
                </div>
            </div>

            <!-- Registration Steps -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="200">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Step-by-Step Registration Guide</h3>

                <div class="space-y-8">
                    <div class="flex">
                        <div class="mr-4 relative">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-medium relative z-10">
                                1
                            </div>
                            <div class="step-connector"></div>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Portal Login</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                    <li>Visit the university portal at <a
                                            href="https://www.myportal.fud.edu.ng/index.html"
                                            class="text-green-600 dark:text-green-400 hover:underline">https://www.myportal.fud.edu.ng/index.html</a>
                                    </li>
                                    <li>Enter your registration number as username</li>
                                    <li>Enter your password (default is your registration number if you haven't changed
                                        it)</li>
                                    <li>Click on "Login" button</li>
                                </ol>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="font-medium">Tip</h5>
                                        <p class="text-sm">If you can't remember your password, click on the "Forgot
                                            Password" link and follow the instructions to reset it.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mr-4 relative">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-medium relative z-10">
                                2
                            </div>
                            <div class="step-connector"></div>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Navigate to Course
                                Registration</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                    <li>From your dashboard, locate and click on "Course Registration" in the main menu
                                    </li>
                                    <li>Select "Register Courses" from the dropdown menu</li>

                                </ol>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="font-medium">Note</h5>
                                        <p class="text-sm">Ensure your fee payment has been verified before attempting
                                            course registration. The system will not allow registration without
                                            confirmed payment.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mr-4 relative">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-medium relative z-10">
                                3
                            </div>
                            <div class="step-connector"></div>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Select Courses</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                    <li>The system will display all available courses for your level and program</li>
                                    <li>Core/compulsory courses are usually pre-selected</li>
                                    <li>Select elective courses as required by your department</li>
                                    <li>Pay attention to the credit unit requirements (minimum and maximum)</li>
                                    <li>Ensure any carryover courses from previous semesters are selected</li>
                                </ol>
                            </div>
                            <div
                                class="bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="font-medium">Important</h5>
                                        <p class="text-sm">The system will not allow you to register beyond the maximum
                                            credit units (24 units) or below the minimum (15 units) for a semester.
                                            Consult your level coordinator if you have special circumstances.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mr-4 relative">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-medium relative z-10">
                                4
                            </div>
                            <div class="step-connector"></div>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Review and Submit</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                    <li>After selecting your courses, Review them</li>
                                    <li>Carefully check all selected courses, ensuring they are correct</li>
                                    <li>Verify the total credit units</li>
                                    <li>Once satisfied, click "Save and print"</li>
                                </ol>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="font-medium">Warning</h5>
                                        <p class="text-sm">After submission, changes to your course registration will
                                            require approval from your department. Be absolutely sure before submitting.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mr-4 relative">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-medium relative z-10">
                                5
                            </div>
                            <div class="step-connector"></div>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Print Registration Form
                            </h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                    <li>After successful submission, A PDF document will be generated with all your
                                        registered courses</li>
                                    <li>Print at least three copies of this form</li>
                                    <li>Sign all copies in the designated area</li>
                                </ol>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="font-medium">Tip</h5>
                                        <p class="text-sm">Save a digital copy of your registration form for your
                                            records. You can also download it again from the portal if needed.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mr-4">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-medium">
                                6
                            </div>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Get Approval</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                    <li>Take your your printed copies(at least 3) to your level coordinator to sign
                                    </li>
                                    <li>submit a copy with your data form to Academic Division</li>
                                    <li> submit to your level coordinator office</li>
                                    <li>Forward one copy to the faculty (Dean&apos;s office)</li>
                                    <li>Keep at least one copy for your personal records</li>
                                </ol>
                            </div>
                            <div
                                class="bg-green-50 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="font-medium">Completion</h5>
                                        <p class="text-sm">Your registration is complete once your form has been saved
                                            and printed, signed by your level coordinator(level coordinator). Always
                                            keep
                                            your copy safe as proof of registration.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Common Issues -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="300">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Common Registration Issues & Solutions
                </h3>

                <div class="space-y-4">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">Portal Access Problems</h4>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">If you can't log in to the portal, try these
                            solutions:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                            <li>Clear your browser cache and cookies</li>
                            <li>Try a different browser (Chrome, Firefox, etc.)</li>
                            <li>Ensure your registration number and password are entered correctly</li>
                            <li>Use the "Forgot Password" option to reset your password</li>
                            <li>Contact ICT Support at <a href="mailto:ict@fud.edu.ng"
                                    class="text-green-600 dark:text-green-400 hover:underline">ict@fud.edu.ng</a> if
                                problems persist</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">Payment Verification Issues</h4>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">If your payment is not reflecting in the
                            system:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                            <li>Allow 24-48 hours for payment to be verified after making payment</li>
                            <li>Ensure you have the correct RRR number and payment receipt</li>
                            <li>Visit the Bursary Department with your payment receipt if verification takes longer than
                                expected</li>
                            <li>Do not make duplicate payments without confirming with the Bursary first</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">Course Selection Problems</h4>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">If you encounter issues with course selection:
                        </p>
                        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                            <li>Ensure you're registering for the correct academic session and semester</li>
                            <li>Check with your department if expected courses are not listed</li>
                            <li>Verify prerequisite courses have been passed if unable to register for certain courses
                            </li>
                            <li>Consult your level coordinator if you have special cases (e.g., less than minimum credit
                                units due to graduation requirements)</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-2">Post-Submission Changes</h4>
                        <p class="text-gray-700 dark:text-gray-300 mb-2">If you need to change your registration after
                            submission:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                            <li>Submit a formal letter requesting changes to your department</li>
                            <li>Include your registration number, full name, and specific courses to add/drop</li>
                            <li>Provide valid reasons for the requested changes</li>
                            <li>Changes must be approved by your level coordinator and head of department</li>
                            <li>Changes are typically only allowed within the first two weeks of classes</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Additional Resources -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="400">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Additional Resources</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-400 mr-3">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Official Documents</h4>
                        </div>
                        <ul class="space-y-2">
                            <li>
                                <a href="#"
                                    class="flex items-center text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                                    <i class="fas fa-download mr-2 text-green-600 dark:text-green-400"></i>
                                    <span>University Academic Calendar</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                                    <i class="fas fa-download mr-2 text-green-600 dark:text-green-400"></i>
                                    <span>Student Handbook</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                                    <i class="fas fa-download mr-2 text-green-600 dark:text-green-400"></i>
                                    <span>Fee Structure</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-3">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h4 class="font-medium text-gray-800 dark:text-white">Contact Information</h4>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-start text-gray-700 dark:text-gray-300">
                                <i class="fas fa-building mt-1 mr-2 text-green-600 dark:text-green-400"></i>
                                <span>Academic Office: <a href="mailto:academics@fud.edu.ng"
                                        class="text-green-600 dark:text-green-400 hover:underline">academics@fud.edu.ng</a>
                                    | +234 123 456 7890</span>
                            </li>
                            <li class="flex items-start text-gray-700 dark:text-gray-300">
                                <i class="fas fa-money-bill-wave mt-1 mr-2 text-green-600 dark:text-green-400"></i>
                                <span>Bursary Department: <a href="mailto:bursary@fud.edu.ng"
                                        class="text-green-600 dark:text-green-400 hover:underline">bursary@fud.edu.ng</a>
                                    | +234 123 456 7891</span>
                            </li>
                            <li class="flex items-start text-gray-700 dark:text-gray-300">
                                <i class="fas fa-laptop mt-1 mr-2 text-green-600 dark:text-green-400"></i>
                                <span>ICT Support: <a href="mailto:ict@fud.edu.ng"
                                        class="text-green-600 dark:text-green-400 hover:underline">ict@fud.edu.ng</a> |
                                    +234 123 456 7892</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Department-Specific Guidelines -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="500">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Department-Specific Guidelines</h3>

                <div class="mb-4">
                    <label for="faculty-select"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Your
                        Faculty</label>
                    <select id="faculty-select"
                        class="w-full md:w-1/2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 dark:text-white text-base">
                        <option value="">-- Select Faculty --</option>
                        <option value="computing">Faculty of Computing</option>
                        <option value="sciences">Faculty of Sciences</option>
                        <option value="agriculture">Faculty of Agriculture</option>
                        <option value="management">Faculty of Management Sciences</option>
                        <option value="arts">Faculty of Arts & Social Sciences</option>
                    </select>
                </div>

                <div id="department-guidelines">
                    <!-- Department guidelines will be dynamically loaded here based on faculty selection -->
                    <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                        <i class="fas fa-hand-pointer text-4xl mb-4"></i>
                        <p>Select your faculty to view department-specific guidelines</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="600">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Frequently Asked Questions</h3>

                <div class="space-y-4">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                        <button class="faq-btn w-full flex justify-between items-center p-4 focus:outline-none"
                            data-target="faq1">
                            <span class="font-medium text-gray-800 dark:text-white">Can I register for courses from any
                                department?</span>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform"></i>
                        </button>
                        <div id="faq1" class="faq-content hidden px-4 pb-4 text-gray-600 dark:text-gray-300">
                            <p>No, you can only register for courses approved in your curriculum. These include your
                                department's core courses, university-wide required courses, and approved electives. If
                                you wish to take courses outside this list, you need special approval from both your
                                department and the department offering the course.</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                        <button class="faq-btn w-full flex justify-between items-center p-4 focus:outline-none"
                            data-target="faq2">
                            <span class="font-medium text-gray-800 dark:text-white">What happens if I miss the
                                registration deadline?</span>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform"></i>
                        </button>
                        <div id="faq2" class="faq-content hidden px-4 pb-4 text-gray-600 dark:text-gray-300">
                            <p>If you miss the regular registration deadline, you can still register during the late
                                registration period (typically 2 weeks after the deadline), but you will be charged a
                                late registration fee. After the late registration period ends, you will not be able to
                                register for courses for that semester and may have to defer your studies.</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                        <button class="faq-btn w-full flex justify-between items-center p-4 focus:outline-none"
                            data-target="faq3">
                            <span class="font-medium text-gray-800 dark:text-white">How do I handle course clashes in my
                                timetable?</span>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform"></i>
                        </button>
                        <div id="faq3" class="faq-content hidden px-4 pb-4 text-gray-600 dark:text-gray-300">
                            <p>The registration system will typically alert you about course clashes. If you have a
                                clash between core courses, immediately inform your level coordinator as the department
                                may need to adjust the schedule. If the clash involves an elective course, you should
                                choose an alternative elective that doesn't clash with your core courses.</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                        <button class="faq-btn w-full flex justify-between items-center p-4 focus:outline-none"
                            data-target="faq4">
                            <span class="font-medium text-gray-800 dark:text-white">Can I make changes to my registered
                                courses after approval?</span>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform"></i>
                        </button>
                        <div id="faq4" class="faq-content hidden px-4 pb-4 text-gray-600 dark:text-gray-300">
                            <p>Once your registration has been approved by your level coordinator and department,
                                changes
                                are only permitted within the first two weeks of classes (Add/Drop period). You must
                                submit a formal request to your department with valid reasons for the changes. After the
                                Add/Drop period, no changes are allowed except in extraordinary circumstances with
                                special approval from the Dean.</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                        <button class="faq-btn w-full flex justify-between items-center p-4 focus:outline-none"
                            data-target="faq5">
                            <span class="font-medium text-gray-800 dark:text-white">What is the minimum and maximum
                                credit load per semester?</span>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform"></i>
                        </button>
                        <div id="faq5" class="faq-content hidden px-4 pb-4 text-gray-600 dark:text-gray-300">
                            <p>The standard credit load is 15-24 units per semester. Regular students must register for
                                a minimum of 15 credit units and cannot exceed 24 units. Final year students in their
                                last semester may be allowed to register for fewer than 15 credits if that's all they
                                need to graduate. Students on probation may be restricted to fewer credits based on
                                their academic standing.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help and Support -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8" data-aos="fade-up"
                data-aos-delay="700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Need Further Assistance?</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            If you still have questions or are experiencing issues with course registration, we're here
                            to help. You can reach out through any of these channels:
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-user-tie mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">level coordinator</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Your first point of contact for
                                        academic guidance</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-building mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">Department Office</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">For department-specific
                                        registration issues</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-headset mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">Student Support Help desk</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Email: <a
                                            href="mailto:support@fud.edu.ng"
                                            class="text-green-600 dark:text-green-400 hover:underline">support@fud.edu.ng</a>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Phone: +234 81 2914 0311</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-4">Submit a Question</h4>
                        <form id="question-form">
                            <div class="mb-4">
                                <label for="question-name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your
                                    Name</label>
                                <input type="text" id="question-name"
                                    class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 dark:text-white">
                            </div>
                            <div class="mb-4">
                                <label for="question-email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                    Address</label>
                                <input type="email" id="question-email"
                                    class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 dark:text-white">
                            </div>
                            <div class="mb-4">
                                <label for="question-text"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your
                                    Question</label>
                                <textarea id="question-text" rows="4"
                                    class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 dark:text-white"></textarea>
                            </div>
                            <button type="button" id="submit-question"
                                class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none w-full">
                                Submit Question
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-6 mb-6 text-center text-gray-500 dark:text-gray-400 text-sm">
            <p>&copy; <span id="year"></span> FUD PAL. All rights reserved.</p>
        </footer>

        <script>
            $(document).ready(function() {
                const currentYear = new Date().getFullYear();
                $('#year').text(currentYear);
            })
        </script>
        <script>
            $(document).ready(function() {
                AOS.init();

                // Mobile menu toggle
                $('#mobile-menu-button').click(function() {
                    $(this).toggleClass('open');
                    $('#mobile-sidebar').toggleClass('-translate-x-full');
                    $('#mobile-menu-overlay').toggleClass('hidden');
                    $('body').toggleClass('overflow-hidden');
                });

                $('#close-mobile-menu').click(function() {
                    $('#mobile-menu-button').removeClass('open');
                    $('#mobile-sidebar').addClass('-translate-x-full');
                    $('#mobile-menu-overlay').addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                });

                $('#mobile-menu-overlay').click(function() {
                    $('#mobile-menu-button').removeClass('open');
                    $('#mobile-sidebar').addClass('-translate-x-full');
                    $('#mobile-menu-overlay').addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                });

                // FAQ accordion
                $('.faq-btn').click(function() {
                    const target = $(this).data('target');
                    $(`#${target}`).slideToggle();
                    $(this).find('i').toggleClass('rotate-180');
                });

                // Faculty selection for department guidelines
                $('#faculty-select').change(function() {
                    const faculty = $(this).val();

                    if (!faculty) {
                        $('#department-guidelines').html(`
                        <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                            <i class="fas fa-hand-pointer text-4xl mb-4"></i>
                            <p>Select your faculty to view department-specific guidelines</p>
                        </div>
                    `);
                        return;
                    }

                    // Show loading state
                    $('#department-guidelines').html(`
                    <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                        <i class="fas fa-spinner spinner text-4xl mb-4"></i>
                        <p>Loading department guidelines...</p>
                    </div>
                `);

                    // Simulate loading department data
                    setTimeout(function() {
                        let departmentHTML = '';

                        if (faculty === 'computing') {
                            departmentHTML = `
                            <div class="bg-green-50 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 mb-6">
                                <p class="font-medium">Faculty of Computing Guidelines</p>
                                <p class="text-sm">The following are specific guidelines for departments within the Faculty of Computing.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Computer Science Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All 100 and 200 level students must register for CSC101 (Introduction to Computer Science) and CSC201 (Data Structures and Algorithms) respectively.</li>
                                            <li>300 level students must register for a minimum of 3 elective courses.</li>
                                            <li>400 level students must select a project supervisor from the approved list before course registration can be approved.</li>
                                            <li>Students with CGPA below 2.0 must meet with the department's level coordinator before registration.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Information Technology Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>IT practical courses require lab registration in addition to course registration.</li>
                                            <li>300 and 400 level students must register for at least one specialization track (Networking, Web Development, or Database Management).</li>
                                            <li>Students with carryover courses must prioritize registering for those courses before adding new courses.</li>
                                            <li>Final year students must submit their project proposals within one week of registration.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Software Engineering Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must register for the Software Engineering Seminar course appropriate for their level.</li>
                                            <li>Students must maintain a minimum CGPA of 2.5 to register for advanced programming courses.</li>
                                            <li>300 level students must complete their Industrial Attachment registration before course registration.</li>
                                            <li>Team project courses require formation of teams before registration deadline.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Cyber Security Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>Students must sign the department's ethical computing agreement before registration is approved.</li>
                                            <li>Ethical Hacking courses require pre-approval and minimum CGPA of 3.0.</li>
                                            <li>All security labs require special registration through the lab administrator.</li>
                                            <li>Students must complete prerequisite courses with a minimum grade of C before registering for advanced security courses.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else if (faculty === 'sciences') {
                            departmentHTML = `
                            <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 text-blue-700 dark:text-blue-200 p-4 mb-6">
                                <p class="font-medium">Faculty of Sciences Guidelines</p>
                                <p class="text-sm">The following are specific guidelines for departments within the Faculty of Sciences.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Physics Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All laboratory courses require separate lab registration and payment of lab fees.</li>
                                            <li>Students must register for PHY101 and PHY102 in the first year, these are prerequisites for all higher courses.</li>
                                            <li>Students with special interests in Theoretical Physics or Applied Physics should consult with the departmental advisor for course selection.</li>
                                            <li>Final year projects require faculty supervisor approval before registration.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Chemistry Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>Safety training must be completed before lab course registration is approved.</li>
                                            <li>All students must register for at least one practical course per semester.</li>
                                            <li>300 and 400 level students must choose a specialization track (Organic, Inorganic, or Physical Chemistry).</li>
                                            <li>Students must maintain a minimum grade of C in prerequisite courses to register for advanced courses.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Mathematics Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must complete MTH101 (Calculus I) before registering for any 200-level mathematics courses.</li>
                                            <li>Students with a grade below C in any mathematics course should consult with a departmental advisor before re-registering.</li>
                                            <li>Pure and Applied Mathematics tracks have different elective requirements; consult the department handbook.</li>
                                            <li>400 level students must register for the Mathematics Seminar course.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else if (faculty === 'agriculture') {
                            departmentHTML = `
                            <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-200 p-4 mb-6">
                                <p class="font-medium">Faculty of Agriculture Guidelines</p>
                                <p class="text-sm">The following are specific guidelines for departments within the Faculty of Agriculture.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Crop Science Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must register for farm practical courses each semester.</li>
                                            <li>Field trips are mandatory components of certain courses; separate registration required.</li>
                                            <li>300 level students must complete their farm attachment registration before course registration.</li>
                                            <li>Final year students must select a research area and supervisor before registration approval.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Animal Science Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>Laboratory safety training must be completed before registering for lab courses.</li>
                                            <li>Students must register for livestock management practical courses each semester.</li>
                                            <li>300 and 400 level students must choose a specialization track (Nutrition, Breeding, or Management).</li>
                                            <li>Final year project proposals must be submitted within two weeks of registration.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else if (faculty === 'management') {
                            departmentHTML = `
                            <div class="bg-purple-50 dark:bg-purple-900 border-l-4 border-purple-500 text-purple-700 dark:text-purple-200 p-4 mb-6">
                                <p class="font-medium">Faculty of Management Sciences Guidelines</p>
                                <p class="text-sm">The following are specific guidelines for departments within the Faculty of Management Sciences.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Accounting Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must register for ACC101 and ACC102 in their first year.</li>
                                            <li>Students must maintain a minimum CGPA of 2.0 to continue in the Accounting program.</li>
                                            <li>300 level students must register for industrial attachment before course registration.</li>
                                            <li>Professional ethics course is mandatory for all levels.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Economics Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must complete ECO101 (Principles of Economics) before registering for any 200-level economics courses.</li>
                                            <li>Statistical Methods courses are prerequisites for advanced economic analysis courses.</li>
                                            <li>300 and 400 level students must choose between Macroeconomics and Microeconomics concentration.</li>
                                            <li>Research methodology course is required before final year project registration.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Business Administration Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must register for BUS101 (Introduction to Business) in their first semester.</li>
                                            <li>300 level students must complete SIWES registration before course registration.</li>
                                            <li>Students must maintain a minimum grade of C in core courses to progress to the next level.</li>
                                            <li>Final year students must register for business seminar and project courses.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else if (faculty === 'arts') {
                            departmentHTML = `
                            <div class="bg-red-50 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-6">
                                <p class="font-medium">Faculty of Arts & Social Sciences Guidelines</p>
                                <p class="text-sm">The following are specific guidelines for departments within the Faculty of Arts & Social Sciences.</p>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">English Language Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must register for ENG101 and ENG102 in their first year.</li>
                                            <li>Literature courses require separate reading materials which must be purchased before classes begin.</li>
                                            <li>300 and 400 level students must choose between Language Studies and Literature tracks.</li>
                                            <li>Creative writing workshop registration is limited; early registration is advised.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Sociology Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must complete SOC101 (Introduction to Sociology) before registering for any advanced courses.</li>
                                            <li>Research methods and statistics courses are prerequisites for final year research project.</li>
                                            <li>Field work courses require separate registration and payment of field trip fees.</li>
                                            <li>Students must maintain a minimum CGPA of 2.0 to continue in the program.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-3">Political Science Department</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                            <li>All students must register for POL101 (Introduction to Political Science) in their first semester.</li>
                                            <li>300 level students must register for political research methods before final year.</li>
                                            <li>International Relations and Public Administration tracks have different elective requirements.</li>
                                            <li>Final year students must attend political science seminar series alongside their project work.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        } else {
                            departmentHTML = `
                            <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                                <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                                <p>No specific guidelines available for the selected faculty. Please contact your department office for registration guidance.</p>
                            </div>
                        `;
                        }

                        $('#department-guidelines').html(departmentHTML);
                    }, 1000);
                });

                // Submit question form
                $('#submit-question').click(function() {
                    const name = $('#question-name').val().trim();
                    const email = $('#question-email').val().trim();
                    const question = $('#question-text').val().trim();

                    // Simple validation
                    if (!name || !email || !question) {
                        alert('Please fill in all fields');
                        return;
                    }

                    // Email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Please enter a valid email address');
                        return;
                    }

                    // Show success message (would be replaced with AJAX call in production)
                    alert('Your question has been submitted successfully! We will get back to you soon.');

                    // Reset form
                    $('#question-form')[0].reset();
                });
            });
        </script>
</body>

</html>