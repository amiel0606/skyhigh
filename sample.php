<?php

session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user']; // Get the current user's ID

var_dump($user); // Debugging: Check user ID

// Fetch user information
$sql = "SELECT pname, pemail, paddress, ptel FROM user WHERE pemail = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("MySQL prepare error: " . $conn->error);
}

$stmt->bind_param("i", $user); // Bind user ID
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("MySQL query error: " . $stmt->error);
}

var_dump($result->num_rows); // Debugging: Check number of rows returned

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    var_dump($userData); // Debugging: Check fetched user data
} else {
    echo "No user found with this ID.";
}

$stmt->close();
?>