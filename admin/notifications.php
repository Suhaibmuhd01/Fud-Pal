<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['delete_id'])) $msg = 'Notification deleted.';
    if (isset($_POST['read_id'])) $msg = 'Marked as read.';
}
// Demo: Notifications
$notifications = [
  ['id'=>1,'type'=>'System','subject'=>'Backup complete','text'=>'Your scheduled backup completed','date'=>'2024-06-04 12:12','read'=>false],
  ['id'=>2,'type'=>'User','subject'=>'New Registration','text'=>'A new user registered: userx','date'=>'2024-06-04 09:44','read'=>false],
  ['id'=>3,'type'=>'Moderation','subject'=>'Flagged Content','text'=>'A post was flagged for spam','date'=>'2024-06-03 21:15','read'=>true],
  ['id'=>4,'type'=>'System','subject'=>'Update Available','text'=>'New system update released','date'=>'2024-06-02 15:28','read'=>true],
];
$filter = $_GET['filter'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Notifications - FUD PAL Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>.fade-in-notif{animation:fadeNotif .7s both;}@keyframes fadeNotif{0%{opacity:0;transform:translateY(15px);}100%{opacity:1;transform:none;}}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-3xl mx-auto py-12 px-4">
  <h1 class="text-3xl font-bold text-green-700 flex items-center gap-2 mb-8"><i class="fas fa-bell"></i> Notifications</h1>
  <?php if($msg): ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded fade-in-notif animate-pulse mb-4"> <?= $msg ?> </div>
  <?php endif; ?>
  <form class="mb-5 flex gap-5 flex-wrap">
    <select name="filter" class="rounded border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500">
      <option value="">All Types</option>
      <option value="System" <?= $filter==='System'?'selected':'' ?>>System</option>
      <option value="User" <?= $filter==='User'?'selected':'' ?>>User</option>
      <option value="Moderation" <?= $filter==='Moderation'?'selected':'' ?>>Moderation</option>
    </select>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Filter</button>
  </form>
  <div class="bg-white rounded-lg shadow-lg p-6 fade-in-notif">
    <?php $empty = true; foreach($notifications as $n): if($filter && $n['type']!==$filter) continue; $empty = false; ?>
      <div class="flex items-center gap-4 p-4 rounded-lg hover:bg-green-50 transition mb-3 border border-green-100 <?= $n['read']?'opacity-60':'' ?>">
        <div class="flex-shrink-0">
          <i class="fas <?= $n['type']==='User'?'fa-user':'fa-bell' ?> <?= $n['type']==='Moderation'?'fa-gavel':'' ?> text-xl <?= $n['type']==='User'?'text-blue-600':($n['type']==='System'?'text-green-600':'text-yellow-600') ?>"></i>
        </div>
        <div class="flex-1">
          <div class="font-semibold text-gray-800 mb-1"> <?= htmlspecialchars($n['subject']) ?> </div>
          <div class="text-gray-600 mb-1 text-sm"> <?= htmlspecialchars($n['text']) ?> </div>
          <div class="text-xs text-gray-400"> <?= $n['date'] ?> </div>
        </div>
        <div class="flex flex-col gap-1">
          <?php if (!$n['read']): ?>
          <form method="POST"><input type="hidden" name="read_id" value="<?= $n['id'] ?>"><button type="submit" class="text-green-700 hover:text-green-900 bg-green-100 px-2 py-1 rounded text-xs transition">Mark read</button></form>
          <?php endif; ?>
          <button type="button" onclick="showNotifModal('<?= addslashes($n['subject']) ?>','<?= addslashes($n['text']) ?>','<?= $n['date'] ?>','<?= $n['type'] ?>')" class="text-blue-600 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded text-xs transition">View</button>
          <form method="POST" onsubmit="return confirm('Delete notification?');"><input type="hidden" name="delete_id" value="<?= $n['id'] ?>"><button type="submit" class="text-red-700 hover:text-red-900 bg-red-100 px-2 py-1 rounded text-xs transition">Delete</button></form>
        </div>
      </div>
    <?php endforeach; if($empty): ?>
      <div class="text-gray-400 text-center py-8">No notifications found.</div>
    <?php endif; ?>
  </div>
  <!-- Modal -->
  <div id="notifModal" class="fixed inset-0 z-50 bg-black bg-opacity-40 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 fade-in-notif relative">
      <button onclick="hideNotifModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h3 class="text-lg font-bold mb-4 text-green-700 flex items-center"><i class="fas fa-bell"></i> Notification Details</h3>
      <div class="space-y-3" id="notifModalContent"></div>
    </div>
  </div>
  <div class="bg-green-50 p-5 mt-6 rounded shadow fade-in-notif flex gap-4 items-center animate-pulse">
    <i class="fas fa-lightbulb text-2xl text-yellow-400"></i>
    <span>Stay up-to-date: mark notifications as read or delete them after review!</span>
  </div>
</div>
<script>
function showNotifModal(title, text, date, type) {
    document.getElementById('notifModalContent').innerHTML =
      `<div><span class='font-semibold'>Title:</span> ${title}</div>`+
      `<div><span class='font-semibold'>Type:</span> ${type}</div>`+
      `<div><span class='font-semibold'>Text:</span> ${text}</div>`+
      `<div><span class='font-semibold'>Date:</span> ${date}</div>`;
    document.getElementById('notifModal').classList.remove('hidden');
    document.getElementById('notifModal').classList.add('flex');
}
function hideNotifModal(){
  document.getElementById('notifModal').classList.remove('flex');
  document.getElementById('notifModal').classList.add('hidden');
}
</script>
</body>
</html>
