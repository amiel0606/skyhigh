<?php
session_start();
include_once('./dbCon.php');

$sql = "SELECT DISTINCT u.uID, u.name 
        FROM tbl_users u
        INNER JOIN tbl_messages m ON u.uID = m.sender OR u.uID = m.receiver
        WHERE u.uID != 'admin'
        ORDER BY u.name ASC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
    exit();
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = [
        'uID' => $row['uID'],
        'name' => htmlspecialchars($row['name'])
    ];
}

echo json_encode([
    'status' => 'success',
    'users' => $users
]);

mysqli_close($conn);