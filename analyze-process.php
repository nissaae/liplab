<?php
// Include config file
require_once 'config.php';

// Check if photo was uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    
    $uploadedFile = $_FILES['photo'];
    $fileName = $uploadedFile['name'];
    $fileTmpPath = $uploadedFile['tmp_name'];
    $fileSize = $uploadedFile['size'];
    $fileType = $uploadedFile['type'];
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($fileType, $allowedTypes)) {
        header("Location: " . SITE_URL . "/find-shade.php?error=invalid_file_type");
        exit();
    }
    
    // Validate file size (10MB limit)
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    if ($fileSize > $maxFileSize) {
        header("Location: " . SITE_URL . "/find-shade.php?error=file_too_large");
        exit();
    }
    
    // Create upload directory if it doesn't exist
    $uploadDir = 'uploads/photos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate unique filename
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('photo_', true) . '.' . $fileExtension;
    $uploadPath = $uploadDir . $newFileName;
    
    // Move uploaded file
    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
        
        // Store photo info in session for potential future use
        $_SESSION['uploaded_photo'] = $uploadPath;
        $_SESSION['analysis_timestamp'] = time();
        
        // For demo purposes, we'll just redirect to results with random products
        // In a real implementation, this is where you'd run the AI analysis
        
        // Simulate processing time with a brief delay
        sleep(2);
        
        // Redirect to results page (will show 12 random products for demo)
        header("Location: " . SITE_URL . "/result.php?analysis=shade_match&photo=" . urlencode($newFileName));
        exit();
        
    } else {
        // File upload failed
        header("Location: " . SITE_URL . "/find-shade.php?error=upload_failed");
        exit();
    }
    
} else {
    // No file uploaded or upload error
    $error_message = "No file uploaded";
    
    if (isset($_FILES['photo'])) {
        switch ($_FILES['photo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_message = "File too large";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message = "File upload incomplete";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message = "No file selected";
                break;
            default:
                $error_message = "Upload failed";
                break;
        }
    }
    
    header("Location: " . SITE_URL . "/find-shade.php?error=" . urlencode($error_message));
    exit();
}
?>