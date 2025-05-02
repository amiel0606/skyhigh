<?php
require_once './getFunctions.php';

$brands = getAllBrands();

echo json_encode($brands);
