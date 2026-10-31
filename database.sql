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
  `consent_given` TINYINT(1) NOT NULL DEFAULT 0,
  `consent_timestamp` DATETIME NULL,
  `consent_ip` VARCHAR(45) NULL,
  `consent_version` VARCHAR(20) NOT NULL DEFAULT 'v1.0',
  `is_anonymized` TINYINT(1) NOT NULL DEFAULT 0,
  `anonymized_at` DATETIME NULL,
  `admin_notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 2.1 Table: `dpdp_requests`
-- Stores Data Principal statutory requests (Access, Correction, Erasure, Grievance)
-- under Digital Personal Data Protection Act, 2023 (DPDP Act 2023)
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

-- (Inquiries & DPDP tables initialized empty)

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

-- (Projects table initialized empty — add client projects via Admin Panel)

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
('office_location', 'Vadodara, Gujarat, India • Global Client Delivery', 'contact'),
('whatsapp_number', '+919426782646', 'contact'),
('consultation_turnaround', '24 Hours Guaranteed', 'general'),
('bing_site_verification', '37D47CA67C44D215674E7B6D860E11FE', 'seo'),
('google_site_verification', '', 'seo'),
('google_analytics_id', 'G-18XT3VN71N', 'seo'),
('meta_pixel_id', '', 'seo'),
('seo_primary_keywords', 'RiTiVerse, RiTiVerse IT Services, RiTiVerse software company, web development company in vadodara, website developers vadodara, best web design company vadodara, custom CRM development vadodara, custom ERP software development, software development company in vadodara gujarat, offshore software development India, custom software engineering, hire CRM developers, enterprise ERP systems, zero lock-in software', 'seo'),
('social_linkedin', 'https://www.linkedin.com/company/ritiverse', 'social'),
('social_instagram', 'https://www.instagram.com/ritiverse.in?utm_source=ig_web_button_share_sheet&srtk=ZDNlZDc0MzIxNw==', 'social'),
('social_github', 'https://github.com/RiTIVerse', 'social'),
('social_x', 'https://x.com/RiTiVerseIn', 'social'),
('social_facebook', 'https://www.facebook.com/profile.php?id=61595110330028', 'social'),
('smtp_enabled', '1', 'smtp'),
('smtp_host', 'smtppro.zoho.in', 'smtp'),
('smtp_port', '465', 'smtp'),
('smtp_encryption', 'ssl', 'smtp'),
('smtp_username', 'info@ritiverse.in', 'smtp'),
('smtp_password', '', 'smtp'),
('smtp_from_email', 'info@ritiverse.in', 'smtp'),
('smtp_from_name', 'RiTiVerse Studio', 'smtp'),
('smtp_recipient_email', 'info@ritiverse.in', 'smtp'),
('smtp_allow_self_signed', '1', 'smtp')
('seo_meta_title', 'Custom Web, CRM & ERP Software Development Company | RiTiVerse', 'seo'),
('seo_meta_description', 'Custom software development company delivering bespoke websites, custom CRM platforms, enterprise ERP systems, and mobile apps with 100% source code ownership. Serving India, USA, UK, UAE & global clients.', 'seo'),
('seo_target_regions', 'Worldwide, US, UK, UAE, CA, AU, IN, DE, SG', 'seo')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`), `setting_group` = VALUES(`setting_group`);

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
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `seo_keywords` TEXT NULL,
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
INSERT INTO `services` (`id`, `title`, `slug`, `icon`, `tagline`, `seo_title`, `seo_description`, `seo_keywords`, `short_desc`, `full_desc`, `deliverables`, `tech_stack`, `timeline`, `starting_price`, `image_url`, `is_active`, `display_order`) VALUES
(1, 'Website Development', 'website-development', 'web', 'High-Converting, Ultra-Fast Business Websites with 100% Code Ownership', 'Custom Web Development Company | Elite Websites & Web Apps | RiTiVerse', 'Looking to build a high-performance business website or web app? RiTiVerse is a custom web development company delivering ultra-fast React & PHP web applications with 100% source code ownership. Serving India, USA, UK & worldwide.', 'custom web development company, hire web developers, website development services, responsive website design, React PHP web development, offshore web development agency, build custom website, web development company India USA UK', 'Fast, clean, and mobile-friendly websites built with React and PHP. Designed to load in under 2 seconds and convert visitors into inquiries.', 'We architect modern, lightning-fast business websites engineered to rank on Google and convert visitors. Unlike conventional agencies that deliver rigid WordPress templates with bloated plugins, every RiTiVerse website is custom-coded using semantic HTML5, modern React, and clean PHP. You receive 100% source code ownership pushed directly to your GitHub repository with zero vendor lock-in.', 'Sub-2-second page load times on mobile & desktop\nCustom UI/UX calibrated to your brand palette\nSEO meta structure & Schema.org rich snippets\nIntegrated contact & lead capture forms\n100% Source code ownership & repository transfer\nFree 30-day post-launch warranty & handover training', 'React 19, PHP 8.3, HTML5, CSS Tokens, Vite, Tailwind, MySQL', '1 – 2 Weeks', '', 'assets/card_web_apps.jpg', 1, 1),
(2, 'Mobile App Development', 'mobile-app-development', 'mobile', 'Native-Performance Android & iOS Apps Engineered for Scale', 'Mobile App Development Company | Native iOS & Android Apps | RiTiVerse', 'Top mobile app development company engineering high-performance Android & iOS mobile applications with 60fps animations, offline sync, and 100% client code ownership.', 'mobile app development company, hire mobile app developers, react native app development, flutter app development company, ios android app development, cross platform app agency', 'High-performance Android and iOS apps with smooth animations, offline data access, and instant push notifications for your users.', 'From initial wireframing to Google Play Store & Apple App Store deployment, we build fluid, responsive cross-platform and native mobile applications. Our mobile architectures feature sub-60fps smooth animations, secure token authentication, real-time push notifications, and offline caching.', 'Cross-platform iOS and Android builds with shared codebase\nOffline-first data synchronization & SQLite caching\nPush notification integration (Firebase / OneSignal)\nBiometric authentication & secure keychain storage\nApp Store & Google Play Store publishing support\nFull source code & build pipeline transfer', 'React Native, Flutter, Kotlin, Swift, Node.js, Firebase', '3 – 6 Weeks', '', 'assets/card_cloud_ai.jpg', 1, 2),
(3, 'Custom Software & APIs', 'custom-software-development', 'software', 'Bespoke Backend Engines, Microservices & High-Throughput APIs', 'Custom Software Development Company | Bespoke APIs & Portals | RiTiVerse', 'Bespoke software development company building scalable backend engines, web portals, microservices, and secure APIs with 100% source code ownership. Serving US, UK, UAE & global clients.', 'custom software development company, bespoke software development, hire dedicated developers, enterprise software solutions, offshore software engineering, API development services, custom software agency India', 'Tailored business software that fits your exact workflow. Automate daily manual tasks and connect third-party APIs easily.', 'When off-the-shelf software does not fit your operational workflow, RiTiVerse engineers bespoke software engines and microservices. We build scalable relational databases, asynchronous task queues, high-throughput REST and GraphQL APIs, and custom client dashboards that eliminate repetitive manual labor.', 'Custom business process automation engines\nHigh-throughput REST & GraphQL API microservices\nThird-party API integrations (Payment, WhatsApp, Shipping)\nRole-based access control (RBAC) & audit logs\nAutomated backup & server health monitoring\n100% client source code ownership on your GitHub', 'PHP 8.3, Laravel, Node.js, Express, Go, MySQL, Redis, Docker', '3 – 5 Weeks', '', 'assets/card_software_apis.jpg', 1, 3),
(4, 'Custom ERP Systems', 'erp-development', 'erp', 'All-in-One Enterprise Resource Planning with Zero Monthly Subscription Fees', 'Custom ERP Software Development Company | Enterprise ERP Systems | RiTiVerse', 'End-to-end custom ERP software development company. Build tailored inventory, billing, multi-warehouse, supply chain, and accounting ERP systems with zero recurring monthly subscription fees and 100% source code ownership.', 'custom erp development company, enterprise erp software development, cloud erp developers, custom erp software solutions, inventory billing erp, bespoke erp system development, offshore erp development, erp development India USA UK', 'Complete management software for billing, stock inventory, purchasing, finances, and staff tracking—custom-built for your business with zero per-user SaaS bills.', 'Eliminate expensive per-user SaaS bills. RiTiVerse designs custom Enterprise Resource Planning software tailored 100% to your manufacturing, wholesale, logistics, or service operations. Manage GST billing, multi-warehouse inventory, procurement, and staff payroll under one centralized dashboard.', 'Automated GST invoice generation & payment tracking\nMulti-warehouse stock & real-time inventory alerts\nSupplier procurement & purchase order management\nStaff attendance, role permissions & performance telemetry\nCustom financial profit/loss dashboards & export to Excel\nZero monthly license fees & 100% self-hosted ownership', 'PHP 8.3, Laravel, MySQL, React, Redis, Chart.js, PDF Engine', '4 – 8 Weeks', '', 'assets/card_ai_agents.jpg', 1, 4),
(5, 'Custom CRM Platforms', 'crm-development', 'crm', 'Automated Sales Pipelines, Lead Management & Multi-Channel Customer Telemetry', 'Custom CRM Development Company | Bespoke CRM Software Solutions | RiTiVerse', 'Build a custom CRM platform tailored to your exact sales pipeline. RiTiVerse engineers bespoke CRM software with WhatsApp automation, lead management, and zero monthly SaaS fees with 100% source code ownership for global clients.', 'custom crm development company, custom crm software development, build custom crm, bespoke crm developers, sales pipeline automation software, hire crm developers, crm software development agency, offshore crm development, crm development India USA UK', 'Manage customer inquiries, assign leads to sales reps, set WhatsApp/email reminders, and track conversion pipelines easily with zero monthly user fees.', 'Stop letting valuable prospective customers slip through the cracks. RiTiVerse creates custom Customer Relationship Management (CRM) platforms that automatically aggregate inbound inquiries from your website forms, WhatsApp, Google Ads, Facebook, and direct calls into a unified visual deal pipeline. Empower your sales reps with automated follow-ups, call logging, and conversion analytics without recurring per-seat subscriptions.', 'Visual drag-and-drop deal pipeline & stage tracking\nAutomated WhatsApp & Email follow-up reminders\nRound-robin lead assignment among sales team members\nCall logging, customer interaction timeline & notes\nTeam conversion performance & revenue forecast telemetry\nZero per-user monthly SaaS lock-in with full data privacy', 'React, Node.js, PHP, MySQL, WhatsApp Business API, WebSockets', '3 – 5 Weeks', '', 'assets/card_cloud_devops.jpg', 1, 5),
(6, 'E-Commerce Storefronts', 'ecommerce-development', 'ecommerce', 'High-Converting, 60fps Online Stores with 1-Click Checkout & Zero Monthly Cut', 'Custom E-Commerce Development Company | Fast Online Stores | RiTiVerse', 'Custom e-commerce web application development with sub-2-second catalog loading, 1-click checkout, 0% sales commission, and global multi-currency payment integration.', 'custom ecommerce development company, ecommerce website development, build online store, stripe razorpay ecommerce development, bespoke ecommerce solutions', 'Fast online shopping stores with one-click checkout, automated order management, and secure Razorpay, UPI, and card payments.', 'Stop giving away 2% to 5% of your gross sales in platform fees to Shopify or WooCommerce plugin ecosystems. We build high-speed, custom e-commerce web applications with sub-2-second product catalog loading, instant search filtering, automated inventory sync, and seamless UPI/Razorpay payment gateways.', 'Sub-2-second product catalog browsing with instant filters\nOptimized mobile checkout flow with UPI, Card & COD support\nAutomated order dispatch & Shiprocket / Delhivery API tracking\nDiscount coupon engine, customer cart abandonment recovery\nCustomer account dashboard with past orders & PDF invoices\nZero recurring platform fees with 100% client code ownership', 'Next.js, PHP, React, MySQL, Razorpay SDK, Shiprocket API', '2 – 4 Weeks', '', 'assets/featured-work.jpg', 1, 6)
ON DUPLICATE KEY UPDATE 
  `title` = VALUES(`title`),
  `tagline` = VALUES(`tagline`),
  `seo_title` = VALUES(`seo_title`),
  `seo_description` = VALUES(`seo_description`),
  `seo_keywords` = VALUES(`seo_keywords`),
  `short_desc` = VALUES(`short_desc`),
  `full_desc` = VALUES(`full_desc`),
  `deliverables` = VALUES(`deliverables`),
  `tech_stack` = VALUES(`tech_stack`);

-- ------------------------------------------------------------------------------
-- Seed DPDP Compliance & Grievance Redressal Officer Settings
-- ------------------------------------------------------------------------------
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('dpdp_dpo_name', 'Grievance Redressal Officer', 'dpdp'),
('dpdp_dpo_email', 'privacy@ritiverse.in', 'dpdp'),
('dpdp_dpo_designation', 'Data Protection & Grievance Officer', 'dpdp'),
('dpdp_retention_days', '365', 'dpdp'),
('dpdp_cookie_consent_active', '1', 'dpdp')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
