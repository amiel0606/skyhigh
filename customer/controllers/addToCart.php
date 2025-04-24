<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

// Check if user is logged in
if (!isset($_SESSION['uID'])) {
    echo json_encode([
        "success" => false, 
        "message" => "You must be logged in to add items to cart.", 
        "requireLogin" => true
    ]);
    exit();
}

$user_id = $_SESSION['uID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['product_id'], $data['product_name'], $data['product_price'])) {
        $product_id = $data['product_id'];
        $product_name = $data['product_name'];
        $product_price = $data['product_price'];
        $quantity = 1; 

        // Check if product exists and get its stock
        $stock_query = "SELECT stock FROM tbl_products WHERE product_id = '$product_id'";
        $stock_result = mysqli_query($conn, $stock_query);
        
        if (mysqli_num_rows($stock_result) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_result);
            $available_stock = $stock_row['stock'];
            
            if ($available_stock <= 0) {
                echo json_encode([
                    "success" => false, 
                    "message" => "Product is out of stock.", 
                    "notification" => [
                        "type" => "error",
                        "title" => "Out of Stock",
                        "message" => "This product is currently out of stock."
                    ]
                ]);
                exit();
            }
            
            $check_query = "SELECT quantity FROM tbl_carts WHERE user_id = '$user_id' AND product_id = '$product_id' AND status != 'Paid'";
            $result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $new_quantity = $row['quantity'] + $quantity;
                
                if ($new_quantity > $available_stock) {
                    echo json_encode([
                        "success" => false, 
                        "message" => "Cannot add more items. Stock limit reached.", 
                        "notification" => [
                            "type" => "warning",
                            "title" => "Stock Limit Reached",
                            "message" => "You already have the maximum available quantity in your cart."
                        ]
                    ]);
                    exit();
                }
                
                $update_query = "UPDATE tbl_carts SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";

                if (mysqli_query($conn, $update_query)) {
                    echo json_encode([
                        "success" => true, 
                        "message" => "Cart updated.", 
                        "notification" => [
                            "type" => "success",
                            "title" => "Cart Updated",
                            "message" => "Quantity updated in your cart."
                        ]
                    ]);
                } else {
                    echo json_encode([
                        "success" => false, 
                        "message" => "Failed to update cart.", 
                        "notification" => [
                            "type" => "error",
                            "title" => "Update Failed",
                            "message" => "Failed to update your cart. Please try again."
                        ]
                    ]);
                }
            } else {
                $insert_query = "INSERT INTO tbl_carts (user_id, product_id, product_name, product_price, quantity) 
                                VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity')";

                if (mysqli_query($conn, $insert_query)) {
                    echo json_encode([
                        "success" => true, 
                        "message" => "Product added to cart.", 
                        "notification" => [
                            "type" => "success",
                            "title" => "Added to Cart",
                            "message" => "$product_name has been added to your cart."
                        ]
                    ]);
                } else {
                    echo json_encode([
                        "success" => false, 
                        "message" => "Failed to add product to cart.", 
                        "notification" => [
                            "type" => "error",
                            "title" => "Add Failed",
                            "message" => "Failed to add product to your cart. Please try again."
                        ]
                    ]);
                }
            }
        } else {
            echo json_encode([
                "success" => false, 
                "message" => "Product not found.", 
                "notification" => [
                    "type" => "error",
                    "title" => "Product Not Found",
                    "message" => "The product you're trying to add doesn't exist."
                ]
            ]);
        }
    } else {
        echo json_encode([
            "success" => false, 
            "message" => "Invalid request data.", 
            "notification" => [
                "type" => "error",
                "title" => "Invalid Request",
                "message" => "The request data is invalid. Please try again."
            ]
        ]);
    }
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Invalid request method.", 
        "notification" => [
            "type" => "error",
            "title" => "Invalid Method",
            "message" => "The request method is invalid. Please try again."
        ]
    ]);
}

mysqli_close($conn);