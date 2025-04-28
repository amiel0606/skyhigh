<?php
include_once('./getFunctions.php');

$activeUsers = getActiveUsers();
echo json_encode($activeUsers);