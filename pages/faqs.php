<?php
session_start();
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';
$profile_picture = $_SESSION['profile_picture'] ?? 'https://i.imgur.com/8Km9tLL.jpg';


// redirect logics
session_start();
if (!isset($_SESSION['user_id'])) {
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$redirect");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta nFAQsadddame="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - FUD Pal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- js -->
    <link rel="tex/javascript" href="./assets/js/main.js">
    <link rel="tex/javascript" href="./assets/js/scrip.js">
    <link rel="tex/javascript" href="./assets/js/map.js">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- animate.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="bg-gray-50 dark:bg-gray-900  flex flex-col min-h-screen    flex-grow   mb-auto">
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
                    <img src="https://i.imgur.com/8Km9tLL.jpg" alt="Profile Picture"
                        class="w-10 h-10 rounded-full object-cover border-2 border-white">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <?php
                    if ($login_successful) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['fullname'] = $user['fullname'];
                        $_SESSION['regnum'] = $user['regnum'];
                        echo json_encode(['success' => true]);
                        exit;
                    }
                    ?>
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
                    <img src="https://i.imgur.com/8Km9tLL.jpg" alt="Profile Picture"
                        class="w-10 h-10 rounded-full object-cover border-2 border-white">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <?php
                    $fullname = $_SESSION['fullname'] ?? 'Student';
                    $regnum = $_SESSION['regnum'] ?? '';
                    $profile_picture = $_SESSION['profile_picture'] ?? 'https://i.imgur.com/8Km9tLL.jpg'; // Default image
                    ?>
                    <h3 class="font-semibold"><?php echo htmlspecialchars($fullname); ?></h3>
                    <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                </div>
            </div>
        </div>

        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="../dashboard.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-white bg-opacity-10">
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
                    <a href="guidelines.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Student Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="reg_guide.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-book"></i>
                        <span>Reg Guidelines</span>
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
                    <a href="forum/"
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
                <li>
                    <a href="notifications.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 ml-auto">3</span>
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


    <div class="container mx-auto px-4 py-8   main-content md:ml-64 min-h-screen transition-all  max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Frequently Asked Questions</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar categories -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md sticky top-24">
                    <div class="bg-green-600 p-4 text-white">
                        <h2 class="text-lg font-semibold">Categories</h2>
                    </div>
                    <div class="p-4">
                        <div class="relative">
                            <input type="text" id="search-faq"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                placeholder="Search FAQs...">
                            <i
                                class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <nav class="mt-4">
                            <ul class="space-y-1">
                                <li>
                                    <a href="#general"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition active">
                                        <i class="fas fa-info-circle mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>General Information</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#registration"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-user-graduate mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>Registration</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#courses"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-book mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>Courses & Examinations</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#fees"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-money-bill-wave mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>Fees & Payments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#facilities"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-building mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>Campus Facilities</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#accommodation"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-home mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>Accommodation</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#technical"
                                        class="faq-category-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <i class="fas fa-laptop mr-2 text-green-600 dark:text-green-400"></i>
                                        <span>Technical Issues</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-gray-700 dark:text-gray-300 text-sm">
                                Can't find what you're looking for?
                            </p>
                            <a href="#contact-support"
                                class="inline-block mt-2 text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                <i class="fas fa-headset mr-1"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main FAQ content -->
            <div class="lg:col-span-3 animate_animated animate_fadeInUp">
                <!-- General Information -->
                <section id="general" class="mb-10 scroll-mt-24 ">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-info-circle mr-3 text-green-600 dark:text-green-400"></i>
                            General Information
                        </h2>

                        <div class="space-y-4">
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">What is Federal University
                                        Dutse (FUD)?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        Federal University Dutse (FUD) is a federal government-owned university located
                                        in Dutse, the capital city of Jigawa State, Nigeria. Established in 2011, FUD is
                                        one of the nine universities created by the Federal Government of Nigeria in
                                        that year. The university offers a wide range of undergraduate and postgraduate
                                        programs across various faculties.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">What faculties are available
                                        at FUD?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        FUD currently has the following faculties:
                                    </p>
                                    <ul class="list-disc pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>Faculty of Agriculture</li>
                                        <li>Faculty of Arts and Social Sciences</li>
                                        <li>Faculty of Education</li>
                                        <li>Faculty of Computing</li>
                                        <li>Faculty of Law</li>
                                        <li>Faculty of Management Sciences</li>
                                        <li>Faculty of Sciences</li>
                                        <li>Faculty of Clinical Science</li>
                                        <li>Faculty of Physical Science</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">What is the academic
                                        calendar for FUD?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        The academic calendar typically runs from September/October to July of the
                                        following year. The academic year is divided into two semesters, with each
                                        semester lasting about 13-16 weeks. The first semester usually runs from
                                        September/October to January/February, while the second semester runs from
                                        February/March to June/July.
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        For the most current academic calendar, please visit the university's official
                                        website or check the notice boards on campus.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">How can I contact the
                                        university administration?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        You can contact the university administration through the following channels:
                                    </p>
                                    <ul class="mt-2 space-y-2 text-gray-700 dark:text-gray-300">
                                        <li><strong>Address:</strong> Federal University Dutse, P.M.B 7156, Ibrahim
                                            Aliyu Bye-Pass, Dutse, Jigawa State, Nigeria</li>
                                        <li><strong>Phone:</strong> +234 123 456 7890, +234 098 765 4321</li>
                                        <li><strong>Email:</strong> info@fud.edu.ng</li>
                                        <li><strong>Website:</strong> <a href="https://fud.edu.ng" target="_blank"
                                                class="text-blue-600 hover:underline dark:text-blue-400">www.fud.edu.ng</a>
                                        </li>
                                    </ul>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        For specific departments or faculties, please check the university website for
                                        their contact information.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">How do I apply for admission
                                        to FUD?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        To apply for admission to FUD, you need to follow these general steps:
                                    </p>
                                    <ol class="list-decimal pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>Register and take the Unified Tertiary Matriculation Examination (UTME)
                                            conducted by JAMB.</li>
                                        <li>Choose FUD as your preferred institution during the JAMB registration.</li>
                                        <li>Meet the minimum UTME score requirement set by FUD for your desired program.
                                        </li>
                                        <li>Register for and participate in the post-UTME screening exercise organized
                                            by FUD.</li>
                                        <li>Check the admission list when published.</li>
                                        <li>If admitted, accept your admission and proceed with the registration
                                            process.</li>
                                    </ol>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        For direct entry admission and postgraduate programs, please visit the
                                        university website for specific requirements and application procedures.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Registration -->
                <section id="registration" class="mb-10 scroll-mt-24">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-user-graduate mr-3 text-green-600 dark:text-green-400"></i>
                            Registration
                        </h2>

                        <div class="space-y-4">
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">When does registration open
                                        for new and returning students?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        Registration typically opens in August/September for the first semester.
                                        New students usually have a dedicated
                                        registration period following the release of admission lists. Specific dates are
                                        announced on the university's official website and notice boards.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">What documents are required
                                        for registration?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        For new students, the following documents are typically required:
                                    </p>
                                    <ul class="list-disc pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>Admission letter</li>
                                        <li>JAMB result slip or Direct Entry admission letter</li>
                                        <li>O'Level results (WAEC/NECO)</li>
                                        <li>Birth certificate or age declaration</li>
                                        <li>Certificate of state of origin</li>
                                        <li>Mwdical Certifiate</li>
                                        <li>Payment receipts for school fees and other charges</li>
                                        <li>Clearance from the department</li>
                                        <li>Passport photographs</li>
                                    </ul>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        For returning students, you'll typically need:
                                    </p>
                                    <ul class="list-disc pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>School ID card</li>
                                        <li>Payment receipts for current session fees</li>
                                        <li>Course registration form from the previous session</li>

                                    </ul>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">How do I complete my course
                                        registration?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        Course registration is a multi-step process:
                                    </p>
                                    <ol class="list-decimal pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>Log in to the student portal using your credentials</li>
                                        <li>Pay your school fees and ensure the payment is confirmed on your portal</li>
                                        <li>Select the courses you want to register for the semester according to your
                                            program's curriculum</li>
                                        <li>Submit your course selection</li>
                                        <li>Print your course registration form</li>
                                        <li>Get the form signed by your level coordinator and the Head of Department
                                        </li>
                                        <li>Submit the signed form to your departmental office</li>
                                    </ol>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        For a detailed guide with screenshots, please check our <a href="reg_guide.php"
                                            class="text-blue-600 hover:underline dark:text-blue-400">Registration
                                            Guide</a>.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">What happens if I miss the
                                        registration deadline?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        If you miss the initial registration deadline, there is usually a late
                                        registration period during which you can still register but with a late
                                        registration fee. After the late registration period closes, you will not be
                                        able to register for that semester, which may affect your graduation timeline.
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        In exceptional circumstances, such as medical emergencies or other serious
                                        issues, you may apply for consideration to the Registrar's office with
                                        supporting documentation.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">Can I make changes to my
                                        registered courses?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        Yes, you can add or drop courses during the add/drop period, which is typically
                                        within the first two weeks of each semester. To make changes:
                                    </p>
                                    <ol class="list-decimal pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>Log in to the student portal</li>
                                        <li>Navigate to the course registration section</li>
                                        <li>Make the necessary changes to your course selection</li>
                                        <li>Print a new course registration form</li>
                                        <li>Get it signed by your level coordinator and the Head of Department</li>
                                        <li>Submit the updated form to your departmental office</li>
                                    </ol>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        After the add/drop period, you will not be able to make changes to your course
                                        registration for that semester without special approval.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Courses & Examinations  -->
                <section id="courses" class="mb-10 scroll-mt-24">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-book mr-3 text-green-600 dark:text-green-400"></i>
                            Courses & Examinations
                        </h2>

                        <div class="space-y-4">
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">How many courses should I
                                        register per semester?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        The number of courses varies by program and level, but generally:
                                    </p>
                                    <ul class="list-disc pl-6 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li>Most undergraduate students register for 15-24 credit units per semester
                                        </li>
                                        <li>The maximum allowed credit load is 24 units per semester</li>
                                        <li>Students on probation may be restricted to 15 credit units</li>
                                        <li>Final year students might have fewer courses depending on their program</li>
                                    </ul>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">
                                        Always consult your department's handbook or level coordinator to ensure you're
                                        registering for the right number and combination of courses for your program.
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <button
                                    class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                                    <span class="font-medium text-gray-800 dark:text-white">What is the grading system
                                        at FUD?</span>
                                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                                </button>
                                <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        FUD uses a 5-point grading system as follows:
                                    </p>
                                    <div class="overflow-x-auto mt-2">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Score Range</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Letter Grade</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Grade Point</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                        Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        70-100</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        A</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        5.0</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        Excellent</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        60-69</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        B</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        4.0</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        Very Good</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        50-59</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        C</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        3.0</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        Good</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        45-49</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        D</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        2.0</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        Fair</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        40-44</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        E</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        1.0</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        Pass</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        0-39</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        F</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        0.0</td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                        Fail</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 mt-3">
                                        Your Grade Point Average (GPA) is calculated by multiplying the grade point of
                                        each course by its credit unit, summing these products, and dividing by the
                                        total credit units attempted in that semester.
                                    </p>
                                </div>
                            </div>

                            <!-- Additional FAQ items would be here -->
                        </div>
                    </div>
                </section>

                <!-- Contact Support section -->
                <section id="contact-support" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-headset mr-3 text-green-600 dark:text-green-400"></i>
                        Contact Support
                    </h2>

                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        If you couldn't find the answer to your question, feel free to contact our support team.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-4">Send Us a Message</h3>

                            <form action="#" method="post" class="space-y-4">
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your
                                        Name</label>
                                    <input type="text" id="name" name="name"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                </div>

                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                        Address</label>
                                    <input type="email" id="email" name="email"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                </div>

                                <div>
                                    <label for="category"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                    <select id="category" name="category"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                        <option value="">Select a category</option>
                                        <option value="registration">Registration Issue</option>
                                        <option value="payment">Payment Issue</option>
                                        <option value="technical">Technical Issue</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="message"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                                    <textarea id="message" name="message" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required></textarea>
                                </div>

                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition">
                                    <i class="fas fa-paper-plane mr-2"></i> Send Message
                                </button>
                            </form>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-4">Contact Information
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">Student Affairs Office</h4>
                                    <ul class="mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li class="flex items-start">
                                            <i class="fas fa-phone-alt mt-1 mr-2 text-green-600"></i>
                                            <span>+234 8012345678</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-envelope mt-1 mr-2 text-green-600"></i>
                                            <span>studentaffairs@fud.edu.ng</span>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">Academic Office</h4>
                                    <ul class="mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li class="flex items-start">
                                            <i class="fas fa-phone-alt mt-1 mr-2 text-green-600"></i>
                                            <span>+234 8087654321</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-envelope mt-1 mr-2 text-green-600"></i>
                                            <span>academics@fud.edu.ng</span>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">Technical Support</h4>
                                    <ul class="mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li class="flex items-start">
                                            <i class="fas fa-phone-alt mt-1 mr-2 text-green-600"></i>
                                            <span>+234 8023456789</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-envelope mt-1 mr-2 text-green-600"></i>
                                            <span>techsupport@fud.edu.ng</span>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">Opening Hours</h4>
                                    <ul class="mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                                        <li class="flex items-start">
                                            <i class="fas fa-clock mt-1 mr-2 text-green-600"></i>
                                            <span>Monday to Friday: 8:00 AM - 4:00 PM</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-clock mt-1 mr-2 text-green-600"></i>
                                            <span>Saturday: 9:00 AM - 1:00 PM</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-clock mt-1 mr-2 text-green-600"></i>
                                            <span>Sunday: Closed</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="font-medium text-gray-800 dark:text-white">Social Media</h4>
                                <div class="flex space-x-4 mt-2">
                                    <a href="#"
                                        class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                                        <i class="fab fa-facebook-f text-xl"></i>
                                    </a>
                                    <a href="#"
                                        class="text-gray-600 hover:text-blue-400 dark:text-gray-400 dark:hover:text-blue-400">
                                        <i class="fab fa-twitter text-xl"></i>
                                    </a>
                                    <a href="#"
                                        class="text-gray-600 hover:text-pink-600 dark:text-gray-400 dark:hover:text-pink-400">
                                        <i class="fab fa-instagram text-xl"></i>
                                    </a>
                                    <a href="#"
                                        class="text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                                        <i class="fab fa-youtube text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 shadow-md py-4 mt-8 animate__animated animate__fadeInUp">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm text-center">
                    &copy; <span id="year"></span> FUD Pal. All rights reserved.
                </p>
                <div class="flex justify-center space-x-4 mt-2 md:mt-0">
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script>
    $(document).ready(function() {
        const currentYear = new Date().getFullYear();
        $('#year').text(currentYear);
    });
    </script>
    </div>

    <script>
    $(document).ready(function() {
        const currentYear = new Date().getFullYear();
        $('#year').text(currentYear);
    });
    </script>

    <!--JavaScriptfor FAQ toggles-- >
          
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // FAQ toggles
                const faqToggles = document.querySelectorAll('.faq-toggle');

                faqToggles.forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('i');

                        // Toggle content visibility
                        content.classList.toggle('hidden');

                        // Rotate icon
                        if (content.classList.contains('hidden')) {
                            icon.classList.remove('rotate-180');
                        } else {
                            icon.classList.add('rotate-180');
                        }
                    });
                });

                // Category navigation
                const categoryLinks = document.querySelectorAll('.faq-category-link');

                categoryLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        const targetId = this.getAttribute('href');
                        const targetSection = document.querySelector(targetId);

                        window.scrollTo({
                            top: targetSection.offsetTop - 80,
                            behavior: 'smooth'
                        });

                        // Update active state
                        categoryLinks.forEach(l => l.classList.remove('bg-green-100',
                            'dark:bg-green-900', 'text-green-800', 'dark:text-green-200'));
                        this.classList.add('bg-green-100', 'dark:bg-green-900', 'text-green-800',
                            'dark:text-green-200');
                    });
                });

                // Search functionality
                const searchInput = document.getElementById('search-faq');

                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    // Get all FAQ items
                    const faqItems = document.querySelectorAll('.faq-toggle');

                    faqItems.forEach(item => {
                        const question = item.querySelector('span').textContent.toLowerCase();
                        const content = item.nextElementSibling.textContent.toLowerCase();
                        const faqContainer = item.parentElement;

                        // Check if question or answer contains the search term
                        if (question.includes(searchTerm) || content.includes(searchTerm)) {
                            faqContainer.style.display = 'block';

                            // Open the FAQ item if there's a search term
                            if (searchTerm && item.nextElementSibling.classList.contains('hidden')) {
                                item.nextElementSibling.classList.remove('hidden');
                                item.querySelector('i').classList.add('rotate-180');
                            }
                        } else {
                            faqContainer.style.display = 'none';
                        }
                    });

                    // Check which sections are empty after filtering
                    const sections = document.querySelectorAll('section[id]');

                    sections.forEach(section => {
                        const visibleFAQs = section.querySelectorAll('.faq-toggle').length;
                        const hiddenFAQs = section.querySelectorAll(
                            '.faq-toggle[style="display: none"]').length;

                        // If all FAQs in this section are hidden, hide the section
                        if (visibleFAQs > 0 && visibleFAQs === hiddenFAQs) {
                            section.style.display = 'none';
                        } else {
                            section.style.display = 'block';
                        }
                    });
                });
            });
    </script>
</body>

</html>