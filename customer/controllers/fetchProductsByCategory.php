<?php
include_once("../../admin_panel/controller/dbCon.php");

// Get category from request
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch products by category
$query = "SELECT * FROM tbl_products WHERE status = 'Available' AND stock > 0";
if (!empty($category)) {
    $query .= " AND product_category = '" . $conn->real_escape_string($category) . "'";
}

$result = $conn->query($query);
$products = [];

while ($row = $result->fetch_assoc()) {
    $row['image'] = !empty($row['image']) ? "./uploads/" . $row['image'] : "./assets/images/default.png";
    $products[] = $row;
}

// Fetch all categories with product count
$categoriesQuery = "SELECT product_category, COUNT(*) as product_count 
                   FROM tbl_products 
                   WHERE status = 'Available' AND stock > 0 
                   GROUP BY product_category";
$categoriesResult = $conn->query($categoriesQuery);
$categories = [];

while ($row = $categoriesResult->fetch_assoc()) {
    $categories[] = [
        'name' => $row['product_category'],
        'count' => $row['product_count']
    ];
}

$conn->close();

echo json_encode([
    'categories' => $categories,
    'products' => $products
]); 