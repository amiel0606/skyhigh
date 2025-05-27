<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

header('Content-Type: application/json');

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
