<?php
session_start();
require_once './functions.php';
require_once '../../admin_panel/controller/dbCon.php';

if (!isset($_SESSION["username"]) || !isset($_SESSION["uID"])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$email = $_SESSION["username"];
$user_ID = $_SESSION["uID"];

$otp = mt_rand(100000, 999999);

$sql = "UPDATE tbl_users SET otp = ? WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $otp, $user_ID);

if ($stmt->execute()) {
    sendOTPEmail($email, $otp);
    echo json_encode(["status" => "success", "message" => "OTP resent successfully"]);

} else {
    echo json_encode(["status" => "error", "message" => "Failed to update OTP"]);
}

$stmt->close();
$conn->close();