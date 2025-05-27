<?php
include_once('./dbCon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';

    // Validate required fields
    if (empty($userId)) {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
        exit();
    }

    // Check if user exists
    $checkSql = "SELECT uID FROM tbl_users WHERE uID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit();
    }

    // Delete user
    $sql = "DELETE FROM tbl_users WHERE uID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
    }

    $stmt->close();
    $checkStmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();