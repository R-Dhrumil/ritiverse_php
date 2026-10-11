-- ==============================================================================
-- RiTiVerse — Master Database Schema & Initial Seed Data
-- Compatible with MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+ (cPanel phpMyAdmin)
-- Charset: utf8mb4 (Full Unicode & Emoji Support)
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";

-- ------------------------------------------------------------------------------
-- 1. Table: `admin_users`
-- Stores admin panel accounts with Bcrypt password hashing
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL DEFAULT 'RiTiVerse Administrator',
  `role` ENUM('super_admin', 'editor') NOT NULL DEFAULT 'super_admin',
  `last_login` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial Administrator Credentials:
-- Username: admin  (or admin@ritiverse.in)
-- Password: Admin@123
INSERT INTO `admin_users` (`id`, `username`, `email`, `password_hash`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@ritiverse.in', '$2y$12$nZDXvvyXeGXEAwARdy7A8.PXsB/FcQa6nSatTUfYCT3HrgdscGLK2', 'Lead Architect', 'super_admin', NOW())
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ------------------------------------------------------------------------------
-- 2. Table: `inquiries`
-- Stores client consultation inquiries from contact form
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `company` VARCHAR(150) NOT NULL,
  `scope` VARCHAR(60) NOT NULL DEFAULT 'website',
  `timeline` VARCHAR(60) NOT NULL DEFAULT '1 – 2 months',
  `details` TEXT NOT NULL,
  `status` ENUM('new', 'contacted', 'in_progress', 'converted', 'archived') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Inquiries for demo/testing
INSERT INTO `inquiries` (`name`, `email`, `company`, `scope`, `timeline`, `details`, `status`, `created_at`) VALUES
('Vikram Mehta', 'vikram@mehtalogistics.in', 'Mehta Logistics India', 'erp', '1-2 months', 'Looking for an enterprise ERP and warehouse tracking solution with zero monthly SaaS lock-in.', 'new', NOW() - INTERVAL 2 HOUR),
('Pooja Patel', 'pooja@swadeshiayur.com', 'Swadeshi Wellness', 'ecommerce', 'immediate', 'Need high-converting e-commerce web platform for herbal product catalog with Razorpay & Shiprocket integration.', 'contacted', NOW() - INTERVAL 1 DAY),
('Anand Verma', 'anand@fintechcore.io', 'FintechCore Solutions', 'custom', '2-4 months', 'Bespoke portfolio telemetry dashboard with high-frequency charting and sub-100ms API response time.', 'converted', NOW() - INTERVAL 3 DAY);

-- ------------------------------------------------------------------------------
-- 3. Table: `projects`
-- Reference architectures and case studies showcased on site
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(160) NOT NULL UNIQUE,
  `category` VARCHAR(50) NOT NULL DEFAULT 'web',
  `tag_label` VARCHAR(80) NOT NULL DEFAULT 'Production Architecture',
  `description` TEXT NOT NULL,
  `metric_1_val` VARCHAR(50) NOT NULL DEFAULT '',
  `metric_1_lbl` VARCHAR(50) NOT NULL DEFAULT '',
  `metric_2_val` VARCHAR(50) NOT NULL DEFAULT '',
  `metric_2_lbl` VARCHAR(50) NOT NULL DEFAULT '',
  `metric_3_val` VARCHAR(50) NOT NULL DEFAULT '',
  `metric_3_lbl` VARCHAR(50) NOT NULL DEFAULT '',
  `tech_tags` VARCHAR(255) NOT NULL DEFAULT '',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `display_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_category` (`category`),
  INDEX `idx_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Flagship Projects
INSERT INTO `projects` (`id`, `title`, `slug`, `category`, `tag_label`, `description`, `metric_1_val`, `metric_1_lbl`, `metric_2_val`, `metric_2_lbl`, `metric_3_val`, `metric_3_lbl`, `tech_tags`, `is_featured`, `display_order`) VALUES
(1, 'Aegis Financial Telemetry OS', 'aegis-financial-telemetry', 'custom web', 'FinTech Architecture', 'High-frequency algorithmic portfolio monitoring reference platform streaming real-time market data across global exchanges with sub-50ms latency.', '0.12s', 'Global Latency', 'Real-Time', 'Data Streams', '100%', 'Source IP', 'Go, Next.js 15, TimescaleDB, WebSockets, AWS EKS', 1, 1),
(2, 'Verve Global Logistics Engine', 'verve-logistics-engine', 'cloud custom', 'Supply Chain Architecture', 'Self-healing containerized microservices architecture demonstrating automated route optimization, telemetry ingestion, and distributed cluster failover.', 'High-Avail', 'Architecture', 'Docker/K8s', 'Containers', 'Zero', 'Lock-In', 'Express.js, Node.js, MySQL, REST APIs, Server Hosting', 1, 2),
(3, 'OmniSphere Private AI Workspace', 'omnisphere-ai-workspace', 'ai custom', 'Enterprise AI Architecture', 'Air-gapped enterprise intelligence prototype demonstrating proprietary document indexing with vector semantic search, hybrid retrieval, and multi-agent synthesis.', 'Sub-second', 'Vector Search', 'pgvector', 'Embeddings', 'Private', 'VPC Isolation', 'Python, FastAPI, pgvector, Claude 3.7, TypeScript', 1, 3),
(4, 'Pulse Luxury Digital Flagship', 'pulse-digital-flagship', 'web', 'Headless Web Platform', 'Cinematic, 60fps editorial buying experience reference built with Next.js 15, edge rendering, and bespoke UI interactions with sub-second page transitions.', '100/100', 'Lighthouse Score', '60 FPS', 'Smooth Motion', '0.18s', 'Average TTFB', 'Next.js 15, React 19, Cloudflare, GSAP, Tailored Tokens', 1, 4),
(5, 'Apex Cloud Observability Console', 'apex-cloud-observability', 'cloud web', 'Observability Platform', 'Real-time operational dashboard visualizing cluster metrics, multi-tenant container health, and automated anomaly detection alerts.', 'Real-Time', 'Telemetry', '45ms', 'Query Latency', '100%', 'Self-Hosted', 'Go, ClickHouse, React, Grafana Engine, Docker', 1, 5),
(6, 'Strata Distributed API Gateway', 'strata-api-gateway', 'custom cloud', 'Distributed Systems', 'High-throughput gRPC and GraphQL routing fabric connecting distributed microservices with cryptographic token verification and zero-downtime blue/green rollouts.', 'Sub-millisecond', 'Proxy Routing', 'Zero Downtime', 'Blue / Green', '0 Lock-In', 'Standard gRPC', 'Go, gRPC, Envoy, PostgreSQL, AWS', 1, 6)
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ------------------------------------------------------------------------------
-- 4. Table: `site_settings`
-- Key-value store for site contact information, global notice, etc.
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(60) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `setting_group` VARCHAR(40) NOT NULL DEFAULT 'general',
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Default Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_name', 'RiTiVerse', 'general'),
('site_tagline', 'Elite Website & Software Development', 'general'),
('contact_email', 'info@ritiverse.in', 'contact'),
('support_email', 'support@ritiverse.in', 'contact'),
('contact_phone', '+91 98765 43210', 'contact'),
('office_location', 'Ahmedabad / Mumbai, India • Global Client Delivery', 'contact'),
('whatsapp_number', '+919876543210', 'contact'),
('consultation_turnaround', '24 Hours Guaranteed', 'general')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
