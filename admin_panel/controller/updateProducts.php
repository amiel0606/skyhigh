<?php
require_once './dbCon.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $products = json_decode($_POST['products'], true);

    if (!empty($products)) {
        foreach ($products as $product) {
            $id = $product['id'];
            $name = $product['name'];
            $description = $product['description'];
            $price = $product['price'];
            $category = $product['category'];
            $stock = $product['stock'];

            $stmt = $conn->prepare("UPDATE tbl_products SET product_name = ?, product_desc = ?, price = ?, product_category = ?, stock = ? WHERE product_id = ?");
            $stmt->bind_param("sssssi", $name, $description, $price, $category, $stock, $id);
            $stmt->execute();
        }
        echo "Products updated successfully!";
    } else {
        echo "No products received.";
    }
} else {
    echo "Invalid request.";
}