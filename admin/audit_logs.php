<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Demo: Log data
$audit_logs = [
  [
    'id'=> 1,'actor'=> 'admin1','action'=>'Suspended user','target'=>'student2','type'=>'User','timestamp'=>'2024-06-04 10:01', 'meta'=>'Reason: Policy Violation'
  ],[
    'id'=> 2,'actor'=> 'admin1','action'=>'Posted announcement','target'=>'All','type'=>'Announcement','timestamp'=>'2024-06-04 09:13','meta'=>'Exam date'
  ],[
    'id'=> 3,'actor'=> 'admin2','action'=>'Created event','target'=>'Tech Meetup','type'=>'Event','timestamp'=>'2024-06-03 14:20','meta'=>'Capacity: 120'
  ],[
    'id'=> 4,'actor'=> 'admin2','action'=>'Deleted forum post','target'=>'post#908','type'=>'Forum','timestamp'=>'2024-06-03 10:09','meta'=>'Spam detected'
  ],[
    'id'=> 5,'actor'=> 'admin3','action'=>'Changed role','target'=>'student3','type'=>'User','timestamp'=>'2024-06-02 17:48','meta'=>'Upgraded to moderator'
  ]
];
$type_filter = $_GET['type'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Audit Logs - FUD PAL Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .fade-in-audit {animation: fadeInAudit 0.7s both;}
    @keyframes fadeInAudit{0%{opacity:0;transform:translateY(25px);}100%{opacity:1;transform:none;}}
    .modal-fade {animation: modalFade 0.35s ease;}
    @keyframes modalFade{0%{opacity:0;transform:scale(.95);}100%{opacity:1;transform:scale(1);}}
  </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-5xl mx-auto py-12 px-6">
  <h1 class="text-3xl font-bold text-green-700 flex items-center gap-2 mb-8"><i class="fas fa-clipboard-list"></i> Audit Logs</h1>
  <form class="mb-5 flex gap-4 flex-wrap">
    <input name="search" type="text" class="rounded border-gray-300 px-3 py-1 focus:ring-2 focus:ring-green-500" placeholder="Search logs...">
    <select name="type" class="rounded border-gray-300 px-3 py-1 focus:ring-2 focus:ring-green-500">
      <option value="">All Types</option>
      <option value="User" <?= $type_filter==="User"?'selected':'' ?>>User</option>
      <option value="Announcement" <?= $type_filter==="Announcement"?'selected':'' ?>>Announcement</option>
      <option value="Event" <?= $type_filter==="Event"?'selected':'' ?>>Event</option>
      <option value="Forum" <?= $type_filter==="Forum"?'selected':'' ?>>Forum</option>
    </select>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded transition">Filter</button>
  </form>
  <div class="bg-white rounded-lg shadow-lg p-6 fade-in-audit overflow-auto">
    <table class="min-w-full table-auto border-collapse">
      <thead>
        <tr class="bg-green-50">
          <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Actor</th>
          <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Action</th>
          <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Target</th>
          <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Type</th>
          <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Time</th>
          <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Details</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($audit_logs as $row):
        if ($type_filter && $type_filter!==$row['type']) continue; ?>
        <tr class="hover:bg-green-50 transition">
          <td class="py-2 px-4"> <?= htmlspecialchars($row['actor']) ?> </td>
          <td class="py-2 px-4"> <?= htmlspecialchars($row['action']) ?> </td>
          <td class="py-2 px-4"> <?= htmlspecialchars($row['target']) ?> </td>
          <td class="py-2 px-4">
            <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-800"> <?= $row['type'] ?> </span>
          </td>
          <td class="py-2 px-4"> <?= htmlspecialchars($row['timestamp']) ?> </td>
          <td class="py-2 px-4">
            <button type="button" onclick="showModal('<?= addslashes($row['actor']) ?>','<?= addslashes($row['action']) ?>','<?= addslashes($row['meta']) ?>','<?= addslashes($row['timestamp']) ?>')" class="text-green-600 hover:text-green-800 px-2 py-1 text-sm transition underline">View</button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <!-- Info Modal -->
  <div id="logModal" class="fixed inset-0 z-50 bg-black bg-opacity-40 hidden justify-center items-center">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 modal-fade relative">
      <button onclick="hideModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h3 class="text-lg font-bold mb-4 text-green-700"><i class="fas fa-info-circle"></i> Log Details</h3>
      <div id="modalContent" class="space-y-4 text-gray-900"></div>
    </div>
  </div>
</div>
<script>
function showModal(actor, action, meta, timestamp) {
  document.getElementById('modalContent').innerHTML =
      `<div><span class='font-semibold'>Actor:</span> ${actor}</div>`+
      `<div><span class='font-semibold'>Action:</span> ${action}</div>`+
      `<div><span class='font-semibold'>Meta:</span> ${meta}</div>`+
      `<div><span class='font-semibold'>Time:</span> ${timestamp}</div>`;
  document.getElementById('logModal').classList.remove('hidden');
  document.getElementById('logModal').classList.add('flex');
}
function hideModal() {
  document.getElementById('logModal').classList.add('hidden');
  document.getElementById('logModal').classList.remove('flex');
}
</script>
</body>
</html>
