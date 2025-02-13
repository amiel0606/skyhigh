<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once './functions.php';
    require_once '../../admin_panel/controller/dbCon.php';

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $phone = trim($_POST["contact"]);
    $password = $_POST["password"];
    $confPassword = $_POST["confPassword"];
    $role = "customer";

    if (empty($name) || empty($email) || empty($address) || empty($phone) || empty($password) || empty($confPassword)) {
        header("location: ../index.php?error=EmptyInput");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location: ../index.php?error=InvalidEmail");
        exit();
    }
    if ($password !== $confPassword) {
        header("location: ../index.php?error=PassNotMatching");
        exit();
    }
    if (userExist($conn, $email) !== false) {
        header("location: ../index.php?error=EmailTaken");
        exit();
    }

    createUser($conn, $name, $email, $address, $phone, $password);
    header("location: ../index.php?success=Registered");
    exit();
} else {
    header("location: ../index.php");
    exit();
}
