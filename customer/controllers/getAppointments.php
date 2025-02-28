<?php
session_start(); 
include_once("./getFunctions.php"); 

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $appointments = gettAppointByUser($username);

    echo json_encode($appointments);
} else {
    echo json_encode(["error" => "Please log in to view your appointments."]);
}