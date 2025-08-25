<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - FUD Pal</title>
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
        }

        .animated-bg {
            background: linear-gradient(-45deg, #10B981, #047857, #047857, #10B981);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .form-container {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-field {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-primary {
            transition: transform 0.2s, box-shadow 0.2s;
            background: linear-gradient(to right, #10B981, #059669);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .password-strength {
            height: 5px;
            transition: width 0.3s ease-in-out;
        }

        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            animation: spinner 0.6s linear infinite;
        }

        /* Responsive tweaks */
        @media (max-width: 1024px) {
            .form-container {
                padding: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .form-container {
                border-radius: 0;
                box-shadow: none;
            }

            .p-8 {
                padding: 1.5rem !important;
            }
        }

        @media (max-width: 640px) {
            .form-container {
                padding: 0 !important;
                border-radius: 0;
            }

            .p-8 {
                padding: 1rem !important;
            }

            .animated-bg {
                padding: 1.25rem !important;
            }
        }
    </style>
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


        function back() {
            const element = document.getElementById('btn');
            element.addEventListener('click') = window.history.back();
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="form-container w-full max-w-2xl bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
            <!-- Top Green Bar with Back Button -->
            <div class="animated-bg text-white p-4 sm:p-6 relative">
                <!-- <a href="index.html" class="absolute left-4 top-4 w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a> -->
                <button type="button" id="btn" onclick="back()"></button>
                <div class="flex justify-center mt-6 mb-2">
                    <h1 class="text-2xl sm:text-3xl font-bold">CREATE ACCOUNT</h1>
                </div>
            </div>
            <!-- Stepper -->
            <div
                class="flex flex-col sm:flex-row justify-between items-center px-2 sm:px-6 py-4 border-b dark:border-gray-700 gap-2 sm:gap-0">
                <!-- Step 1 -->
                <div id="step-1-indicator" class="flex flex-col items-center w-1/3">
                    <div
                        class="step-indicator flex items-center justify-center w-9 h-9 rounded-full bg-green-500 text-white font-bold text-lg transition-all duration-300">
                        1</div>
                    <span class="mt-1 text-xs sm:text-sm font-medium text-gray-800 dark:text-white">Personal Info</span>
                </div>
                <div class="flex-1 flex items-center px-1 sm:px-4 w-full">
                    <div class="h-1 w-full bg-gray-200 dark:bg-gray-700 rounded">
                        <div id="progress-1-2" class="h-1 bg-green-500 transition-all duration-300 rounded"
                            style="width: 0%"></div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div id="step-2-indicator" class="flex flex-col items-center w-1/3">
                    <div
                        class="step-indicator flex items-center justify-center w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-bold text-lg transition-all duration-300">
                        2</div>
                    <span class="mt-1 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Academic
                        Info</span>
                </div>
                <div class="flex-1 flex items-center px-1 sm:px-4 w-full">
                    <div class="h-1 w-full bg-gray-200 dark:bg-gray-700 rounded">
                        <div id="progress-2-3" class="h-1 bg-green-500 transition-all duration-300 rounded"
                            style="width: 0%"></div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div id="step-3-indicator" class="flex flex-col items-center w-1/3">
                    <div
                        class="step-indicator flex items-center justify-center w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-bold text-lg transition-all duration-300">
                        3</div>
                    <span class="mt-1 text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Security</span>
                </div>
            </div>
            <div class="p-4 sm:p-8">
                <!-- Alert for displaying errors -->
                <div id="error-alert"
                    class="hidden mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded dark:bg-red-200 dark:text-red-800"
                    role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p id="error-message" class="text-sm"></p>
                        </div>
                    </div>
                </div>
                <!-- Success alert -->
                <div id="success-alert"
                    class="hidden mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p id="success-message" class="text-sm">Registration successful! Redirecting to login
                                page...</p>
                        </div>
                    </div>
                </div>
                <!-- Signup form with steps -->
                <form id="signup-form" method="post" action="signup_process.php" autocomplete="off">
                    <!-- Step 1: Personal Information -->
                    <div id="step-1" class="step-content">
                        <h2 class="text-lg sm:text-xl font-semibold mb-6 text-gray-800 dark:text-white">Personal
                            Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label for="fullname"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Full
                                    Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="fullname" name="fullname"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        placeholder="e.g. John Doe" required>
                                </div>
                            </div>
                            <div>
                                <label for="regnum"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Registration
                                    Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="text" id="regnum" name="regnum"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        placeholder="e.g. FCP/CIT/22/1043" required>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label for="email"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Email
                                    Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" id="email" name="email"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        placeholder="your.email@example.com" required>
                                </div>
                            </div>
                            <div>
                                <label for="phone"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Phone
                                    Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        placeholder="e.g. 08012345678" required>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="next-to-step-2"
                                class="btn-primary py-3 px-6 border border-transparent text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Step 2: Academic Information -->
                    <div id="step-2" class="step-content hidden">
                        <h2 class="text-lg sm:text-xl font-semibold mb-6 text-gray-800 dark:text-white">Academic
                            Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label for="faculty"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Faculty</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-university text-gray-400"></i>
                                    </div>
                                    <select id="faculty" name="faculty"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        required>
                                        <option value="">Select Faculty</option>
                                        <option value="computing">Faculty of Computing</option>
                                        <option value="sciences">Faculty of Sciences</option>
                                        <option value="education">Faculty of Education</option>
                                        <option value="clinical">Faculty of Clinical Science</option>
                                        <option value="agriculture">Faculty of Agriculture</option>
                                        <option value="management">Faculty of Management Sciences</option>
                                        <option value="arts">Faculty of Arts & Social Sciences</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="department"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Department</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-gray-400"></i>
                                    </div>
                                    <select id="department" name="department"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        required disabled>
                                        <option value="">Select Department</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label for="level"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Level</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-layer-group text-gray-400"></i>
                                    </div>
                                    <select id="level" name="level"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        required>
                                        <option value="">Select Level</option>
                                        <option value="100">100 Level</option>
                                        <option value="200">200 Level</option>
                                        <option value="300">300 Level</option>
                                        <option value="400">400 Level</option>
                                        <option value="500">500 Level</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="session"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Academic
                                    Session</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <select id="session" name="session"
                                        class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                        required>
                                        <option value="">Select Session</option>
                                        <option value="2022/2023">2022/2023</option>
                                        <option value="2023/2024">2023/2024</option>
                                        <option value="2024/2025">2024/2025</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between gap-2">
                            <button type="button" id="back-to-step-1"
                                class="py-3 px-6 border border-gray-300 text-base font-medium rounded-lg text-gray-700 dark:text-white bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="button" id="next-to-step-3"
                                class="btn-primary py-3 px-6 border border-transparent text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Step 3: Security Information -->
                    <div id="step-3" class="step-content hidden">
                        <h2 class="text-lg sm:text-xl font-semibold mb-6 text-gray-800 dark:text-white">Security
                            Information</h2>
                        <div class="mb-6">
                            <label for="password"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password"
                                    class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    placeholder="Create a secure password" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="toggle-password" class="text-gray-400 focus:outline-none">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Password strength indicator -->
                            <div class="mt-2">
                                <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div id="password-strength" class="password-strength h-full bg-red-500"
                                        style="width: 0%"></div>
                                </div>
                                <p id="password-strength-text" class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                    Password strength: Too weak</p>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="confirm_password"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Confirm
                                Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="confirm_password" name="confirm_password"
                                    class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    placeholder="Confirm your password" required>
                            </div>
                            <p id="password-match" class="text-xs mt-1 hidden text-red-500">Passwords do not match</p>
                        </div>
                        <div class="mb-6">
                            <label for="security_question"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Security
                                Question</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-question-circle text-gray-400"></i>
                                </div>
                                <select id="security_question" name="security_question"
                                    class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    required>
                                    <option value="">Select a security question</option>
                                    <option value="mother_name">What is your mother's maiden name?</option>
                                    <option value="pet_name">What was the name of your first pet?</option>
                                    <option value="birth_city">What city were you born in?</option>
                                    <option value="school_name">What was the name of your primary school?</option>
                                    <option value="favorite_color">What is your favorite color?</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="security_answer"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Security
                                Answer</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="text" id="security_answer" name="security_answer"
                                    class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    placeholder="Your answer" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">
                                        I agree to the <a href=""
                                            class="text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">Terms
                                            and Conditions</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between gap-2">
                            <button type="button" id="back-to-step-2"
                                class="py-3 px-6 border border-gray-300 text-base font-medium rounded-lg text-gray-700 dark:text-white bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="submit" id="register-btn"
                                class="btn-primary py-3 px-6 border border-transparent text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                <span id="register-text">Create Account</span>
                                <span id="register-spinner" class="hidden spinner ml-2">
                                    <i class="fas fa-circle-notch"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Already have an account?
                            <a href="login.php"
                                class="font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                                Login here
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Initialize AOS animation library
            AOS.init();
            // Faculty and department data
            const departmentsByFaculty = {
                computing: ['Computer Science', 'Information Technology', 'Software Engineering',
                    'Cyber Security'
                ],
                sciences: ['Physics', 'Chemistry', 'Biology', 'Zoology', 'Botany', 'Mathematics',
                    'Biochemistry', 'Biotechnology', 'Environmental Management'
                ],
                education: ['Islamic Studies', 'Arabic', 'Primary Education'],
                agriculture: ['Crop Science', 'Animal Science', 'Fishery', 'Forestry',
                    'Agricultural Extension'
                ],
                management: ['Accounting', 'Business Administration', 'Taxation', 'Banking and Finance'],
                arts: ['English Language', 'Linguistics', 'Political Science', 'Sociology', 'Criminology'],
                clinical: ['Medicine', 'Anatomy', 'Physiolog', 'Nursing', 'Public Health']
            };
            // Populate departments based on faculty selection
            $('#faculty').change(function() {
                const faculty = $(this).val();
                const departmentSelect = $('#department');
                departmentSelect.html('<option value="">Select Department</option>');
                if (faculty) {
                    departmentSelect.prop('disabled', false);
                    const departments = departmentsByFaculty[faculty] || [];
                    departments.forEach(function(department) {
                        departmentSelect.append(
                            `<option value="${department.toLowerCase().replace(/\s+/g, '_')}">${department}</option>`
                        );
                    });
                } else {
                    departmentSelect.prop('disabled', true);
                }
            });
            // Toggle password visibility
            $('#toggle-password').click(function() {
                const passwordField = $('#password');
                const passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });
            // Password strength checker
            $('#password').on('input', function() {
                const password = $(this).val();
                let strength = 0;
                let strengthText = '';
                let strengthColor = 'red';
                if (password.length >= 8) {
                    strength += 25;
                }
                if (/[a-z]/.test(password)) {
                    strength += 25;
                }
                if (/[A-Z]/.test(password)) {
                    strength += 25;
                }
                if (/[0-9]/.test(password) || /[^a-zA-Z0-9]/.test(password)) {
                    strength += 25;
                }
                if (strength === 0) {
                    strengthText = 'Too weak';
                    strengthColor = 'red';
                } else if (strength <= 25) {
                    strengthText = 'Weak';
                    strengthColor = 'red';
                } else if (strength <= 50) {
                    strengthText = 'Fair';
                    strengthColor = 'orange';
                } else if (strength <= 75) {
                    strengthText = 'Good';
                    strengthColor = 'yellow';
                } else {
                    strengthText = 'Strong';
                    strengthColor = 'green';
                }
                $('#password-strength').css('width', strength + '%');
                $('#password-strength').removeClass('bg-red-500 bg-orange-500 bg-yellow-500 bg-green-500');
                if (strengthColor === 'red') {
                    $('#password-strength').addClass('bg-red-500');
                } else if (strengthColor === 'orange') {
                    $('#password-strength').addClass('bg-orange-500');
                } else if (strengthColor === 'yellow') {
                    $('#password-strength').addClass('bg-yellow-500');
                } else {
                    $('#password-strength').addClass('bg-green-500');
                }
                $('#password-strength-text').text('Password strength: ' + strengthText);
            });
            // Check if passwords match
            $('#confirm_password').on('input', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();
                if (confirmPassword && password !== confirmPassword) {
                    $('#password-match').removeClass('hidden').addClass('block');
                } else {
                    $('#password-match').removeClass('block').addClass('hidden');
                }
            });
            // Multi-step form navigation
            $('#next-to-step-2').click(function() {
                // Validate step 1
                const fullname = $('#fullname').val().trim();
                const regnum = $('#regnum').val().trim();
                const email = $('#email').val().trim();
                const phone = $('#phone').val().trim();
                if (!fullname) {
                    showError('Please enter your full name');
                    return;
                }
                if (!regnum) {
                    showError('Please enter your registration number');
                    return;
                }
                const regnumPattern = /^[A-Z]{2,5}\/[A-Z]{2,5}\/\d{2}\/\d{4}$/;
                if (!regnumPattern.test(regnum)) {
                    showError('Registration number format should be like BMS/ANT/22/1098');
                    return;
                }
                if (!email) {
                    showError('Please enter your email address');
                    return;
                }
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    showError('Please enter a valid email address');
                    return;
                }
                if (!phone) {
                    showError('Please enter your phone number');
                    return;
                }
                $('#error-alert').addClass('hidden');
                $('#step-1').addClass('hidden');
                $('#step-2').removeClass('hidden');
                // Update stepper
                $('#step-1-indicator .step-indicator').addClass('bg-green-500 text-white').removeClass(
                    'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-400');
                $('#step-2-indicator .step-indicator').addClass('bg-green-500 text-white').removeClass(
                    'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-400');
                $('#step-2-indicator span').addClass('text-gray-800 dark:text-white').removeClass(
                    'text-gray-500 dark:text-gray-400');
                $('#progress-1-2').css('width', '100%');
            });
            $('#back-to-step-1').click(function() {
                $('#step-2').addClass('hidden');
                $('#step-1').removeClass('hidden');
                $('#step-2-indicator .step-indicator').removeClass('bg-green-500 text-white').addClass(
                    'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400');
                $('#step-2-indicator span').removeClass('text-gray-800 dark:text-white').addClass(
                    'text-gray-500 dark:text-gray-400');
                $('#progress-1-2').css('width', '0%');
            });
            $('#next-to-step-3').click(function() {
                // Validate step 2
                const faculty = $('#faculty').val();
                const department = $('#department').val();
                const level = $('#level').val();
                const session = $('#session').val();
                if (!faculty) {
                    showError('Please select your faculty');
                    return;
                }
                if (!department) {
                    showError('Please select your department');
                    return;
                }
                if (!level) {
                    showError('Please select your current level');
                    return;
                }
                if (!session) {
                    showError('Please select your academic session');
                    return;
                }
                $('#error-alert').addClass('hidden');
                $('#step-2').addClass('hidden');
                $('#step-3').removeClass('hidden');
                $('#step-3-indicator .step-indicator').addClass('bg-green-500 text-white').removeClass(
                    'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-400');
                $('#step-3-indicator span').addClass('text-gray-800 dark:text-white').removeClass(
                    'text-gray-500 dark:text-gray-400');
                $('#progress-2-3').css('width', '100%');
            });
            $('#back-to-step-2').click(function() {
                $('#step-3').addClass('hidden');
                $('#step-2').removeClass('hidden');
                $('#step-3-indicator .step-indicator').removeClass('bg-green-500 text-white').addClass(
                    'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400');
                $('#step-3-indicator span').removeClass('text-gray-800 dark:text-white').addClass(
                    'text-gray-500 dark:text-gray-400');
                $('#progress-2-3').css('width', '0%');
            });
            // Form submission
            $('#signup-form').submit(function(e) {
                e.preventDefault();
                // Validate step 3
                const password = $('#password').val();
                const confirmPassword = $('#confirm_password').val();
                const securityQuestion = $('#security_question').val();
                const securityAnswer = $('#security_answer').val();
                const termsAgreed = $('#terms').is(':checked');
                if (!password || password.length < 8) {
                    showError('Password must be at least 8 characters long');
                    return;
                }
                if (password !== confirmPassword) {
                    showError('Passwords do not match');
                    return;
                }
                if (!securityQuestion) {
                    showError('Please select a security question');
                    return;
                }
                if (!securityAnswer) {
                    showError('Please provide an answer to your security question');
                    return;
                }
                if (!termsAgreed) {
                    showError('You must agree to the Terms and Conditions');
                    return;
                }
                $('#error-alert').addClass('hidden');
                $('#register-text').text('Creating Account...');
                $('#register-spinner').removeClass('hidden');
                $('#register-btn').prop('disabled', true);
                // Get all form data
                const formData = {
                    fullname: $('#fullname').val().trim(),
                    regnum: $('#regnum').val().trim(),
                    email: $('#email').val().trim(),
                    phone: $('#phone').val().trim(),
                    faculty: $('#faculty').val(),
                    department: $('#department').val(),
                    level: $('#level').val(),
                    session: $('#session').val(),
                    password: password,
                    security_question: securityQuestion,
                    security_answer: securityAnswer
                };
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'signup_process.php',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#success-alert').removeClass('hidden');
                                $('#register-text').text('Success!');
                                $('#register-spinner').html(
                                    '<i class="fas fa-check"></i>');
                                setTimeout(function() {
                                    window.location.href = 'login.php';
                                }, 2000);
                            } else {
                                showError(response.message ||
                                    'Registration failed. Please try again.');
                                $('#register-text').text('Create Account');
                                $('#register-spinner').addClass('hidden');
                                $('#register-btn').prop('disabled', false);
                            }
                        },
                        error: function() {
                            showError('An error occurred. Please try again later.');
                            $('#register-text').text('Create Account');
                            $('#register-spinner').addClass('hidden');
                            $('#register-btn').prop('disabled', false);
                        }
                    });
                }, 2000);
            });
            // Function to show error messages and retain input values
            function showError(message) {
                $('#error-message').text(message);
                $('#error-alert').removeClass('hidden');
                $('html, body').animate({
                    scrollTop: $('#error-alert').offset().top - 20
                }, 300);
            }
        });
    </script>
</body>

</html>