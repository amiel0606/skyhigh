<?php
include_once('./dbCon.php');
session_start();

$sql = "SELECT m.msg_id, m.message, m.sender, m.timestamp, u.name 
        FROM tbl_messages m
        JOIN tbl_users u ON m.sender = u.uID
        WHERE m.is_seen = 0
        ORDER BY m.timestamp DESC";
$result = $conn->query($sql);

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode([
    'status' => 'success',
    'count' => count($notifications),
    'notifications' => $notifications
]);