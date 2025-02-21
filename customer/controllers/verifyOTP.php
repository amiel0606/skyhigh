<?php
require_once '../../admin_panel/controller/dbCon.php';
session_start();

if (!isset($_SESSION["uID"]) || !isset($_POST["otp"])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$otpSent = trim($_POST["otp"]);
$uID = $_SESSION["uID"];

$sql = "SELECT otp FROM tbl_users WHERE uID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uID);
$stmt->execute();
$stmt->bind_result($storedOtp);
$stmt->fetch();
$stmt->close();



if ($storedOtp == $otpSent) {
    $updateSql = "UPDATE tbl_users SET verified = 'true' WHERE uID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("s", $uID);
    
    if ($updateStmt->execute()) {
        $_SESSION["verified"] = "true"; 
        echo json_encode(["status" => "success", "message" => "OTP verified successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update verification status"]);
    }
    
    $updateStmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid OTP"]);
}

$conn->close();