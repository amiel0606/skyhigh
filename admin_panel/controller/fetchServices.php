<?php
require_once './dbCon.php';

$sql = "SELECT s_id, service_name, description FROM tbl_services";
$result = $conn->query($sql);
$services = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}
$conn->close();
echo json_encode($services); 