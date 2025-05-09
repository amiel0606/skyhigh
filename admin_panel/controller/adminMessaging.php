<?php
session_start();
include_once('./dbCon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
        exit();
    }

    $receiver = $_POST['user_id'];
    $sender = 'admin';

    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    if (empty($message) && !$image) {
        echo json_encode(['status' => 'error', 'message' => 'Message or image is required']);
        exit();
    }

    $imageUrl = null;

    if ($image) {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowedMimeTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image type']);
            exit();
        }

        $uploadDir = '../../uploads/chat/';
        $publicPath = '../uploads/chat/';
        $filename = uniqid('image_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $fullPath = $uploadDir . $filename;

        if (!move_uploaded_file($image['tmp_name'], $fullPath)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
            exit();
        }

        $message = $publicPath . $filename;
        $messageType = 'image';
        $imageUrl = $message; // return the same public path
    } else {
        $messageType = 'text';
    }

    $sql = "INSERT INTO tbl_messages (receiver, sender, message, type) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $receiver, $sender, $message, $messageType);

    if (mysqli_stmt_execute($stmt)) {
        $response = [
            'status' => 'success',
            'message' => 'Message sent successfully'
        ];

        if ($imageUrl) {
            $response['imageUrl'] = $imageUrl;
        }

        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
