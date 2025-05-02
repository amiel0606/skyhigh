<?php
include_once './dbCon.php';
session_start();

$user_id = intval($_POST['user_id'] ?? 0);

if ($user_id) {
    $sql = "UPDATE tbl_messages SET is_seen = 1 WHERE sender = $user_id AND is_seen = 0";
    $conn->query($sql);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
}