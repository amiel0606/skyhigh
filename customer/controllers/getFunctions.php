<?php
include_once("../../admin_panel/controller/dbCon.php");
function gettAppointByUser($username) {
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