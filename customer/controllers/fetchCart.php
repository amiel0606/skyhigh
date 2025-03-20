<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['uID'];

$sql = "SELECT c.product_id, p.product_name, p.price, p.image AS product_image, c.quantity, 
               (p.price * c.quantity) AS total_price
        FROM tbl_carts c
        INNER JOIN tbl_products p ON c.product_id = p.product_id
        WHERE c.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

$cartItems = [];
$totalPrice = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $totalPrice += $row['total_price'];
    $cartItems[] = $row;
}

echo json_encode(["success" => true, "cartItems" => $cartItems, "totalPrice" => $totalPrice]);

mysqli_close($conn);