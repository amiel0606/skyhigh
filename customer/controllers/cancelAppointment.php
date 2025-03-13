<?php
include_once("../../admin_panel/controller/dbCon.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['appointment_id']) || !isset($data['cancellation_reason'])) {
        echo json_encode(["error" => "Invalid data"]);
        exit;
    }

    $appointmentId = intval($data['appointment_id']);
    $cancellationReason = htmlspecialchars($data['cancellation_reason']);

    $stmt = $conn->prepare("UPDATE tbl_appointments SET status = 'Cancelled', cancellation_reason = ? WHERE a_id = ?");
    $stmt->bind_param("si", $cancellationReason, $appointmentId);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Appointment cancelled successfully."]);
    } else {
        echo json_encode(["error" => "Database error"]);
    }

    $stmt->close();
    $conn->close();
}