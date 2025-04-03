<?php
include_once('./getFunctions.php'); 

$payments = getAllPayments();

$response = [
    'payments' => $payments ? $payments : [] 
];

header('Content-Type: application/json');

echo json_encode($response);
