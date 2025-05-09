<?php
require_once './dbCon.php';

$query = "SELECT p.*, b.brand_name 
FROM tbl_products p 
LEFT JOIN tbl_brands b ON p.brand = b.b_id 
ORDER BY p.product_id DESC";
$result = $conn->query($query);

$products = [];

while ($row = $result->fetch_assoc()) {
    $row['image'] = !empty($row['image']) ? "./uploads/" . $row['image'] : "./assets/images/default.png";
    $products[] = $row;
}

$conn->close();

echo json_encode($products);