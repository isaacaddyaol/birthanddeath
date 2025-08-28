-- Facial Recognition Database Schema
-- SQL script to add facial recognition functionality to birth registration system

-- Create facial recognition table
CREATE TABLE IF NOT EXISTS `tbl_facial_recognition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `birth_id` int(11) NOT NULL,
  `face_image_path` varchar(255) NOT NULL,
  `face_descriptor` TEXT NOT NULL COMMENT 'JSON encoded face descriptor array',
  `confidence` decimal(4,3) DEFAULT NULL COMMENT 'Face detection confidence score',
  `face_landmarks` TEXT DEFAULT NULL COMMENT 'JSON encoded facial landmarks',
  `face_quality_score` decimal(4,3) DEFAULT NULL COMMENT 'Face quality assessment score',
  `verification_attempts` int(11) DEFAULT 0 COMMENT 'Number of verification attempts',
  `last_verified` datetime DEFAULT NULL COMMENT 'Last successful verification timestamp',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Whether this face data is active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_birth_face` (`birth_id`),
  KEY `idx_birth_id` (`birth_id`),
  KEY `idx_confidence` (`confidence`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_active` (`is_active`),
  CONSTRAINT `fk_facial_recognition_birth` FOREIGN KEY (`birth_id`) REFERENCES `tblbirth` (`birthId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Facial recognition data for birth records';

-- Add facial recognition fields to tblbirth table
ALTER TABLE `tblbirth` 
ADD COLUMN `has_facial_data` tinyint(1) DEFAULT 0 COMMENT 'Whether birth record has facial recognition data',
ADD COLUMN `facial_verification_enabled` tinyint(1) DEFAULT 1 COMMENT 'Whether facial verification is enabled for this record',
ADD COLUMN `face_capture_date` datetime DEFAULT NULL COMMENT 'When facial data was captured',
ADD COLUMN `face_last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last facial data update';

-- Add indexes for facial recognition fields in tblbirth
ALTER TABLE `tblbirth`
ADD KEY `idx_has_facial_data` (`has_facial_data`),
ADD KEY `idx_facial_verification_enabled` (`facial_verification_enabled`),
ADD KEY `idx_face_capture_date` (`face_capture_date`);

-- Create facial recognition verification log table
CREATE TABLE IF NOT EXISTS `tbl_facial_verification_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `birth_id` int(11) NOT NULL,
  `cert_no` varchar(255) NOT NULL,
  `verification_type` enum('registration','certificate_verification','manual_check') NOT NULL,
  `verification_result` enum('success','failure','error') NOT NULL,
  `confidence_score` decimal(4,3) DEFAULT NULL,
  `similarity_score` decimal(4,3) DEFAULT NULL,
  `error_code` varchar(50) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `admin_id` int(10) DEFAULT NULL COMMENT 'Admin who performed verification (if applicable)',
  `verification_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_birth_id` (`birth_id`),
  KEY `idx_cert_no` (`cert_no`),
  KEY `idx_verification_type` (`verification_type`),
  KEY `idx_verification_result` (`verification_result`),
  KEY `idx_verification_timestamp` (`verification_timestamp`),
  KEY `idx_admin_id` (`admin_id`),
  CONSTRAINT `fk_verification_log_birth` FOREIGN KEY (`birth_id`) REFERENCES `tblbirth` (`birthId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_verification_log_admin` FOREIGN KEY (`admin_id`) REFERENCES `tbladmin` (`adminId`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log of facial recognition verification attempts';

-- Create facial recognition settings table
CREATE TABLE IF NOT EXISTS `tbl_facial_recognition_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `setting_type` enum('boolean','integer','float','string','json') NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT 0 COMMENT 'Whether this is a system setting (non-deletable)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Facial recognition system settings';

-- Insert default facial recognition settings
INSERT INTO `tbl_facial_recognition_settings` (`setting_key`, `setting_value`, `setting_type`, `description`, `is_system`) VALUES
('facial_recognition_enabled', '1', 'boolean', 'Enable/disable facial recognition system', 1),
('min_confidence_threshold', '0.6', 'float', 'Minimum confidence threshold for face matching', 1),
('max_face_file_size', '2097152', 'integer', 'Maximum face image file size in bytes (2MB)', 1),
('face_quality_threshold', '0.5', 'float', 'Minimum face quality score required', 1),
('max_verification_attempts', '5', 'integer', 'Maximum verification attempts per day', 1),
('auto_cleanup_days', '30', 'integer', 'Days to keep verification logs before cleanup', 1),
('require_facial_verification', '0', 'boolean', 'Require facial verification for certificate access', 0),
('allowed_file_types', '["image/jpeg","image/png","image/jpg"]', 'json', 'Allowed file types for face images', 1),
('face_detection_options', '{"minFaceSize":160,"scoreThreshold":0.5,"nmsThreshold":0.4}', 'json', 'Face detection configuration options', 1);

-- Create view for birth records with facial recognition data
CREATE OR REPLACE VIEW `view_birth_with_facial_data` AS
SELECT 
    b.*,
    fr.id as face_id,
    fr.face_image_path,
    fr.confidence as face_confidence,
    fr.face_quality_score,
    fr.verification_attempts,
    fr.last_verified,
    fr.is_active as face_active,
    fr.created_at as face_created_at,
    fr.updated_at as face_updated_at,
    CASE 
        WHEN fr.id IS NOT NULL THEN 1 
        ELSE 0 
    END as has_facial_data_actual
FROM 
    tblbirth b
LEFT JOIN 
    tbl_facial_recognition fr ON b.birthId = fr.birth_id AND fr.is_active = 1;

-- Update existing records to set has_facial_data flag
UPDATE tblbirth b 
SET has_facial_data = (
    SELECT CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END
    FROM tbl_facial_recognition fr 
    WHERE fr.birth_id = b.birthId AND fr.is_active = 1
);

-- Create triggers to maintain has_facial_data flag
DELIMITER ;;

CREATE TRIGGER `tr_facial_recognition_insert` 
AFTER INSERT ON `tbl_facial_recognition`
FOR EACH ROW
BEGIN
    UPDATE tblbirth 
    SET has_facial_data = 1, face_capture_date = NEW.created_at 
    WHERE birthId = NEW.birth_id;
END;;

CREATE TRIGGER `tr_facial_recognition_update` 
AFTER UPDATE ON `tbl_facial_recognition`
FOR EACH ROW
BEGIN
    UPDATE tblbirth 
    SET has_facial_data = CASE WHEN NEW.is_active = 1 THEN 1 ELSE 0 END,
        face_capture_date = CASE WHEN NEW.is_active = 1 THEN NEW.updated_at ELSE NULL END
    WHERE birthId = NEW.birth_id;
END;;

CREATE TRIGGER `tr_facial_recognition_delete` 
AFTER DELETE ON `tbl_facial_recognition`
FOR EACH ROW
BEGIN
    UPDATE tblbirth 
    SET has_facial_data = (
        SELECT CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END
        FROM tbl_facial_recognition 
        WHERE birth_id = OLD.birth_id AND is_active = 1
    ),
    face_capture_date = NULL
    WHERE birthId = OLD.birth_id;
END;;

DELIMITER ;

-- Create stored procedures for facial recognition operations

DELIMITER ;;

-- Procedure to get facial recognition statistics
CREATE PROCEDURE `sp_get_facial_recognition_stats`()
BEGIN
    SELECT 
        (SELECT COUNT(*) FROM tbl_facial_recognition WHERE is_active = 1) as total_faces,
        (SELECT COUNT(*) FROM tbl_facial_recognition WHERE is_active = 1 AND DATE(created_at) = CURDATE()) as faces_today,
        (SELECT COUNT(*) FROM tblbirth WHERE has_facial_data = 1) as births_with_faces,
        (SELECT ROUND(AVG(confidence), 3) FROM tbl_facial_recognition WHERE confidence IS NOT NULL AND is_active = 1) as avg_confidence,
        (SELECT COUNT(*) FROM tbl_facial_verification_log WHERE DATE(verification_timestamp) = CURDATE()) as verifications_today,
        (SELECT COUNT(*) FROM tbl_facial_verification_log WHERE verification_result = 'success' AND DATE(verification_timestamp) = CURDATE()) as successful_verifications_today,
        (SELECT ROUND((COUNT(CASE WHEN verification_result = 'success' THEN 1 END) * 100.0 / COUNT(*)), 2) FROM tbl_facial_verification_log WHERE DATE(verification_timestamp) = CURDATE()) as success_rate_today;
END;;

-- Procedure to cleanup old verification logs
CREATE PROCEDURE `sp_cleanup_facial_verification_logs`(IN days_to_keep INT)
BEGIN
    DELETE FROM tbl_facial_verification_log 
    WHERE verification_timestamp < DATE_SUB(NOW(), INTERVAL days_to_keep DAY);
    
    SELECT ROW_COUNT() as deleted_records;
END;;

-- Procedure to get verification history for a birth record
CREATE PROCEDURE `sp_get_verification_history`(IN birth_record_id INT, IN limit_records INT)
BEGIN
    SELECT 
        vl.*,
        a.username as admin_username
    FROM tbl_facial_verification_log vl
    LEFT JOIN tbladmin a ON vl.admin_id = a.adminId
    WHERE vl.birth_id = birth_record_id
    ORDER BY vl.verification_timestamp DESC
    LIMIT limit_records;
END;;

DELIMITER ;

-- Grant necessary permissions (adjust as needed for your user)
-- GRANT SELECT, INSERT, UPDATE, DELETE ON birthanddeath.tbl_facial_recognition TO 'your_db_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON birthanddeath.tbl_facial_verification_log TO 'your_db_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON birthanddeath.tbl_facial_recognition_settings TO 'your_db_user'@'localhost';
-- GRANT SELECT ON birthanddeath.view_birth_with_facial_data TO 'your_db_user'@'localhost';
-- GRANT EXECUTE ON PROCEDURE birthanddeath.sp_get_facial_recognition_stats TO 'your_db_user'@'localhost';
-- GRANT EXECUTE ON PROCEDURE birthanddeath.sp_cleanup_facial_verification_logs TO 'your_db_user'@'localhost';
-- GRANT EXECUTE ON PROCEDURE birthanddeath.sp_get_verification_history TO 'your_db_user'@'localhost';

-- Create indexes for performance optimization
CREATE INDEX idx_birth_cert_facial ON tblbirth(certNo, has_facial_data);
CREATE INDEX idx_facial_birth_active ON tbl_facial_recognition(birth_id, is_active);
CREATE INDEX idx_verification_log_composite ON tbl_facial_verification_log(birth_id, verification_result, verification_timestamp);

-- Add comments to existing tables for documentation
ALTER TABLE tblbirth COMMENT = 'Birth registration records with facial recognition support';
ALTER TABLE tbl_facial_recognition COMMENT = 'Facial recognition biometric data for birth records';
ALTER TABLE tbl_facial_verification_log COMMENT = 'Audit log for facial recognition verification attempts';
ALTER TABLE tbl_facial_recognition_settings COMMENT = 'Configuration settings for facial recognition system';