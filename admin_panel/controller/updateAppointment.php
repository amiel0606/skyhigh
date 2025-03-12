<?php
require_once './dbCon.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; 

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
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    if (empty($appointmentId) || empty($name) || empty($username) || empty($address) || empty($contact) || empty($vehicle) || empty($reason) || empty($service) || empty($time) || empty($date)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all the fields."]);
        exit();
    }

    $sql = "UPDATE tbl_appointments 
            SET name = ?, username = ?, address = ?, contact = ?, vehicle = ?, service = ?, time = ?, date = ?, status = 'Pending', cancellation_reason = ?
            WHERE a_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssi", $name, $username, $address, $contact, $vehicle, $service, $time, $date, $reason, $appointmentId);

        if (mysqli_stmt_execute($stmt)) {
            sendEmailNotification($username, $name, $service, $date, $time, $reason);
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

function sendEmailNotification($username, $name, $service, $date, $time, $reason) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = 'otp.skyhigh@gmail.com';  
        $mail->Password = 'xgwuumprorznbwvc';     
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;  

        $mail->setFrom('otp.skyhigh@gmail.com', 'Skyhigh Motorcycle Parts');
        $mail->addAddress($username);

        $mail->isHTML(true);
        $mail->Subject = 'Your Appointment has been Rescheduled';
        $mail->Body    = "Dear $name,<br><br>Your appointment has been rescheduled to <strong>$date</strong> at <strong>$time</strong> for the following service: <strong>$service</strong> for the following reason/s: $reason .<br><br>If you have any questions, feel free to contact us.<br><br>Thank you for using our service.";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}