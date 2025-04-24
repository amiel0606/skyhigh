<?php
include_once("../../admin_panel/controller/dbCon.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['transID'])) {
    echo json_encode(["error" => "Missing transID"]);
    exit;
}

$transID = $data['transID'];

$sql = "UPDATE tbl_transactions SET status = 'Completed' WHERE payment_intent_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare statement"]);
    exit;
}

$stmt->bind_param("s", $transID);
$success = $stmt->execute();

if ($success) {
    echo json_encode(["success" => true, "message" => "Status updated"]);
} else {
    echo json_encode(["error" => "Failed to update status"]);
}
