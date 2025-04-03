<?php

require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once('./postFunctions.php');

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['payment_intent_id'], $input['status'])) {
    global $conn;
    $transactionId = $input['payment_intent_id'];
    $status = $input['status'];

    // Fetch user email
    $sql = "SELECT t.user_id, u.username, u.name 
            FROM tbl_transactions t 
            INNER JOIN tbl_users u ON t.user_id = u.uID 
            WHERE t.payment_intent_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $transactionId);
    $stmt->execute();
    $stmt->bind_result($userId, $username, $name);
    $stmt->fetch();
    $stmt->close();

    if ($username) {
        if (statusUpdate($transactionId, $status) > 0) {
            sendEmail($username, $name, $status);
            echo json_encode(["success" => true, "message" => "Status updated and email sent."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update status."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

function statusUpdate($id, $status)
{
    global $conn;
    $sql = "UPDATE tbl_transactions SET status = ? WHERE payment_intent_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $status, $id); 
    $stmt->execute();

    return $stmt->affected_rows;
}

function sendEmail($username, $name, $status, $reason = '')
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
        $mail->Subject = 'Your Order Status';

        $body = "Dear $name,<br><br>Your order status is now: $status.<br><br>";
        if (!empty($reason)) {
            $body .= "<strong>Reason:</strong> $reason<br><br>";
        }

        $body .= "If you have any questions or concerns, feel free to contact us.<br><br>Thank you for choosing Skyhigh Motorcycle Parts.";

        $mail->Body = $body;

        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
