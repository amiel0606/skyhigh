<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['uID'];

$sql = "SELECT c.product_id, c.quantity, c.product_price, p.stock, p.product_name, p.image 
        FROM tbl_carts c 
        JOIN tbl_products p ON c.product_id = p.product_id
        WHERE c.user_id = '$user_id' AND c.status != 'Paid'";
$result = mysqli_query($conn, $sql);

$cartItems = [];
$totalPrice = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = [
        "product_id" => $row['product_id'],
        "quantity" => $row['quantity'],
        "price" => $row['product_price'],
        "total_price" => $row['product_price'] * $row['quantity'],
        "product_name" => $row['product_name'],
        "product_image" => $row['image'],
        "stock" => $row['stock']  
    ];
    $totalPrice += $row['product_price'] * $row['quantity'];
}

echo json_encode(["success" => true, "cartItems" => $cartItems, "totalPrice" => $totalPrice]);

mysqli_close($conn);