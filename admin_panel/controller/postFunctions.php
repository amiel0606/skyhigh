<?php
include_once('./dbCon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

function approveAppointment($appointmentId)
{
    global $conn;

    $sql = "UPDATE tbl_appointments SET status = 'Confirmed' WHERE a_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();

    $sqlFetch = "SELECT username, name FROM tbl_appointments WHERE a_id = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("i", $appointmentId);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();
    $user = $result->fetch_assoc();

    if ($stmt->affected_rows > 0) {
        sendEmailNotification($user['username'], $user['name'], 'Confirmed');
        return $stmt->affected_rows;
    }

    return 0;
}

function declineAppointment($appointmentId, $reason)
{
    global $conn;

    $sql = "UPDATE tbl_appointments SET status = 'Declined', cancellation_reason = ? WHERE a_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reason, $appointmentId);
    $stmt->execute();

    $sqlFetch = "SELECT username, name FROM tbl_appointments WHERE a_id = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("i", $appointmentId);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();
    $user = $result->fetch_assoc();

    if ($stmt->affected_rows > 0) {
        sendEmailNotification($user['username'], $user['name'], 'Declined', $reason);
        return $stmt->affected_rows;
    }

    return true;
}

function updateOrder($id, $status) {
    global $conn;
    $sql = "UPDATE tbl_transactions SET status = ? WHERE t_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    return $stmt->affected_rows;
}

function sendEmailNotification($username, $name, $status, $reason = '')
{
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
        $mail->Subject = 'Your Appointment Status';

        $body = "Dear $name,<br><br>Your appointment has been $status.<br><br>";
        if (!empty($reason)) {
            $body .= "<strong>Reason:</strong> $reason<br><br>";
        }

        $body .= "If you have any questions or concerns, feel free to contact us.<br><br>Thank you for using our service.";

        $mail->Body = $body;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function addBrand($brandName) {
    global $conn;
    $sql = "INSERT INTO tbl_brands (brand_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $brandName);
    return $stmt->execute();
}

function updateBrand($brandId, $brandName) {
    global $conn;
    $sql = "UPDATE tbl_brands SET brand_name = ? WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $brandName, $brandId);
    return $stmt->execute();
}

function deleteBrand($brandId) {
    global $conn;
    $sql = "DELETE FROM tbl_brands WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brandId);
    return $stmt->execute();
}