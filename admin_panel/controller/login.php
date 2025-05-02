<?php
session_start();
include_once 'dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        header('Location: ../login.php?error=Please+enter+both+fields');
        exit();
    }

    $stmt = $conn->prepare('SELECT admin_id, password FROM tbl_admin WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            header('Location: ../index.php');
            exit();
        }
    }
    header('Location: ../login.php?error=Invalid+credentials');
    exit();
} else {
    header('Location: ../login.php');
    exit();
} 