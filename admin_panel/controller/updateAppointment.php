<?php
require_once './dbCon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentId = mysqli_real_escape_string($conn, $_POST['appointmentId']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $vehicle = mysqli_real_escape_string($conn, $_POST['vehicle']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    
    if (empty($appointmentId) || empty($name) || empty($username) || empty($address) || empty($contact) || empty($vehicle) || empty($service) || empty($time) || empty($date)) {
        echo json_encode(value: ["status" => "error", "message" => "Please fill in all the fields."]);
        exit();
    }

    $sql = "UPDATE tbl_appointments 
            SET name = ?, username = ?, address = ?, contact = ?, vehicle = ?, service = ?, time = ?, date = ? 
            WHERE appointmentId = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssssi", $name, $username, $address, $contact, $vehicle, $service, $time, $date, $appointmentId);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Appointment updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update the appointment."]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to prepare the SQL statement."]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit();
}
