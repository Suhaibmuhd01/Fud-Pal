<?php
session_start();
require_once "../config/db_config.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// Demo files
$files = [
  ['name'=>'notice.pdf','size'=>245120,'type'=>'pdf','uploaded'=>'2024-05-22 12:01'],
  ['name'=>'policy.docx','size'=>57020,'type'=>'docx','uploaded'=>'2024-05-19 16:42'],
  ['name'=>'results.xlsx','size'=>91800,'type'=>'xlsx','uploaded'=>'2024-05-15 09:26'],
];
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['delete_file'])) $msg = 'File deleted.';
    if (isset($_POST['upload'])) $msg = 'File uploaded (simulated).';
}
function fsize($bytes) {
    if ($bytes < 1024) return $bytes.' B';
    if ($bytes < 1048576) return round($bytes/1024,1).' KB';
    return round($bytes/1048576,1).' MB';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>File Manager - FUD PAL Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>.fade-in-fm{animation:fadeFM 0.7s both;}@keyframes fadeFM{0%{opacity:0;transform:translateY(25px);}100%{opacity:1;transform:none;}}.pulse{animation:pulse 1s infinite alternate}@keyframes pulse{to{background:#bbf7d0;}}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
<div class="max-w-4xl mx-auto py-12 px-4">
  <div class="flex items-center justify-between mb-7">
    <h1 class="text-3xl font-bold text-green-700 flex gap-2"><i class="fas fa-folder"></i> File Manager</h1>
    <button onclick="showUpload()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition flex items-center"><i class="fas fa-upload"></i> <span class="ml-2 font-semibold">Upload</span></button>
  </div>
  <?php if($msg): ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded fade-in-fm animate-pulse mb-4"> <?= $msg ?> </div>
  <?php endif; ?>
  <div class="bg-white rounded-lg shadow-lg p-7 fade-in-fm overflow-x-auto">
    <table class="min-w-full table-auto border-collapse">
      <thead>
        <tr class="bg-green-50">
          <th class="p-2 text-left">File</th>
          <th class="p-2 text-left">Type</th>
          <th class="p-2 text-left">Size</th>
          <th class="p-2 text-left">Uploaded</th>
          <th class="p-2 text-left">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($files as $f): ?>
        <tr class="hover:bg-green-50 transition">
          <td class="p-2"><i class="fas fa-file-<?php echo $f['type']==='pdf'?'pdf':($f['type']==='xlsx'?'excel':($f['type']==='docx'?'word':'alt')); ?> text-green-700"></i> <?= htmlspecialchars($f['name']) ?></td>
          <td class="p-2"> <?= strtoupper($f['type']) ?> </td>
          <td class="p-2"> <?= fsize($f['size']) ?> </td>
          <td class="p-2"> <?= $f['uploaded'] ?> </td>
          <td class="p-2 flex gap-2">
            <a href="#" class="bg-blue-200 hover:bg-blue-300 text-blue-800 px-2 py-1 rounded shadow text-xs" onclick="previewFile('<?= addslashes($f['name']) ?>','<?= $f['type'] ?>'); return false;"><i class="fas fa-eye"></i> View</a>
            <a href="#" class="bg-green-200 hover:bg-green-300 text-green-800 px-2 py-1 rounded shadow text-xs"><i class="fas fa-download"></i> Download</a>
            <form method="POST" class="inline-block" onsubmit="return confirm('Delete this file?')">
              <input type="hidden" name="delete_file" value="<?= htmlspecialchars($f['name']) ?>">
              <button type="submit" class="bg-red-200 hover:bg-red-400 text-red-700 px-2 py-1 rounded shadow text-xs"><i class="fas fa-trash"></i> Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <!-- Upload Modal -->
  <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 fade-in-fm relative">
      <button onclick="hideUpload()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h3 class="text-lg font-bold mb-4 text-green-700 flex items-center"><i class="fas fa-upload"></i> Upload File</h3>
      <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required class="w-full py-2 px-3 mb-4 rounded border border-gray-300">
        <button type="submit" name="upload" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition w-full font-semibold">Upload</button>
      </form>
    </div>
  </div>
  <!-- Preview Modal -->
  <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-8 fade-in-fm relative">
      <button onclick="hidePreview()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h3 class="text-lg font-bold mb-4 text-green-700 flex items-center"><i class="fas fa-eye"></i> File Preview</h3>
      <div class="text-center text-gray-700" id="previewBox">Demo preview: Feature integrates with PDF/image/doc previewer in production.</div>
    </div>
  </div>
  <div class="bg-green-50 p-5 mt-6 rounded shadow fade-in-fm flex gap-4 items-center animate-pulse">
    <i class="fas fa-lightbulb text-2xl text-yellow-400"></i>
    <span>Your files are safe here. In production, configure upload folder permissions for security!</span>
  </div>
</div>
<script>
function showUpload(){document.getElementById('uploadModal').classList.remove('hidden');document.getElementById('uploadModal').classList.add('flex');}
function hideUpload(){document.getElementById('uploadModal').classList.remove('flex');document.getElementById('uploadModal').classList.add('hidden');}
function previewFile(name, type) {
    document.getElementById('previewBox').innerHTML = "Can't preview this file in demo: " + name + ". This would link to a real previewer for " + type + ".";
    document.getElementById('viewModal').classList.remove('hidden');
    document.getElementById('viewModal').classList.add('flex');
}
function hidePreview() {
    document.getElementById('viewModal').classList.remove('flex');
    document.getElementById('viewModal').classList.add('hidden');
}
</script>
</body>
</html>
