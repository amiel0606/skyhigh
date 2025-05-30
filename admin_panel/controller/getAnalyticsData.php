<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

header('Content-Type: application/json');

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
$detailed = isset($_GET['detailed']) ? $_GET['detailed'] : false;
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';

if (isset($_GET['serviceBookings']) && $_GET['serviceBookings'] == '1') {
    if ($detailed) {
        echo json_encode(getDetailedServiceBookingsData($startDate, $endDate));
    } else if ($startDate && $endDate) {
        echo json_encode(getServiceBookingsCountByDateRange($startDate, $endDate));
    } else {
        switch ($filter) {
            case 'daily':
                echo json_encode(getServiceBookingsCountByDay(30));
                break;
            case 'yearly':
                echo json_encode(getServiceBookingsCountByYear());
                break;
            default:
                echo json_encode(getServiceBookingsCount());
                break;
        }
    }
    exit();
}

try {
    $analyticsData = [
        'totalOrders' => getTotalOrders(),
        'totalRevenue' => getTotalRevenue(),
        'topSellingItem' => getTopSellingItem(),
        'topService' => getTopService(),
        'mostScheduledTime' => getMostScheduledTime(),
        'mostScheduledDay' => getMostScheduledDay(),
        'totalAppointments' => getTotalAppointments(),
        'activeUsers' => getActiveUsersCount(),
        'walkInAppointments' => getWalkInAppointmentsCount(),
        'totalRevenueAllMonths' => getTotalRevenueAllMonths(),
        'totalAppointmentsAllMonths' => getTotalAppointmentsAllMonths()
    ];

    echo json_encode($analyticsData);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch analytics data: ' . $e->getMessage()]);
}
