<?php
/**
 * RiTiVerse — Central Application Configuration
 * Optimized for cPanel / Apache / LiteSpeed Deployment
 * 
 * -----------------------------------------------------------------------------
 * cPanel File Manager Deployment Checklist:
 * 1. Right Folder: Saara code direct `public_html/` ke root me hona chahiye
 *    (e.g. `public_html/index.php`, `public_html/css/`, `public_html/includes/`).
 *    Agar zip kisi subfolder me extract hui ho, to use move karke direct `public_html/` me daalein.
 * 2. Default index.html: Hosting provider ki default `index.html` ya `default.html`
 *    ko delete ya rename karein taaki aapka `index.php` direct load ho.
 * -----------------------------------------------------------------------------
 */

// Error reporting settings: Production-safe
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Application Identity & Metadata
define('APP_NAME', 'RiTiVerse');
define('APP_LEGAL_NAME', 'RiTiVerse Studio');
define('APP_TAGLINE', 'Elite Website & Software Development');
define('APP_DESCRIPTION', 'Engineering studio delivering custom websites, mobile apps, CRM, ERP, and bespoke software with 100% client source code ownership.');

// Database Credentials (Auto-detects Local XAMPP vs Production cPanel)
$isLocalHost = (
    PHP_OS_FAMILY === 'Windows' ||
    php_sapi_name() === 'cli' ||
    (!empty($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false)) ||
    (!empty($_SERVER['SERVER_NAME']) && (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false || strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false))
);
define('DB_HOST', getenv('DB_HOST') ?: ($isLocalHost ? '127.0.0.1' : 'localhost'));
define('DB_NAME', getenv('DB_NAME') ?: ($isLocalHost ? 'ritiverse' : 'ritivers_main'));
define('DB_USER', getenv('DB_USER') ?: ($isLocalHost ? 'root' : 'ritivers_main'));
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : ($isLocalHost ? '' : 'ritivers_main'));
define('DB_CHARSET', 'utf8mb4');

// High-Priority SEO Search Keywords (Rank #1 for Website Making, CRM, ERP, Software Dev)
define('SEO_PRIMARY_KEYWORDS', 'custom CRM development company, custom ERP software development, website development company, offshore software development India, custom software engineering, hire CRM developers, enterprise ERP systems, bespoke web applications, zero lock-in software');
define('SEO_AUTHOR', 'RiTiVerse Engineering Studio');
define('SEO_GEO_REGION', 'IN');
define('SEO_GEO_PLACENAME', 'India');

// Contact & Support Coordinates
define('CONTACT_EMAIL', 'info@ritiverse.in');
define('SUPPORT_EMAIL', 'support@ritiverse.in');
define('CONTACT_PHONE', '+91 94267 82646');
define('CONTACT_PHONE_ALT', '+91 91042 53289');

// SMTP & TLS Email Transport Coordinates (High-Deliverability Inbox Configuration)
define('SMTP_ENABLED', getenv('SMTP_ENABLED') !== false ? (bool)getenv('SMTP_ENABLED') : true);
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtppro.zoho.in'); // Zoho Mail (India: smtppro.zoho.in, Global: smtppro.zoho.com)
define('SMTP_PORT', (int)(getenv('SMTP_PORT') ?: 465));
define('SMTP_ENCRYPTION', getenv('SMTP_ENCRYPTION') ?: 'ssl'); // 'ssl' (Port 465) or 'tls' (Port 587)
define('SMTP_USER', getenv('SMTP_USER') ?: 'info@ritiverse.in');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('SMTP_FROM_EMAIL', getenv('SMTP_FROM_EMAIL') ?: 'info@ritiverse.in');
define('SMTP_FROM_NAME', getenv('SMTP_FROM_NAME') ?: 'RiTiVerse Studio');
define('SMTP_RECIPIENT_EMAIL', getenv('SMTP_RECIPIENT_EMAIL') ?: 'info@ritiverse.in');
define('SMTP_ALLOW_SELF_SIGNED', true);

// Official Social Channels & Profiles
define('SOCIAL_LINKEDIN', 'https://www.linkedin.com/company/ritiverse');
define('SOCIAL_INSTAGRAM', 'https://www.instagram.com/ritiverse.in?utm_source=ig_web_button_share_sheet&srtk=ZDNlZDc0MzIxNw==');
define('SOCIAL_GITHUB', 'https://github.com/RiTIVerse');
define('SOCIAL_TWITTER', 'https://x.com/RiTiVerseIn');
define('SOCIAL_X', 'https://x.com/RiTiVerseIn');
define('SOCIAL_FACEBOOK', 'https://www.facebook.com/profile.php?id=61595110330028');

// Google & Bing Search Console Verification Tokens & Tracking
define('GOOGLE_SITE_VERIFICATION', getenv('GOOGLE_SITE_VERIFICATION') ?: '');
define('BING_SITE_VERIFICATION', getenv('BING_SITE_VERIFICATION') ?: '37D47CA67C44D215674E7B6D860E11FE');
define('GOOGLE_ANALYTICS_ID', getenv('GOOGLE_ANALYTICS_ID') ?: 'G-18XT3VN71N');
define('META_PIXEL_ID', getenv('META_PIXEL_ID') ?: '');

// Dynamic Base URL detection for cPanel
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
define('SITE_URL', $protocol . $host);

/**
 * Helper: Generate clean link (works with or without mod_rewrite)
 */
function url($path = '') {
    $cleanPath = ltrim($path, '/');
    return '/' . $cleanPath;
}

/**
 * Helper: Check active navigation page
 */
function is_active($page, $currentPage) {
    return ($page === $currentPage) ? 'active' : '';
}

/**
 * Helper: Escape HTML strings safely
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Helper: Start secure session with modern cookie attributes
 */
function start_secure_session() {
    if (session_status() === PHP_SESSION_NONE) {
        $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $is_https,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        session_start();
    }
}

/**
 * Helper: CSRF token generation
 */
function csrf_token() {
    start_secure_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Helper: Generate hidden CSRF input field
 */
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/**
 * Helper: Verify CSRF token safely with timing-attack safe comparison
 */
function verify_csrf_token($token) {
    start_secure_session();
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Helper: Rate limiting check for sensitive operations (per IP/session)
 * @param string $action Unique identifier for the action
 * @param int $max_attempts Maximum allowed attempts in the window
 * @param int $decay_seconds Window size in seconds
 * @return bool True if allowed, false if limit exceeded
 */
function check_rate_limit($action, $max_attempts = 5, $decay_seconds = 300) {
    start_secure_session();
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $key = 'rate_limit_' . md5($action . '_' . $ip);
    
    $now = time();
    $data = $_SESSION[$key] ?? ['attempts' => 0, 'first_attempt' => $now];
    
    if ($now - $data['first_attempt'] > $decay_seconds) {
        $data = ['attempts' => 1, 'first_attempt' => $now];
        $_SESSION[$key] = $data;
        return true;
    }
    
    if ($data['attempts'] >= $max_attempts) {
        return false;
    }
    
    $data['attempts']++;
    $_SESSION[$key] = $data;
    return true;
}

/**
 * Universal Global Setting Accessor (Safe Fallback)
 */
if (!function_exists('get_setting')) {
    function get_setting($key, $default = '') {
        if (function_exists('get_db')) {
            $db = get_db();
            if ($db) {
                try {
                    $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1");
                    $stmt->execute([$key]);
                    $val = $stmt->fetchColumn();
                    return ($val !== false && $val !== null) ? $val : $default;
                } catch (Exception $e) {
                    return $default;
                }
            }
        }
        return $default;
    }
}

// =============================================================================
// Digital Personal Data Protection Act, 2023 (DPDP Act 2023) Security Framework
// =============================================================================
define('DPDP_ACT_NAME', 'Digital Personal Data Protection Act, 2023');
define('DPDP_NOTICE_VERSION', 'v1.0-2024');
define('DPDP_DEFAULT_DPO_NAME', 'Grievance Redressal Officer');
define('DPDP_DEFAULT_DPO_EMAIL', 'privacy@ritiverse.in');
define('DPDP_DEFAULT_DPO_DESIGNATION', 'Data Protection & Grievance Officer');
define('DPDP_JURISDICTION', 'Gujarat, India');

/**
 * Helper: Retrieve current Data Protection / Grievance Redressal Officer details
 */
function get_dpo_details() {
    return [
        'name' => get_setting('dpdp_dpo_name', DPDP_DEFAULT_DPO_NAME),
        'email' => get_setting('dpdp_dpo_email', DPDP_DEFAULT_DPO_EMAIL),
        'designation' => get_setting('dpdp_dpo_designation', DPDP_DEFAULT_DPO_DESIGNATION),
        'jurisdiction' => DPDP_JURISDICTION,
        'response_sla' => '30 calendar days (per DPDP statutory rules)',
    ];
}

/**
 * Helper: Mask email for privacy-safe display in telemetry & logs
 */
function mask_email($email) {
    if (empty($email) || strpos($email, '@') === false) return '***';
    [$name, $domain] = explode('@', $email, 2);
    $len = mb_strlen($name);
    if ($len <= 2) {
        $maskedName = mb_substr($name, 0, 1) . '*';
    } else {
        $maskedName = mb_substr($name, 0, 1) . str_repeat('*', min(5, $len - 2)) . mb_substr($name, -1, 1);
    }
    return $maskedName . '@' . $domain;
}

/**
 * Helper: Mask IP address for privacy-safe audit logging
 */
function mask_ip($ip) {
    if (empty($ip)) return '0.0.0.0';
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $parts = explode('.', $ip);
        return $parts[0] . '.' . ($parts[1] ?? '0') . '.***.***';
    }
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $parts = explode(':', $ip);
        return ($parts[0] ?? '') . ':' . ($parts[1] ?? '') . ':***:***';
    }
    return '***';
}

/**
 * Helper: Anonymize an inquiry (Right to Erasure / Section 12(3))
 * Scrubs all PII fields while retaining aggregate timestamp for analytics/accounting
 */
function anonymize_inquiry($inquiry_id) {
    $db = function_exists('get_db') ? get_db() : null;
    if (!$db) return false;
    try {
        $stmt = $db->prepare("UPDATE inquiries SET 
            name = '[Data Principal Requested Erasure]',
            email = 'erased@ritiverse.dpdp',
            company = '[Erased]',
            details = '[Personal details erased per Section 12(3) of DPDP Act 2023]',
            ip_address = '0.0.0.0',
            is_anonymized = 1,
            anonymized_at = NOW()
            WHERE id = ?");
        return $stmt->execute([$inquiry_id]);
    } catch (Exception $e) {
        error_log("DPDP Erasure failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Self-Healing Schema Helper: Ensure DPDP Act database tables and columns exist automatically
 * Prevents "1146 Table doesn't exist" errors on fresh cPanel deployments without requiring manual phpMyAdmin import.
 */
function ensure_dpdp_tables($db = null) {
    if (!$db && function_exists('get_db')) {
        $db = get_db();
    }
    if (!$db) return false;

    static $checked = false;
    if ($checked) return true;

    try {
        // 1. Create dpdp_requests table if not exists
        $db->exec("CREATE TABLE IF NOT EXISTS `dpdp_requests` (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 2. Ensure columns exist on inquiries table
        try {
            $colsStmt = $db->query("SHOW COLUMNS FROM `inquiries`");
            $existingCols = $colsStmt ? $colsStmt->fetchAll(PDO::FETCH_COLUMN) : [];
            
            if (!in_array('consent_given', $existingCols)) {
                $db->exec("ALTER TABLE `inquiries` ADD COLUMN `consent_given` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`");
            }
            if (!in_array('consent_timestamp', $existingCols)) {
                $db->exec("ALTER TABLE `inquiries` ADD COLUMN `consent_timestamp` DATETIME NULL AFTER `consent_given`");
            }
            if (!in_array('consent_ip', $existingCols)) {
                $db->exec("ALTER TABLE `inquiries` ADD COLUMN `consent_ip` VARCHAR(45) NULL AFTER `consent_timestamp`");
            }
            if (!in_array('consent_version', $existingCols)) {
                $db->exec("ALTER TABLE `inquiries` ADD COLUMN `consent_version` VARCHAR(20) NOT NULL DEFAULT 'v1.0' AFTER `consent_ip`");
            }
            if (!in_array('is_anonymized', $existingCols)) {
                $db->exec("ALTER TABLE `inquiries` ADD COLUMN `is_anonymized` TINYINT(1) NOT NULL DEFAULT 0 AFTER `consent_version`");
            }
            if (!in_array('anonymized_at', $existingCols)) {
                $db->exec("ALTER TABLE `inquiries` ADD COLUMN `anonymized_at` DATETIME NULL AFTER `is_anonymized`");
            }
        } catch (Exception $colEx) {
            error_log("Inquiries column check notice: " . $colEx->getMessage());
        }

        // 3. Seed site_settings if needed
        try {
            $checkSetting = $db->prepare("SELECT COUNT(*) FROM `site_settings` WHERE `setting_key` = 'dpdp_dpo_email'");
            $checkSetting->execute();
            if ((int)$checkSetting->fetchColumn() === 0) {
                $db->exec("INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
                    ('dpdp_dpo_name', 'Grievance Redressal Officer', 'dpdp'),
                    ('dpdp_dpo_email', 'privacy@ritiverse.in', 'dpdp'),
                    ('dpdp_dpo_designation', 'Data Protection & Grievance Officer', 'dpdp'),
                    ('dpdp_retention_days', '365', 'dpdp'),
                    ('dpdp_cookie_consent_active', '1', 'dpdp')
                ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`");
            }
        } catch (Exception $settEx) {
            error_log("DPDP settings seed notice: " . $settEx->getMessage());
        }

        $checked = true;
        return true;
    } catch (Exception $e) {
        error_log("ensure_dpdp_tables error: " . $e->getMessage());
        return false;
    }
}


