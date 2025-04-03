<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

$revenue = getRevenueByMonth();
echo json_encode($revenue);