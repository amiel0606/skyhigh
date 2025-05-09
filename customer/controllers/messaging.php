<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

$uploadDir = '../../uploads/chat/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$sender = isset($_SESSION['uID']) ? $_SESSION['uID'] : 'guest';
$receiver = 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 🔹 Handle image upload
    if (!empty($_FILES['image'])) {
        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image format.']);
            exit();
        }

        $newFilename = uniqid("img_") . '.' . $ext;
        $target = $uploadDir . $newFilename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $relativePath = str_replace('../../', '../', $target);
            $sql = "INSERT INTO tbl_messages (receiver, sender, message, type) VALUES (?, ?, ?, 'image')";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo json_encode(['status' => 'error', 'message' => 'Database error']);
                exit();
            }
            mysqli_stmt_bind_param($stmt, "sss", $receiver, $sender, $relativePath);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'imageUrl' => $relativePath]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save image message']);
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Image upload failed']);
            exit();
        }
    }

    // 🔹 Handle text message (JSON)
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['message']) || empty(trim($data['message']))) {
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty']);
        exit();
    }

    $message = trim($data['message']);
    $sql = "INSERT INTO tbl_messages (receiver, sender, message, type) VALUES (?, ?, ?, 'text')";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $receiver, $sender, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully', 'sender' => $sender]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
