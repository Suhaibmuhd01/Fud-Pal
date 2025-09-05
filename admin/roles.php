<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$roles = [
    ['id'=>1,'role'=>'Super Admin','permissions'=>['users','moderation','settings','backup']],
    ['id'=>2,'role'=>'Moderator','permissions'=>['moderation','users']],
    ['id'=>3,'role'=>'Staff','permissions'=>['users']],
    ['id'=>4,'role'=>'Viewer','permissions'=>['view']],
];
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['delete_role'])) $msg='Role deleted.';
    if (isset($_POST['add_role'])) $msg='Role added.';
    if (isset($_POST['update_perms'])) $msg='Permissions updated.';
}
$permissions_list=['users'=>'Manage Users','moderation'=>'Content Moderation','settings'=>'Settings','backup'=>'Backup','view'=>'View Data'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Roles & Permissions - FUD PAL Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>.fade-in-roles{animation:fadeRole 0.7s both;}@keyframes fadeRole{0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:none;}}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-8">
      <h1 class="text-3xl font-bold text-green-700 flex gap-2"><i class="fas fa-user-shield"></i> Roles & Permissions</h1>
      <button onclick="showAddModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow flex items-center transition"><i class="fas fa-plus mr-2"></i> Add Role</button>
    </div>
    <?php if($msg): ?>
      <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded fade-in-roles animate-pulse mb-4"> <?= $msg ?> </div>
    <?php endif; ?>
    <div class="bg-white rounded-lg shadow-lg p-7 fade-in-roles overflow-x-auto">
      <table class="min-w-full table-auto border-collapse">
        <thead>
          <tr class="bg-green-50">
            <th class="p-2 text-left">Role</th>
            <th class="p-2 text-left">Permissions</th>
            <th class="p-2 text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($roles as $r): ?>
            <tr class="hover:bg-green-50 transition">
              <td class="p-2"> <span class="font-bold"> <?= htmlspecialchars($r['role']) ?> </span> </td>
              <td class="p-2">
                <?php foreach($r['permissions'] as $p): ?>
                  <span class="inline-block px-2 py-1 rounded text-xs bg-green-100 text-green-700 mr-1"> <?= htmlspecialchars($permissions_list[$p]) ?> </span>
                <?php endforeach; ?>
              </td>
              <td class="p-2 flex gap-1">
                <button onclick="showPermModal('<?= addslashes($r['role']) ?>','<?= htmlspecialchars(json_encode($r['permissions'])) ?>')"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition" title="Edit Permissions">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <form method="POST" class="inline-block" onsubmit="return confirm('Delete this role?')">
                  <input type="hidden" name="delete_role" value="1">
                  <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition" title="Delete">
                    <i class="fas fa-trash-alt"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Add Role Modal and JS would go here -->
  </div>
</body>
</html>