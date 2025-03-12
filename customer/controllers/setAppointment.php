<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
require_once '../../admin_panel/controller/dbCon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $vehicle = mysqli_real_escape_string($conn, $_POST['vehicle']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    if (empty($name) || empty($username) || empty($address) || empty($contact) || empty($vehicle) || empty($service) || empty($time) || empty($date)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    }

    $sql = "INSERT INTO tbl_appointments (name, username, address, contact, vehicle, service, time, date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $username, $address, $contact, $vehicle, $service, $time, $date);

        if (mysqli_stmt_execute($stmt)) {
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
                $mail->Subject = 'Your Appointment has been successfully set';
                $mail->Body = "
                    <p>Hello $name,</p>
                    <p>Your appointment has been successfully set.</p>
                    <p>Vehicle: $vehicle</p>
                    <p>Service: $service</p>
                    <p>Time: $time</p>
                    <p>Date: $date</p>  
                    <p>Thank you.</p>
                ";
                $mail->send();
            } catch (Exception $e) {
                error_log("Email sending failed: " . $mail->ErrorInfo);
            }
            header("Location: ../index.php?error=none");
            exit();
        } else {
            header("Location: ../index.php?error=queryfailed");
            exit();
        }
    } else {
        header("Location: ../index.php?error=preparefailed");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}