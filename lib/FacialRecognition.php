<?php
/**
 * Facial Recognition Library
 * Core functions for facial recognition processing
 */

require_once __DIR__ . '/../config/facial_recognition_config.php';
require_once __DIR__ . '/../dbcon.php';

class FacialRecognition {
    private $config;
    private $db;
    
    public function __construct() {
        $this->config = getFacialRecognitionConfig();
        global $con;
        $this->db = $con;
        
        // Initialize directories
        initializeFacialRecognitionDirs();
    }
    
    /**
     * Store facial recognition data for a birth record
     */
    public function storeFacialData($birthId, $imageData, $faceDescriptor, $confidence = null) {
        try {
            // Generate unique filename
            $filename = 'face_' . $birthId . '_' . time() . '.jpg';
            $filepath = $this->config['faceDir'] . $filename;
            
            // Save image to filesystem
            if (!file_put_contents($filepath, base64_decode($imageData))) {
                throw new Exception('Failed to save face image');
            }
            
            // Store in database
            $stmt = $this->db->prepare("
                INSERT INTO " . FR_TABLE_NAME . " 
                (birth_id, face_image_path, face_descriptor, confidence, created_at) 
                VALUES (?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                face_image_path = VALUES(face_image_path),
                face_descriptor = VALUES(face_descriptor),
                confidence = VALUES(confidence),
                updated_at = NOW()
            ");
            
            $descriptorJson = json_encode($faceDescriptor);
            $stmt->bind_param("issd", $birthId, $filename, $descriptorJson, $confidence);
            
            if (!$stmt->execute()) {
                throw new Exception('Database error: ' . $this->db->error);
            }
            
            return [
                'success' => true,
                'face_id' => $this->db->insert_id ?: $this->getFaceIdByBirthId($birthId),
                'filename' => $filename
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => FR_ERROR_CODES['DATABASE_ERROR']
            ];
        }
    }
    
    /**
     * Get facial recognition data for a birth record
     */
    public function getFacialData($birthId) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM " . FR_TABLE_NAME . " 
                WHERE birth_id = ? 
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->bind_param("i", $birthId);
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $row['face_descriptor'] = json_decode($row['face_descriptor'], true);
                return [
                    'success' => true,
                    'data' => $row
                ];
            }
            
            return [
                'success' => false,
                'error' => 'No facial data found',
                'error_code' => FR_ERROR_CODES['NO_MATCH_FOUND']
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => FR_ERROR_CODES['DATABASE_ERROR']
            ];
        }
    }
    
    /**
     * Compare face descriptors
     */
    public function compareFaceDescriptors($descriptor1, $descriptor2) {
        if (!is_array($descriptor1) || !is_array($descriptor2)) {
            return [
                'success' => false,
                'error' => 'Invalid descriptors',
                'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
            ];
        }
        
        if (count($descriptor1) !== count($descriptor2)) {
            return [
                'success' => false,
                'error' => 'Descriptor dimension mismatch',
                'error_code' => FR_ERROR_CODES['PROCESSING_ERROR']
            ];
        }
        
        // Calculate Euclidean distance
        $distance = $this->calculateEuclideanDistance($descriptor1, $descriptor2);
        
        // Convert distance to similarity score (0-1, where 1 is identical)
        $similarity = max(0, 1 - ($distance / 2));
        
        // Determine if faces match based on confidence threshold
        $isMatch = $similarity >= $this->config['minConfidence'];
        
        return [
            'success' => true,
            'similarity' => $similarity,
            'distance' => $distance,
            'is_match' => $isMatch,
            'confidence' => $similarity
        ];
    }
    
    /**
     * Verify face against stored data
     */
    public function verifyFace($birthId, $faceDescriptor) {
        // Get stored facial data
        $storedData = $this->getFacialData($birthId);
        
        if (!$storedData['success']) {
            return $storedData;
        }
        
        // Compare descriptors
        $comparison = $this->compareFaceDescriptors(
            $faceDescriptor,
            $storedData['data']['face_descriptor']
        );
        
        if (!$comparison['success']) {
            return $comparison;
        }
        
        return [
            'success' => true,
            'verified' => $comparison['is_match'],
            'confidence' => $comparison['confidence'],
            'similarity' => $comparison['similarity'],
            'stored_data' => $storedData['data']
        ];
    }
    
    /**
     * Search for matching faces in database
     */
    public function searchMatchingFaces($faceDescriptor, $limit = 10) {
        try {
            $stmt = $this->db->prepare("
                SELECT fr.*, b.firstName, b.lastName, b.certNo 
                FROM " . FR_TABLE_NAME . " fr
                JOIN tblbirth b ON fr.birth_id = b.birthId
                ORDER BY fr.created_at DESC
                LIMIT ?
            ");
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $matches = [];
            
            while ($row = $result->fetch_assoc()) {
                $storedDescriptor = json_decode($row['face_descriptor'], true);
                $comparison = $this->compareFaceDescriptors($faceDescriptor, $storedDescriptor);
                
                if ($comparison['success'] && $comparison['is_match']) {
                    $matches[] = [
                        'birth_id' => $row['birth_id'],
                        'cert_no' => $row['certNo'],
                        'name' => $row['firstName'] . ' ' . $row['lastName'],
                        'confidence' => $comparison['confidence'],
                        'similarity' => $comparison['similarity'],
                        'face_image_path' => $row['face_image_path']
                    ];
                }
            }
            
            // Sort by confidence (highest first)
            usort($matches, function($a, $b) {
                return $b['confidence'] <=> $a['confidence'];
            });
            
            return [
                'success' => true,
                'matches' => $matches,
                'total' => count($matches)
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => FR_ERROR_CODES['DATABASE_ERROR']
            ];
        }
    }
    
    /**
     * Delete facial recognition data
     */
    public function deleteFacialData($birthId) {
        try {
            // Get existing data to delete file
            $existingData = $this->getFacialData($birthId);
            
            if ($existingData['success']) {
                $filepath = $this->config['faceDir'] . $existingData['data']['face_image_path'];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            
            // Delete from database
            $stmt = $this->db->prepare("DELETE FROM " . FR_TABLE_NAME . " WHERE birth_id = ?");
            $stmt->bind_param("i", $birthId);
            
            if (!$stmt->execute()) {
                throw new Exception('Database error: ' . $this->db->error);
            }
            
            return [
                'success' => true,
                'deleted' => $stmt->affected_rows > 0
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => FR_ERROR_CODES['DATABASE_ERROR']
            ];
        }
    }
    
    /**
     * Calculate Euclidean distance between two descriptors
     */
    private function calculateEuclideanDistance($desc1, $desc2) {
        $sum = 0;
        for ($i = 0; $i < count($desc1); $i++) {
            $diff = $desc1[$i] - $desc2[$i];
            $sum += $diff * $diff;
        }
        return sqrt($sum);
    }
    
    /**
     * Get face ID by birth ID
     */
    private function getFaceIdByBirthId($birthId) {
        $stmt = $this->db->prepare("SELECT id FROM " . FR_TABLE_NAME . " WHERE birth_id = ?");
        $stmt->bind_param("i", $birthId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }
    
    /**
     * Get system statistics
     */
    public function getStatistics() {
        try {
            $stats = [];
            
            // Total faces stored
            $result = $this->db->query("SELECT COUNT(*) as total FROM " . FR_TABLE_NAME);
            $stats['total_faces'] = $result->fetch_assoc()['total'];
            
            // Faces added today
            $result = $this->db->query("
                SELECT COUNT(*) as today 
                FROM " . FR_TABLE_NAME . " 
                WHERE DATE(created_at) = CURDATE()
            ");
            $stats['faces_today'] = $result->fetch_assoc()['today'];
            
            // Average confidence
            $result = $this->db->query("
                SELECT AVG(confidence) as avg_confidence 
                FROM " . FR_TABLE_NAME . " 
                WHERE confidence IS NOT NULL
            ");
            $row = $result->fetch_assoc();
            $stats['average_confidence'] = $row['avg_confidence'] ? round($row['avg_confidence'], 3) : 0;
            
            return [
                'success' => true,
                'statistics' => $stats
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_code' => FR_ERROR_CODES['DATABASE_ERROR']
            ];
        }
    }
}
?>