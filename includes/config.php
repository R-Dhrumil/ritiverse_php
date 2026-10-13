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

// Database Credentials (Configure for local dev or cPanel phpMyAdmin)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'ritivers_main');
define('DB_USER', getenv('DB_USER') ?: 'ritivers_main');
define('DB_PASS', getenv('DB_PASS') ?: 'ritivers_main');
define('DB_CHARSET', 'utf8mb4');

// High-Priority SEO Search Keywords (Rank #1 for Website Making, CRM, ERP, Software Dev)
define('SEO_PRIMARY_KEYWORDS', 'website making, website development company India, custom CRM development, ERP software development, ERP billing software, custom software development, mobile app development, e-commerce website design, React PHP development agency, zero vendor lock-in software');
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
define('GOOGLE_ANALYTICS_ID', getenv('GOOGLE_ANALYTICS_ID') ?: '');
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

