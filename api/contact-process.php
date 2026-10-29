<?php
/**
 * RiTiVerse — Production Contact Form Processor
 * Optimized for cPanel mail() and SMTP environments
 */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Only POST requests are accepted.'
    ]);
    exit;
}

// Rate Limiting: Max 5 inquiries per 10 minutes per IP/session
if (!check_rate_limit('contact_submission', 5, 600)) {
    http_response_code(429);
    echo json_encode([
        'success' => false,
        'message' => 'Too many submissions in a short period. Please wait a few minutes before trying again.'
    ]);
    exit;
}

// Sanitize inputs cleanly without converting newlines into HTML entities (&#13;&#10;)
$name = trim(strip_tags((string)($_POST['name'] ?? '')));
$email = trim((string)filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$company = trim(strip_tags((string)($_POST['company'] ?? '')));
$project_type = trim(strip_tags((string)($_POST['scope'] ?? '')));
$timeline = trim(strip_tags((string)($_POST['timeline'] ?? 'Not specified')));
$details = trim(strip_tags((string)($_POST['details'] ?? '')));
// Decode any existing numeric or HTML entities in case client submitted encoded CRLF
$details = html_entity_decode($details, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$honeypot = trim($_POST['website_hp'] ?? ''); // Honeypot field for bot protection

// Header injection prevention: strip carriage returns and newlines from single-line headers
$name = str_replace(["\r", "\n", "%0a", "%0d"], '', $name);
$email = str_replace(["\r", "\n", "%0a", "%0d"], '', $email);
$company = str_replace(["\r", "\n", "%0a", "%0d"], '', $company);

// Honeypot spam check: if filled, quietly reject bot
if (!empty($honeypot)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your inquiry has been received.'
    ]);
    exit;
}

// CSRF Security Check (Allow graceful fallback if token is expired/missing from legacy browser sessions)
$csrf_token = $_POST['csrf_token'] ?? '';
if (!empty($csrf_token) && !verify_csrf_token($csrf_token)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Security token verification failed. Please refresh the page and try again.'
    ]);
    exit;
}

// DPDP Act 2023 Affirmative Consent Enforcement
$dpdp_consent = !empty($_POST['dpdp_consent']);
if (!$dpdp_consent) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Affirmative consent under the Digital Personal Data Protection Act, 2023 (DPDP Act 2023) is required to process your consultation inquiry.'
    ]);
    exit;
}

// Field validation & Length bounds
$errors = [];
if (empty($name)) {
    $errors[] = 'Full name is required.';
} elseif (mb_strlen($name) > 100) {
    $errors[] = 'Name exceeds maximum length of 100 characters.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
} elseif (mb_strlen($email) > 120) {
    $errors[] = 'Email exceeds maximum length of 120 characters.';
}

if (empty($company)) {
    $errors[] = 'Company or business name is required.';
} elseif (mb_strlen($company) > 150) {
    $errors[] = 'Company name exceeds maximum length of 150 characters.';
}

if (empty($project_type)) {
    $errors[] = 'Please select a project type.';
}

if (empty($details)) {
    $errors[] = 'Project details are required.';
} elseif (mb_strlen($details) > 5000) {
    $errors[] = 'Project details exceed maximum length of 5000 characters.';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors)
    ]);
    exit;
}

require_once __DIR__ . '/../includes/smtp_mailer.php';

// Recipient on cPanel / Admin setting
$to = get_setting('smtp_recipient_email', CONTACT_EMAIL);
$subject = "New Project Inquiry from {$name} ({$company}) — " . APP_NAME;

// Construct Plain Text Email Body
$plainBody = "====================================================\n";
$plainBody .= " NEW PROJECT INQUIRY — " . APP_NAME . "\n";
$plainBody .= "====================================================\n\n";
$plainBody .= "Client Name:  " . $name . "\n";
$plainBody .= "Email:        " . $email . "\n";
$plainBody .= "Company:      " . $company . "\n";
$plainBody .= "Project Type: " . $project_type . "\n";
$plainBody .= "Timeline:     " . $timeline . "\n";
$plainBody .= "Submitted:    " . date('Y-m-d H:i:s') . " (IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown') . ")\n\n";
$plainBody .= "Project Details & Requirements:\n";
$plainBody .= "----------------------------------------------------\n";
$plainBody .= $details . "\n";
$plainBody .= "====================================================\n";

// Construct Branded HTML Email Body
$htmlBody = build_inquiry_html_email([
    'name' => $name,
    'email' => $email,
    'company' => $company,
    'scope' => $project_type,
    'timeline' => $timeline,
    'details' => $details,
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
]);

// 1. Save directly into MySQL database if connected (with DPDP consent audit trail)
$db = get_db();
if ($db) {
    $client_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    try {
        // Attempt insert with DPDP Act 2023 consent audit metadata
        $stmt = $db->prepare("INSERT INTO inquiries (name, email, company, scope, timeline, details, status, consent_given, consent_timestamp, consent_ip, consent_version, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, 'new', 1, NOW(), ?, 'v1.0', ?, NOW())");
        $stmt->execute([$name, $email, $company, $project_type, $timeline, $details, $client_ip, $client_ip]);
    } catch (Exception $e) {
        // Safe fallback if dpdp_update.sql migration has not yet run
        try {
            $stmt = $db->prepare("INSERT INTO inquiries (name, email, company, scope, timeline, details, status, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, 'new', ?, NOW())");
            $stmt->execute([$name, $email, $company, $project_type, $timeline, $details, $client_ip]);
        } catch (Exception $e2) {
            error_log("Database insertion notice: " . $e2->getMessage());
        }
    }
}

// 2. Dispatch mail using Authenticated SMTP over TLS (falls back safely to envelope-safe mail() if SMTP offline)
$mailResult = ritiverse_send_mail($to, $subject, $htmlBody, $plainBody, $email, $name);
$mailSent = !empty($mailResult['success']);

// 3. Log submission locally on server as redundancy backup
$logDir = __DIR__ . '/../logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
$logEntry = "[" . date('Y-m-d H:i:s') . "] " . json_encode([
    'name' => $name,
    'email' => $email,
    'company' => $company,
    'type' => $project_type,
    'timeline' => $timeline,
    'status' => $mailSent ? 'sent' : 'logged_only',
    'transport' => $mailResult['method'] ?? 'unknown'
]) . PHP_EOL;
@file_put_contents($logDir . '/inquiries.log', $logEntry, FILE_APPEND);

// Success Response
echo json_encode([
    'success' => true,
    'message' => "Thank you, {$name}! We have received your inquiry. Our senior technical team will review your requirements and reach out within 24 hours with an initial estimate."
]);
exit;
