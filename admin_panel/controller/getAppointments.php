<?php
include_once('./dbCon.php');
include_once('./getFunctions.php');

$appointments = getAppointmentsCountByMonth();
echo json_encode($appointments);