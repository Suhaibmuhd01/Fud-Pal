<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $msg = 'Settings updated successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Settings - FUD PAL</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>.fade-in-settings{animation:fadeSettings 0.7s both;}@keyframes fadeSettings{0%{opacity:0;transform:translateY(20px);}100%{opacity:1;transform:none;}}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-2xl mx-auto py-12 px-4">
  <h1 class="text-3xl font-bold text-green-700 flex gap-2 mb-8"><i class="fas fa-cog"></i> Admin Settings</h1>
  <?php if($msg): ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded fade-in-settings animate-pulse mb-4"> <?= $msg ?> </div>
  <?php endif; ?>
  <form method="POST" class="space-y-8 bg-white rounded-lg shadow-lg p-8 fade-in-settings">
    <div>
      <h2 class="font-semibold text-lg mb-3 text-gray-800 flex items-center gap-2"><i class="fas fa-user"></i> Profile Settings</h2>
      <div class="space-y-3">
        <label class="block">
          <span class="text-gray-700">Display Name</span>
          <input type="text" name="display_name" placeholder="Admin Name" value="Admin" class="mt-1 px-3 py-2 rounded border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
        </label>
        <label class="block">
          <span class="text-gray-700">Email Address</span>
          <input type="email" name="email" placeholder="admin@email.com" value="admin@email.com" class="mt-1 px-3 py-2 rounded border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
        </label>
        <label class="block">
          <span class="text-gray-700">Change Password</span>
          <input type="password" name="new_pass" placeholder="New password" class="mt-1 px-3 py-2 rounded border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
        </label>
      </div>
    </div>
    <div>
      <h2 class="font-semibold text-lg mb-3 text-gray-800 flex items-center gap-2"><i class="fas fa-toggle-on"></i> Preferences</h2>
      <div class="flex items-center gap-4 mb-3">
        <span>Theme:</span>
        <select name="theme" class="rounded border-gray-300 focus:ring-2 focus:ring-green-500 py-2 px-3">
          <option value="light">Light</option>
          <option value="dark">Dark</option>
          <option value="system">System</option>
        </select>
      </div>
      <div class="flex items-center gap-3">
        <span>Notifications:</span>
        <label class="flex items-center gap-2">
          <input type="checkbox" name="email_notif" checked class="rounded accent-green-700" /> Email
        </label>
        <label class="flex items-center gap-2">
          <input type="checkbox" name="sms_notif" class="rounded accent-green-700" /> SMS
        </label>
      </div>
    </div>
    <div>
      <h2 class="font-semibold text-lg mb-3 text-gray-800 flex items-center gap-2"><i class="fas fa-lock"></i> Security</h2>
      <div class="flex items-center gap-4 mb-3">
        <label class="flex items-center gap-2">
          <input type="checkbox" name="2fa" class="rounded accent-green-700" checked /> Enable Two-factor authentication
        </label>
        <label class="flex items-center gap-2">
          <input type="checkbox" name="timeout" class="rounded accent-green-700" /> Auto logout after 10 min
        </label>
      </div>
    </div>
    <button type="submit" class="bg-green-600 hover:bg-green-700 px-6 py-2 text-white rounded shadow font-semibold transition">Save Settings</button>
  </form>
  <div class="bg-green-50 p-5 mt-6 rounded shadow fade-in-settings flex gap-4 items-center animate-pulse">
    <i class="fas fa-lightbulb text-2xl text-yellow-400"></i>
    <span>Keep your admin settings up to date for a secure and smooth experience.</span>
  </div>
</div>
</body>
</html>
