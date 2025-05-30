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
            faqs TEXT,
            logo_picture VARCHAR(255),
            background_picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($createTable)) {
            // Insert default content
            $insertDefault = "INSERT INTO website_content (about_us, logo_title, logo_subtitle, faqs) VALUES (
                'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
                'SKYHIGH MOTORCYCLE',
                'Your Trusted Motorcycle Partner',
                '<h3>Frequently Asked Questions</h3><p><strong>Q: What services do you offer?</strong><br>A: We offer motorcycle repair, maintenance, parts sales, and customization services.</p><p><strong>Q: Do you work on all motorcycle brands?</strong><br>A: Yes, we work on all major motorcycle brands and models.</p>'
            )";
            $conn->query($insertDefault);
        }
    } else {
        // Check if faqs column exists, if not add it
        $checkColumn = "SHOW COLUMNS FROM website_content LIKE 'faqs'";
        $columnResult = $conn->query($checkColumn);
        
        if ($columnResult->num_rows == 0) {
            // Add faqs column to existing table
            $addColumn = "ALTER TABLE website_content ADD COLUMN faqs TEXT AFTER logo_subtitle";
            $conn->query($addColumn);
            
            // Update existing records with default FAQ content
            $updateDefault = "UPDATE website_content SET faqs = '<h3>Frequently Asked Questions</h3><p><strong>Q: What services do you offer?</strong><br>A: We offer motorcycle repair, maintenance, parts sales, and customization services.</p><p><strong>Q: Do you work on all motorcycle brands?</strong><br>A: Yes, we work on all major motorcycle brands and models.</p>' WHERE faqs IS NULL OR faqs = ''";
            $conn->query($updateDefault);
        }
    }
    
    // Fetch content
    $query = "SELECT * FROM website_content ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $content = $result->fetch_assoc();
    } else {
        // If no content exists, create default
        $insertDefault = "INSERT INTO website_content (about_us, logo_title, logo_subtitle, faqs) VALUES (
            'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
            'SKYHIGH MOTORCYCLE',
            'Your Trusted Motorcycle Partner',
            '<h3>Frequently Asked Questions</h3><p><strong>Q: What services do you offer?</strong><br>A: We offer motorcycle repair, maintenance, parts sales, and customization services.</p><p><strong>Q: Do you work on all motorcycle brands?</strong><br>A: Yes, we work on all major motorcycle brands and models.</p>'
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
        'faqs' => '<h3>Frequently Asked Questions</h3><p><strong>Q: What services do you offer?</strong><br>A: We offer motorcycle repair, maintenance, parts sales, and customization services.</p><p><strong>Q: Do you work on all motorcycle brands?</strong><br>A: Yes, we work on all major motorcycle brands and models.</p>',
        'logo_picture' => '',
        'background_picture' => ''
    );
}