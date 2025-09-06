<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Demo analytics data
$card_stats = [
  ['label' => 'Total Users', 'value' => 1250, 'icon' => 'fa-users', 'color' => 'green'],
  ['label' => 'Active Users', 'value' => 965, 'icon' => 'fa-user-check', 'color' => 'blue'],
  ['label' => 'Suspended', 'value' => 18, 'icon' => 'fa-user-slash', 'color' => 'yellow'],
  ['label' => 'Announcements', 'value' => 36, 'icon' => 'fa-bullhorn', 'color' => 'purple'],
  ['label' => 'Events', 'value' => 22, 'icon' => 'fa-calendar-day', 'color' => 'indigo'],
  ['label' => 'Past Qs Uploaded', 'value' => 211, 'icon' => 'fa-file-pdf', 'color' => 'red'],
];
$this_month = [27, 33, 21, 44, 12, 8, 50, 31, 41, 25, 61, 49, 51, 39, 34, 33, 60, 44, 23, 17, 49, 60, 43, 35, 30, 22, 30, 44];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Analytics - FUD PAL Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
  <div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-700 flex items-center gap-2 mb-8"><i class="fas fa-chart-line"></i> Analytics</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
      <?php foreach($card_stats as $stat): ?>
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center gap-4 hover:scale-105 transition-all duration-200 animate-fade-in"
          style="animation-delay: <?= rand(0, 200) ?>ms; animation-name: fadeIn;">
          <div class="p-3 rounded-full bg-<?= $stat['color'] ?>-100">
            <i class="fas <?= $stat['icon'] ?> text-2xl text-<?= $stat['color'] ?>-600"></i>
          </div>
          <div>
            <div class="text-2xl font-bold text-<?= $stat['color'] ?>-700"> <?= $stat['value'] ?> </div>
            <div class="text-gray-700 mt-1 font-semibold"> <?= $stat['label'] ?> </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-8 animate-fade-in">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-chart-area"></i> User Signups This Month</h2>
      <canvas id="signupsChart" height="80"></canvas>
    </div>
  </div>
  <style>
    .animate-fade-in {animation: fadeIn 0.7s cubic-bezier(.39,.575,.565,1.000) both;}
    @keyframes fadeIn{0%{opacity:0;transform:translateY(25px);}100%{opacity:1;transform:none;}}
  </style>
  <script>
    // Animated chart for monthly signups
    new Chart(document.getElementById('signupsChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: [<?php for($d=1;$d<=count($this_month);$d++) echo '"'.$d.'",'; ?>],
        datasets: [{
          label: 'Signups',
          backgroundColor: 'rgba(16,185,129,0.15)',
          borderColor: '#10B981',
          borderWidth: 2,
          pointBackgroundColor: '#10B981',
          pointRadius: 4,
          fill: true,
          tension: .35,
          data: <?= json_encode($this_month) ?>
        }]
      },
      options: {
        plugins: {
          legend: {display: false}
        },
        scales: {
          x: {display: true},
          y: {display: true, beginAtZero: true}
        }
      }
    });
  </script>
</body>
</html>
