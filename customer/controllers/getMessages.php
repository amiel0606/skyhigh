<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['uID'];

$sql = "SELECT msg_id, message, sender, receiver, timestamp, type
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
$response = ['status' => 'success', 'messages' => []];

while ($row = mysqli_fetch_assoc($result)) {
    $msg = [
        'msg_id' => $row['msg_id'],
        'sender' => $row['sender'],
        'receiver' => $row['receiver'],
        'message' => $row['message'],
        'isFromAdmin' => ($row['sender'] === 'admin'),
        'timestamp' => $row['timestamp'],
        'type' => $row['type']
    ];

    $response['messages'][] = $msg;
}

echo json_encode($response);
mysqli_stmt_close($stmt);
mysqli_close($conn);