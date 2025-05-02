<?php
include_once("../../admin_panel/controller/dbCon.php");

$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$sort = isset($_GET['sort']) ? strtolower($_GET['sort']) : '';

$query = "SELECT * FROM tbl_products WHERE status = 'Available' AND stock > 0";
if (!empty($brand)) {
    $query .= " AND brand = '" . $conn->real_escape_string($brand) . "'";
}
if ($sort === 'asc') {
    $query .= " ORDER BY price ASC";
} elseif ($sort === 'desc') {
    $query .= " ORDER BY price DESC";
}

$result = $conn->query($query);
$products = [];

while ($row = $result->fetch_assoc()) {
    $row['image'] = !empty($row['image']) ? "./uploads/" . $row['image'] : "./assets/images/default.png";
    $products[] = $row;
}

$brandsQuery = "SELECT brand, COUNT(*) as product_count 
                FROM tbl_products 
                WHERE status = 'Available' AND stock > 0 
                GROUP BY brand";
$brandsResult = $conn->query($brandsQuery);
$brands = [];

while ($row = $brandsResult->fetch_assoc()) {
    $brands[] = [
        'name' => $row['brand'],
        'count' => $row['product_count']
    ];
}

$conn->close();

echo json_encode([
    'brands' => $brands,
    'products' => $products
]); 