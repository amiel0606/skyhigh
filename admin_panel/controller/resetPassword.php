<?php
include_once('./dbCon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';

    // Validate required fields
    if (empty($userId)) {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
        exit();
    }

    // Get user details
    $getUserSql = "SELECT name, username FROM tbl_users WHERE uID = ?";
    $getUserStmt = $conn->prepare($getUserSql);
    $getUserStmt->bind_param("s", $userId);
    $getUserStmt->execute();
    $userResult = $getUserStmt->get_result();

    if ($userResult->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit();
    }

    $user = $userResult->fetch_assoc();
    $userName = $user['name'];
    $username = $user['username'];
    $userEmail = $username; // Username is the email

    if (empty($userEmail)) {
        echo json_encode(['status' => 'error', 'message' => 'User email not found']);
        exit();
    }

    // Generate random password
    $newPassword = generateRandomPassword();
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in database
    $updateSql = "UPDATE tbl_users SET password = ? WHERE uID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $hashedPassword, $userId);

    if ($updateStmt->execute()) {
        // Send email with new password
        $emailSent = sendPasswordResetEmail($userEmail, $userName, $username, $newPassword);
        
        if ($emailSent) {
            echo json_encode(['status' => 'success', 'message' => 'Password reset successfully. New password sent to user email.']);
        } else {
            echo json_encode(['status' => 'warning', 'message' => 'Password reset but failed to send email. New password: ' . $newPassword]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to reset password']);
    }

    $updateStmt->close();
    $getUserStmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

function generateRandomPassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

function sendPasswordResetEmail($email, $name, $username, $newPassword) {
    require_once __DIR__ . '/../../vendor/autoload.php'; 
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'otp.skyhigh@gmail.com';
        $mail->Password = 'xgwuumprorznbwvc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('otp.skyhigh@gmail.com', 'Skyhigh Motorcycle Parts');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset - SkyHigh Admin';

        $body = "Dear $name,<br><br>Your password has been reset by an administrator.<br><br>";
        $body .= "<strong>Username:</strong> $username<br>";
        $body .= "<strong>New Password:</strong> $newPassword<br><br>";
        $body .= "Please log in with your new password and change it immediately for security purposes.<br><br>";
        $body .= "If you have any questions or concerns, feel free to contact us.<br><br>Best regards,<br>SkyHigh Admin Team";

        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$conn->close();