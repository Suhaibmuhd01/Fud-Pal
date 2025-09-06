<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'backup') {
        $msg = 'Backup has been created successfully!';
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $msg = 'Backup deleted.';
    }
    if (isset($_POST['action']) && $_POST['action'] === 'restore') {
        $msg = 'Backup has been restored (simulated).';
    }
}
// Demo backups
$backups = [
  ['file'=>'db_backup_jun04_2024.sql','date'=>'2024-06-04 14:20'],
  ['file'=>'db_backup_jun01_2024.sql','date'=>'2024-06-01 19:27'],
  ['file'=>'db_backup_may29_2024.sql','date'=>'2024-05-29 11:11'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Backup System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>.fade-in {animation: fadeInB 0.7s both;}@keyframes fadeInB{0%{opacity:0;transform:translateY(30px);}100%{opacity:1;transform:none;}}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-3xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-700 flex gap-2 mb-8"><i class="fas fa-database"></i> Backup Manager</h1>
    <?php if ($msg): ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded mb-5 fade-in animate-pulse"> <?= $msg ?> </div>
    <?php endif; ?>
    <div class="bg-white rounded-lg shadow-lg p-7 fade-in mb-8">
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-4">
            <div class="text-lg font-semibold mb-2">Create a new database backup.</div>
            <form method="POST" class="">
                <input type="hidden" name="action" value="backup">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow font-bold flex gap-2 items-center transition duration-200 animate-bounce"><i class="fas fa-plus-circle"></i> Backup Now</button>
            </form>
        </div>
        <div class="border-t pt-4 mt-4">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-green-50">
                        <th class="py-2 px-4 text-left font-semibold text-gray-700">Backup File</th>
                        <th class="py-2 px-4 text-left font-semibold text-gray-700">Date</th>
                        <th class="py-2 px-4 text-left font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($backups as $b): ?>
                    <tr class="hover:bg-green-50 transition">
                        <td class="py-2 px-4"> <i class="fas fa-database text-green-600"></i> <?= htmlspecialchars($b['file']) ?> </td>
                        <td class="py-2 px-4"> <?= $b['date'] ?> </td>
                        <td class="py-2 px-4 flex gap-2">
                         <form method="POST" class="inline-block">
                            <input type="hidden" name="action" value="restore">
                            <input type="hidden" name="file" value="<?= htmlspecialchars($b['file']) ?>">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow transition"><i class="fas fa-sync"></i> Restore</button>
                         </form>
                         <form method="POST" class="inline-block" onsubmit="return confirm('Delete this backup?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="file" value="<?= htmlspecialchars($b['file']) ?>">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow transition"><i class="fas fa-trash"></i> Delete</button>
                         </form>
                         <a class="bg-gray-100 hover:bg-gray-200 text-green-700 border border-green-200 px-3 py-1 rounded shadow transition flex items-center" href="#" download><i class="fas fa-download"></i> <span class="ml-1">Download</span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="bg-green-50 p-5 mt-6 rounded shadow fade-in flex gap-4 items-center animate-pulse">
        <i class="fas fa-lightbulb text-2xl text-yellow-400"></i>
        <span>Backups allow you to restore your database to a previous state in case of errors or loss. Always download backups regularly.</span>
    </div>
</div>
</body>
</html>
