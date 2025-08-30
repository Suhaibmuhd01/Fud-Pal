<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FUD PAL</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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

        /* Dark mode styles */
        .dark body {
            background-color: #1F2937;
            color: #F3F4F6;
        }

        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            animation: spinner 0.6s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="form-container w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
            <!-- Top Green Bar with Back Button -->
            <div class="animated-bg text-white p-4 relative">
                <a href="javascript:void(0)" onclick="window.history.back()"
                    class="absolute left-4 top-4 w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex justify-center mt-6 mb-2">
                    <h1 class="text-3xl font-bold">LOGIN!</h1>
                </div>
            </div>

            <div class="p-8">
                <!-- Alert for displaying errors -->
                <div id="error-alert"
                    class="hidden mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded dark:bg-red-200 dark:text-red-800"
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

                <!-- Login form -->
                <form id="login-form" method="post"
                    action="login_process.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
                    <div class="mb-6">
                        <label for="regnum"
                            class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Registration
                            Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" id="regnum" name="regnum"
                                class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                placeholder="e.g. FCP/CIT/22/1022" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="password"
                            class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password"
                                class="input-field text-base py-3 pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                placeholder="Your password" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" id="toggle-password" class="text-gray-400 focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Remember me
                            </label>
                        </div>

                        <a href="reset_password.php"
                            class="text-sm font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" id="login-btn"
                        class="btn-primary w-full flex justify-center py-3 px-4 border border-transparent text-base font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        <span id="login-text">Login</span>
                        <span id="login-spinner" class="hidden spinner ml-2">
                            <i class="fas fa-circle-notch"></i>
                        </span>
                    </button>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Don't Have An Account?
                            <a href="signup.php"
                                class="font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                                Register Here!
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

            // Form submission handling
            $('#login-form').submit(function(e) {
                e.preventDefault();

                // Hide any existing errors
                $('#error-alert').addClass('hidden');

                // Get form values
                const regnum = $('#regnum').val().trim();
                const password = $('#password').val();

                // Basic validation
                if (!regnum) {
                    showError('Please enter your registration number');
                    return;
                }

                if (!password) {
                    showError('Please enter your password');
                    return;
                }

                // Show loading state
                $('#login-text').text('Logging in...');
                $('#login-spinner').removeClass('hidden');
                $('#login-btn').prop('disabled', true);

                // Simulate AJAX request to the server (replace with actual AJAX in production)
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'login_process.php',
                        data: {
                            regnum: regnum,
                            password: password,
                            remember: $('#remember-me').is(':checked') ? 1 : 0
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#login-text').text('Success!');
                                $('#login-spinner').html(
                                    '<i class="fas fa-check animate-spin" id="tick-icon"></i>'
                                );
                                setTimeout(function() {
                                    $('#tick-icon').removeClass('animate-spin')
                                        .addClass('fa-rotate-90');
                                    setTimeout(function() {
                                        window.location.href =
                                            'dashboard.php';
                                    }, 500);
                                }, 800);
                            } else {
                                // Show error message
                                showError(response.message ||
                                    'Invalid registration number or password');

                                // Reset button state
                                $('#login-text').text('Login');
                                $('#login-spinner').addClass('hidden');
                                $('#login-btn').prop('disabled', false);
                            }
                        },
                        error: function() {
                            showError('An error occurred. Please try again later.');

                            // Reset button state
                            $('#login-text').text('Login');
                            $('#login-spinner').addClass('hidden');
                            $('#login-btn').prop('disabled', false);
                        }
                    });
                }, 1500);
            });

            // Function to show error messages
            function showError(message) {
                $('#error-message').text(message);
                $('#error-alert').removeClass('hidden');

                // Scroll to the error if needed
                $('html, body').animate({
                    scrollTop: $('#error-alert').offset().top - 20
                }, 300);
            }
        });
    </script>
</body>

</html>