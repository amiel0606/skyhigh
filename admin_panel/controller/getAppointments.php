<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
$detailed = isset($_GET['detailed']) ? $_GET['detailed'] : false;

// If detailed data is requested (for table view)
if ($detailed) {
    $appointments = getDetailedAppointmentsData($startDate, $endDate);
    echo json_encode($appointments);
    exit;
}

// For chart data
if ($startDate && $endDate) {
    $appointments = getAppointmentsCountByDateRange($startDate, $endDate);
} else {
    switch ($filter) {
        case 'daily':
            $appointments = getAppointmentsCountByDay(30);
            break;
        case 'week':
            $appointments = getAppointmentsCountByDayOfWeek();
            break;
        case 'yearly':
            $appointments = getAppointmentsCountByYear();
            break;
        case 'month':
        default:
            $appointments = getAppointmentsCountByMonth();
            break;
    }
}

echo json_encode($appointments);