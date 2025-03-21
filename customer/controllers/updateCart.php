<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['uID'];
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$action = $data['action'];

if ($action === "increase") {
    $query = "UPDATE tbl_carts SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
} elseif ($action === "decrease") {
    $query = "UPDATE tbl_carts SET quantity = GREATEST(quantity - 1, 1) WHERE user_id = '$user_id' AND product_id = '$product_id'";
} elseif ($action === "delete") {
    $query = "DELETE FROM tbl_carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    exit();
}

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Cart updated"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}

mysqli_close($conn);