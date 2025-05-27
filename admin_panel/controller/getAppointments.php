<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';

if ($filter === 'week') {
    $appointments = getAppointmentsCountByDayOfWeek();
} else {
    $appointments = getAppointmentsCountByMonth();
}
echo json_encode($appointments);