<?php
// Include the necessary files
include_once('./dbCon.php');  // Database connection
include_once('./postFunctions.php');  // Post functions where the approveAppointment function is defined

// Check if the request method is POST and the appointmentId is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the appointmentId from the POST request
    $appointmentId = $_POST['appointmentId'];

    // Call the approveAppointment function to update the appointment status
    $result = approveAppointment($appointmentId);

    // Check if the update was successful
    if ($result > 0) {
        // Success, send a success response
        echo json_encode(['success' => true]);
    } else {
        // Failure, send a failure response
        echo json_encode(['success' => false, 'message' => 'Failed to update appointment']);
    }
} else {
    // Invalid request, send an error response
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}