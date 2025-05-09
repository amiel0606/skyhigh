<?php
require_once './postFunctions.php';
require_once './dbCon.php'; // Ensure DB connection is available

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $brandId = $data['brand_id'] ?? null;

    if (empty($brandId)) {
        echo json_encode(['success' => false, 'message' => 'Brand ID is required']);
        exit;
    }

    // Check if any product is using this brand
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tbl_products WHERE brand = ?");
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'Cannot delete brand: there are products with this brand.']);
        $conn->close();
        exit;
    }

    $result = deleteBrand($brandId);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Brand deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete brand']);
    }
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
