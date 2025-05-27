<?php
include_once('./dbCon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $username = $_POST['username'] ?? '';
    $contact = $_POST['contact'] ?? '';

    // Validate required fields
    if (empty($userId) || empty($name) || empty($username)) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
        exit();
    }

    // Check if username already exists for other users
    $checkSql = "SELECT uID FROM tbl_users WHERE username = ? AND uID != ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
        exit();
    }

    // Update user
    $sql = "UPDATE tbl_users SET name = ?, address = ?, username = ?, contact = ? WHERE uID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $address, $username, $contact, $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
    }

    $stmt->close();
    $checkStmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();