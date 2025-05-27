<?php
include_once('dbCon.php');

// Initialize content array
$content = array();

try {
    // Check if content table exists, if not create it
    $checkTable = "SHOW TABLES LIKE 'website_content'";
    $result = $conn->query($checkTable);
    
    if ($result->num_rows == 0) {
        // Create the table if it doesn't exist
        $createTable = "CREATE TABLE website_content (
            id INT AUTO_INCREMENT PRIMARY KEY,
            about_us TEXT,
            logo_title VARCHAR(255),
            logo_subtitle VARCHAR(255),
            logo_picture VARCHAR(255),
            background_picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($createTable)) {
            // Insert default content
            $insertDefault = "INSERT INTO website_content (about_us, logo_title, logo_subtitle) VALUES (
                'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
                'SKYHIGH MOTORCYCLE',
                'Your Trusted Motorcycle Partner'
            )";
            $conn->query($insertDefault);
        }
    }
    
    // Fetch content
    $query = "SELECT * FROM website_content ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $content = $result->fetch_assoc();
    } else {
        // If no content exists, create default
        $insertDefault = "INSERT INTO website_content (about_us, logo_title, logo_subtitle) VALUES (
            'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
            'SKYHIGH MOTORCYCLE',
            'Your Trusted Motorcycle Partner'
        )";
        
        if ($conn->query($insertDefault)) {
            // Fetch the newly inserted content
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $content = $result->fetch_assoc();
            }
        }
    }
    
} catch (Exception $e) {
    error_log("Error in getContent.php: " . $e->getMessage());
    // Set default values if there's an error
    $content = array(
        'about_us' => 'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
        'logo_title' => 'SKYHIGH MOTORCYCLE',
        'logo_subtitle' => 'Your Trusted Motorcycle Partner',
        'logo_picture' => '',
        'background_picture' => ''
    );
}