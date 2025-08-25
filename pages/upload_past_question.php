<?php
session_start();
include '../includes/config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_code = $_POST['course_code'] ?? '';
    $faculty = $_POST['faculty'] ?? '';
    $course_title = $_POST['course_title'] ?? '';
    $department = $_POST['department'] ?? '';
    $level = isset($_POST['level']) ? intval($_POST['level']) : 0;
    $uploaded_by = $_SESSION['regnum'] ?? 'unknown';

    // Validate required fields
    if (
        empty($course_code) ||
        empty($faculty) ||
        empty($course_title) ||
        empty($department) ||
        empty($level) ||
        empty($uploaded_by)
    ) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file_upload']['tmp_name'];
        $fileName = $_FILES['file_upload']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        if ($fileExtension !== 'pdf') {
            echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed.']);
            exit;
        }

        $uploadFileDir = '../uploads/past_questions/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }
        $newFileName = uniqid() . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        $file_blob = file_get_contents($fileTmpPath);

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $stmt = $conn->prepare("INSERT INTO past_questions (course_title, course_code, faculty, department, level, file_path, file_blob, uploaded_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $null = NULL;
            $stmt->bind_param("ssssisssb", $course_title, $course_code, $faculty, $department, $level, $dest_path, $null, $uploaded_by);
            $stmt->send_long_data(6, $file_blob);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Past question uploaded successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File upload failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
