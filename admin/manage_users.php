<?php
session_start();
require_once "../config/db_config.php";
$conn = connectDB();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}

// Handle actions
$feedback = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Add user
    if (isset($_POST["action"]) && $_POST["action"] === "add_user") {
        $fullname = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $role = $_POST["role"];
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role, status) VALUES (?, ?, ?, ?, 'Active')");
        $stmt->bind_param("ssss", $fullname, $email, $password, $role);
        if ($stmt->execute()) $feedback = "User added successfully.";
        else $feedback = "Failed to add user.";
    }
    // Suspend/Unsuspend
    if (isset($_POST["action"]) && $_POST["action"] === "toggle_suspend") {
        $user_id = intval($_POST["user_id"]);
    $stmt = $conn->prepare("SELECT is_active FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $current = $stmt->get_result()->fetch_assoc();
    $new_status = ($current["is_active"] == 0) ? 1 : 0;
    $stmt2 = $conn->prepare("UPDATE users SET is_active=? WHERE id=?");
    $stmt2->bind_param("ii", $new_status, $user_id);
        if ($stmt2->execute()) $feedback = "Status updated.";
        else $feedback = "Failed to update status.";
    }
    // Delete
    if (isset($_POST["action"]) && $_POST["action"] === "delete") {
        $user_id = intval($_POST["user_id"]);
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) $feedback = "User deleted.";
        else $feedback = "Failed to delete user.";
    }
}
// Query for users
$status_filter = $_GET["status"] ?? "";
$where = [];
if ($status_filter !== "") {
    if ($status_filter === "Active") $where[] = "is_active=1";
    else if ($status_filter === "Suspended") $where[] = "is_active=0";
}
$where_sql = $where ? ("WHERE " . implode(" AND ", $where)) : "";
$sql = "SELECT id, fullname, email, is_active FROM users $where_sql ORDER BY id DESC";
$users = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .fade-in-modal { animation: fadeInModal 0.4s both; }
        @keyframes fadeInModal { 0% { opacity: 0; transform: scale(.95); } 100% { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-green-700 flex items-center gap-2"><i class="fas fa-users"></i> Manage Users</h1>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition-all" onclick="showAddModal()"><i class="fas fa-user-plus"></i> Add User</button>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 animate-fade-in">
            <form class="mb-6 flex gap-4 flex-wrap">
                <label class="flex items-center gap-2 text-gray-700">
                    Status:
                    <select name="status" class="rounded border-gray-300 focus:ring-2 focus:ring-green-500">
                        <option value="">All</option>
                        <option value="Active" <?= $status_filter==='Active'? 'selected':'' ?>>Active</option>
                        <option value="Suspended" <?= $status_filter==='Suspended'? 'selected':'' ?>>Suspended</option>
                    </select>
                </label>
                <!-- Role filter removed: no 'role' column in users table -->
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition">Apply Filters</button>
            </form>
            <?php if($feedback): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-3 rounded mb-3 animate-pulse"> <?= $feedback ?> </div>
            <?php endif; ?>
            <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse rounded shadow-sm bg-white">
                <thead>
                    <tr class="bg-green-50">
                        <th class="py-2 px-4 font-semibold text-gray-700">Full Name</th>
                        <th class="py-2 px-4 font-semibold text-gray-700">Email</th>
                        <!-- <th class="py-2 px-4 font-semibold text-gray-700">Role</th> -->
                        <th class="py-2 px-4 font-semibold text-gray-700">Status</th>
                        <th class="py-2 px-4 font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                                <?php while($row = $users->fetch_assoc()): ?>
                                    <tr class="border-t hover:bg-green-50 transition">
                                            <td class="py-2 px-4"> <?= htmlspecialchars($row["fullname"]) ?> </td>
                      <td class="py-2 px-4"> <?= htmlspecialchars($row["email"]) ?> </td>
                      <!-- <td class="py-2 px-4"> <?= htmlspecialchars($row["role"]) ?> </td> -->
                      <td class="py-2 px-4">
                          <span class="inline-block px-2 py-1 text-xs rounded <?=
                              $row["is_active"]==1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                              <?= $row["is_active"]==1 ? 'Active' : 'Suspended' ?>
                          </span>
                      </td>
                      <td class="py-2 px-4 flex gap-2">
                          <form method="POST" class="inline-block">
                              <input type="hidden" name="action" value="toggle_suspend">
                              <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                              <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition" title="Suspend/Unsuspend">
                                  <i class="fas fa-pause"></i> <?= $row['is_active']==1?'Suspend':'Unsuspend' ?>
                              </button>
                          </form>
                          <form method="POST" class="inline-block" onsubmit="return confirm('Delete user permanently?')">
                              <input type="hidden" name="action" value="delete">
                              <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition" title="Delete">
                                  <i class="fas fa-trash-alt"></i> Delete
                              </button>
                          </form>
                      </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- Add User Modal -->
        <div id="add-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 fade-in-modal relative">
                <button onclick="hideAddModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                <h3 class="text-xl font-semibold mb-5 text-green-700 flex items-center gap-2"><i class="fas fa-user-plus"></i> Add User</h3>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add_user">
                    <div>
                        <label class="block text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required class="w-full rounded border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full rounded border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Role</label>
                        <select name="role" required class="w-full rounded border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="Student">Student</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required class="w-full rounded border-gray-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="flex justify-end gap-4 mt-4">
                        <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow transition">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    // Add User Modal control for Tailwind's flex/hidden conflict
    function showAddModal() {
      const modal = document.getElementById('add-modal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
    function hideAddModal() {
      const modal = document.getElementById('add-modal');
      modal.classList.remove('flex');
      modal.classList.add('hidden');
    }
    </script>

    <!-- Footer -->
    <footer class="w-full bg-green-800 text-white py-4 mt-auto fixed bottom-0 left-0 z-50 flex items-center justify-center">
        <span class="text-sm">&copy; <?= date('Y') ?> FUD PAL Admin. All rights reserved.</span>
    </footer>
</body>
</html>
