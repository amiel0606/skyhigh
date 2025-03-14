<?php
include_once("../../admin_panel/controller/dbCon.php");

$conn->query("UPDATE tbl_products SET status = 'unavailable' WHERE stock < 1");

$categoriesQuery = "SELECT DISTINCT product_category FROM tbl_products";
$categoriesResult = $conn->query($categoriesQuery);
$categories = [];

while ($row = $categoriesResult->fetch_assoc()) {
    $categories[] = $row['product_category'];
}

$lowStockQuery = "SELECT * FROM tbl_products WHERE status = 'Available' AND stock > 0";
$lowStockResult = $conn->query($lowStockQuery);
$products = [];

while ($row = $lowStockResult->fetch_assoc()) {
    $row['image'] = !empty($row['image']) ? "./uploads/" . $row['image'] : "./assets/images/default.png";
    $products[] = $row;
}

$conn->close();

echo json_encode([
    'categories' => $categories,
    'products' => $products
]);
