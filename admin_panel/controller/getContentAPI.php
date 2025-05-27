<?php
include_once('dbCon.php');

// Set content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Fetch content
    $query = "SELECT * FROM website_content ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $content = $result->fetch_assoc();
        
        // Add full URLs for images
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '../uploads/';
        
        if ($content['logo_picture']) {
            $content['logo_picture_url'] = $baseUrl . $content['logo_picture'];
        } else {
            $content['logo_picture_url'] = '';
        }
        
        if ($content['background_picture']) {
            $content['background_picture_url'] = $baseUrl . $content['background_picture'];
        } else {
            $content['background_picture_url'] = '';
        }
        
        echo json_encode([
            'success' => true,
            'data' => $content
        ]);
    } else {
        // Return default content if none exists
        echo json_encode([
            'success' => true,
            'data' => [
                'about_us' => 'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
                'logo_title' => 'SKYHIGH MOTORCYCLE',
                'logo_subtitle' => 'Your Trusted Motorcycle Partner',
                'logo_picture' => '',
                'background_picture' => '',
                'logo_picture_url' => '',
                'background_picture_url' => ''
            ]
        ]);
    }
    
} catch (Exception $e) {
    error_log("Error in getContentAPI.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred'
    ]);
}

$conn->close();