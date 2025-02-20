<?php
include_once('./dbCon.php');
function getSchedules() {
    global $conn;
    $sql = "SELECT * FROM tbl_appointments ORDER BY date, time DESC";
    $result = $conn->query($sql);

    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    return $schedules;
}

function searchSchedules($query) {
    global $conn;
    $query = "%" . $conn->real_escape_string($query) . "%";
    $sql = "SELECT * FROM tbl_appointments 
            WHERE name LIKE ? OR address LIKE ? OR contact LIKE ? 
            ORDER BY date, time DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    return $schedules;
}

function getScheduleById($id) {
    global $conn;
    $sql = "SELECT * FROM tbl_appointments WHERE a_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function closeConnection() {
    global $conn;
    $conn->close();
}