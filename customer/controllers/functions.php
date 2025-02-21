<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
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
        $_SESSION["verified"] = $userExists["verified"];
        $_SESSION["otp"] = $userExists["otp"];

        if ($userExists["role"] === "admin") {
            header("location: ../../admin_panel/index.php?error=none");
        } elseif ($userExists["role"] === "customer") {
            header("location: ../index.php?error=none");
        } else {
            header("location: ../index.php?error=InvalidRole");
        }
        exit();
    }
}
function sendOTPEmail($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'otp.skyhigh@gmail.com';
        $mail->Password = 'xgwuumprorznbwvc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('otp.skyhigh@gmail.com', 'Skyhigh Motorcycle Parts');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - OTP Code';
        $mail->Body = "
            <p>Hello,</p>
            <p>Your OTP code is: <b>$otp</b></p>
            <p>Thank you.</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
    }
}

function createUser($conn, $name, $email, $address, $phone, $password)
{
    $otp = mt_rand(100000, 999999); 

    $sql = "INSERT INTO tbl_users (name, username, address, contact, password, role, otp) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $role = "customer";

    mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $address, $phone, $hashedPass, $role, $otp);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    sendOTPEmail($email, $otp); 

    header("location: ../index.php?success=Registered");
    exit();
}