<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
$detailed = isset($_GET['detailed']) ? $_GET['detailed'] : false;

// If detailed data is requested (for table view)
if ($detailed) {
    $revenue = getDetailedRevenueData($startDate, $endDate);
    echo json_encode($revenue);
    exit;
}

// For chart data
if ($startDate && $endDate) {
    $revenue = getRevenueByDateRange($startDate, $endDate);
} else {
    switch ($filter) {
        case 'daily':
            $revenue = getRevenueByDay(30);
            break;
        case 'week':
            $revenue = getRevenueByDayOfWeek();
            break;
        case 'yearly':
            $revenue = getRevenueByYear();
            break;
        case 'month':
        default:
            $revenue = getRevenueByMonth();
            break;
    }
}

echo json_encode($revenue);