-- Add biometric and imageType columns to tblbirth table
ALTER TABLE `tblbirth` ADD COLUMN `biometric` LONGBLOB AFTER `dateReg`;
ALTER TABLE `tblbirth` ADD COLUMN `imageType` varchar(255) AFTER `biometric`;
ALTER TABLE `tblbirth` ADD COLUMN `payId` int(11) DEFAULT 0 AFTER `imageType`;
ALTER TABLE `tblbirth` ADD COLUMN `pod` varchar(255) AFTER `birthPlace`;
ALTER TABLE `tblbirth` ADD COLUMN `father_occupation` varchar(255) AFTER `mothersName`;
ALTER TABLE `tblbirth` ADD COLUMN `father_nationality` varchar(255) AFTER `father_occupation`;
ALTER TABLE `tblbirth` ADD COLUMN `father_religion` varchar(255) AFTER `father_nationality`;
ALTER TABLE `tblbirth` ADD COLUMN `mother_nationality` varchar(255) AFTER `father_religion`; 