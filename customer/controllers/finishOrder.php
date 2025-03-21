<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo "<h2>Unauthorized Access</h2>";
    exit();
}

$user_id = $_SESSION['uID'];
$date = date("Y-m-d H:i:s");

$sql = "SELECT product_id, quantity, product_price FROM tbl_carts WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

$cartItems = [];
$totalPrice = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
    $totalPrice += $row['product_price'] * $row['quantity'];
}

if ($totalPrice <= 0) {
    echo "<h2>Error</h2><p>No items found in your cart.</p>";
    exit();
}

$insertSql = "INSERT INTO tbl_transactions (user_id, date, total) VALUES ('$user_id', '$date', '$totalPrice')";
if (mysqli_query($conn, $insertSql)) {
    foreach ($cartItems as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        $updateStockSql = "UPDATE tbl_products SET stock = stock - $quantity WHERE product_id = '$product_id'";
        mysqli_query($conn, $updateStockSql);
    }

    mysqli_query($conn, "DELETE FROM tbl_carts WHERE user_id = '$user_id'");

    echo "<script>window.location.href = '../userCart.php';
    alert('Success Payment');
    </script>";
    exit();

} else {
    echo "<h2>Error</h2><p>Failed to record transaction.</p>";
}

mysqli_close($conn);
