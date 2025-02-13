<?php
require_once '../../admin_panel/controller/dbCon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $vehicle = mysqli_real_escape_string($conn, $_POST['vehicle']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    
    if (empty($name) || empty($username) || empty($address) || empty($contact) || empty($vehicle) || empty($service) || empty($time) || empty($date)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    }

    $sql = "INSERT INTO tbl_appointments (name, username, address, contact, vehicle, service, time, date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $username, $address, $contact, $vehicle, $service, $time, $date);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../index.php?error=none");
            exit();
        } else {
            header("Location: ../index.php?error=queryfailed");
            exit();
        }
    } else {
        header("Location: ../index.php?error=preparefailed");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../index.php");
    exit();
}