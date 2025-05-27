<?php
require_once './dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $serviceId = $data['service_id'] ?? null;

    if ($serviceId) {
        $stmt = $conn->prepare("DELETE FROM tbl_services WHERE s_id = ?");
        $stmt->bind_param("i", $serviceId);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Service deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete service']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Service ID is required']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 