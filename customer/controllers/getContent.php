<?php
// Set content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Include database connection
include_once('../../admin_panel/controller/dbCon.php');

// Initialize default content
$defaultContent = [
    'about_us' => 'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.',
    'logo_title' => 'SKYHIGH',
    'logo_subtitle' => 'MOTORCYCLE',
    'logo_picture' => '',
    'background_picture' => ''
];

try {
    // Fetch content from database
    $query = "SELECT * FROM website_content ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $content = $result->fetch_assoc();
        
        // Build response with full URLs for images
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/skyhigh/admin_panel/uploads/';
        
        $responseContent = [
            'about_us' => $content['about_us'] ?? $defaultContent['about_us'],
            'logo_title' => $content['logo_title'] ?? $defaultContent['logo_title'],
            'logo_subtitle' => $content['logo_subtitle'] ?? $defaultContent['logo_subtitle'],
            'logo_picture' => $content['logo_picture'] ?? $defaultContent['logo_picture'],
            'background_picture' => $content['background_picture'] ?? $defaultContent['background_picture'],
            'logo_picture_url' => !empty($content['logo_picture']) ? $baseUrl . $content['logo_picture'] : '../img/logo.png',
            'background_picture_url' => !empty($content['background_picture']) ? $baseUrl . $content['background_picture'] : '../img/background-home.png'
        ];
        
        echo json_encode([
            'success' => true,
            'data' => $responseContent
        ]);
    } else {
        // Return default content if none exists
        echo json_encode([
            'success' => true,
            'data' => array_merge($defaultContent, [
                'logo_picture_url' => '../img/logo.png',
                'background_picture_url' => '../img/background-home.png'
            ])
        ]);
    }
    
} catch (Exception $e) {
    error_log("Error in getContent.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred',
        'data' => array_merge($defaultContent, [
            'logo_picture_url' => '../img/logo.png',
            'background_picture_url' => '../img/background-home.png'
        ])
    ]);
}

// Close connection if it exists
if (isset($conn)) {
    $conn->close();
}
?> 