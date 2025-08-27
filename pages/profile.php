<?php
session_start();
include '../includes/config.php';

class User
{
    private $conn;
    public $regnum, $fullname, $faculty, $department;
    public function __construct($conn, $regnum)
    {
        $this->conn = $conn;
        $this->regnum = $regnum;
        $this->load();
    }
    public function load()
    {
        $stmt = $this->conn->prepare("SELECT fullname, faculty, department FROM users WHERE regnum = ?");
        $stmt->bind_param("s", $this->regnum);
        $stmt->execute();
        $stmt->bind_result($this->fullname, $this->faculty, $this->department);
        $stmt->fetch();
        $stmt->close();
    }
}

$regnum = $_SESSION['regnum'] ?? '';
if (!$regnum) {
    header('Location: ../login.php');
    exit;
}
$user = new User($conn, $regnum);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile - FUD PAL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="max-w-xl mx-auto mt-10 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-center text-green-700 dark:text-green-300">My Profile</h1>
        <form id="profile-form" method="post" enctype="multipart/form-data" class="space-y-4">
            <div class="flex flex-col items-center">
                <img id="profile-img-preview"
                    src="profile_image.php?regnum=<?php echo urlencode($user->regnum); ?>&t=<?php echo time(); ?>"
                    class="w-24 h-24 rounded-full object-cover mb-2 border-2 border-green-400" alt="Profile Picture">
                <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*"
                    class="block w-full text-sm text-gray-500" disabled>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($user->fullname); ?>" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3"
                    disabled>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Reg Number</label>
                <input type="text" name="regnum" value="<?php echo htmlspecialchars($user->regnum); ?>" readonly
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3 bg-gray-100">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Faculty</label>
                <input type="text" name="faculty" value="<?php echo htmlspecialchars($user->faculty); ?>" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3"
                    disabled>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Department</label>
                <input type="text" name="department" value="<?php echo htmlspecialchars($user->department); ?>" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-3"
                    disabled>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="edit-btn"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Edit</button>
                <button type="submit" id="save-btn"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold hidden">Save
                    Changes</button>
            </div>
        </form>
    </div>

    <!-- Popup -->
    <div id="popup" class="fixed inset-0 z-50 items-center justify-center hidden">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 flex flex-col items-center relative animate__animated animate__bounceIn">
            <button id="close-popup"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            <div id="popup-animation" class="mb-4"></div>
            <h2 id="popup-title" class="text-2xl font-bold mb-2"></h2>
            <p id="popup-message" class="text-gray-700 dark:text-gray-300 mb-4"></p>
        </div>
    </div>

    <script>
        $('img[src*="profile_image.php"]').each(function() {
            this.src = this.src.split('?')[0] +
                '?regnum=<?php echo urlencode($user->regnum); ?>&t=' + new Date().getTime();
        });

        // Enable editing
        $('#edit-btn').click(function() {
            $('#profile-form input:not([name="regnum"])').prop('disabled', false);
            $('#profile-picture-input').prop('disabled', false);
            $('#save-btn').removeClass('hidden');
            $(this).addClass('hidden');
        });

        // Preview image
        $('#profile-picture-input').change(function(e) {
            const [file] = e.target.files;
            if (file) {
                $('#profile-img-preview').attr('src', URL.createObjectURL(file));
            }
        });


        // Popup logic
        function showPopup(success, message) {
            $('#popup-title').text(success ? 'Success!' : 'Error');
            $('#popup-message').text(message);
            $('#popup').removeClass('hidden');
            if (success) {
                $('#popup-animation').html(
                    '<img src="https://cdn.pixabay.com/animation/2022/10/13/14/44/14-44-47-282_512.gif" class="w-24 h-24 mx-auto mb-2" alt="Confetti">'
                );
            } else {
                $('#popup-animation').html('<i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-2"></i>');
            }
        }
        $('#close-popup').click(function() {
            $('#popup').addClass('hidden');
            if ($('#popup-title').text() === 'Success!') {
                location.reload();
            }
        });

        // AJAX submit
        $('#profile-form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#save-btn').prop('disabled', true).text('Saving...');
            $.ajax({
                url: 'profile_update.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    let res = {};
                    try {
                        res = typeof response === 'object' ? response : JSON.parse(response);
                    } catch (e) {}
                    showPopup(res.success, res.message || (res.success ? 'Profile updated!' :
                        'Update failed.'));
                    if (res.success) {
                        // Update all profile images on the page
                        $('img[src*="profile_image.php"]').each(function() {
                            this.src = this.src.split('?')[0] +
                                '?regnum=<?php echo urlencode($user->regnum); ?>&t=' +
                                new Date().getTime();
                        });
                    }
                },
                error: function() {
                    showPopup(false, 'An error occurred.');
                },
                complete: function() {
                    $('#save-btn').prop('disabled', false).text('Save Changes');
                }
            });
        });
    </script>
</body>

</html>