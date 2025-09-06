<?php
session_start();
require_once "../config/db_config.php";
$conn = connectDB();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Handle moderation actions (demo logic)
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mod_action'])) {
    $action = $_POST['mod_action'];
    $id = intval($_POST['id']);
    // In production, perform DB moderation
    if ($action == 'approve') $msg = "Content approved!";
    if ($action == 'reject') $msg = "Content rejected.";
    if ($action == 'ban') $msg = "User banned!";
}
// Demo: Fetch pending contents & users for moderation
$pending = [
    [
        'id' => 1,
        'type' => 'Post',
        'user' => 'student1',
        'content' => 'This is a flagged forum post about exam leaks.',
        'status' => 'Pending',
        'flag' => 'Cheating',
    ],
    [
        'id' => 2,
        'type' => 'Comment',
        'user' => 'student2',
        'content' => 'A possibly offensive comment.',
        'status' => 'Pending',
        'flag' => 'Offensive',
    ],
    [
        'id' => 3,
        'type' => 'User',
        'user' => 'troublemaker',
        'content' => '-',
        'status' => 'Pending',
        'flag' => 'Multiple Reports',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderation Center - FUD PAL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .fade-in-mod { animation: fadeInMod 0.5s both; }
        @keyframes fadeInMod { from {opacity:0;transform:translateY(30px);} to{opacity:1;transform:none;} }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <div class="max-w-4xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold text-green-700 flex gap-2 mb-8"><i class="fa-solid fa-shield-halved"></i> Moderation Center</h1>
        <?php if ($msg): ?>
        <div class="bg-green-50 text-green-700 p-3 rounded mb-5 fade-in-mod border-l-4 border-green-500 animate-bounceIn">
            <?= $msg ?>
        </div>
        <?php endif; ?>
        <div class="bg-white rounded-lg shadow-lg p-6 animate-fade-in">
            <h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center gap-2"><i class="fa-solid fa-gavel"></i> Pending Items</h2>
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-green-50">
                        <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Type</th>
                        <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">User</th>
                        <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Content</th>
                        <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Flag</th>
                        <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pending as $item): ?>
                    <tr class="hover:bg-green-50 transition">
                        <td class="py-2 px-4"> <?= htmlspecialchars($item['type']) ?> </td>
                        <td class="py-2 px-4"> <?= htmlspecialchars($item['user']) ?> </td>
                        <td class="py-2 px-4"> <?= htmlspecialchars($item['content']) ?> </td>
                        <td class="py-2 px-4">
                            <span class="inline-block px-2 py-1 text-xs rounded bg-red-100 text-red-700"> <?= htmlspecialchars($item['flag']) ?> </span>
                        </td>
                        <td class="py-2 px-4"> <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800"> <?= $item['status'] ?> </span> </td>
                        <td class="py-2 px-4 flex gap-2">
                            <form method="POST" class="inline-block">
                                <input type="hidden" name="mod_action" value="approve">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded shadow transition"><i class="fas fa-check"></i> Approve</button>
                            </form>
                            <form method="POST" class="inline-block">
                                <input type="hidden" name="mod_action" value="reject">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow transition"><i class="fas fa-times"></i> Reject</button>
                            </form>
                            <?php if($item['type']==='User'): ?>
                            <form method="POST" class="inline-block">
                                <input type="hidden" name="mod_action" value="ban">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow transition"><i class="fas fa-user-slash"></i> Ban</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Animated Info Card -->
        <div class="bg-green-50 rounded-lg mt-10 p-5 shadow fade-in-mod text-green-900 flex gap-4 items-center animate-pulse">
            <i class="fa-solid fa-lightbulb text-2xl text-yellow-400"></i>
            <span>Moderators can review and take immediate actions on flagged users and content. All actions are logged in the <a href="audit_logs.php" class="text-green-700 underline">audit trail</a>.</span>
        </div>
    </div>
</body>
</html>
