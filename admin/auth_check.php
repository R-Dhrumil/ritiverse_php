<?php
/**
 * RiTiVerse — Admin Authentication Gatekeeper
 * Protects administrative routes with session security, timeout, and hijacking detection
 */
require_once __DIR__ . '/../includes/config.php';
start_secure_session();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Session Hijacking Protection: Verify User-Agent matches initial login
$current_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'standard';
if (isset($_SESSION['admin_user_agent']) && $_SESSION['admin_user_agent'] !== $current_agent) {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header('Location: login.php?msg=security_check_failed');
    exit;
}

// Session Inactivity Timeout: 2 hours (7200 seconds)
$now = time();
if (isset($_SESSION['admin_last_activity']) && ($now - $_SESSION['admin_last_activity'] > 7200)) {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header('Location: login.php?msg=session_timeout');
    exit;
}
$_SESSION['admin_last_activity'] = $now;
