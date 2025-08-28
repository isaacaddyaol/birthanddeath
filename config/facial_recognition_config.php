<?php
/**
 * Facial Recognition Configuration
 * Configuration settings for facial recognition functionality
 */

// Facial Recognition Settings
define('FR_ENABLED', true);
define('FR_MIN_CONFIDENCE', 0.6); // Minimum confidence for face matching (0-1)
define('FR_MAX_FACE_SIZE', 2 * 1024 * 1024); // 2MB max file size
define('FR_ALLOWED_FORMATS', ['image/jpeg', 'image/png', 'image/jpg']);
define('FR_FACE_DIR', __DIR__ . '/../images/faces/');
define('FR_TEMP_DIR', __DIR__ . '/../temp/faces/');

// Face detection settings
define('FR_DETECTION_OPTIONS', [
    'minFaceSize' => 160,
    'scoreThreshold' => 0.5,
    'nmsThreshold' => 0.4,
    'maxNumScales' => 10,
    'scaleFactor' => 0.709,
    'shiftFactor' => 0.4
]);

// Face descriptor settings
define('FR_DESCRIPTOR_DIMENSIONS', 128); // face-api.js uses 128-dimensional descriptors

// Database table for facial recognition
define('FR_TABLE_NAME', 'tbl_facial_recognition');

// API endpoints
define('FR_API_DETECT', 'api/face_detect.php');
define('FR_API_COMPARE', 'api/face_compare.php');
define('FR_API_VERIFY', 'api/face_verify.php');

// Error codes
define('FR_ERROR_CODES', [
    'NO_FACE_DETECTED' => 1001,
    'MULTIPLE_FACES' => 1002,
    'LOW_QUALITY' => 1003,
    'INVALID_FORMAT' => 1004,
    'FILE_TOO_LARGE' => 1005,
    'PROCESSING_ERROR' => 1006,
    'NO_MATCH_FOUND' => 1007,
    'DATABASE_ERROR' => 1008
]);

/**
 * Get facial recognition configuration
 */
function getFacialRecognitionConfig() {
    return [
        'enabled' => FR_ENABLED,
        'minConfidence' => FR_MIN_CONFIDENCE,
        'maxFaceSize' => FR_MAX_FACE_SIZE,
        'allowedFormats' => FR_ALLOWED_FORMATS,
        'faceDir' => FR_FACE_DIR,
        'tempDir' => FR_TEMP_DIR,
        'detectionOptions' => FR_DETECTION_OPTIONS,
        'descriptorDimensions' => FR_DESCRIPTOR_DIMENSIONS,
        'apiEndpoints' => [
            'detect' => FR_API_DETECT,
            'compare' => FR_API_COMPARE,
            'verify' => FR_API_VERIFY
        ],
        'errorCodes' => FR_ERROR_CODES
    ];
}

/**
 * Initialize facial recognition directories
 */
function initializeFacialRecognitionDirs() {
    $dirs = [FR_FACE_DIR, FR_TEMP_DIR];
    
    foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0755, true)) {
                throw new Exception("Failed to create directory: $dir");
            }
        }
        
        if (!is_writable($dir)) {
            throw new Exception("Directory not writable: $dir");
        }
    }
    
    return true;
}

/**
 * Clean up temporary facial recognition files
 */
function cleanupTempFaceFiles($maxAge = 3600) {
    $tempDir = FR_TEMP_DIR;
    $cutoff = time() - $maxAge;
    
    if (!is_dir($tempDir)) {
        return;
    }
    
    $files = glob($tempDir . '*');
    foreach ($files as $file) {
        if (is_file($file) && filemtime($file) < $cutoff) {
            unlink($file);
        }
    }
}

/**
 * Validate facial recognition file
 */
function validateFaceFile($file) {
    $errors = [];
    
    // Check file size
    if ($file['size'] > FR_MAX_FACE_SIZE) {
        $errors[] = 'File too large. Maximum size: ' . (FR_MAX_FACE_SIZE / 1024 / 1024) . 'MB';
    }
    
    // Check file type
    if (!in_array($file['type'], FR_ALLOWED_FORMATS)) {
        $errors[] = 'Invalid file format. Allowed: ' . implode(', ', FR_ALLOWED_FORMATS);
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'File upload error: ' . $file['error'];
    }
    
    return $errors;
}
?>