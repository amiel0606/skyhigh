<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';

if ($filter === 'week') {
    $revenue = getRevenueByDayOfWeek();
} else {
    $revenue = getRevenueByMonth();
}
echo json_encode($revenue);