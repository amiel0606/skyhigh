<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['uID'];
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$action = $data['action'];

if ($action === "increase") {
    // Check if increasing quantity would exceed available stock
    $stock_query = "SELECT stock FROM tbl_products WHERE product_id = '$product_id'";
    $stock_result = mysqli_query($conn, $stock_query);
    
    if (mysqli_num_rows($stock_result) > 0) {
        $stock_row = mysqli_fetch_assoc($stock_result);
        $available_stock = $stock_row['stock'];
        
        // Get current cart quantity
        $cart_query = "SELECT quantity FROM tbl_carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $cart_result = mysqli_query($conn, $cart_query);
        
        if (mysqli_num_rows($cart_result) > 0) {
            $cart_row = mysqli_fetch_assoc($cart_result);
            $current_quantity = $cart_row['quantity'];
            
            if ($current_quantity >= $available_stock) {
                echo json_encode(["success" => false, "message" => "Cannot increase quantity. Stock limit reached."]);
                exit();
            }
        }
    }
    
    $query = "UPDATE tbl_carts SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
} elseif ($action === "decrease") {
    $query = "UPDATE tbl_carts SET quantity = GREATEST(quantity - 1, 1) WHERE user_id = '$user_id' AND product_id = '$product_id'";
} elseif ($action === "delete") {
    $query = "DELETE FROM tbl_carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    exit();
}

if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true, "message" => "Cart updated"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}

mysqli_close($conn);