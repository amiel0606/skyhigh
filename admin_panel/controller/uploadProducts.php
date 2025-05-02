<?php
require_once './dbCon.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    $stock = intval($_POST['stock']);
    $brandName = trim($_POST['brand_name']);
    $status = 'Available'; 
    $defaultImage = 'default.png'; 
    $file = $_FILES['product_image'];

    if (!empty($file['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (!in_array($file['type'], $allowedTypes) || $file['size'] > 5000000) {
            die("Invalid file type or size too large.");
        }

        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); 
        }

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $imgName = uniqid('', true) . '.' . $fileExtension;
        $targetFilePath = $targetDir . $imgName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            $defaultImage = $imgName;
        } else {
            die("Error uploading file.");
        }
    }

    $sql = "INSERT INTO tbl_products (product_name, product_desc, price, product_category, stock, status, image, brand) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssdsssss", $productName, $description, $price, $category, $stock, $status, $defaultImage, $brandName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $conn->close();

    header("Location: ../index.php?upload=success");
    exit();
}