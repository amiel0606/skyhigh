<?php
require_once './dbCon.php';

$query = "SELECT * FROM tbl_products ORDER BY product_id DESC";
$result = $conn->query($query);

$products = [];

while ($row = $result->fetch_assoc()) {
    $row['image'] = !empty($row['image']) ? "./uploads/" . $row['image'] : "./assets/images/default.png";
    $products[] = $row;
}

$conn->close();

echo json_encode($products);