<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['support_msg'])) {
    $msg = 'Your support request has been submitted!';
}
$faqs = [
  ['q'=>'How do I reset a user password?','a'=>'Go to Manage Users, click on the user, and use “Reset Password”.'],
  ['q'=>'How can I change my email address?','a'=>'You can change it on the <a class="underline text-green-700" href="settings.php">settings page</a>.'],
  ['q'=>'Where do I see system logs?','a'=>'Open <a class="underline text-green-700" href="audit_logs.php">Audit Logs</a> in the menu.'],
  ['q'=>'Can I restore a deleted file?','a'=>'If there is a backup, use <a class="underline text-green-700" href="backup.php">Backup Manager</a>.'],
];
$tickets = [
  ['id'=>1001,'subject'=>'Account issue','status'=>'Resolved','created'=>'2024-05-15'],
  ['id'=>1002,'subject'=>'Feature request','status'=>'Open','created'=>'2024-06-04'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Support - FUD PAL</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>.fade-in-sup{animation:fadeSup 0.7s both;}@keyframes fadeSup{0%{opacity:0;transform:translateY(18px);}100%{opacity:1;transform:none;}}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-3xl mx-auto py-12 px-4">
  <h1 class="text-3xl font-bold text-green-700 flex gap-2 mb-8"><i class="fas fa-life-ring"></i> Support Center</h1>
  <?php if($msg): ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded fade-in-sup animate-pulse mb-4"> <?= $msg ?> </div>
  <?php endif; ?>
  <div class="bg-white rounded-lg shadow-lg p-7 fade-in-sup mb-8">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2"><i class="fas fa-question-circle"></i> FAQs</h2>
    <?php foreach($faqs as $i=>$f): ?>
      <details class="mb-2 group">
        <summary class="cursor-pointer flex items-center gap-2 font-semibold text-green-700 group-open:text-green-800 bg-green-50 rounded px-3 py-2 transition"> <i class="fas fa-plus"></i> <?= $f['q'] ?> </summary>
        <div class="mt-2 px-3 text-gray-700" style="margin-left:1.6rem"> <?= $f['a'] ?> </div>
      </details>
    <?php endforeach; ?>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-7 fade-in-sup">
      <h2 class="font-semibold text-lg mb-3 text-gray-800 flex items-center gap-2"><i class="fas fa-envelope"></i> Contact Support</h2>
      <form method="POST" class="space-y-3">
        <input type="hidden" name="support_msg" value="1">
        <input type="text" name="subject" required placeholder="Subject" class="w-full rounded border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500">
        <textarea name="body" rows="5" required placeholder="Describe your issue..." class="w-full rounded border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500"></textarea>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow font-semibold transition flex items-center"><i class="fas fa-paper-plane mr-2"></i> Send</button>
      </form>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-7 fade-in-sup">
      <h2 class="font-semibold text-lg mb-3 text-gray-800 flex items-center gap-2"><i class="fas fa-ticket-alt"></i> Tickets</h2>
      <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-green-50">
            <th class="p-2 text-left">ID</th>
            <th class="p-2 text-left">Subject</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2 text-left">Created</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($tickets as $t): ?>
          <tr class="hover:bg-green-50 transition">
            <td class="p-2">#<?= $t['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($t['subject']) ?></td>
            <td class="p-2">
              <span class="inline-block px-2 py-1 rounded text-xs <?= $t['status']==='Resolved' ? 'bg-green-100 text-green-800':'bg-yellow-100 text-yellow-700' ?>">
                <?= $t['status'] ?>
              </span>
            </td>
            <td class="p-2"> <?= $t['created'] ?> </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="bg-green-50 p-5 mt-6 rounded shadow fade-in-sup flex gap-4 items-center animate-pulse">
    <i class="fas fa-lightbulb text-2xl text-yellow-400"></i>
    <span>Get help fast: check FAQs, or send us a message. We'll reply through the ticket system above.</span>
  </div>
</div>
</body>
</html>
