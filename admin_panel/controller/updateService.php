<?php
require_once './dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $serviceId = $data['service_id'] ?? null;
    $serviceName = $data['service_name'] ?? null;
    $description = $data['service_description'] ?? null;

    if ($serviceId && $serviceName && $description) {
        $stmt = $conn->prepare("UPDATE tbl_services SET service_name = ?, description = ? WHERE s_id = ?");
        $stmt->bind_param("ssi", $serviceName, $description, $serviceId);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Service updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update service']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Service ID, name, and description are required']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 