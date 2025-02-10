<?php
if (isset($_POST["Login"])) {
    $uName = $_POST["username"];
    $pwd = $_POST["password"];
    // echo password_verify('a', '$2y$10$JKDJkEnGe15u0WhtcNH4AeUtP9zH99172CLMLiJH9zRPcTHKmKNIq');

    require_once './functions.php';
    require_once '../../admin_panel/controller/dbCon.php';

    if (emptyInputLogin($uName, $pwd) !== false) {
        header("location: ../index.php?error=EmptyInput");
        exit();
    }
    loginUser($conn, $uName, $pwd);
}
