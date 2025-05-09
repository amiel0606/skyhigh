<?php
include_once('./dbCon.php');  
include_once('./postFunctions.php'); 

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$appointmentId = $_POST['appointmentId'] ?? null;
$status = $_POST['status'] ?? null;
$reason = $_POST['reason'] ?? null;

if (!$appointmentId || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit();
}

$validStatuses = ['Confirmed', 'declined'];
if (!in_array($status, $validStatuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit();
}

if ($status === 'declined' && !$reason) {
    echo json_encode(['success' => false, 'message' => 'Reason is required for declining an appointment']);
    exit();
}

try {
    $result = ($status === 'Confirmed') 
        ? approveAppointment($appointmentId) 
        : declineAppointment($appointmentId, $reason);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Appointment status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update appointment status']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating appointment: ' . $e->getMessage()]);
}
