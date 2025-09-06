<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Example users table
$users = [
    ['id'=>1,'name'=>'Alice','email'=>'alice@example.com','role'=>'Student','status'=>'Active'],
    ['id'=>2,'name'=>'Bob','email'=>'bob@example.com','role'=>'Student','status'=>'Suspended'],
    ['id'=>3,'name'=>'Claire','email'=>'claire@example.com','role'=>'Staff','status'=>'Active'],
    ['id'=>4,'name'=>'David','email'=>'david@example.com','role'=>'Student','status'=>'Active'],
    ['id'=>5,'name'=>'Elizabeth','email'=>'elizabeth@example.com','role'=>'Staff','status'=>'Active'],
];
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['bulk_action']) && isset($_POST['checked']) && is_array($_POST['checked'])) {
    $act = $_POST['bulk_action'];
    $count = count($_POST['checked']);
    if ($act==='suspend') $msg = "Suspended $count user(s).";
    elseif ($act==='delete') $msg = "Deleted $count user(s).";
    elseif ($act==='promote') $msg = "Promoted $count user(s) to Staff.";
    else $msg = 'No action performed.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Bulk Actions - FUD PAL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      .fade-in-bulk{animation:fadeInBulk .7s both;}@keyframes fadeInBulk{0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:none;}}
      .pulse{animation:pulseFake 1s linear infinite;}
      @keyframes pulseFake{0%{background:rgba(16,185,129,0.2);}50%{background:rgba(16,185,129,0.6);}100%{background:rgba(16,185,129,0.2);}}
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-5xl mx-auto py-12 px-4">
  <h1 class="text-3xl font-bold text-green-700 flex gap-2 mb-8"><i class="fas fa-layer-group"></i> Bulk Actions</h1>
  <?php if($msg): ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded fade-in-bulk animate-pulse mb-4"> <?= $msg ?> </div>
  <?php endif; ?>
  <div class="bg-white rounded-lg shadow-lg p-7 fade-in-bulk">
    <form method="POST" id="bulkForm" onsubmit="return bulkConfirm();">
      <div class="flex flex-col md:flex-row md:items-center gap-5 justify-between mb-3">
        <div class="flex gap-2 items-center">
          <select name="bulk_action" required class="rounded border-gray-300 focus:ring-2 focus:ring-green-500 px-3 py-2">
            <option value="" selected disabled>Bulk action</option>
            <option value="suspend">Suspend</option>
            <option value="promote">Promote to Staff</option>
            <option value="delete">Delete</option>
          </select>
          <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white flex items-center transition pulse"><i class="fas fa-cogs"></i> <span class="ml-2 font-semibold">Apply</span></button>
        </div>
        <span class="text-gray-400 text-sm">Select user(s) and choose an action</span>
      </div>
      <table class="min-w-full table-auto border-collapse">
        <thead>
          <tr class="bg-green-50">
            <th class="p-2"><input type="checkbox" id="checkAll" /></th>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Role</th>
            <th class="p-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $u): ?>
          <tr class="hover:bg-green-50 transition">
            <td class="p-2"><input type="checkbox" name="checked[]" value="<?= $u['id'] ?>" class="rowCheck"></td>
            <td class="p-2"> <?= htmlspecialchars($u['name']) ?> </td>
            <td class="p-2"> <?= htmlspecialchars($u['email']) ?> </td>
            <td class="p-2"> <?= htmlspecialchars($u['role']) ?> </td>
            <td class="p-2">
              <span class="inline-block px-2 py-1 rounded text-xs <?= ($u['status']==='Active' ? 'bg-green-100 text-green-800':'bg-yellow-100 text-yellow-700') ?>">
                <?= $u['status'] ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </form>
  </div>
  <div class="bg-green-50 p-5 mt-6 rounded shadow fade-in-bulk flex gap-4 items-center animate-pulse">
    <i class="fas fa-lightbulb text-2xl text-yellow-400"></i>
    <span>Bulk actions save you time during moderation and mass updates. Always confirm before applying destructive actions.</span>
  </div>
</div>
<script>
// Check all/none
const checkAll = document.getElementById('checkAll');
const boxes = document.querySelectorAll('.rowCheck');
checkAll && checkAll.addEventListener('change',()=>{
  boxes.forEach(b=>b.checked=checkAll.checked);
});
function bulkConfirm(){
  const anyChecked=Array.from(boxes).some(b=>b.checked);
  if(!anyChecked){alert('Please select at least one user.'); return false;}
  return confirm('Are you sure to perform this bulk action?');
}
</script>
</body>
</html>
