<?php
include_once('./dbCon.php');  

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$productId = $data['product_id'] ?? null;
$status = $data['status'] ?? null;

if (!$productId || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing product ID or status']);
    exit();
}

if (!in_array($status, ['available', 'unavailable'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit();
}

$stmt = $conn->prepare("UPDATE tbl_products SET status = ? WHERE product_id = ?");
$stmt->bind_param("si", $status, $productId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product status']);
}

$stmt->close();
$conn->close();