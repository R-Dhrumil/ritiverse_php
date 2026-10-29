-- ==============================================================================
-- RiTiVerse — DPDP Act 2023 Security & Compliance Database Migration
-- Implements compliance with Digital Personal Data Protection Act, 2023 (India)
-- Compatible with MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+ (cPanel phpMyAdmin)
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- 1. Augment `inquiries` table with DPDP Consent & Anonymization Audit fields
-- ------------------------------------------------------------------------------
ALTER TABLE `inquiries`
  ADD COLUMN IF NOT EXISTS `consent_given` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`,
  ADD COLUMN IF NOT EXISTS `consent_timestamp` DATETIME NULL AFTER `consent_given`,
  ADD COLUMN IF NOT EXISTS `consent_ip` VARCHAR(45) NULL AFTER `consent_timestamp`,
  ADD COLUMN IF NOT EXISTS `consent_version` VARCHAR(20) NOT NULL DEFAULT 'v1.0' AFTER `consent_ip`,
  ADD COLUMN IF NOT EXISTS `is_anonymized` TINYINT(1) NOT NULL DEFAULT 0 AFTER `consent_version`,
  ADD COLUMN IF NOT EXISTS `anonymized_at` DATETIME NULL AFTER `is_anonymized`;

-- ------------------------------------------------------------------------------
-- 2. Create `dpdp_requests` table: Data Principal Statutory Rights Management
-- Handles: Access (Sec 11), Correction (Sec 12), Erasure (Sec 12(3)), Grievances (Sec 13)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dpdp_requests` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` VARCHAR(32) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `phone` VARCHAR(30) NULL,
  `request_type` ENUM('access', 'correction', 'erasure', 'withdraw_consent', 'grievance') NOT NULL,
  `details` TEXT NOT NULL,
  `status` ENUM('pending', 'in_review', 'fulfilled', 'rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `resolved_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_req_type` (`request_type`),
  INDEX `idx_req_status` (`status`),
  INDEX `idx_req_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. Seed DPDP Compliance & Grievance Redressal Officer Settings
-- ------------------------------------------------------------------------------
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('dpdp_dpo_name', 'Grievance Redressal Officer', 'dpdp'),
('dpdp_dpo_email', 'privacy@ritiverse.in', 'dpdp'),
('dpdp_dpo_designation', 'Data Protection & Grievance Officer', 'dpdp'),
('dpdp_retention_days', '365', 'dpdp'),
('dpdp_cookie_consent_active', '1', 'dpdp')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

SET FOREIGN_KEY_CHECKS = 1;
