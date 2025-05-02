<?php
include_once('./dbCon.php');

header('Content-Type: application/json');

if (!isset($_GET['date'])) {
    echo json_encode(['success' => false, 'message' => 'Date parameter is required']);
    exit;
}

$date = $_GET['date'];

try {
    $stmt = $conn->prepare("SELECT time FROM tbl_appointments WHERE date = ? AND status != 'Declined'");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedSlots = [];
    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = $row['time'];
    }

    echo json_encode([
        'success' => true,
        'bookedSlots' => $bookedSlots
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error checking time slots'
    ]);
}