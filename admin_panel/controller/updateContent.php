<?php
session_start();
include_once('dbCon.php');

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

try {
    // Get POST data
    $aboutUs = $_POST['aboutUs'] ?? '';
    $logoTitle = $_POST['logoTitle'] ?? '';
    $logoSubtitle = $_POST['logoSubtitle'] ?? '';
    $faqs = $_POST['faqs'] ?? '';
    
    // Handle file uploads
    $logoFileName = '';
    $backgroundFileName = '';
    
    // Create uploads directory if it doesn't exist
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Handle logo picture upload
    if (isset($_FILES['logoPicture']) && $_FILES['logoPicture']['error'] === UPLOAD_ERR_OK) {
        $logoFile = $_FILES['logoPicture'];
        $logoFileExtension = strtolower(pathinfo($logoFile['name'], PATHINFO_EXTENSION));
        
        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($logoFileExtension, $allowedExtensions)) {
            // Generate unique filename
            $logoFileName = 'logo_' . time() . '_' . uniqid() . '.' . $logoFileExtension;
            $logoUploadPath = $uploadDir . $logoFileName;
            
            if (!move_uploaded_file($logoFile['tmp_name'], $logoUploadPath)) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload logo image']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid logo file type. Only JPG, PNG, GIF, and WebP are allowed.']);
            exit();
        }
    }
    
    // Handle background picture upload
    if (isset($_FILES['backgroundPicture']) && $_FILES['backgroundPicture']['error'] === UPLOAD_ERR_OK) {
        $backgroundFile = $_FILES['backgroundPicture'];
        $backgroundFileExtension = strtolower(pathinfo($backgroundFile['name'], PATHINFO_EXTENSION));
        
        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($backgroundFileExtension, $allowedExtensions)) {
            // Generate unique filename
            $backgroundFileName = 'background_' . time() . '_' . uniqid() . '.' . $backgroundFileExtension;
            $backgroundUploadPath = $uploadDir . $backgroundFileName;
            
            if (!move_uploaded_file($backgroundFile['tmp_name'], $backgroundUploadPath)) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload background image']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid background file type. Only JPG, PNG, GIF, and WebP are allowed.']);
            exit();
        }
    }
    
    // Check if content exists
    $checkQuery = "SELECT id, logo_picture, background_picture FROM website_content ORDER BY id DESC LIMIT 1";
    $checkResult = $conn->query($checkQuery);
    
    if ($checkResult && $checkResult->num_rows > 0) {
        // Update existing content
        $existingContent = $checkResult->fetch_assoc();
        $contentId = $existingContent['id'];
        
        // Build update query dynamically
        $updateFields = [];
        $updateValues = [];
        
        $updateFields[] = "about_us = ?";
        $updateValues[] = $aboutUs;
        
        $updateFields[] = "logo_title = ?";
        $updateValues[] = $logoTitle;
        
        $updateFields[] = "logo_subtitle = ?";
        $updateValues[] = $logoSubtitle;
        
        $updateFields[] = "faqs = ?";
        $updateValues[] = $faqs;
        
        // Only update file fields if new files were uploaded
        if ($logoFileName) {
            $updateFields[] = "logo_picture = ?";
            $updateValues[] = $logoFileName;
            
            // Delete old logo file if it exists
            if ($existingContent['logo_picture'] && file_exists($uploadDir . $existingContent['logo_picture'])) {
                unlink($uploadDir . $existingContent['logo_picture']);
            }
        }
        
        if ($backgroundFileName) {
            $updateFields[] = "background_picture = ?";
            $updateValues[] = $backgroundFileName;
            
            // Delete old background file if it exists
            if ($existingContent['background_picture'] && file_exists($uploadDir . $existingContent['background_picture'])) {
                unlink($uploadDir . $existingContent['background_picture']);
            }
        }
        
        $updateFields[] = "updated_at = CURRENT_TIMESTAMP";
        $updateValues[] = $contentId;
        
        $updateQuery = "UPDATE website_content SET " . implode(", ", $updateFields) . " WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        
        if ($stmt) {
            // Create type string for bind_param
            $types = str_repeat('s', count($updateValues) - 1) . 'i'; // All strings except last one (id) which is int
            $stmt->bind_param($types, ...$updateValues);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Content updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update content: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare update statement: ' . $conn->error]);
        }
        
    } else {
        // Insert new content
        $insertQuery = "INSERT INTO website_content (about_us, logo_title, logo_subtitle, faqs, logo_picture, background_picture) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        
        if ($stmt) {
            $stmt->bind_param('ssssss', $aboutUs, $logoTitle, $logoSubtitle, $faqs, $logoFileName, $backgroundFileName);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Content created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create content: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare insert statement: ' . $conn->error]);
        }
    }
    
} catch (Exception $e) {
    error_log("Error in updateContent.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error occurred']);
}

$conn->close();
?> 