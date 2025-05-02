<?php
require_once './postFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $brandId = $data['brand_id'] ?? null;
    $brandName = $data['brand_name'] ?? null;

    if (empty($brandName) || empty($brandId)) {
        echo json_encode(['success' => false, 'message' => 'Brand name and ID are required']);
        exit;
    }

    $result = updateBrand($brandId, $brandName);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Brand updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update brand']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
