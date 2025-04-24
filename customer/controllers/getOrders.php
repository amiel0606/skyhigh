<?php
session_start();
require_once 'getFunctions.php';
require_once "../../admin_panel/controller/dbCon.php";

if (!isset($_SESSION['uID'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$status = isset($_GET['status']) ? $_GET['status'] : 'ALL';

$orders = getOrders($_SESSION['uID'], $status);

header('Content-Type: application/json');
echo json_encode($orders);