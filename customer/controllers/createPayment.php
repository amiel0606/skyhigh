<?php
session_start();
include_once("../../admin_panel/controller/dbCon.php");

if (!isset($_SESSION['uID'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['uID'];
$date = date("Y-m-d H:i:s");

$userQuery = "SELECT name, username, contact FROM tbl_users WHERE uID = '$user_id'";
$userResult = mysqli_query($conn, $userQuery);

if (!$userResult || mysqli_num_rows($userResult) == 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit();
}

$userData = mysqli_fetch_assoc($userResult);
$user_name = $userData['name'];
$user_email = $userData['username'];
$user_contact = $userData['contact'];

$sql = "SELECT SUM(product_price * quantity) AS total FROM tbl_carts WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalPrice = $row['total'] * 100;

if ($totalPrice <= 0) {
    echo json_encode(["success" => false, "message" => "No items in cart"]);
    exit();
}

$secretKey = "sk_test_zAzfhKKa6mFrGinRP72REyut"; 

$intent_data = [
    "data" => [
        "attributes" => [
            "amount" => $totalPrice,
            "payment_method_allowed" => ["gcash"],
            "currency" => "PHP",
            "capture_type" => "automatic",
            "description" => "Order Payment",
            "statement_descriptor" => "MyStore",
        ]
    ]
];

$intent_payload = json_encode($intent_data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payment_intents");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $intent_payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$response = curl_exec($ch);
curl_close($ch);

$intent_result = json_decode($response, true);

if (!isset($intent_result["data"]["id"])) {
    echo json_encode(["success" => false, "message" => "Failed to create payment intent", "error" => $response]);
    exit();
}

$payment_intent_id = $intent_result["data"]["id"];
$client_key = $intent_result["data"]["attributes"]["client_key"];

$transactionUuid = uniqid('txn_', true);  
$insertTransactionSql = "INSERT INTO tbl_transactions (user_id, total, uuid, payment_intent_id) 
                         VALUES ('$user_id', '$totalPrice', '$transactionUuid', '$payment_intent_id')";

if (mysqli_query($conn, $insertTransactionSql)) {
} else {
    echo json_encode(["success" => false, "message" => "Failed to insert transaction into database", "error" => mysqli_error($conn)]);
    exit();
}

$method_data = [
    "data" => [
        "attributes" => [
            "type" => "gcash",
            "billing" => [
                "name" => $user_name,
                "email" => $user_email,
                "phone" => $user_contact 
            ]
        ]
    ]
];

$method_payload = json_encode($method_data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payment_methods");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $method_payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$method_response = curl_exec($ch);
curl_close($ch);

$method_result = json_decode($method_response, true);

if (!isset($method_result["data"]["id"])) {
    echo json_encode(["success" => false, "message" => "Failed to create payment method", "error" => $method_response]);
    exit();
}

$payment_method_id = $method_result["data"]["id"];

$attach_data = [
    "data" => [
        "attributes" => [
            "payment_method" => $payment_method_id,
            "client_key" => $client_key,
            "return_url" => "http://localhost/skyhigh/customer/controllers/finishOrder.php" 
        ]
    ]
];

$attach_payload = json_encode($attach_data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payment_intents/$payment_intent_id/attach");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $attach_payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$attach_response = curl_exec($ch);
curl_close($ch);

$attach_result = json_decode($attach_response, true);

if (isset($attach_result["data"]["attributes"]["next_action"]["redirect"]["url"])) {
    echo json_encode([
        "success" => true,
        "redirect_url" => $attach_result["data"]["attributes"]["next_action"]["redirect"]["url"],
        "payment_intent_id" => $payment_intent_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to attach payment method",
        "error" => $attach_response
    ]);
}