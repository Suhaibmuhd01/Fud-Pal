<?php
session_start();
include '../../config/db_config.php';
include '../../utils/notification_functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'] ?? 'Student';
$regnum = $_SESSION['regnum'] ?? '';

$topic_id = (int)($_GET['id'] ?? 0);
if (!$topic_id) {
    header("Location: index.php");
    exit;
}

$message = '';
$success = false;

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_content'])) {
    $reply_content = trim($_POST['reply_content'] ?? '');
    
    if (empty($reply_content)) {
        $message = 'Reply content is required.';
    } else {
        $conn = connectDB();
        $stmt = $conn->prepare("INSERT INTO forum_replies (topic_id, content, created_by) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $topic_id, $reply_content, $user_id);
        
        if ($stmt->execute()) {
            $message = 'Reply posted successfully!';
            $success = true;
            
            // Add notification to topic creator
            $stmt = $conn->prepare("SELECT created_by, title FROM forum_topics WHERE id = ?");
            $stmt->bind_param("i", $topic_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                if ($row['created_by'] != $user_id) {
                    addNotification($row['created_by'], "New reply on your topic: " . $row['title'], "forums/topic.php?id=" . $topic_id);
                }
            }
        } else {
            $message = 'Failed to post reply. Please try again.';
        }
        $stmt->close();
        $conn->close();
    }
}

// Get topic details
$conn = connectDB();
$stmt = $conn->prepare("SELECT ft.*, u.fullname as author_name FROM forum_topics ft JOIN users u ON ft.created_by = u.id WHERE ft.id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$topic = $result->fetch_assoc();
$stmt->close();

if (!$topic) {
    header("Location: index.php");
    exit;
}

// Update view count
$stmt = $conn->prepare("UPDATE forum_topics SET views = views + 1 WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$stmt->close();

// Get replies
$stmt = $conn->prepare("SELECT fr.*, u.fullname as author_name FROM forum_replies fr JOIN users u ON fr.created_by = u.id WHERE fr.topic_id = ? ORDER BY fr.created_at ASC");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$replies = [];
while ($row = $result->fetch_assoc()) {
    $replies[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($topic['title']); ?> - FUD PAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
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
        
        .reply-card {
            transition: all 0.3s ease;
        }
        
        .reply-card:hover {
            background-color: rgba(0, 0, 0, 0.02);
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
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:sticky top-0 left-0 z-30 w-64 h-screen bg-green-600 text-white shadow-lg overflow-y-auto">
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
                        <img src="profile_image.php?regnum=<?php echo urlencode($regnum); ?>&t=<?php echo time(); ?>"
                            alt="Profile" class="w-14 h-14 rounded-full object-cover border-4 border-white shadow-lg">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-base text-white"><?php echo htmlspecialchars($fullname); ?></span>
                        <span class="text-xs text-green-200"><?php echo htmlspecialchars($regnum); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="py-4">
                <ul class="space-y-1">
                    <li><a href="../../dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                    <li><a href="../map.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-map-marker-alt"></i><span>Campus Map</span></a></li>
                    <li><a href="../past_questions.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-question-circle"></i><span>Past Questions</span></a></li>
                    <li><a href="../reg_guide.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Registration Guide</span></a></li>
                    <li><a href="../guidelines.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-book"></i><span>Course Reg Guidelines</span></a></li>
                    <li><a href="../faqs.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-info-circle"></i><span>FAQs</span></a></li>
                    <li><a href="index.php" class="flex items-center space-x-3 px-4 py-3 bg-green-700 text-white"><i class="fas fa-comments"></i><span>Forum</span></a></li>
                    <li><a href="../profile/" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700 transition-colors"><i class="fas fa-user"></i><span>Profile</span></a></li>
                </ul>
                <div class="mt-8 px-4">
                    <a href="../../logout.php" class="flex items-center space-x-3 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-4 md:p-8 w-full md:w-[calc(100%-16rem)]">
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="index.php" class="text-green-600 dark:text-green-400 hover:underline mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Forum
                    </a>
                </div>
            </div>

            <!-- Topic Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <img src="../profile_image.php?regnum=<?php echo urlencode($topic['author_name']); ?>&t=<?php echo time(); ?>"
                                alt="Author" class="w-12 h-12 rounded-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                                    <?php echo htmlspecialchars($topic['title']); ?>
                                </h1>
                                <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full">
                                    <?php echo htmlspecialchars($topic['category']); ?>
                                </span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center">
                                    <i class="fas fa-user mr-1"></i>
                                    <?php echo htmlspecialchars($topic['author_name']); ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <?php echo timeAgo($topic['created_at']); ?>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    <?php echo $topic['views']; ?> views
                                </span>
                            </div>
                            <div class="prose dark:prose-invert max-w-none">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap"><?php echo htmlspecialchars($topic['content']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Discussion & Replies (<?php echo count($replies); ?>)
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Any user can reply, discuss, or ask follow-up questions below.</p>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if (empty($replies)): ?>
                        <div class="p-8 text-center">
                            <i class="fas fa-comment text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">No Replies Yet</h3>
                            <p class="text-gray-500 dark:text-gray-500">Be the first to reply, discuss, or ask a follow-up question!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($replies as $reply): ?>
                            <div class="reply-card p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="../profile_image.php?regnum=<?php echo urlencode($reply['author_name']); ?>&t=<?php echo time(); ?>"
                                            alt="Author" class="w-10 h-10 rounded-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                <?php echo htmlspecialchars($reply['author_name']); ?>
                                            </h4>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                <?php echo timeAgo($reply['created_at']); ?>
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                            <?php echo htmlspecialchars($reply['content']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Reply/Discussion Form -->
            <div id="reply-form-section" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Join the Discussion / Post a Reply</h2>
                </div>
                <div class="p-6">
                    <?php if ($message): ?>
                        <div class="mb-4 p-4 rounded-lg <?php echo $success ? 'bg-green-100 text-green-700 border-green-300' : 'bg-red-100 border-red-300 text-red-700'; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" class="space-y-4">
                        <div>
                            <label for="reply_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Reply, Question, or Comment
                            </label>
                            <textarea id="reply_content" name="reply_content" rows="6" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Write your reply, question, or comment here..."></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-reply mr-2"></i>
                                Post Reply
                            </button>
                        </div>
                    </form>
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