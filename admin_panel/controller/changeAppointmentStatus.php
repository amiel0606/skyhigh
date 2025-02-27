<?php
include_once('./dbCon.php');  
include_once('./postFunctions.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status']; 
    if ($status !== 'approved' && $status !== 'declined') {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        exit();
    }
    if ($status === 'approved') {
        $result = approveAppointment($appointmentId);
    } else {
        $result = declineAppointment($appointmentId);
    }

    if ($result > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update appointment']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}