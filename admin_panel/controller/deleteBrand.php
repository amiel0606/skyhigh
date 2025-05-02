<?php
require_once './postFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $brandId = $data['brand_id'] ?? null;

    if (empty($brandId)) {
        echo json_encode(['success' => false, 'message' => 'Brand ID is required']);
        exit;
    }

    $result = deleteBrand($brandId);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Brand deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete brand']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
