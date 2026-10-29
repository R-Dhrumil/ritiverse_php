<?php
/**
 * RiTiVerse — Services Data & Helper Layer
 * Provides robust DB retrieval, auto-table creation, and high-fidelity fallback
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/**
 * Return default high-fidelity fallback services dictionary
 */
function get_default_services_data() {
    return [
        'website-development' => [
            'id' => 1,
            'title' => 'Website Development',
            'slug' => 'website-development',
            'icon' => 'web',
            'seo_title' => 'Web Development Company in Vadodara | Custom Websites | RiTiVerse',
            'seo_description' => 'Top web development company in Vadodara, Gujarat. We engineer custom business websites, portals & web apps with sub-2s load time and 100% source code ownership.',
            'seo_keywords' => 'web development company in vadodara, website developers vadodara, web design company in vadodara, custom web development vadodara, best website development company in vadodara, hire web developers in vadodara, IT company in vadodara gujarat, offshore web development India',
            'tagline' => 'High-Converting, Ultra-Fast Business Websites with 100% Code Ownership',
            'short_desc' => 'Fast, clean, and mobile-friendly websites built with React and PHP. Designed to load in under 2 seconds and convert visitors into inquiries.',
            'full_desc' => "We architect modern, lightning-fast business websites engineered to rank on Google and convert visitors into paying clients. Based in Vadodara, Gujarat, we deliver custom websites for local leaders and international enterprises. Unlike conventional digital agencies that deliver rigid WordPress templates burdened with 30+ bloated plugins, every RiTiVerse website is custom-coded using clean HTML5, modern React, and performant PHP. You receive 100% source code ownership pushed directly to your company's GitHub repository from Day 1 with zero ongoing platform lock-in fees.",
            'deliverables' => "Sub-2-second page load speeds on mobile & desktop networks\nBespoke UI/UX design calibrated to your brand identity & typography\nTechnical SEO structure, OpenGraph cards & Schema.org rich snippets\nIntegrated inquiry capture forms with instant WhatsApp & email alerts\nFull responsive optimization across iOS, Android, tablets & ultra-wide screens\n100% Source code ownership with GitHub / GitLab repository handover\nFree 30-day post-launch warranty, speed audits & technical training",
            'tech_stack' => 'React 19, PHP 8.3, HTML5, CSS Tokens, Vite, Tailwind, MySQL',
            'timeline' => '1 – 2 Weeks',
            'starting_price' => 'Fixed Milestone Scope',
            'image_url' => 'assets/card_web_apps.jpg',
            'is_active' => 1,
            'display_order' => 1,
            'comparison' => [
                'competitor_label' => 'Traditional WordPress / Template Agencies',
                'items' => [
                    ['feature' => 'Source Code Ownership', 'ritiverse' => '100% Yours. Pushed to your private GitHub repo.', 'competitor' => 'Locked inside proprietary CMS or agency hosting.'],
                    ['feature' => 'Page Load Performance', 'ritiverse' => 'Sub-2 seconds. 95+ Google Lighthouse score.', 'competitor' => '4 – 8+ seconds due to bloated theme plugins.'],
                    ['feature' => 'Security & Maintenance', 'ritiverse' => 'Zero vulnerable third-party plugins. Clean code.', 'competitor' => 'Frequent plugin hacks, database bloat & update crashes.'],
                    ['feature' => 'Monthly Platform Fees', 'ritiverse' => '₹0 recurring license fees. You host anywhere.', 'competitor' => 'Mandatory monthly maintenance retainers.']
                ]
            ],
            'faqs' => [
                ['q' => 'Is RiTiVerse located in Vadodara, Gujarat and can we meet in person?', 'a' => 'Yes! Our primary development studio is in Vadodara, Gujarat. We welcome in-person consultations for local businesses in Vadodara, Ahmedabad, and Surat, as well as virtual meetings for clients across India and globally (USA, UK, UAE).'],
                ['q' => 'How long does it take to design and launch our website?', 'a' => 'Most business websites take between 1 to 2 weeks from kickoff to live deployment. We work in rapid milestone sprints and provide weekly live staging links so you test real progress.'],
                ['q' => 'Do we get 100% full source code ownership?', 'a' => 'Yes, unconditionally. All source code, design assets, and database schemas are transferred to your GitHub account upon milestone completion. You are never locked into our agency.'],
                ['q' => 'Will our website be mobile-friendly and fast on 4G/5G?', 'a' => 'Absolutely. We test across actual iPhone and Android devices to guarantee responsive rendering and sub-2-second loading, ensuring maximum lead conversion.'],
                ['q' => 'Do you work with international clients across US, UK, and Europe?', 'a' => 'Yes. Over 50% of our software and website development projects are for international clients across the US, UK, UAE, Europe, and Australia. We provide overlapping work hours (EST, PST, GMT, GST), weekly video sprint reviews, direct Slack/WhatsApp communication, and transparent milestone invoicing.'],
                ['q' => 'How do you ensure search engines rank our new website?', 'a' => 'We build every site with clean semantic HTML5 architecture, sub-2-second Core Web Vitals speed, automated XML sitemaps, OpenGraph metadata, and Google JSON-LD Schema.org rich snippets out of the box.']
            ]
        ],

        'mobile-app-development' => [
            'id' => 2,
            'title' => 'Mobile App Development',
            'slug' => 'mobile-app-development',
            'icon' => 'mobile',
            'seo_title' => 'Mobile App Development Company | Native iOS & Android Apps | RiTiVerse',
            'seo_description' => 'Top mobile app development company engineering high-performance Android & iOS mobile applications with 60fps animations, offline sync, and 100% client code ownership.',
            'seo_keywords' => 'mobile app development company, hire mobile app developers, react native app development, flutter app development company, ios android app development, cross platform app agency',
            'tagline' => 'Native-Performance Android & iOS Apps Engineered for Scale',
            'short_desc' => 'High-performance Android and iOS apps with smooth animations, offline data access, and instant push notifications for your users.',
            'full_desc' => "From initial interactive wireframing to Google Play Store and Apple App Store publishing, RiTiVerse builds fluid, reliable mobile applications. We leverage modern cross-platform frameworks (React Native, Flutter) and native toolchains to deliver 60fps animations, rock-solid offline caching, real-time push notifications, and biometric security—all backed by clean microservices.",
            'deliverables' => "Cross-platform Android & iOS builds from a unified, maintainable codebase\nSub-60fps fluid UI transitions and gesture animations\nOffline-first SQLite / WatermelonDB data synchronization\nReal-time push notifications via Firebase Cloud Messaging (FCM) & OneSignal\nSecure biometric authentication (FaceID, Fingerprint) & keychain storage\nEnd-to-end Google Play Store & Apple App Store compliance & submission\n100% Client ownership of build pipelines, keystores & app repository",
            'tech_stack' => 'React Native, Flutter, Kotlin, Swift, Node.js, Firebase, SQLite',
            'timeline' => '3 – 6 Weeks',
            'starting_price' => 'Fixed Milestone Scope',
            'image_url' => 'assets/card_cloud_ai.jpg',
            'is_active' => 1,
            'display_order' => 2,
            'comparison' => [
                'competitor_label' => 'Generic App Freelancers / No-Code Builders',
                'items' => [
                    ['feature' => 'Store Acceptance Guarantee', 'ritiverse' => 'Full compliance with Apple & Google review policies.', 'competitor' => 'App rejected multiple times with zero guidance.'],
                    ['feature' => 'Code Architecture & Performance', 'ritiverse' => 'Native bridge optimization with 60fps animations.', 'competitor' => 'Sluggish webview wrappers that drain battery.'],
                    ['feature' => 'Offline Data Resilience', 'ritiverse' => 'Offline SQLite caching with automatic cloud sync.', 'competitor' => 'App crashes when mobile data is unstable.'],
                    ['feature' => 'Keystore & Signing Keys', 'ritiverse' => 'You own all signing keystores and App Store accounts.', 'competitor' => 'Agency holds your app keys hostage for renewals.']
                ]
            ],
            'faqs' => [
                ['q' => 'Can one app run on both Android and iOS devices?', 'a' => 'Yes. We utilize cross-platform architectures like React Native and Flutter which deliver native 60fps performance on both iOS and Android from a single unified codebase, cutting your development budget by nearly 40%.'],
                ['q' => 'Do you handle the App Store and Google Play publishing process?', 'a' => 'Yes. We prepare all app screenshots, privacy policy manifests, store listings, and handle the entire review submission until your app is live and downloadable.'],
                ['q' => 'Can the app work when the user has no internet connection?', 'a' => 'Yes. We implement offline-first database synchronization so users can browse products, take notes, or review records offline, automatically syncing when connection resumes.']
            ]
        ],

        'custom-software-development' => [
            'id' => 3,
            'title' => 'Custom Software & APIs',
            'slug' => 'custom-software-development',
            'icon' => 'software',
            'seo_title' => 'Custom Software Development Company | Bespoke APIs & Portals | RiTiVerse',
            'seo_description' => 'Bespoke software development company building scalable backend engines, web portals, microservices, and secure APIs with 100% source code ownership. Serving US, UK, UAE & global clients.',
            'seo_keywords' => 'custom software development company, bespoke software development, hire dedicated developers, enterprise software solutions, offshore software engineering, API development services, custom software agency India',
            'tagline' => 'Bespoke Backend Engines, Microservices & High-Throughput APIs',
            'short_desc' => 'Tailored business software that fits your exact workflow. Automate daily manual tasks and connect third-party APIs easily.',
            'full_desc' => "When commercial off-the-shelf software falls short of your operational workflow, RiTiVerse builds bespoke software engines and microservices from scratch. We architect scalable relational schemas, asynchronous job queues, high-throughput REST and GraphQL APIs, and custom operational portals that eliminate manual spreadsheets and repetitive human data entry.",
            'deliverables' => "Tailor-made business workflow automation engines eliminating manual entry\nHigh-throughput REST and GraphQL API microservices with sub-120ms response\nSeamless third-party integrations (Payment Gateways, WhatsApp, SMS, Shipping)\nGranular Role-Based Access Control (RBAC) with complete audit trail logs\nAutomated server health telemetry, failover alerts & encrypted backups\nComprehensive Swagger / Postman API documentation & developer onboarding\n100% Intellectual property and source code transfer to your repository",
            'tech_stack' => 'PHP 8.3, Laravel, Node.js, Express, Go, MySQL, Redis, Docker',
            'timeline' => '3 – 5 Weeks',
            'starting_price' => 'Fixed Milestone Scope',
            'image_url' => 'assets/card_software_apis.jpg',
            'is_active' => 1,
            'display_order' => 3,
            'comparison' => [
                'competitor_label' => 'Off-the-Shelf SaaS / Generic Packages',
                'items' => [
                    ['feature' => 'Workflow Compatibility', 'ritiverse' => '100% Custom-engineered around your exact operations.', 'competitor' => 'Forces you to change your workflow to fit their template.'],
                    ['feature' => 'Recurring License Costs', 'ritiverse' => 'Zero recurring license fees. You own the software.', 'competitor' => 'Exponential monthly costs that increase as your team grows.'],
                    ['feature' => 'Data Privacy & Hosting', 'ritiverse' => 'Self-hosted in your private cloud or dedicated server.', 'competitor' => 'Your proprietary business data stored on multi-tenant servers.'],
                    ['feature' => 'Custom API Integrations', 'ritiverse' => 'Unlimited direct integrations with any hardware or API.', 'competitor' => 'Restricted behind expensive enterprise tiers.']
                ]
            ],
            'faqs' => [
                ['q' => 'Why invest in custom software instead of buying an existing tool?', 'a' => 'Existing tools charge per-user monthly subscriptions and force your team into rigid workflows. Custom software is built exactly for your business logic, gives you 100% intellectual property ownership, and scales forever with zero extra license costs.'],
                ['q' => 'Can this software integrate with our existing accounting or logistics systems?', 'a' => 'Yes. We specialize in building secure API bridges that sync bidirectional data with Tally, QuickBooks, WhatsApp Business, payment processors, GPS trackers, and shipping partners.'],
                ['q' => 'Do you provide full API documentation and post-deployment support?', 'a' => 'Yes. Every backend engine and API microservice comes with comprehensive Postman / Swagger documentation, automated database seeders, Docker container manifests, and a 30-day post-launch warranty with team training.']
            ]
        ],

        'erp-development' => [
            'id' => 4,
            'title' => 'Custom ERP Systems',
            'slug' => 'erp-development',
            'icon' => 'erp',
            'seo_title' => 'Custom ERP & Billing Software Development in Vadodara | RiTiVerse',
            'seo_description' => 'Custom ERP and GST billing software company in Vadodara, Gujarat. Tailored inventory, dispatch & accounting ERP platforms with zero monthly per-user fees.',
            'seo_keywords' => 'erp software company in vadodara, custom erp development vadodara, billing software vadodara gujarat, inventory management software vadodara, enterprise erp systems vadodara, offshore erp development India',
            'tagline' => 'All-in-One Enterprise Resource Planning with Zero Monthly Subscription Fees',
            'short_desc' => 'Complete management software for billing, stock inventory, purchasing, finances, and staff tracking—custom-built for your business.',
            'full_desc' => "Eliminate expensive per-user SaaS bills. RiTiVerse designs custom Enterprise Resource Planning (ERP) systems tailored to manufacturing, distribution, retail, and service businesses. Centralize your GST billing, multi-warehouse inventory, procurement cycles, staff attendance, and financial ledgers into one blazing-fast, secure dashboard that your entire organization can use without paying monthly user licenses.",
            'deliverables' => "GST/VAT-compliant automated invoicing, credit notes & payment receipt generation\nMulti-location warehouse stock tracking with low-inventory automated alerts\nVendor procurement, purchase orders & supplier payment lifecycle management\nStaff biometric attendance tracking, shift scheduling & payroll computation\nInteractive financial analytics: gross margin, daily P&L, balance sheets & Excel export\nGranular department roles (Accounts, Warehouse, Sales, Management)\n100% Self-hosted server deployment with encrypted nightly database backups",
            'tech_stack' => 'PHP 8.3, Laravel, MySQL, React, Redis, Chart.js, PDF Engine',
            'timeline' => '4 – 8 Weeks',
            'starting_price' => 'Fixed Milestone Scope',
            'image_url' => 'assets/card_ai_agents.jpg',
            'is_active' => 1,
            'display_order' => 4,
            'comparison' => [
                'competitor_label' => 'Rigid ERP Subscriptions (SAP / Odoo Cloud)',
                'items' => [
                    ['feature' => 'License Pricing Model', 'ritiverse' => 'One-time milestone investment. Zero ($0 / ₹0) per-user monthly fees.', 'competitor' => '$50 – $150+ (₹2,000 – ₹10,000+) per user per month forever.'],
                    ['feature' => 'Customization Flexibility', 'ritiverse' => 'Tailored to your specific manufacturing/trade formula.', 'competitor' => 'Extremely rigid; custom modules cost tens of thousands.'],
                    ['feature' => 'Database Speed & Control', 'ritiverse' => 'Sub-second queries optimized specifically for your volume.', 'competitor' => 'Slow multi-tenant databases with slow export options.'],
                    ['feature' => 'Source Code Ownership', 'ritiverse' => '100% Source code delivered to your private repository.', 'competitor' => 'Zero ownership. Cancel subscription and you lose access.']
                ]
            ],
            'faqs' => [
                ['q' => 'Why choose custom ERP development over SAP or Odoo subscriptions?', 'a' => 'Traditional ERP subscriptions charge recurring monthly fees per employee that balloon as your company grows, and force your business into rigid predefined workflows. RiTiVerse engineers a custom ERP tailored 100% to your proprietary processes, with zero ongoing per-user license fees and complete source code ownership.'],
                ['q' => 'Can our ERP handle multi-currency, multi-warehouse inventory, and global taxation?', 'a' => 'Yes. We build automated multi-warehouse tracking, cross-location stock transfers, and automated multi-currency support (USD, GBP, EUR, AED, INR) with compliance for GST, VAT, and local tax schedules.'],
                ['q' => 'How many staff members can access the ERP?', 'a' => 'Unlimited. Because you own the software, there are no per-user license fees. You can add 10, 100, or 1,000 employees with custom access roles without paying a single dollar or rupee more.'],
                ['q' => 'Can we access the ERP securely from mobile phones and tablets?', 'a' => 'Yes. The system is built with responsive web architecture and role-based permissions, allowing managers and executives to review reports, approve purchase orders, and monitor stock levels securely from anywhere in the world.']
            ]
        ],

        'crm-development' => [
            'id' => 5,
            'title' => 'Custom CRM Platforms',
            'slug' => 'crm-development',
            'icon' => 'crm',
            'seo_title' => 'Custom CRM Software Development Company in Vadodara | RiTiVerse',
            'seo_description' => 'Leading custom CRM development company in Vadodara. Automated WhatsApp follow-ups, sales pipelines & lead management with zero monthly SaaS subscription fees.',
            'seo_keywords' => 'crm development company in vadodara, custom crm software vadodara, crm developers vadodara gujarat, lead management crm vadodara, bespoke crm software development, offshore crm development India',
            'tagline' => 'Automated Sales Pipelines, Lead Management & Zero Monthly SaaS Fees',
            'short_desc' => 'Manage customer inquiries, assign leads to sales reps, set WhatsApp/email reminders, and track conversion pipelines easily with zero monthly user fees.',
            'full_desc' => "Stop letting valuable prospective customers slip through the cracks. RiTiVerse creates custom Customer Relationship Management (CRM) platforms that automatically aggregate inbound inquiries from your website forms, WhatsApp, Google Ads, Facebook, and direct calls into a unified visual deal pipeline. Empower your sales reps with automated follow-ups, call logging, and conversion analytics without recurring per-seat subscriptions.",
            'deliverables' => "Visual Kanban drag-and-drop lead pipeline with custom deal stages\nAutomated lead capture from Website forms, WhatsApp Business, Meta Ads & Google\nIntelligent round-robin lead distribution among sales representatives\nAutomated WhatsApp and Email follow-up triggers and reminder task queues\nDetailed client interaction timelines, meeting notes, call logs & document attachments\nExecutive conversion analytics: rep performance, close rates & revenue forecasting\n100% Source code ownership and self-hosted database privacy",
            'tech_stack' => 'React, Node.js, PHP, MySQL, WhatsApp Business API, WebSockets',
            'timeline' => '3 – 5 Weeks',
            'starting_price' => 'Fixed Milestone Scope',
            'image_url' => 'assets/card_cloud_devops.jpg',
            'is_active' => 1,
            'display_order' => 5,
            'comparison' => [
                'competitor_label' => 'SaaS CRMs (Salesforce / HubSpot / Zoho)',
                'items' => [
                    ['feature' => 'Per-Seat User Pricing', 'ritiverse' => 'Zero ($0 / ₹0) per-user fees. Add your entire team with no extra costs.', 'competitor' => '$40 – $150+ (₹3,000 – ₹12,000) per user per month.'],
                    ['feature' => 'Direct WhatsApp Integration', 'ritiverse' => 'Deep native WhatsApp Business Cloud API automation.', 'competitor' => 'Third-party plugins with costly message markups.'],
                    ['feature' => 'Lead Privacy & Security', 'ritiverse' => 'Stored in your isolated private database. No shared data.', 'competitor' => 'Hosted on public multi-tenant clouds.'],
                    ['feature' => 'Custom Fields & Pipelines', 'ritiverse' => 'Unlimited custom fields, deal stages and automation rules.', 'competitor' => 'Locked behind high-end Enterprise plans.']
                ]
            ],
            'faqs' => [
                ['q' => 'How much does custom CRM development cost compared to Salesforce or Zoho?', 'a' => 'Off-the-shelf SaaS CRMs charge $25 to $150+ per user every month. For a 20-person team, that is $6,000 to $36,000+ per year forever. RiTiVerse builds a custom CRM tailored 100% to your workflows for a fixed one-time milestone fee with 100% source code ownership and zero per-user monthly bills.'],
                ['q' => 'Can RiTiVerse act as an offshore CRM development partner for US, UK, or global businesses?', 'a' => 'Yes. We offer offshore custom CRM engineering with dedicated developer teams, complete IP and GitHub repository transfer, bilateral NDA security, and seamless multi-currency payment processing (USD, GBP, EUR, AED) via Stripe or wire transfer.'],
                ['q' => 'Can leads from our website and WhatsApp automatically appear in the CRM?', 'a' => 'Yes! The moment a prospect fills out a website form or sends a WhatsApp inquiry, the CRM automatically creates a lead card and alerts the assigned sales representative instantly.'],
                ['q' => 'Can we restrict what each sales executive can see?', 'a' => 'Yes. Role-based permissions ensure sales reps only view their assigned leads, while managers and business owners have complete visibility into all leads, revenues, and conversion stats.']
            ]
        ],

        'ecommerce-development' => [
            'id' => 6,
            'title' => 'E-Commerce Storefronts',
            'slug' => 'ecommerce-development',
            'icon' => 'ecommerce',
            'seo_title' => 'Custom E-Commerce Development Company | Fast Online Stores | RiTiVerse',
            'seo_description' => 'Custom e-commerce web application development with sub-2-second catalog loading, 1-click checkout, 0% sales commission, and global multi-currency payment integration.',
            'seo_keywords' => 'custom ecommerce development company, ecommerce website development, build online store, stripe razorpay ecommerce development, bespoke ecommerce solutions',
            'tagline' => 'High-Converting, 60fps Online Stores with 1-Click Checkout & Zero Monthly Cut',
            'short_desc' => 'Fast online shopping stores with one-click checkout, automated order management, and secure Razorpay, UPI, and card payments.',
            'full_desc' => "Avoid surrendering 2% to 5% of your gross sales in platform fees to hosted e-commerce builders. RiTiVerse engineers high-speed, custom e-commerce web applications with sub-2-second product catalog loading, instant faceted filtering, automated stock synchronization, and lightning-fast UPI / Razorpay payment flows that maximize checkout conversion.",
            'deliverables' => "Sub-2-second catalog loading with instant category, size & price filtering\nFrictionless 1-click mobile checkout supporting UPI, Credit Cards, NetBanking & COD\nSeamless payment gateway integration with Razorpay, Stripe, Cashfree & PhonePe\nAutomated shipping courier integration with Shiprocket, Delhivery & Bluedart\nDiscount voucher engine, abandoned cart recovery & customer notification triggers\nCustomer account portal with past orders, live tracking & downloadable GST receipts\n100% Client ownership with zero transaction fee cuts",
            'tech_stack' => 'Next.js, PHP, React, MySQL, Razorpay SDK, Shiprocket API',
            'timeline' => '2 – 4 Weeks',
            'starting_price' => 'Fixed Milestone Scope',
            'image_url' => 'assets/featured-work.jpg',
            'is_active' => 1,
            'display_order' => 6,
            'comparison' => [
                'competitor_label' => 'Shopify / WooCommerce Plugin Stores',
                'items' => [
                    ['feature' => 'Transaction Fee Commission', 'ritiverse' => '0% commission on your sales. You keep 100% of revenue.', 'competitor' => '0.5% – 2.0% cut on every single transaction.'],
                    ['feature' => 'Catalog Loading Speed', 'ritiverse' => 'Sub-2 seconds. Instant faceted client-side filtering.', 'competitor' => '4 – 7 seconds due to heavy third-party app scripts.'],
                    ['feature' => 'Monthly App & Plugin Bills', 'ritiverse' => 'Zero recurring app fees. All features natively built.', 'competitor' => '₹5,000 – ₹25,000/month for reviews, popups, filters.'],
                    ['feature' => 'Checkout Customization', 'ritiverse' => '100% Custom checkout flow tailored for Indian UPI buyers.', 'competitor' => 'Locked checkout unless you pay for Shopify Plus ($2,000/mo).']
                ]
            ],
            'faqs' => [
                ['q' => 'Which payment gateways can we connect to our store?', 'a' => 'We integrate all major payment gateways including Razorpay, Stripe, PhonePe, Cashfree, PayU, and Cash on Delivery (COD) with automated OTP verification.'],
                ['q' => 'Can orders be automatically sent to shipping couriers?', 'a' => 'Yes. We integrate courier APIs like Shiprocket and Delhivery so tracking numbers and shipping labels generate automatically when an order is packed.'],
                ['q' => 'Do you take any percentage of our sales?', 'a' => 'Never. Unlike Shopify, RiTiVerse takes 0% commission on your sales. 100% of your earnings go straight to your bank account.']
            ]
        ]
    ];
}

/**
 * Ensure `services` table exists and is populated in MySQL
 */
function ensure_services_table() {
    $db = get_db();
    if (!$db) return false;

    try {
        $check = $db->query("SHOW TABLES LIKE 'services'")->fetchColumn();
        if (!$check) {
            $db->exec("CREATE TABLE IF NOT EXISTS `services` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            // Seed default services
            $defaults = get_default_services_data();
            $stmt = $db->prepare("INSERT INTO services (id, title, slug, icon, tagline, short_desc, full_desc, deliverables, tech_stack, timeline, starting_price, image_url, is_active, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($defaults as $svc) {
                $stmt->execute([
                    $svc['id'],
                    $svc['title'],
                    $svc['slug'],
                    $svc['icon'],
                    $svc['tagline'],
                    $svc['short_desc'],
                    $svc['full_desc'],
                    $svc['deliverables'],
                    $svc['tech_stack'],
                    $svc['timeline'],
                    $svc['starting_price'],
                    $svc['image_url'],
                    $svc['is_active'],
                    $svc['display_order']
                ]);
            }
        }
        return true;
    } catch (Exception $e) {
        error_log("Services table ensure error: " . $e->getMessage());
        return false;
    }
}

/**
 * Fetch all active services (from DB with fallback to defaults)
 * @param bool $include_inactive Whether to include inactive (for admin)
 * @return array
 */
function get_all_services($include_inactive = false) {
    $db = get_db();
    $services = [];

    if ($db) {
        try {
            ensure_services_table();
            $sql = "SELECT * FROM services";
            if (!$include_inactive) {
                $sql .= " WHERE is_active = 1";
            }
            $sql .= " ORDER BY display_order ASC, id ASC";
            $stmt = $db->query($sql);
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $services[$row['slug']] = $row;
                }
                return $services;
            }
        } catch (Exception $e) {
            // DB read failed, fall through to defaults
        }
    }

    // Fallback to static defaults
    $defaults = get_default_services_data();
    if (!$include_inactive) {
        return array_filter($defaults, function($s) { return !empty($s['is_active']); });
    }
    return $defaults;
}

/**
 * Fetch a single service by slug or id
 * @param string|int $slug_or_id
 * @return array|null
 */
function get_service_by_slug_or_id($slug_or_id) {
    $db = get_db();
    $defaults = get_default_services_data();

    // Map common aliases
    $alias_map = [
        'web' => 'website-development',
        'app' => 'mobile-app-development',
        'software' => 'custom-software-development',
        'erp' => 'erp-development',
        'crm' => 'crm-development',
        'ecommerce' => 'ecommerce-development'
    ];
    if (isset($alias_map[$slug_or_id])) {
        $slug_or_id = $alias_map[$slug_or_id];
    }

    if ($db) {
        try {
            ensure_services_table();
            if (is_numeric($slug_or_id)) {
                $stmt = $db->prepare("SELECT * FROM services WHERE id = ? LIMIT 1");
                $stmt->execute([(int)$slug_or_id]);
            } else {
                $stmt = $db->prepare("SELECT * FROM services WHERE slug = ? LIMIT 1");
                $stmt->execute([$slug_or_id]);
            }
            $row = $stmt->fetch();
            if ($row) {
                // Enrich with comparison, FAQs & SEO metadata from defaults if matching slug
                if (isset($defaults[$row['slug']])) {
                    if (empty($row['comparison'])) {
                        $row['comparison'] = $defaults[$row['slug']]['comparison'] ?? null;
                    }
                    if (empty($row['faqs'])) {
                        $row['faqs'] = $defaults[$row['slug']]['faqs'] ?? null;
                    }
                    if (empty($row['seo_title'])) {
                        $row['seo_title'] = $defaults[$row['slug']]['seo_title'] ?? null;
                    }
                    if (empty($row['seo_description'])) {
                        $row['seo_description'] = $defaults[$row['slug']]['seo_description'] ?? null;
                    }
                    if (empty($row['seo_keywords'])) {
                        $row['seo_keywords'] = $defaults[$row['slug']]['seo_keywords'] ?? null;
                    }
                }
                return $row;
            }
        } catch (Exception $e) {
            // fall through
        }
    }

    // Check defaults
    if (is_numeric($slug_or_id)) {
        foreach ($defaults as $s) {
            if ($s['id'] == $slug_or_id) return $s;
        }
    } else {
        if (isset($defaults[$slug_or_id])) {
            return $defaults[$slug_or_id];
        }
    }

    return null;
}
