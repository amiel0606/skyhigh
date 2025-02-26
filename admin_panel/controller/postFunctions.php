<?php
include_once('./dbCon.php');

function approveAppointment($appointmentId) {
    global $conn;
    $sql = "UPDATE tbl_appointments SET status = 'Confirmed' WHERE a_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();

    return $stmt->affected_rows;
}