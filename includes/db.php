<?php
/**
 * RiTiVerse — Resilient Database Connection Layer
 * Uses PDO with Prepared Statements & Graceful Degradation
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

        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
        ];

        try {
            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            self::$connectionError = null;
            return self::$pdo;
        } catch (PDOException $e) {
            self::$connectionError = $e->getMessage();
            // Log error silently without breaking the public site
            error_log("RiTiVerse DB Connection Warning: " . $e->getMessage());
            return null;
        }
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
 * Procedural Helper: Fetch setting from database or fall back to default
 */
function get_setting($key, $default = '') {
    $db = get_db();
    if (!$db) return $default;

    try {
        $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        return ($val !== false && $val !== null) ? $val : $default;
    } catch (Exception $e) {
        return $default;
    }
}
