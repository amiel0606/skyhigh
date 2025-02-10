<?php
function emptyInputSignup($Fname, $Lname, $address, $UserName, $password, $ConfPassword)
{
    return empty($Fname) || empty($Lname) || empty($address) || empty($UserName) || empty($password) || empty($ConfPassword);
}

function InvalidUser($UserName)
{
    return !preg_match("/^[a-zA-Z0-9]*$/", $UserName);
}

function passMatch($password, $ConfPassword)
{
    return $password !== $ConfPassword;
}

function userExist($conn, $UserName)
{
    $sql = "SELECT * FROM tbl_users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $UserName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

}

function emptyInputLogin($uName, $pwd)
{
    if (empty($uName) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $uName, $pwd)
{
    $UserExists = userExist($conn, $uName);

    if ($UserExists == false) {
        header("location: ../index.php?error=WrongLogin");
        exit();
    }

    $pwdHashed = $UserExists["password"];

    if (!password_verify($pwd, $pwdHashed)) {
        echo "Password verification failed!";
        exit();
    } else {
        session_start();
        $_SESSION["uID"] = $UserExists["uID"];
        $_SESSION["username"] = $UserExists["username"];
        header("location: ../index.php");
        exit();
    }
}


function createUser($conn, $UserName, $Lname, $Fname, $address, $contact, $birthday, $password)
{
    $sql = "INSERT INTO tbl_users (pass_normal, username, password, role, firstName, lastName, address, contact, birthday) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $role = "customer";

    mysqli_stmt_bind_param($stmt, "sssssssss", $password, $UserName, $hashedPass, $role, $Fname, $Lname, $address, $contact, $birthday);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("location: ../index.php?error=Success");
    exit();
}
