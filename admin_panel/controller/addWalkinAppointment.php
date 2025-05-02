<?php
session_start();
include_once('./dbCon.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    $name = $_POST['name'] ?? '';
    $email = $_POST['username'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $vehicle = $_POST['vehicle'] ?? '';
    $service = $_POST['service'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $status = 'Pending';
    $type = 'Walk-in';

    if (
        empty($name) || empty($email) || empty($address) || empty($contact) ||
        empty($vehicle) || empty($service) || empty($date) || empty($time)
    ) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

    if (!preg_match('/^09[0-9]{9}$/', $contact)) {
        echo json_encode(['success' => false, 'message' => 'Invalid phone number format']);
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_appointments WHERE date = ? AND time = ? AND status != 'Declined'");
    $stmt->execute([$date, $time]);
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];

    if ($count > 0) {
        echo json_encode(['success' => false, 'message' => 'This time slot is already booked']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO tbl_appointments (name, username, address, contact, vehicle, service, date, time, status, type) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([$name, $email, $address, $contact, $vehicle, $service, $date, $time, $status, $type]);

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Walk-in appointment added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add walk-in appointment']);
    }

} catch (PDOException $e) {
    error_log("Error in addWalkinAppointment.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request']);
}