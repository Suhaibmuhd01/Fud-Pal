<?php
session_start();
include 'includes/config.php';

$message = '';
$success = false;

// Retain form values
$regnum = $_POST['regnum'] ?? '';
$security_question = $_POST['security_question'] ?? '';
$security_answer = $_POST['security_answer'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regnum = trim($_POST['regnum'] ?? '');
    $security_question = trim($_POST['security_question'] ?? '');
    $security_answer = trim($_POST['security_answer'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$regnum || !$security_question || !$security_answer || !$new_password || !$confirm_password) {
        $message = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $message = 'Passwords do not match.';
    } elseif (strlen($new_password) < 8) {
        $message = 'Password must be at least 8 characters.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE regnum=? AND security_question=? AND security_answer=?");
        $stmt->bind_param("sss", $regnum, $security_question, $security_answer);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt->close();
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE regnum=?");
            $stmt->bind_param("ss", $hashed, $regnum);
            if ($stmt->execute()) {
                $message = 'Password reset successful!';
                $success = true;
            } else {
                $message = 'Failed to reset password. Try again.';
            }
        } else {
            $message = 'Invalid details. Please check your info.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password - FUD PAL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .input-field:focus {
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.15);
            border-color: #10B981;
        }

        .popup-bg {
            background: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            min-width: 320px;
            max-width: 90vw;
        }

        .input-icon {
            transition: opacity 0.3s;
        }

        .input-icon.hide {
            opacity: 0;
        }

        .input-icon.show {
            opacity: 1;
        }

        @media (max-width: 640px) {
            .form-container {
                padding: 1rem !important;
                border-radius: 0;
            }

            .popup-content {
                min-width: 90vw;
            }
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-green-50 via-green-100 to-green-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg sm:max-w-2xl px-2">
        <div
            class="animate__animated animate__fadeInDown form-container bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden p-4 sm:p-10">
            <h1
                class="text-2xl sm:text-3xl font-bold text-center mb-6 text-green-700 dark:text-green-300 tracking-wide">
                Reset Password</h1>
            <form id="reset-form" method="post" class="space-y-5">
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">Registration Number</label>
                    <div class="relative">
                        <input type="text" name="regnum" id="regnum" required
                            value="<?php echo htmlspecialchars($regnum); ?>"
                            class="input-field w-full py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500 transition-all">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400 input-icon show"
                            id="icon-regnum"><i class="fas fa-id-card"></i></span>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">Security Question</label>
                    <select name="security_question" required
                        class="input-field w-full py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500 transition-all">
                        <option value="">Select a question</option>
                        <option value="mother_name" <?php if ($security_question == 'mother_name') echo 'selected'; ?>>
                            What is your mother's maiden name?</option>
                        <option value="pet_name" <?php if ($security_question == 'pet_name') echo 'selected'; ?>>What
                            was the name of your first pet?</option>
                        <option value="birth_city" <?php if ($security_question == 'birth_city') echo 'selected'; ?>>
                            What city were you born in?</option>
                        <option value="school_name" <?php if ($security_question == 'school_name') echo 'selected'; ?>>
                            What was the name of your primary school?</option>
                        <option value="favorite_color"
                            <?php if ($security_question == 'favorite_color') echo 'selected'; ?>>What is your favorite
                            color?</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">Security Answer</label>
                    <div class="relative">
                        <input type="text" name="security_answer" id="security_answer" required
                            value="<?php echo htmlspecialchars($security_answer); ?>"
                            class="input-field w-full py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500 transition-all">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400 input-icon show"
                            id="icon-key"><i class="fas fa-key"></i></span>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">New Password</label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password" required
                            class="input-field w-full py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500 transition-all pr-12">
                        <button type="button" id="toggle-new-password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">Confirm New
                        Password</label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" required
                            class="input-field w-full py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500 transition-all pr-12">
                        <button type="button" id="toggle-confirm-password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white py-3 rounded-lg font-semibold text-lg shadow-lg hover:from-green-600 hover:to-green-800 transition-all focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
    <!-- Animated Popup -->
    <div id="popup-bg" class="fixed inset-0 z-50 flex items-center justify-center popup-bg hidden">
        <div id="popup-content"
            class="popup-content bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-8 flex flex-col items-center animate__animated">
            <div id="popup-animation" class="mb-4"></div>
            <h2 id="popup-title" class="text-2xl font-bold mb-2"></h2>
            <p id="popup-message" class="text-gray-700 dark:text-gray-300 mb-4 text-center"></p>
            <button id="popup-login-btn"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold mt-2 transition-all hidden">Return
                to Login</button>
            <button id="popup-ok-btn"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold mt-2 transition-all hidden">OK</button>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Password visibility toggles
            $('#toggle-new-password').click(function() {
                const field = $('#new_password');
                const type = field.attr('type');
                if (type === 'password') {
                    field.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    field.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });
            $('#toggle-confirm-password').click(function() {
                const field = $('#confirm_password');
                const type = field.attr('type');
                if (type === 'password') {
                    field.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    field.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });
            // Icon fade logic for regnum
            $('#regnum').on('focus', function() {
                $('#icon-regnum').addClass('hide').removeClass('show');
            }).on('blur', function() {
                if (!$(this).val()) {
                    $('#icon-regnum').addClass('show').removeClass('hide');
                }
            }).on('input', function() {
                if ($(this).val()) {
                    $('#icon-regnum').addClass('hide').removeClass('show');
                } else {
                    $('#icon-regnum').addClass('show').removeClass('hide');
                }
            });
            // Icon fade logic for security_answer
            $('#security_answer').on('focus', function() {
                $('#icon-key').addClass('hide').removeClass('show');
            }).on('blur', function() {
                if (!$(this).val()) {
                    $('#icon-key').addClass('show').removeClass('hide');
                }
            }).on('input', function() {
                if ($(this).val()) {
                    $('#icon-key').addClass('hide').removeClass('show');
                } else {
                    $('#icon-key').addClass('show').removeClass('hide');
                }
            });
            // Handle popup buttons
            $('#popup-login-btn').click(function() {
                window.location.href = 'login.php';
            });
            $('#popup-ok-btn').click(function() {
                $('#popup-bg').addClass('hidden');
                $('#regnum').focus();
            });
            // Show popup if PHP set a message
            <?php if ($message): ?>
                showPopup(<?php echo $success ? 'true' : 'false'; ?>, <?php echo json_encode($message); ?>);
            <?php endif; ?>
        });
        // Show animated popup
        function showPopup(success, message) {
            $('#popup-title').text(success ? 'Success!' : 'Error');
            $('#popup-message').html(message);
            $('#popup-bg').removeClass('hidden');
            $('#popup-content').removeClass('animate__fadeOutUp').addClass('animate__fadeInDown');
            if (success) {
                $('#popup-animation').html(
                    '<img src="https://cdn.pixabay.com/animation/2022/10/13/14/44/14-44-47-282_512.gif" class="w-24 h-24 mx-auto mb-2" alt="Confetti">'
                );
                $('#popup-login-btn').removeClass('hidden');
                $('#popup-ok-btn').addClass('hidden');
            } else {
                $('#popup-animation').html(
                    '<i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-2 animate__animated animate__shakeX"></i>'
                );
                $('#popup-login-btn').addClass('hidden');
                $('#popup-ok-btn').removeClass('hidden');
            }
        }
    </script>
</body>

</html>