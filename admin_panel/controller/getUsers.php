<?php
session_start();
include_once('./dbCon.php');

$sql = "SELECT * FROM tbl_users";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
    exit();
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    unset($row['password']);
    $users[] = $row;
}

echo json_encode([
    'status' => 'success',
    'users' => $users
]);

mysqli_close($conn);