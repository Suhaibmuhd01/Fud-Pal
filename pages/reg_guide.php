<?php
session_start();
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';
$profile_picture = $_SESSION['profile_picture'] ?? 'https://i.imgur.com/8Km9tLL.jpg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Guide - Fud-pal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- JavaScript -->
    <script src="./assets/js/main.js" defer></script>
    <script src="./assets/js/scrip.js" defer></script>
    <script src="./assets/js/map.js" defer></script>
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
    <!-- Tailwind CSS replaces all custom card/page container styles -->
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar (Desktop) -->
    <aside class="sidebar fixed top-0 left-0 h-full bg-green-600 text-white z-30 flex flex-col">
        <div class="p-4 border-b border-green-500">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-users text-xl"></i>
                <h1 class="text-xl font-bold">FUD Pal</h1>
            </div>
        </div>
        <div class="p-4 border-b border-green-500">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture"
                        class="w-10 h-10 rounded-full object-cover border-2 border-white">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-semibold"><?php echo htmlspecialchars($fullname); ?></h3>
                    <p class="text-sm text-green-200"><?php echo htmlspecialchars($regnum); ?></p>
                </div>
            </div>
        </div>
        <nav class="p-4 flex-1 overflow-y-auto">
            <ul class="space-y-2">
                <li><a href="../dashboard.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li><a href="map2.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-map-marker-alt"></i><span>Campus Map</span></a></li>
                <li><a href="past_questions.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-question-circle"></i><span>Past Questions</span></a></li>
                <li><a href="reg_guide.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-white bg-opacity-10"><i
                            class="fas fa-book"></i><span>Reg Guidelines</span></a></li>
                <li><a href="guidelines.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-book"></i><span>Student Guidelines</span></a></li>
                <li><a href="faqs.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-info-circle"></i><span>FAQs</span></a></li>
                <li><a href="forum.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-comments"></i><span>Forum</span></a></li>
                <li><a href="profile.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-user"></i><span>Profile</span></a></li>
                <li><a href="notifications.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-bell"></i><span>Notifications</span><span
                            class="bg-red-500 text-white text-xs rounded-full px-2 ml-auto">3</span></a></li>
                <li class="mt-6 border-t border-green-500 pt-4"><a href="../logout.php"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors"><i
                            class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            </ul>
        </nav>
    </aside>

    <!-- Quick Navigation (Desktop) -->
    <nav class="quick-nav hidden lg:flex flex-col fixed left-64 top-0 bg-gray-100 dark:bg-gray-800 z-20">
        <div class="flex flex-col p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="bg-green-600 p-4 text-white rounded-t-lg">
                    <h2 class="text-lg font-semibold">Quick Navigation</h2>
                </div>
                <ul class="p-4 space-y-1 text-white">
                    <li>
                        <a href="#overview"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-info-circle mr-2 text-green-600 dark:text-green-400"></i> Overview
                        </a>
                    </li>
                    <li>
                        <a href="#new-students"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-user-graduate mr-2 text-green-600 dark:text-green-400"></i> New Students
                        </a>
                    </li>
                    <li>
                        <a href="#returning-students"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-users mr-2 text-green-600 dark:text-green-400"></i> Returning Students
                        </a>
                    </li>
                    <li>
                        <a href="#registration-steps"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-list-ol mr-2 text-green-600 dark:text-green-400"></i> Registration Steps
                        </a>
                    </li>
                    <li>
                        <a href="#course-registration"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-book mr-2 text-green-600 dark:text-green-400"></i> Course Registration
                        </a>
                    </li>
                    <li>
                        <a href="#payment-procedures"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-money-bill-wave mr-2 text-green-600 dark:text-green-400"></i> Payment
                            Procedures
                        </a>
                    </li>
                    <li>
                        <a href="#important-dates"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-calendar-alt mr-2 text-green-600 dark:text-green-400"></i> Important Dates
                        </a>
                    </li>
                    <li>
                        <a href="#faqs"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-question-circle mr-2 text-green-600 dark:text-green-400"></i> FAQs
                        </a>
                    </li>
                    <li>
                        <a href="#contact"
                            class="guide-nav-link flex items-center py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-phone-alt mr-2 text-green-600 dark:text-green-400"></i> Contact Support
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mr-4 ml-auto max-w-4xl w-full pr-6 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Registration Guide</h1>
        <!-- Overview section -->
        <section id="overview" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Overview</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Welcome to the Federal University Dutse Registration Guide. This comprehensive guide
                provides step-by-step instructions for both new and returning students to complete their
                registration process successfully. Registration is a critical process that every student
                must complete at the beginning of each academic session.
            </p>
            <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 p-4 my-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 dark:text-yellow-200">
                            <span class="font-bold">Important:</span>
                            Students are required to
                            complete their registration
                            within the stipulated time frame. Late registration
                            may attract additional fees.
                        </p>
                    </div>
                </div>
            </div>
            <p class="text-gray-700 dark:text-gray-300">
                The registration process consists of several steps including fee payment, course
                registration, and departmental clearance.
                All these steps
                must be completed for your
                registration
                to be considered valid
                for the the
                session
                .</p>
        </section>

        <!-- New Students section -->
        <section id="new-students"
            class="mb-10 bg-white dark:bg-gray-400 dark:bg-gray-800 rounded-lg shadow-md p-6 card-shadow">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">New Students</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Congratulations on your admission to Federal University Dutse!
                This section outlines the
                steps new students need to follow to complete their registration process.
            </p>
            <div class="space-y-4">
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-green">Step 1: Accept Your Admission</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Visit the FUD admission portal with your application number and password to accept
                        your admission offer.
                    </p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-green">Step 2: Generate Invoice</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        After accepting your admission,
                        generate an invoice for the
                        the acceptance fee
                        fee and other
                        applicable fees
                        .
                    </p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-300">Step 3: Payment</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Make payment through
                        the university's approved payment
                        payment
                        platform (Remita
                        )
                        .
                    </p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-300">Step 4: Registration Number
                        (Matriculation Number)</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        After payment
                        confirmation
                        payment
                        ,
                        you will
                        be issued
                        matriculation
                        a matriculation number
                        number which
                        will
                        serve as
                        your
                        unique
                        identifier
                        throughout
                        study
                        your
                        period
                        .
                        .
                    </p>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-300">Document Submission</h5>
                        <p class="text-gray-700 dark:text-gray-300">
                            payment
                            "
                            Submit
                            your
                            original
                            credentials
                            to
                            your
                            department
                            for
                            verification
                            .
                        </p>
                </div>
            </div>
            <div class="mt-6">
                <div class="mt-20">
                    a
                    href="student.txt" href href="#" download
                    class="inline-flex items-center"
                    class="inline-flex items-center text-green-600 hover:text-green-700 dark:text-green-400
                    dark:hover:text-green-300">
                    <span>Download New Student
                        registration
                        Registration
                        checklist
                        student
                    </span>
                    <i class="fas fa-download ml-2"></i>
                    </a>
                </div>
        </section>

        <!-- Returning Students section -->
        <section id="returning-students" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Returning Students</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Welcome back! As a returning student, your registration process is slightly different.
                Follow these steps to complete your registration for the new academic session.
            </p>
            <div class="space-y-4">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white">Step 1: Login to Student Portal</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Login to the student portal using your matriculation number and password.
                    </p>
                </div>
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white">Step 2: Generate Invoice</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Generate payment invoice using remita for the current session's fees.
                    </p>
                </div>
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white">Step 3: Payment</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Complete payment through remita.
                    </p>
                </div>
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white">Step 4: Course Registration</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Register your courses when the course Reg is open for the semester through the student portal.
                    </p>
                </div>
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white">Step 5: Course Form Submission</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Print and submit your course registration form to your Faculty, department, and Academic
                        Division together with your Central Registration.
                    </p>
                </div>
            </div>
            <div class="mt-6">
                <a href="returning.txt" download
                    class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    <span>Download Returning Student Guide</span>
                    <i class="fas fa-download ml-2"></i>
                </a>
            </div>
        </section>

        <!-- Registration Steps section -->
        <section id="registration-steps" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Registration Steps</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">
                The registration process follows a specific sequence of steps. Complete each step before
                moving to the next one to avoid complications.
            </p>
            <div class="relative">
                <!-- Timeline bar -->
                <div
                    class="absolute h-full w-0.5 bg-green-200 dark:bg-green-800 left-6 top-0 transform -translate-x-1/2">
                </div>
                <!-- Timeline steps -->
                <div class="space-y-8">
                    <div class="relative pl-8">
                        <div
                            class="absolute left-0 w-3 h-3 bg-green-600 rounded-full border-4 border-green-100 dark:border-green-900">
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white">1. Portal Access</h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Login to the university portal using your credentials. New students will
                                need to create an account first.
                            </p>
                        </div>
                    </div>
                    <div class="relative pl-8">
                        <div
                            class="absolute left-0 w-3 h-3 bg-green-600 rounded-full border-4 border-green-100 dark:border-green-900">
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white">2. Fee Payment</h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Generate payment invoice and complete fee payment through remita.
                            </p>
                        </div>
                    </div>
                    <div class="relative pl-8">
                        <div
                            class="absolute left-0 w-3 h-3 bg-green-600 rounded-full border-4 border-green-100 dark:border-green-900">
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white">3. Course Selection</h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Courses will be provided for the session on the portal, select them, save, and print.
                            </p>
                        </div>
                    </div>
                    <div class="relative pl-8">
                        <div
                            class="absolute left-0 w-3 h-3 bg-green-600 rounded-full border-4 border-green-100 dark:border-green-900">
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white">4. Course Form Printing</h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Print your course registration form after completing the online registration.
                            </p>
                        </div>
                    </div>
                    <div class="relative pl-8">
                        <div
                            class="absolute left-0 w-3 h-3 bg-green-600 rounded-full border-4 border-green-100 dark:border-green-900">
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white">5. Departmental Approval
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Submit the printed form to the Academic Division, Faculty, and Department.
                            </p>
                        </div>
                    </div>
                    <div class="relative pl-8">
                        <div
                            class="absolute left-0 w-3 h-3 bg-green-600 rounded-full border-4 border-green-100 dark:border-green-900">
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-white">6. Finalization</h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Your registration is complete for the semester.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Registration section -->
        <section id="course-registration" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Course Registration</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Course registration is a critical part of the academic process. Students must register for
                courses at the beginning of each semester to be eligible to take examinations.
            </p>
            <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 p-4 my-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-200">
                            Ensure you register for the correct courses according to your program's
                            curriculum. Consult your level coordinator or Head of Department (HOD)
                            if you're unsure about which courses to select.
                        </p>
                    </div>
                </div>
            </div>
            <h3 class="font-semibold text-lg mt-6 mb-2 text-gray-800 dark:text-white">Course Registration Guidelines
            </h3>
            <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>Students must register for both compulsory and elective courses.</li>
                <li>The maximum credit load per semester is 24 units.</li>
                <li>Students on probation are limited to 15 credit units.</li>
                <li>Courses are registered on a first-come, first-served basis.</li>
                <li>Prerequisites must be completed before registering for advanced courses.</li>
                <li>Course changes are only allowed within the first two weeks of the semester.</li>
            </ul>
            <h3 class="font-semibold text-lg mt-6 mb-2 text-gray-800 dark:text-white">Registration Validation</h3>
            <ol class="list-decimal pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                <li>Printing the course registration form.</li>
                <li>Getting it signed by your level coordinator.</li>
                <li>Submitting the signed form to the Academic Division.</li>
                <li>Submitting the signed form to your Faculty and departmental office.</li>
            </ol>
        </section>

        <!-- Payment Procedures section -->
        <section id="payment-procedures" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Payment Procedures</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                The university has established multiple payment channels to make the fee payment process
                convenient for all students.
            </p>
            <h3 class="font-semibold text-lg mt-6 mb-2 text-gray-800 dark:text-white">Fee Structure</h3>
            <div class="overflow-x-auto">
                <table class="min-w-[50rem] lg:min-w-[70rem] divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Fee Type</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Amount (₦)</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Applicable To</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                Acceptance Fee</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                ₦2,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                New Students Only</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                Tuition Fee</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                null</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                All Students</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                Development Levy</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                ₦5,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                All Students</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                Medical Fee</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                ₦5,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                All Students</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                Library Fee</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                ₦2,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                All Students</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                ICT Fee</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                ₦5,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                All Students</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h3 class="font-semibold text-lg mt-6 mb-2 text-gray-800 dark:text-white">Payment Methods</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-university text-2xl text-blue-600 dark:text-blue-400 mr-3"></i>
                        <h4 class="font-medium text-gray-800 dark:text-white">Bank Payment</h4>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Visit any branch of our partner banks with your generated invoice to make payment.
                    </p>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-credit-card text-2xl text-green-600 dark:text-green-400 mr-3"></i>
                        <h4 class="font-medium text-gray-800 dark:text-white">Online Payment</h4>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Pay securely online using debit cards, credit cards, or bank transfers.
                    </p>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-mobile-alt text-2xl text-purple-600 dark:text-purple-400 mr-3"></i>
                        <h4 class="font-medium text-gray-800 dark:text-white">Mobile Banking</h4>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Use your bank's mobile app to pay using the biller code provided on your invoice.
                    </p>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-money-bill-wave text-2xl text-amber-600 dark:text-amber-400 mr-3"></i>
                        <h4 class="font-medium text-gray-800 dark:text-white">USSD Transfer</h4>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Use your bank's USSD code to pay using the biller code provided on your invoice.
                    </p>
                </div>
            </div>
            <div class="bg-red-50 dark:bg-red-900 border-l-4 border-red-500 p-4 mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Important Notice</h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <p>Never make payments to individual accounts. The university will not be
                                responsible for payments made through unauthorized channels.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Important Dates section -->
        <section id="important-dates" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Important Dates</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">
                Below are the key dates for the current academic session. Mark your calendar to avoid
                missing important deadlines.
            </p>
            <div class="space-y-4">
                <div class="border-l-4 border-green-500 pl-4 py-2">
                    <h3 class="font-semibold text-gray-800 dark:text-white">First Semester</h3>
                    <ul class="mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                        <li class="flex justify-between">
                            <span>Registration Opens</span>
                            <span class="font-medium">September 1, 2025</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Registration Deadline (Without Late Fee)</span>
                            <span class="font-medium">September 30, 2023</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Late Registration Period</span>
                            <span class="font-medium">October 1-14, 2023</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Course Add/Drop Period</span>
                            <span class="font-medium">October 1-14, 2023</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Mid-Semester Examinations</span>
                            <span class="font-medium">November 6-10, 2023</span>
                        </li>
                        <li class="flex justify-between">
                            <span>End of First Semester Lectures</span>
                            <span class="font-medium">December 22, 2023</span>
                        </li>
                        <li class="flex justify-between">
                            <span>First Semester Examinations</span>
                            <span class="font-medium">June 06, 2025</span>
                        </li>
                    </ul>
                </div>
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <h3 class="font-semibold text-gray-800 dark:text-white">Second Semester</h3>
                    <ul class="mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                        <li class="flex justify-between">
                            <span>Lectures start</span>
                            <span class="font-medium">June 20, 2025</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Mid-Semester Examinations</span>
                            <span class="font-medium">August 15-22, 2025</span>
                        </li>
                        <li class="flex justify-between">
                            <span>End of Second Semester Lectures</span>
                            <span class="font-medium">October 05, 2025</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Second Semester Examinations</span>
                            <span class="font-medium">October 08-31, 2025</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-6">
                <a href="circular.pdf" download
                    class="inline-flex items-center text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                    <span>Download Academic Calendar</span>
                    <i class="fas fa-calendar-alt ml-2"></i>
                </a>
            </div>
        </section>

        <!-- FAQs section -->
        <section id="faqs" class="mb-10 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Frequently Asked Questions</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">
                Here are answers to some common questions about the registration process.
            </p>
            <div class="space-y-4">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                    <button
                        class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                        <span class="font-medium text-gray-800 dark:text-white">What happens if I miss the registration
                            deadline?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">
                            If you miss the initial registration deadline, you can still register during the
                            late registration period, but a late fee will be applied. After the late
                            registration period ends, you will not be able to register for the session.
                        </p>
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                    <button
                        class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                        <span class="font-medium text-gray-800 dark:text-white">Can I change my courses after
                            registration?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">
                            Yes, you can add or drop courses during the course add/drop period, which is
                            typically during the first semester. After this period, any changes require special approval
                            from your department and the Academic Office.
                        </p>
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                    <button
                        class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                        <span class="font-medium text-gray-800 dark:text-white">Is there an installment plan for fee
                            payment?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">
                            The university offers installment payment plans for students with financial
                            constraints. To apply for this option, visit the Bursary Department with a
                            formal application and supporting documents. Note that approval is not
                            guaranteed and is assessed on a case-by-case basis.
                        </p>
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                    <button
                        class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                        <span class="font-medium text-gray-800 dark:text-white">What if I've forgotten my portal
                            password?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">
                            You can reset your password by clicking on the "Forgot Password" link on the
                            login page. You will receive a password reset link on your registered email
                            address. If you don't have access to that email, visit the ICT Department with
                            your ID card for manual password reset.
                        </p>
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                    <button
                        class="faq-toggle w-full flex justify-between items-center p-4 focus:outline-none text-left">
                        <span class="font-medium text-gray-800 dark:text-white">Can I register for more than the maximum
                            credit load?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden p-4 pt-0 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300">
                            No, but, in exceptional cases, students with outstanding academic performance (CGPA of
                            4.0 and above) may request to register for additional credits beyond the maximum
                            load. This requires approval from your Head of Department and the Dean of the
                            Faculty.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-gray-700 dark:text-gray-300">
                    Didn't find what you're looking for? Visit our comprehensive
                    <a href="faqs.php"
                        class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">FAQs
                        page</a>
                    or contact the registration support team.
                </p>
            </div>
        </section>

        <!-- Contact Support section -->
        <section id="contact" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Contact Support</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">
                If you encounter any issues during the registration process, don't hesitate to visit the ICT unit or
                reach out to the support team.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-3">Technical Office</h3>
                    <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                            <span>Faculty of Computing, Top Floor, Room 02</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                            <span>registration@fud.edu.ng</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                            <span>+234 8012345678, +234 8098765432</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-3 text-green-600 dark:text-green-400"></i>
                            <div>
                                <span>Monday to Thursday, 10:00 AM - 2:00 PM</span><br>
                                <span>Monday to Friday, 10:00 AM - 4:00 PM</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-3">Technical Support</h3>
                    <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>ICT Building, First Floor, Room 105</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>ict.support@fud.edu.ng</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>+234 9087654567</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>Monday to Friday, 8:00 AM - 4:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-6">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-3">Live Chat Support</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-3">
                    Our online support team is available to assist you during the registration period. Click
                    the button below to start a chat with a support representative.
                </p>
                <button
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    <i class="fas fa-comments mr-2"></i>
                    Start Live Chat
                </button>
            </div>
        </section>
    </main>

    <!-- Mobile: Show Quick Navigation as a collapsible drawer -->
    <nav
        class="lg:hidden fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800 border-t border-green-600 z-40 flex justify-around py-2">
        <a href="#overview" class="text-green-600 dark:text-green-400 font-semibold flex flex-col items-center"><i
                class="fas fa-info-circle"></i><span class="text-xs">Overview</span></a>
        <a href="#new-students" class="text-green-600 dark:text-green-400 font-semibold flex flex-col items-center"><i
                class="fas fa-user-graduate"></i><span class="text-xs">New</span></a>
        <a href="#registration-steps"
            class="text-green-600 dark:text-green-400 font-semibold flex flex-col items-center"><i
                class="fas fa-list-ol"></i><span class="text-xs">Steps</span></a>
        <a href="#faqs" class="text-green-600 dark:text-green-400 font-semibold flex flex-col items-center"><i
                class="fas fa-question-circle"></i><span class="text-xs">FAQs</span></a>
    </nav>
    </div>

    <!-- Footer -->
    <footer
        class="footer-content bg-white dark:bg-gray-800 shadow-md py-4 relative ml-[16rem] w-[calc(100%-16rem)] flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-gray-600 dark:text-gray-400 text-sm md:text-center">
                    &copy; <span id="footer-year"></span> FUD Pal. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            const currentYear = new Date().getFullYear();
            $('#footer-year').text(currentYear);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // FAQ content toggles
            const faqToggles = document.querySelectorAll('.faq-toggle-dark');

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

            // Smooth scrolling for navigation links
            const navLinks = document.querySelectorAll('.guide-nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);

                    window.scrollTo({
                        top: targetSection.offsetTop - 100,
                        behavior: 'smooth'
                    });

                    // Add active state to clicked link
                    navLinks.forEach(link => {
                        link.classList.remove('bg-green-100', 'dark:bg-green',
                            'text-green-800', 'dark:text-green');
                    });
                    this.classList.add('bg-green-100', 'dark:bg-green', 'text-green-800',
                        'dark:text-green');
                });
            });

            // Highlight active section while scrolling
            window.addEventListener('scroll', function() {
                const sections = document.querySelectorAll('section[id]');

                let currentSection = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 150;
                    const sectionHeight = section.clientHeight;

                    if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
                        currentSection = '#' + section.getAttribute('id');
                    }
                });

                if (currentSection) {
                    navLinks.forEach(link => {
                        link.classList.remove('bg-green-100', 'dark:bg-green', 'text-green-800',
                            'dark:text-green');

                        if (link.getAttribute('href') === currentSection) {
                            link.classList.add('bg-green-100', 'dark:bg-green', 'text-green-800',
                                'dark:text-green');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>