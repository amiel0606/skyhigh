<?php
session_start();
include_once('./dbCon.php');

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
    exit();
}

$user_id = $_GET['user_id'];

$sql = "SELECT msg_id, message, sender, receiver, timestamp 
        FROM tbl_messages
        WHERE (receiver = ? AND sender = 'admin') 
        OR (sender = ? AND receiver = 'admin')
        ORDER BY timestamp ASC";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
    exit();
}

mysqli_stmt_bind_param($stmt, "ss", $user_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = [
        'msg_id' => $row['msg_id'],
        'message' => htmlspecialchars($row['message']),
        'sender' => $row['sender'],
        'receiver' => $row['receiver'],
        'timestamp' => $row['timestamp'],
        'isFromAdmin' => ($row['sender'] === 'admin')
    ];
}

echo json_encode([
    'status' => 'success',
    'messages' => $messages
]);

mysqli_stmt_close($stmt);
mysqli_close($conn);
