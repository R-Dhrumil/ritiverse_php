-- ==============================================================================
-- RiTiVerse — SEO & International Search Optimization SQL Patch
-- Safe to run in cPanel phpMyAdmin / MySQL / MariaDB Console
-- Updates site settings, adds SEO columns, and updates all 6 services with high-intent keywords
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

-- ------------------------------------------------------------------------------
-- 1. Update Global SEO & International Search Settings in `site_settings`
-- ------------------------------------------------------------------------------
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('seo_primary_keywords', 'RiTiVerse, RiTiVerse IT Services, RiTiVerse software company, web development company in vadodara, website developers vadodara, best web design company vadodara, custom CRM development vadodara, custom ERP software development, software development company in vadodara gujarat, offshore software development India, custom software engineering, hire CRM developers, enterprise ERP systems, zero lock-in software', 'seo'),
('seo_meta_title', 'RiTiVerse — IT Services, Custom Web, CRM & ERP Software Development Company', 'seo'),
('seo_meta_description', 'RiTiVerse is an official IT services & custom software development company in Vadodara, Gujarat. We build websites, CRM, ERP & apps with 100% code ownership.', 'seo'),
('seo_target_regions', 'Vadodara, Gujarat, India, Worldwide, US, UK, UAE, CA, AU, DE, SG', 'seo'),
('office_location', 'Vadodara, Gujarat, India • Global Client Delivery', 'contact')
ON DUPLICATE KEY UPDATE 
  `setting_value` = VALUES(`setting_value`),
  `setting_group` = VALUES(`setting_group`);

-- ------------------------------------------------------------------------------
-- 2. Add SEO Metadata Columns to `services` Table (if not exists)
-- ------------------------------------------------------------------------------
ALTER TABLE `services` 
  ADD COLUMN IF NOT EXISTS `seo_title` VARCHAR(255) NULL AFTER `tagline`,
  ADD COLUMN IF NOT EXISTS `seo_description` TEXT NULL AFTER `seo_title`,
  ADD COLUMN IF NOT EXISTS `seo_keywords` TEXT NULL AFTER `seo_description`;

-- ------------------------------------------------------------------------------
-- 3. Update Existing 6 Services with High-Intent Commercial SEO Content
-- ------------------------------------------------------------------------------

-- Service 1: Website Development
UPDATE `services` SET
  `title` = 'Website Development',
  `tagline` = 'High-Converting, Ultra-Fast Business Websites with 100% Code Ownership',
  `short_desc` = 'Fast, clean, and mobile-friendly websites built with React and PHP. Designed to load in under 2 seconds and convert visitors into inquiries.',
  `full_desc` = 'We architect modern, lightning-fast business websites engineered to rank on Google and convert visitors into paying clients. Based in Vadodara, Gujarat, we deliver custom websites for local leaders and international enterprises. Unlike conventional digital agencies that deliver rigid WordPress templates burdened with 30+ bloated plugins, every RiTiVerse website is custom-coded using clean HTML5, modern React, and performant PHP. You receive 100% source code ownership pushed directly to your company\'s GitHub repository from Day 1 with zero ongoing platform lock-in fees.',
  `deliverables` = 'Sub-2-second page load speeds on mobile & desktop networks\nBespoke UI/UX design calibrated to your brand identity & typography\nTechnical SEO structure, OpenGraph cards & Schema.org rich snippets\nIntegrated inquiry capture forms with instant WhatsApp & email alerts\nFull responsive optimization across iOS, Android, tablets & ultra-wide screens\n100% Source code ownership with GitHub / GitLab repository handover\nFree 30-day post-launch warranty, speed audits & technical training',
  `tech_stack` = 'React 19, PHP 8.3, HTML5, CSS Tokens, Vite, Tailwind, MySQL',
  `seo_title` = 'Web Development Company in Vadodara | Custom Websites | RiTiVerse',
  `seo_description` = 'Top web development company in Vadodara, Gujarat. We engineer custom business websites, portals & web apps with sub-2s load time and 100% source code ownership.',
  `seo_keywords` = 'web development company in vadodara, website developers vadodara, web design company in vadodara, custom web development vadodara, best website development company in vadodara, hire web developers in vadodara, IT company in vadodara gujarat, offshore web development India'
WHERE `slug` = 'website-development';

-- Service 2: Custom CRM Platforms
UPDATE `services` SET
  `title` = 'Custom CRM Platforms',
  `tagline` = 'Automated Sales Pipelines, Lead Management & Zero Monthly SaaS Fees',
  `short_desc` = 'Manage customer inquiries, assign leads to sales reps, set WhatsApp/email reminders, and track conversion pipelines easily with zero monthly user fees.',
  `full_desc` = 'Stop letting valuable prospective customers slip through the cracks. RiTiVerse creates custom Customer Relationship Management (CRM) platforms that automatically aggregate inbound inquiries from your website forms, WhatsApp, Google Ads, Facebook, and direct calls into a unified visual deal pipeline. Empower your sales reps with automated follow-ups, call logging, and conversion analytics without recurring per-seat subscriptions.',
  `deliverables` = 'Visual Kanban drag-and-drop lead pipeline with custom deal stages\nAutomated lead capture from Website forms, WhatsApp Business, Meta Ads & Google\nIntelligent round-robin lead distribution among sales representatives\nAutomated WhatsApp and Email follow-up triggers and reminder task queues\nDetailed client interaction timelines, meeting notes, call logs & document attachments\nExecutive conversion analytics: rep performance, close rates & revenue forecasting\n100% Source code ownership and self-hosted database privacy',
  `tech_stack` = 'React, Node.js, PHP, MySQL, WhatsApp Business API, WebSockets',
  `seo_title` = 'Custom CRM Software Development Company in Vadodara | RiTiVerse',
  `seo_description` = 'Leading custom CRM development company in Vadodara. Automated WhatsApp follow-ups, sales pipelines & lead management with zero monthly SaaS subscription fees.',
  `seo_keywords` = 'crm development company in vadodara, custom crm software vadodara, crm developers vadodara gujarat, lead management crm vadodara, bespoke crm software development, offshore crm development India'
WHERE `slug` = 'crm-development';

-- Service 3: Custom ERP Systems
UPDATE `services` SET
  `title` = 'Custom ERP Systems',
  `tagline` = 'All-in-One Enterprise Resource Planning with Zero Monthly Subscription Fees',
  `short_desc` = 'Complete management software for billing, stock inventory, purchasing, finances, and staff tracking—custom-built for your business with zero per-user SaaS bills.',
  `full_desc` = 'Eliminate expensive per-user SaaS bills. RiTiVerse designs custom Enterprise Resource Planning (ERP) systems tailored to manufacturing, distribution, retail, and service businesses. Centralize your GST billing, multi-warehouse inventory, procurement cycles, staff attendance, and financial ledgers into one blazing-fast, secure dashboard that your entire organization can use without paying monthly user licenses.',
  `deliverables` = 'GST/VAT-compliant automated invoicing, credit notes & payment receipt generation\nMulti-location warehouse stock tracking with low-inventory automated alerts\nVendor procurement, purchase orders & supplier payment lifecycle management\nStaff biometric attendance tracking, shift scheduling & payroll computation\nInteractive financial analytics: gross margin, daily P&L, balance sheets & Excel export\nGranular department roles (Accounts, Warehouse, Sales, Management)\n100% Self-hosted server deployment with encrypted nightly database backups',
  `tech_stack` = 'PHP 8.3, Laravel, MySQL, React, Redis, Chart.js, PDF Engine',
  `seo_title` = 'Custom ERP & Billing Software Development in Vadodara | RiTiVerse',
  `seo_description` = 'Custom ERP and GST billing software company in Vadodara, Gujarat. Tailored inventory, dispatch & accounting ERP platforms with zero monthly per-user fees.',
  `seo_keywords` = 'erp software company in vadodara, custom erp development vadodara, billing software vadodara gujarat, inventory management software vadodara, enterprise erp systems vadodara, offshore erp development India'
WHERE `slug` = 'erp-development';

-- Service 4: Custom Software & APIs
UPDATE `services` SET
  `title` = 'Custom Software & APIs',
  `tagline` = 'Bespoke Backend Engines, Microservices & High-Throughput APIs',
  `short_desc` = 'Tailored business software that fits your exact workflow. Automate daily manual tasks and connect third-party APIs easily.',
  `full_desc` = 'When commercial off-the-shelf software falls short of your operational workflow, RiTiVerse builds bespoke software engines and microservices from scratch. We architect scalable relational schemas, asynchronous job queues, high-throughput REST and GraphQL APIs, and custom operational portals that eliminate manual spreadsheets and repetitive human data entry.',
  `deliverables` = 'Tailor-made business workflow automation engines eliminating manual entry\nHigh-throughput REST and GraphQL API microservices with sub-120ms response\nSeamless third-party integrations (Payment Gateways, WhatsApp, SMS, Shipping)\nGranular Role-Based Access Control (RBAC) with complete audit trail logs\nAutomated server health telemetry, failover alerts & encrypted backups\nComprehensive Swagger / Postman API documentation & developer onboarding\n100% Intellectual property and source code transfer to your repository',
  `tech_stack` = 'PHP 8.3, Laravel, Node.js, Express, Go, MySQL, Redis, Docker',
  `seo_title` = 'Custom Software Development Company | Bespoke APIs & Portals | RiTiVerse',
  `seo_description` = 'Bespoke software development company building scalable backend engines, web portals, microservices, and secure APIs with 100% source code ownership. Serving US, UK, UAE & global clients.',
  `seo_keywords` = 'custom software development company, bespoke software development, hire dedicated developers, enterprise software solutions, offshore software engineering, API development services, custom software agency India'
WHERE `slug` = 'custom-software-development';

-- Service 5: Mobile App Development
UPDATE `services` SET
  `title` = 'Mobile App Development',
  `tagline` = 'Native-Performance Android & iOS Apps Engineered for Scale',
  `short_desc` = 'High-performance Android and iOS apps with smooth animations, offline data access, and instant push notifications for your users.',
  `full_desc` = 'From initial interactive wireframing to Google Play Store and Apple App Store publishing, RiTiVerse builds fluid, reliable mobile applications. We leverage modern cross-platform frameworks (React Native, Flutter) and native toolchains to deliver 60fps animations, rock-solid offline caching, real-time push notifications, and biometric security—all backed by clean microservices.',
  `deliverables` = 'Cross-platform Android & iOS builds from a unified, maintainable codebase\nSub-60fps fluid UI transitions and gesture animations\nOffline-first SQLite / WatermelonDB data synchronization\nReal-time push notifications via Firebase Cloud Messaging (FCM) & OneSignal\nSecure biometric authentication (FaceID, Fingerprint) & keychain storage\nEnd-to-end Google Play Store & Apple App Store compliance & submission\n100% Client ownership of build pipelines, keystores & app repository',
  `tech_stack` = 'React Native, Flutter, Kotlin, Swift, Node.js, Firebase, SQLite',
  `seo_title` = 'Mobile App Development Company | Native iOS & Android Apps | RiTiVerse',
  `seo_description` = 'Top mobile app development company engineering high-performance Android & iOS mobile applications with 60fps animations, offline sync, and 100% client code ownership.',
  `seo_keywords` = 'mobile app development company, hire mobile app developers, react native app development, flutter app development company, ios android app development, cross platform app agency'
WHERE `slug` = 'mobile-app-development';

-- Service 6: E-Commerce Storefronts
UPDATE `services` SET
  `title` = 'E-Commerce Storefronts',
  `tagline` = 'High-Converting, 60fps Online Stores with 1-Click Checkout & Zero Monthly Cut',
  `short_desc` = 'Fast online shopping stores with one-click checkout, automated order management, and secure Razorpay, UPI, and card payments.',
  `full_desc` = 'Avoid surrendering 2% to 5% of your gross sales in platform fees to hosted e-commerce builders. RiTiVerse engineers high-speed, custom e-commerce web applications with sub-2-second product catalog loading, instant faceted filtering, automated stock synchronization, and lightning-fast UPI / Razorpay payment flows that maximize checkout conversion.',
  `deliverables` = 'Sub-2-second catalog loading with instant category, size & price filtering\nFrictionless 1-click mobile checkout supporting UPI, Credit Cards, NetBanking & COD\nSeamless payment gateway integration with Razorpay, Stripe, Cashfree & PhonePe\nAutomated shipping courier integration with Shiprocket, Delhivery & Bluedart\nDiscount voucher engine, abandoned cart recovery & customer notification triggers\nCustomer account portal with past orders, live tracking & downloadable GST receipts\n100% Client ownership with zero transaction fee cuts',
  `tech_stack` = 'Next.js, PHP, React, MySQL, Razorpay SDK, Shiprocket API',
  `seo_title` = 'Custom E-Commerce Development Company | Fast Online Stores | RiTiVerse',
  `seo_description` = 'Custom e-commerce web application development with sub-2-second catalog loading, 1-click checkout, 0% sales commission, and global multi-currency payment integration.',
  `seo_keywords` = 'custom ecommerce development company, ecommerce website development, build online store, stripe razorpay ecommerce development, bespoke ecommerce solutions'
WHERE `slug` = 'ecommerce-development';

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;

