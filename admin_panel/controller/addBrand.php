<?php
require_once './postFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $brandName = $data['brand_name'] ?? null;

    if ($brandName) {
        addBrand($brandName);
        echo json_encode(['success' => true, 'message' => 'Brand added successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Brand name is required']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
