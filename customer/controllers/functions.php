<?php
function emptyInputSignup($name, $email, $address, $phone, $password, $confPassword)
{
    return empty($name) || empty($email) || empty($address) || empty($phone) || empty($password) || empty($confPassword);
}

function passMatch($password, $confPassword)
{
    return $password !== $confPassword;
}

function userExist($conn, $email)
{
    $sql = "SELECT * FROM tbl_users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }
}

function emptyInputLogin($email, $password)
{
    return empty($email) || empty($password);
}

function loginUser($conn, $email, $password)
{
    $userExists = userExist($conn, $email);
    
    if ($userExists == false) {
        header("location: ../index.php?error=WrongLogin");
        exit();
    }

    $pwdHashed = $userExists["password"];
    if (!password_verify($password, $pwdHashed)) {
        header("location: ../index.php?error=WrongPassword");
        exit();
    } else {
        session_start();
        $_SESSION["uID"] = $userExists["uID"];
        $_SESSION["username"] = $userExists["username"];
        $_SESSION["name"] = $userExists["name"];
        $_SESSION["contact"] = $userExists["contact"];
        $_SESSION["role"] = $userExists["role"];
        $_SESSION["address"] = $userExists["address"];

        header("location: ../index.php?error=none");
        exit();
    }
}

function createUser($conn, $name, $email, $address, $phone, $password)
{
    $sql = "INSERT INTO tbl_users (name, username, address, contact, password, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $role = "customer";

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $address, $phone, $hashedPass, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("location: ../index.php?success=Registered");
    exit();
}
