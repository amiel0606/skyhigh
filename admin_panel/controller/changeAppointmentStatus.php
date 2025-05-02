<?php
include_once('./dbCon.php');  
include_once('./postFunctions.php'); 

header('Content-Type: application/json');
$reason = $_POST['reason'] ?? null;
$status = $_POST['status'] ?? null;
$appointmentId = $_POST['appointmentId'] ?? null;

if ($status === 'declined' && !$reason) {
    echo json_encode(['success' => false, 'message' => 'Reason is required for declining an appointment']);
    exit();
}

$result = ($status === 'Confirmed') 
    ? approveAppointment($appointmentId) 
    : declineAppointment($appointmentId, $reason);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$appointmentId = $_POST['appointmentId'] ?? null;
$status = $_POST['status'] ?? null;

if (!$appointmentId || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit();
}

$validStatuses = ['Confirmed', 'declined'];
if (!in_array($status, $validStatuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit();
}

$result = ($status === 'Confirmed') ? approveAppointment($appointmentId) : declineAppointment($appointmentId, $reason);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Appointment status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update appointment']);
}
