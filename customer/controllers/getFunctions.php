<?php
include_once("../../admin_panel/controller/dbCon.php");

function gettAppointByUser($username)
{
    global $conn;
    $sql = "SELECT * FROM tbl_appointments WHERE username = ? ORDER BY date, time DESC";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return ["error" => "Failed to prepare statement"];
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
    return $appointments;
}

function getOrders($user_id, $status = 'ALL')
{
    global $conn;

    $sql = "
        SELECT 
            c.transID, 
            p.product_name, 
            p.product_desc, 
            p.image, 
            p.price, 
            c.quantity, 
            t.status
        FROM tbl_carts c
        INNER JOIN tbl_products p ON c.product_id = p.product_id
        INNER JOIN tbl_transactions t ON c.transID = t.payment_intent_id
        WHERE c.user_id = ?
    ";
    
    if ($status !== 'ALL') {
        $sql .= " AND t.status = ?";
    }
    
    $sql .= " ORDER BY c.transID";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return ["error" => "Failed to prepare statement"];
    }

    if ($status === 'ALL') {
        $stmt->bind_param("i", $user_id);
    } else {
        $stmt->bind_param("is", $user_id, $status);
    }
    
    $stmt->execute();

    $result = $stmt->get_result();
    $groupedOrders = [];

    while ($row = $result->fetch_assoc()) {
        $transID = $row['transID'];
        if (!isset($groupedOrders[$transID])) {
            $groupedOrders[$transID] = [];
        }
        $groupedOrders[$transID][] = [
            "name" => $row['product_name'],
            "description" => $row['product_desc'],
            "image" => $row['image'],
            "original_price" => $row['price'],
            "quantity" => $row['quantity'],
            "status" => $row['status'], 
            "transID" => $row['transID']
        ];
    }

    return $groupedOrders;
}
