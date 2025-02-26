<?php
header("Content-Type: application/json");
include_once('./getFunctions.php'); 

$appointmentId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($appointmentId > 0) {
    $schedule = getScheduleById($appointmentId);
    echo json_encode($schedule);
} else {
    if (!empty($searchQuery)) {
        $schedules = searchSchedules($searchQuery); 
    } else {
        $schedules = getSchedules(); 
    }
    echo json_encode($schedules); 
}
