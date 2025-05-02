<?php
include_once 'dbCon.php';

$sql = "CREATE TABLE IF NOT EXISTS tbl_admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "tbl_admin table checked/created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$result = $conn->query("SELECT COUNT(*) as cnt FROM tbl_admin");
$row = $result->fetch_assoc();
if ($row['cnt'] == 0) {
    $defaultUser = 'admin';
    $defaultPass = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO tbl_admin (username, password) VALUES (?, ?)");
    $stmt->bind_param('ss', $defaultUser, $defaultPass);
    if ($stmt->execute()) {
        echo "Default admin user created. Username: admin, Password: admin123<br>";
    } else {
        echo "Error inserting default admin: " . $stmt->error . "<br>";
    }
    $stmt->close();
} else {
    echo "tbl_admin already has data. No default admin inserted.<br>";
}

$conn->close(); 