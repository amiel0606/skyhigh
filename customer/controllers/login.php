<?php
if (isset($_POST["Login"])) {
    $uName = $_POST["username"];
    $pwd = $_POST["password"];

    require_once './functions.php';
    require_once '../../admin_panel/controller/dbCon.php';

    if (emptyInputLogin($uName, $pwd) !== false) {
        header("location: ../index.php?error=EmptyInput");
        exit();
    }
    loginUser($conn, $uName, $pwd);
}