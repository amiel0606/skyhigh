<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['message']) || empty(trim($data['message']))) {
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty']);
        exit();
    }
    
    $message = trim($data['message']);
    $sender = $_SESSION['uID'];
    $receiver = 'admin';
    
    $sql = "INSERT INTO tbl_messages (receiver, sender, message) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sss", $receiver, $sender, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}