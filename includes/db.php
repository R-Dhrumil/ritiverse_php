<?php
/**
 * RiTiVerse — Resilient Database Connection Layer
 * Uses PDO with Prepared Statements & Pure MySQL Persistence
 */
require_once __DIR__ . '/config.php';

class Database {
    private static $pdo = null;
    private static $connectionError = null;

    /**
     * Get or initialize PDO connection instance
     * @return PDO|null
     */
    public static function getConnection() {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 2
        ];

        // 1. Primary connection attempt using configured constants
        $primaryHost = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
        $primaryDb   = defined('DB_NAME') ? DB_NAME : 'ritiverse';
        $primaryUser = defined('DB_USER') ? DB_USER : 'root';
        $primaryPass = defined('DB_PASS') ? DB_PASS : '';
        $charset     = defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4';

        $dsn = "mysql:host={$primaryHost};dbname={$primaryDb};charset={$charset}";

        try {
            self::$pdo = new PDO($dsn, $primaryUser, $primaryPass, $options);
            self::$connectionError = null;
            return self::$pdo;
        } catch (PDOException $e) {
            self::$connectionError = $e->getMessage();
        }

        // 2. Local development fallback: try alternative hosts & common local credentials
        $isLocal = (
            (defined('PHP_OS_FAMILY') && PHP_OS_FAMILY === 'Windows') ||
            $primaryHost === 'localhost' ||
            $primaryHost === '127.0.0.1' ||
            php_sapi_name() === 'cli'
        );

        if ($isLocal) {
            $hostsToTry = array_unique([$primaryHost, '127.0.0.1', 'localhost']);
            $dbsToTry   = array_unique([$primaryDb, 'ritiverse', 'ritiverse_php', 'ritivers_main']);
            $credsToTry = [
                ['root', ''],
                [$primaryUser, $primaryPass]
            ];

            foreach ($hostsToTry as $host) {
                foreach ($dbsToTry as $dbName) {
                    foreach ($credsToTry as [$user, $pass]) {
                        try {
                            $altDsn = "mysql:host={$host};dbname={$dbName};charset={$charset}";
                            self::$pdo = new PDO($altDsn, $user, $pass, $options);
                            self::$connectionError = null;
                            return self::$pdo;
                        } catch (PDOException $eFallback) {
                            // Continue trying other combinations
                        }
                    }
                }
            }
        }

        error_log("RiTiVerse DB Connection Warning: " . self::$connectionError);
        return null;
    }

    /**
     * Check if database connection is live
     * @return bool
     */
    public static function isConnected() {
        return self::getConnection() !== null;
    }

    /**
     * Return connection error string if any
     * @return string|null
     */
    public static function getError() {
        return self::$connectionError;
    }
}

/**
 * Procedural Helper: Get DB Instance
 */
function get_db() {
    return Database::getConnection();
}

/**
 * Procedural Helper: Check DB Live Status
 */
function is_db_connected() {
    return Database::isConnected();
}

/**
 * Procedural Helper: Fetch setting from MySQL database or fall back to provided default constant
 */
if (!function_exists('get_setting')) {
    function get_setting($key, $default = '') {
        $db = get_db();
        if ($db) {
            try {
                $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1");
                $stmt->execute([$key]);
                $val = $stmt->fetchColumn();
                if ($val !== false && $val !== null) {
                    return $val;
                }
            } catch (Exception $e) {
                error_log("get_setting error for key '{$key}': " . $e->getMessage());
            }
        }

        return $default;
    }
}

/**
 * Procedural Helper: Save setting directly to MySQL site_settings table
 */
if (!function_exists('save_setting')) {
    function save_setting($key, $val, $group = 'general') {
        $db = get_db();
        if ($db) {
            try {
                $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group) 
                                      VALUES (?, ?, ?) 
                                      ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_group = VALUES(setting_group), updated_at = CURRENT_TIMESTAMP");
                return $stmt->execute([$key, $val, $group]);
            } catch (Exception $e) {
                error_log("save_setting error for key '{$key}': " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
}
