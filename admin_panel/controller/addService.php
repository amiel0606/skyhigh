<?php
require_once './dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $serviceName = $data['service_name'] ?? null;
    $description = $data['service_description'] ?? null;

    if ($serviceName && $description) {
        $stmt = $conn->prepare("INSERT INTO tbl_services (service_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $serviceName, $description);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Service added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add service']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Service name and description are required']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 