<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo "<h2>Unauthorized Access</h2>";
    exit();
}

$user_id = $_SESSION['uID'];

if (!isset($_GET['payment_intent_id'])) {
    echo "<h2>Error</h2><p>Missing payment intent ID.</p>";
    exit();
}

$payment_intent_id = $_GET['payment_intent_id'];

$checkTxn = mysqli_query($conn, "SELECT * FROM tbl_transactions WHERE user_id = '$user_id' AND payment_intent_id = '$payment_intent_id'");
if (!$checkTxn || mysqli_num_rows($checkTxn) == 0) {
    echo "<h2>Error</h2><p>Invalid or unknown transaction.</p>";
    exit();
}

$txn = mysqli_fetch_assoc($checkTxn);
$totalPrice = $txn['total'];
$transactionUuid = $txn['uuid'];

$secretKey = "sk_test_zAzfhKKa6mFrGinRP72REyut";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payment_intents/$payment_intent_id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$response = curl_exec($ch);
curl_close($ch);

$paymentIntentResult = json_decode($response, true);

if (isset($paymentIntentResult["data"]["attributes"]["status"]) && $paymentIntentResult["data"]["attributes"]["status"] === "succeeded") {
    $sql = "SELECT product_id, quantity FROM tbl_carts WHERE user_id = '$user_id' AND status = 'Pending'";
    $result = mysqli_query($conn, $sql);

    $cartItems = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }

    if (empty($cartItems)) {
        echo "<h2>Error</h2><p>No pending items found in your cart.</p>";
        exit();
    }

    foreach ($cartItems as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        $updateStockSql = "UPDATE tbl_products SET stock = stock - $quantity WHERE product_id = '$product_id'";
        mysqli_query($conn, $updateStockSql);

        $updateCartStatusSql = "
            UPDATE tbl_carts 
            SET status = 'Paid', transID = '$payment_intent_id'  
            WHERE user_id = '$user_id' 
            AND product_id = '$product_id' 
            AND status = 'Pending'";
        mysqli_query($conn, $updateCartStatusSql);
    }

    $updateTransactionStatusSql = "
        UPDATE tbl_transactions 
        SET status = 'Paid' 
        WHERE uuid = '$transactionUuid' AND user_id = '$user_id'";
    mysqli_query($conn, $updateTransactionStatusSql);

    echo "<script>
        alert('Success Payment');
        window.location.href = '../userCart.php';
    </script>";
    exit();
} else {
    echo "<h2>Error</h2><p>Payment was not successful. Please try again.</p>";
    exit();
}