<?php
require_once './dbCon.php';

// Support JSON input (application/json)
if (empty($_POST) && isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['products'])) {
        $_POST['products'] = $input['products'];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Case 1: Handle product info update (from JSON body via `$_POST['products']`)
    if (isset($_POST['products'])) {
        $products = json_decode($_POST['products'], true);

        if (!empty($products)) {
            foreach ($products as $product) {
                $id = $product['id'];
                $name = $product['name'];
                $description = $product['description'];
                $price = $product['price'];
                $category = $product['category'];
                $stock = $product['stock'];
                $brand = $product['brand'];

                $stmt = $conn->prepare("UPDATE tbl_products SET product_name = ?, product_desc = ?, price = ?, product_category = ?, stock = ?, brand = ? WHERE product_id = ?");
                $stmt->bind_param("ssssssi", $name, $description, $price, $category, $stock, $brand, $id);
                $stmt->execute();
            }

            echo json_encode(["success" => true, "message" => "Products updated successfully!"]);
            exit;
        }
    }

    if (isset($_POST['product_id']) && isset($_FILES['product_image'])) {
        $productId = $_POST['product_id'];
        $image = $_FILES['product_image'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($image['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid image type']);
            exit;
        }

        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('product_', true) . '.' . $ext;
        $uploadDir = '../uploads/';
        $uploadPath = $uploadDir . $newFileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $stmt = $conn->prepare("UPDATE tbl_products SET image = ? WHERE product_id = ?");
            $stmt->bind_param("si", $newFileName, $productId);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Image uploaded successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'No valid data provided']);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
