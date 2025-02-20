<?php
header("Content-Type: application/json");
include_once('./getFunctions.php'); 

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if (!empty($searchQuery)) {
    $schedules = searchSchedules($searchQuery); 
} else {
    $schedules = getSchedules(); 
}

echo json_encode($schedules);