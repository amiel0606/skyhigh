<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
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

        $check_query = "SELECT quantity FROM tbl_carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $new_quantity = $row['quantity'] + $quantity;
            $update_query = "UPDATE tbl_carts SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";

            if (mysqli_query($conn, $update_query)) {
                echo json_encode(["success" => true, "message" => "Cart updated."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update cart."]);
            }
        } else {
            $insert_query = "INSERT INTO tbl_carts (user_id, product_id, product_name, product_price, quantity) 
                             VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity')";

            if (mysqli_query($conn, $insert_query)) {
                echo json_encode(["success" => true, "message" => "Product added to cart."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add product to cart."]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request data."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

mysqli_close($conn);