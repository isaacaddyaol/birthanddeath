<?php
/**
 * Facial Recognition API - Face Detection and Processing
 * Handles face detection, encoding, and storage
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

require_once '../config/facial_recognition_config.php';
require_once '../lib/FacialRecognition.php';
require_once '../dbcon.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Initialize facial recognition
    $fr = new FacialRecognition();
    
    // Get action from request
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'detect_face':
            handleFaceDetection();
            break;
            
        case 'store_face':
            handleFaceStorage();
            break;
            
        case 'verify_face':
            handleFaceVerification();
            break;
            
        case 'search_faces':
            handleFaceSearch();
            break;
            
        case 'get_face_data':
            handleGetFaceData();
            break;
            
        case 'verify_certificate_holder':
            handleCertificateHolderVerification();
            break;
            
        default:
            throw new Exception('Invalid action specified');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
    ]);
}

/**
 * Handle face detection from uploaded image
 */
function handleFaceDetection() {
    try {
        // Validate file upload
        if (!isset($_FILES['face_image'])) {
            throw new Exception('No image file provided');
        }
        
        $file = $_FILES['face_image'];
        $errors = validateFaceFile($file);
        
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        // Generate temporary filename
        $tempFilename = 'temp_' . uniqid() . '_' . time() . '.jpg';
        $tempPath = FR_TEMP_DIR . $tempFilename;
        
        // Move uploaded file to temp directory
        if (!move_uploaded_file($file['tmp_name'], $tempPath)) {
            throw new Exception('Failed to save uploaded file');
        }
        
        // Convert image to base64 for client-side processing
        $imageData = base64_encode(file_get_contents($tempPath));
        $imageInfo = getimagesize($tempPath);
        
        if (!$imageInfo) {
            unlink($tempPath);
            throw new Exception('Invalid image file');
        }
        
        // Clean up temp file
        unlink($tempPath);
        
        echo json_encode([
            'success' => true,
            'image_data' => 'data:' . $imageInfo['mime'] . ';base64,' . $imageData,
            'image_width' => $imageInfo[0],
            'image_height' => $imageInfo[1],
            'temp_filename' => $tempFilename,
            'message' => 'Image uploaded successfully. Please detect face on client side.'
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
        ]);
    }
}

/**
 * Handle storing face data
 */
function handleFaceStorage() {
    global $fr;
    
    try {
        // Validate required parameters
        $birthId = $_POST['birth_id'] ?? null;
        $faceDescriptor = $_POST['face_descriptor'] ?? null;
        $imageData = $_POST['image_data'] ?? null;
        $confidence = $_POST['confidence'] ?? null;
        $landmarks = $_POST['landmarks'] ?? null;
        $qualityScore = $_POST['quality_score'] ?? null;
        
        if (!$birthId || !$faceDescriptor || !$imageData) {
            throw new Exception('Missing required parameters: birth_id, face_descriptor, image_data');
        }
        
        // Parse face descriptor
        $descriptor = json_decode($faceDescriptor, true);
        if (!is_array($descriptor)) {
            throw new Exception('Invalid face descriptor format');
        }
        
        // Validate descriptor dimensions
        if (count($descriptor) !== FR_DESCRIPTOR_DIMENSIONS) {
            throw new Exception('Invalid descriptor dimensions. Expected ' . FR_DESCRIPTOR_DIMENSIONS . ', got ' . count($descriptor));
        }
        
        // Remove data URL prefix if present
        if (strpos($imageData, 'data:image') === 0) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
        }
        
        // Store facial data
        $result = $fr->storeFacialData($birthId, $imageData, $descriptor, $confidence);
        
        if ($result['success']) {
            // Update birth record
            global $con;
            $stmt = $con->prepare("
                UPDATE tblbirth 
                SET has_facial_data = 1, 
                    face_capture_date = NOW(),
                    face_last_updated = NOW()
                WHERE birthId = ?
            ");
            $stmt->bind_param("i", $birthId);
            $stmt->execute();
            
            // Log the storage action
            logFacialVerification($birthId, 'registration', 'success', $confidence, null, null);
        }
        
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
        ]);
    }
}

/**
 * Handle face verification
 */
function handleFaceVerification() {
    global $fr;
    
    try {
        $birthId = $_POST['birth_id'] ?? null;
        $certNo = $_POST['cert_no'] ?? null;
        $faceDescriptor = $_POST['face_descriptor'] ?? null;
        
        if (!$faceDescriptor || (!$birthId && !$certNo)) {
            throw new Exception('Missing required parameters');
        }
        
        // Get birth ID from cert number if provided
        if (!$birthId && $certNo) {
            global $con;
            $stmt = $con->prepare("SELECT birthId FROM tblbirth WHERE certNo = ?");
            $stmt->bind_param("s", $certNo);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $birthId = $row['birthId'];
            } else {
                throw new Exception('Certificate not found');
            }
        }
        
        // Parse face descriptor
        $descriptor = json_decode($faceDescriptor, true);
        if (!is_array($descriptor)) {
            throw new Exception('Invalid face descriptor format');
        }
        
        // Verify face
        $result = $fr->verifyFace($birthId, $descriptor);
        
        // Log verification attempt
        $logResult = $result['success'] && $result['verified'] ? 'success' : 'failure';
        $confidence = $result['confidence'] ?? null;
        $similarity = $result['similarity'] ?? null;
        
        logFacialVerification($birthId, 'certificate_verification', $logResult, $confidence, $similarity, 
                             !$result['success'] ? $result['error'] : null);
        
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
        ]);
    }
}

/**
 * Handle face search
 */
function handleFaceSearch() {
    global $fr;
    
    try {
        $faceDescriptor = $_POST['face_descriptor'] ?? null;
        $limit = $_POST['limit'] ?? 10;
        
        if (!$faceDescriptor) {
            throw new Exception('Missing face descriptor');
        }
        
        // Parse face descriptor
        $descriptor = json_decode($faceDescriptor, true);
        if (!is_array($descriptor)) {
            throw new Exception('Invalid face descriptor format');
        }
        
        // Search for matching faces
        $result = $fr->searchMatchingFaces($descriptor, (int)$limit);
        
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
        ]);
    }
}

/**
 * Handle getting face data for a birth record
 */
function handleGetFaceData() {
    global $fr;
    
    try {
        $birthId = $_POST['birth_id'] ?? null;
        $certNo = $_POST['cert_no'] ?? null;
        
        if (!$birthId && !$certNo) {
            throw new Exception('Missing birth_id or cert_no');
        }
        
        // Get birth ID from cert number if provided
        if (!$birthId && $certNo) {
            global $con;
            $stmt = $con->prepare("SELECT birthId FROM tblbirth WHERE certNo = ?");
            $stmt->bind_param("s", $certNo);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $birthId = $row['birthId'];
            } else {
                throw new Exception('Certificate not found');
            }
        }
        
        // Get facial data
        $result = $fr->getFacialData($birthId);
        
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
        ]);
    }
}

/**
 * Log facial verification attempt
 */
function logFacialVerification($birthId, $type, $result, $confidence = null, $similarity = null, $error = null) {
    try {
        global $con;
        
        // Get certificate number
        $stmt = $con->prepare("SELECT certNo FROM tblbirth WHERE birthId = ?");
        $stmt->bind_param("i", $birthId);
        $stmt->execute();
        $certResult = $stmt->get_result();
        $certNo = $certResult->fetch_assoc()['certNo'] ?? '';
        
        // Get client info
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $adminId = $_SESSION['adminId'] ?? null;
        
        // Insert log entry
        $stmt = $con->prepare("
            INSERT INTO tbl_facial_verification_log 
            (birth_id, cert_no, verification_type, verification_result, confidence_score, 
             similarity_score, error_message, ip_address, user_agent, admin_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param("isssddsssi", 
            $birthId, $certNo, $type, $result, $confidence, 
            $similarity, $error, $ipAddress, $userAgent, $adminId
        );
        
        $stmt->execute();
        
    } catch (Exception $e) {
        // Log error but don't fail the main operation
        error_log("Failed to log facial verification: " . $e->getMessage());
    }
}

/**
 * Handle certificate holder verification for printing
 */
function handleCertificateHolderVerification() {
    global $fr;
    
    try {
        $certType = $_POST['cert_type'] ?? null;
        $certId = $_POST['cert_id'] ?? null;
        $faceDescriptor = $_POST['face_descriptor'] ?? null;
        
        if (!$certType || !$certId || !$faceDescriptor) {
            throw new Exception('Missing required parameters: cert_type, cert_id, face_descriptor');
        }
        
        // Validate certificate type
        if (!in_array($certType, ['birth', 'death'])) {
            throw new Exception('Invalid certificate type. Must be birth or death.');
        }
        
        global $con;
        $birthId = null;
        
        // Get the certificate data and associated birth record
        if ($certType === 'birth') {
            // For birth certificates, use the birth ID directly
            $stmt = $con->prepare("SELECT birthId, firstName, lastName, certNo FROM tblbirth WHERE birthId = ?");
            $stmt->bind_param("i", $certId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $birthId = $row['birthId'];
                $certData = $row;
            } else {
                throw new Exception('Birth certificate not found');
            }
        } else if ($certType === 'death') {
            // For death certificates, we need to find if there's an associated birth record
            // This assumes that the person who died might have facial data from their birth registration
            $stmt = $con->prepare("SELECT firstName, lastName, certNo FROM tbldeath WHERE deathId = ?");
            $stmt->bind_param("i", $certId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $deathData = $row;
                
                // Try to find matching birth record based on name
                $stmt = $con->prepare("
                    SELECT birthId, firstName, lastName, certNo 
                    FROM tblbirth 
                    WHERE firstName = ? AND lastName = ? AND has_facial_data = 1
                    ORDER BY dateReg DESC 
                    LIMIT 1
                ");
                $stmt->bind_param("ss", $deathData['firstName'], $deathData['lastName']);
                $stmt->execute();
                $birthResult = $stmt->get_result();
                
                if ($birthRow = $birthResult->fetch_assoc()) {
                    $birthId = $birthRow['birthId'];
                    $certData = array_merge($deathData, ['associated_birth_id' => $birthId]);
                } else {
                    throw new Exception('No facial data found for this person. Death certificate verification requires prior birth registration with facial data.');
                }
            } else {
                throw new Exception('Death certificate not found');
            }
        }
        
        if (!$birthId) {
            throw new Exception('No biometric data available for verification');
        }
        
        // Check if facial data exists for this birth record
        $stmt = $con->prepare("SELECT has_facial_data FROM tblbirth WHERE birthId = ? AND has_facial_data = 1");
        $stmt->bind_param("i", $birthId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result->fetch_assoc()) {
            throw new Exception('No facial biometric data registered for this certificate holder');
        }
        
        // Parse face descriptor
        $descriptor = json_decode($faceDescriptor, true);
        if (!is_array($descriptor)) {
            throw new Exception('Invalid face descriptor format');
        }
        
        // Verify face against stored biometric data
        $verificationResult = $fr->verifyFace($birthId, $descriptor);
        
        // Log the verification attempt
        $logResult = $verificationResult['success'] && $verificationResult['verified'] ? 'success' : 'failure';
        $confidence = $verificationResult['confidence'] ?? null;
        $similarity = $verificationResult['similarity'] ?? null;
        
        logFacialVerification($birthId, 'certificate_printing_verification', $logResult, $confidence, $similarity, 
                             !$verificationResult['success'] ? $verificationResult['error'] : null);
        
        // Return the result with additional context
        $response = [
            'success' => $verificationResult['success'],
            'verified' => $verificationResult['verified'] ?? false,
            'confidence' => $confidence,
            'similarity' => $similarity,
            'certificate_type' => $certType,
            'certificate_id' => $certId,
            'verification_timestamp' => date('Y-m-d H:i:s')
        ];
        
        if (!$verificationResult['success'] || !$verificationResult['verified']) {
            $response['error'] = $verificationResult['error'] ?? 'Biometric verification failed';
        }
        
        echo json_encode($response);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'verified' => false,
            'error' => $e->getMessage(),
            'error_code' => FR_ERROR_CODES['PROCESSING_ERROR'] ?? 'VERIFICATION_ERROR'
        ]);
    }
}
?>