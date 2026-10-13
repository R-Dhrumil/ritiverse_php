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
  `client_name` VARCHAR(150) NOT NULL DEFAULT '',
  `category` VARCHAR(50) NOT NULL DEFAULT 'web',
  `tag_label` VARCHAR(80) NOT NULL DEFAULT 'Production Architecture',
  `description` TEXT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL DEFAULT '',
  `live_url` VARCHAR(255) NOT NULL DEFAULT '',
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
INSERT INTO `projects` (`id`, `title`, `slug`, `client_name`, `category`, `tag_label`, `description`, `image_url`, `live_url`, `metric_1_val`, `metric_1_lbl`, `metric_2_val`, `metric_2_lbl`, `metric_3_val`, `metric_3_lbl`, `tech_tags`, `is_featured`, `display_order`) VALUES
(1, 'Aegis Financial Telemetry OS', 'aegis-financial-telemetry', 'FinTech Global Corp', 'custom web', 'FinTech Architecture', 'High-frequency algorithmic portfolio monitoring reference platform streaming real-time market data across global exchanges with sub-50ms latency.', 'assets/card_software_apis.jpg', '', '0.12s', 'Global Latency', 'Real-Time', 'Data Streams', '100%', 'Source IP', 'Go, Next.js 15, TimescaleDB, WebSockets, AWS EKS', 1, 1),
(2, 'Verve Global Logistics Engine', 'verve-logistics-engine', 'Mehta Logistics India', 'cloud custom', 'Supply Chain Architecture', 'Self-healing containerized microservices architecture demonstrating automated route optimization, telemetry ingestion, and distributed cluster failover.', 'assets/card_cloud_devops.jpg', '', 'High-Avail', 'Architecture', 'Docker/K8s', 'Containers', 'Zero', 'Lock-In', 'Express.js, Node.js, MySQL, REST APIs, Server Hosting', 1, 2),
(3, 'OmniSphere Private AI Workspace', 'omnisphere-ai-workspace', 'Enterprise Intelligence Corp', 'ai custom', 'Enterprise AI Architecture', 'Air-gapped enterprise intelligence prototype demonstrating proprietary document indexing with vector semantic search, hybrid retrieval, and multi-agent synthesis.', 'assets/card_ai_agents.jpg', '', 'Sub-second', 'Vector Search', 'pgvector', 'Embeddings', 'Private', 'VPC Isolation', 'Python, FastAPI, pgvector, Claude 3.7, TypeScript', 1, 3),
(4, 'Pulse Luxury Digital Flagship', 'pulse-digital-flagship', 'Pulse Retail Group', 'web', 'Headless Web Platform', 'Cinematic, 60fps editorial buying experience reference built with Next.js 15, edge rendering, and bespoke UI interactions with sub-second page transitions.', 'assets/card_web_apps.jpg', '', '100/100', 'Lighthouse Score', '60 FPS', 'Smooth Motion', '0.18s', 'Average TTFB', 'Next.js 15, React 19, Cloudflare, GSAP, Tailored Tokens', 1, 4),
(5, 'Apex Cloud Observability Console', 'apex-cloud-observability', 'Apex Cloud Systems', 'cloud web', 'Observability Platform', 'Real-time operational dashboard visualizing cluster metrics, multi-tenant container health, and automated anomaly detection alerts.', 'assets/card_cloud_ai.jpg', '', 'Real-Time', 'Telemetry', '45ms', 'Query Latency', '100%', 'Self-Hosted', 'Go, ClickHouse, React, Grafana Engine, Docker', 1, 5),
(6, 'Strata Distributed API Gateway', 'strata-api-gateway', 'Strata Networks', 'custom cloud', 'Distributed Systems', 'High-throughput gRPC and GraphQL routing fabric connecting distributed microservices with cryptographic token verification and zero-downtime blue/green rollouts.', 'assets/card_software_apis.jpg', '', 'Sub-millisecond', 'Proxy Routing', 'Zero Downtime', 'Blue / Green', '0 Lock-In', 'Standard gRPC', 'Go, gRPC, Envoy, PostgreSQL, AWS', 1, 6)
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
('contact_phone', '+91 94267 82646', 'contact'),
('office_location', 'Ahmedabad / Mumbai, India • Global Client Delivery', 'contact'),
('whatsapp_number', '+919426782646', 'contact'),
('consultation_turnaround', '24 Hours Guaranteed', 'general'),
('bing_site_verification', '37D47CA67C44D215674E7B6D860E11FE', 'seo'),
('google_site_verification', '', 'seo'),
('google_analytics_id', '', 'seo'),
('meta_pixel_id', '', 'seo'),
('seo_primary_keywords', 'website making, website development company India, custom CRM development, ERP software development, ERP billing software, custom software development, mobile app development, e-commerce website design, React PHP development agency, zero vendor lock-in software', 'seo'),
('social_linkedin', 'https://www.linkedin.com/company/ritiverse', 'social'),
('social_instagram', 'https://www.instagram.com/ritiverse.in?utm_source=ig_web_button_share_sheet&srtk=ZDNlZDc0MzIxNw==', 'social'),
('social_github', 'https://github.com/RiTIVerse', 'social'),
('social_x', 'https://x.com/RiTiVerseIn', 'social'),
('social_facebook', 'https://www.facebook.com/profile.php?id=61595110330028', 'social')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- ------------------------------------------------------------------------------
-- 5. Table: `services`
-- Core engineering service domains and dedicated landing pages
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(160) NOT NULL UNIQUE,
  `icon` VARCHAR(60) NOT NULL DEFAULT 'web',
  `tagline` VARCHAR(255) NOT NULL DEFAULT '',
  `short_desc` TEXT NOT NULL,
  `full_desc` TEXT NOT NULL,
  `deliverables` TEXT NOT NULL,
  `tech_stack` VARCHAR(255) NOT NULL DEFAULT '',
  `timeline` VARCHAR(80) NOT NULL DEFAULT '2 – 4 Weeks',
  `starting_price` VARCHAR(80) NOT NULL DEFAULT '',
  `image_url` VARCHAR(255) NOT NULL DEFAULT '',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `display_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed 6 Core Engineering Services
INSERT INTO `services` (`id`, `title`, `slug`, `icon`, `tagline`, `short_desc`, `full_desc`, `deliverables`, `tech_stack`, `timeline`, `starting_price`, `image_url`, `is_active`, `display_order`) VALUES
(1, 'Website Development', 'website-development', 'web', 'High-Converting, Ultra-Fast Business Websites with 100% Code Ownership', 'Fast, clean, and mobile-friendly websites built with React and PHP. Designed to load in under 2 seconds and convert visitors into inquiries.', 'We architect modern, lightning-fast business websites engineered to rank on Google and convert visitors. Unlike conventional agencies that deliver rigid WordPress templates with bloated plugins, every RiTiVerse website is custom-coded using semantic HTML5, modern React, and clean PHP. You receive 100% source code ownership pushed directly to your GitHub repository with zero vendor lock-in.', 'Sub-2-second page load times on mobile & desktop\nCustom UI/UX calibrated to your brand palette\nSEO meta structure & Schema.org rich snippets\nIntegrated contact & lead capture forms\n100% Source code ownership & repository transfer\nFree 30-day post-launch warranty & handover training', 'React 19, PHP 8.3, HTML5, CSS Tokens, Vite, Tailwind, MySQL', '1 – 2 Weeks', '', 'assets/card_web_apps.jpg', 1, 1),
(2, 'Mobile App Development', 'mobile-app-development', 'mobile', 'Native-Performance Android & iOS Apps Engineered for Scale', 'High-performance Android and iOS apps with smooth animations, offline data access, and instant push notifications for your users.', 'From initial wireframing to Google Play Store & Apple App Store deployment, we build fluid, responsive cross-platform and native mobile applications. Our mobile architectures feature sub-60fps smooth animations, secure token authentication, real-time push notifications, and offline caching.', 'Cross-platform iOS and Android builds with shared codebase\nOffline-first data synchronization & SQLite caching\nPush notification integration (Firebase / OneSignal)\nBiometric authentication & secure keychain storage\nApp Store & Google Play Store publishing support\nFull source code & build pipeline transfer', 'React Native, Flutter, Kotlin, Swift, Node.js, Firebase', '3 – 6 Weeks', '', 'assets/card_cloud_ai.jpg', 1, 2),
(3, 'Custom Software & APIs', 'custom-software-development', 'software', 'Bespoke Backend Engines, Microservices & High-Throughput APIs', 'Tailored business software that fits your exact workflow. Automate daily manual tasks and connect third-party APIs easily.', 'When off-the-shelf software does not fit your operational workflow, RiTiVerse engineers bespoke software engines and microservices. We build scalable relational databases, asynchronous task queues, high-throughput REST and GraphQL APIs, and custom client dashboards that eliminate repetitive manual labor.', 'Custom business process automation engines\nHigh-throughput REST & GraphQL API microservices\nThird-party API integrations (Payment, WhatsApp, Shipping)\nRole-based access control (RBAC) & audit logs\nAutomated backup & server health monitoring\n100% client source code ownership on your GitHub', 'PHP 8.3, Laravel, Node.js, Express, Go, MySQL, Redis, Docker', '3 – 5 Weeks', '', 'assets/card_software_apis.jpg', 1, 3),
(4, 'Custom ERP Systems', 'erp-development', 'erp', 'All-in-One Enterprise Resource Planning with Zero Monthly Subscription Fees', 'Complete management software for billing, stock inventory, purchasing, finances, and staff tracking—custom-built for your business.', 'Tired of paying thousands of dollars every month for rigid ERP subscriptions that charge per user? RiTiVerse designs custom Enterprise Resource Planning software tailored 100% to your manufacturing, wholesale, logistics, or service operations. Manage GST billing, multi-warehouse inventory, procurement, and staff payroll under one centralized dashboard.', 'Automated GST invoice generation & payment tracking\nMulti-warehouse stock & real-time inventory alerts\nSupplier procurement & purchase order management\nStaff attendance, role permissions & performance telemetry\nCustom financial profit/loss dashboards & export to Excel\nZero monthly license fees & 100% self-hosted ownership', 'PHP 8.3, Laravel, MySQL, React, Redis, Chart.js, PDF Engine', '4 – 8 Weeks', '', 'assets/card_ai_agents.jpg', 1, 4),
(5, 'Custom CRM Platforms', 'crm-development', 'crm', 'Automated Sales Pipelines, Lead Management & Multi-Channel Customer Telemetry', 'Manage customer inquiries, assign leads to sales reps, set WhatsApp/email reminders, and track conversion pipelines easily.', 'Never lose another prospective client lead. Our custom CRM platforms aggregate leads from your website forms, WhatsApp, Facebook, Google Ads, and walk-ins into a unified visual pipeline. Automated follow-up reminders, lead scoring, and team assignment prevent leads from slipping through the cracks.', 'Visual drag-and-drop deal pipeline & stage tracking\nAutomated WhatsApp & Email follow-up reminders\nRound-robin lead assignment among sales team members\nCall logging, customer interaction timeline & notes\nTeam conversion performance & revenue forecast telemetry\nZero per-user monthly SaaS lock-in with full data privacy', 'React, Node.js, PHP, MySQL, WhatsApp Business API, WebSockets', '3 – 5 Weeks', '', 'assets/card_cloud_devops.jpg', 1, 5),
(6, 'E-Commerce Storefronts', 'ecommerce-development', 'ecommerce', 'High-Converting, 60fps Online Stores with 1-Click Checkout & Zero Monthly Cut', 'Fast online shopping stores with one-click checkout, automated order management, and secure Razorpay, UPI, and card payments.', 'Stop giving away 2% to 5% of your gross sales in platform fees to Shopify or WooCommerce plugin ecosystems. We build high-speed, custom e-commerce web applications with sub-2-second product catalog loading, instant search filtering, automated inventory sync, and seamless UPI/Razorpay payment gateways.', 'Sub-2-second product catalog browsing with instant filters\nOptimized mobile checkout flow with UPI, Card & COD support\nAutomated order dispatch & Shiprocket / Delhivery API tracking\nDiscount coupon engine, customer cart abandonment recovery\nCustomer account dashboard with past orders & PDF invoices\nZero recurring platform fees with 100% client code ownership', 'Next.js, PHP, React, MySQL, Razorpay SDK, Shiprocket API', '2 – 4 Weeks', '', 'assets/featured-work.jpg', 1, 6)
ON DUPLICATE KEY UPDATE `id` = `id`;

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
