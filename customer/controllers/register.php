<?php
if (isset($_POST["submit"])) {
    $Fname = $_POST["Fname"];
    $Lname = $_POST["Lname"];
    $address = $_POST["address"];
    $UserName = $_POST["UserName"];
    $password = $_POST["user_pass"];
    $ConfPassword = $_POST["ConfPassword"];
    $birthday = $_POST["birthday"];
    $contact = $_POST["contact"];
    $role = "customer";
    var_dump($_POST["user_pass"]);  // Add this to register.php
    // exit();
    
    require_once './functions.php';
    require_once '../../admin_panel/controller/dbCon.php';

    if (emptyInputSignup($Fname, $Lname, $address, $UserName, $password, $ConfPassword)  !== false) {
        header("location: ../index.php?error=EmptyInput");
        exit();
    }
    if (passMatch($password, $ConfPassword) !== false) {
        header("location: ../index.php?error=PassNotMatching");
        exit();
    }
    if (userExist($conn, $UserName) !== false) {
        header("location: ../index.php?error=UsernameTaken");
        exit();
    }
    createUser($conn,  $UserName, $Lname, $Fname, $address, $contact, $birthday, $password);
} else {
    header("location: ../index.php");
    exit();
}