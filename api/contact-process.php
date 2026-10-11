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

// Sanitize inputs
$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$company = trim(filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$project_type = trim(filter_input(INPUT_POST, 'scope', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$timeline = trim(filter_input(INPUT_POST, 'timeline', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'Not specified');
$details = trim(filter_input(INPUT_POST, 'details', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
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

// Recipient on cPanel
$to = CONTACT_EMAIL;
$subject = "New Project Inquiry from {$name} ({$company}) — " . APP_NAME;

// Construct Email Body
$messageBody = "====================================================\n";
$messageBody .= " NEW PROJECT INQUIRY — " . APP_NAME . "\n";
$messageBody .= "====================================================\n\n";
$messageBody .= "Client Name:  " . $name . "\n";
$messageBody .= "Email:        " . $email . "\n";
$messageBody .= "Company:      " . $company . "\n";
$messageBody .= "Project Type: " . $project_type . "\n";
$messageBody .= "Timeline:     " . $timeline . "\n";
$messageBody .= "Submitted:    " . date('Y-m-d H:i:s') . " (IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown') . ")\n\n";
$messageBody .= "Project Details & Requirements:\n";
$messageBody .= "----------------------------------------------------\n";
$messageBody .= $details . "\n";
$messageBody .= "====================================================\n";

// cPanel Mail Headers
$headers = [];
$headers[] = 'From: ' . APP_NAME . ' Web <noreply@' . ($_SERVER['HTTP_HOST'] ?? 'ritiverse.in') . '>';
$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
$headers[] = 'X-Mailer: PHP/' . phpversion();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';

// 1. Save directly into MySQL database if connected
$db = get_db();
if ($db) {
    try {
        $stmt = $db->prepare("INSERT INTO inquiries (name, email, company, scope, timeline, details, status, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, 'new', ?, NOW())");
        $stmt->execute([$name, $email, $company, $project_type, $timeline, $details, $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1']);
    } catch (Exception $e) {
        error_log("Database insertion notice: " . $e->getMessage());
    }
}

// 2. Attempt to dispatch mail using cPanel's local sendmail
$mailSent = @mail($to, $subject, $messageBody, implode("\r\n", $headers));

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
    'status' => $mailSent ? 'sent' : 'logged_only'
]) . PHP_EOL;
@file_put_contents($logDir . '/inquiries.log', $logEntry, FILE_APPEND);

// Success Response
echo json_encode([
    'success' => true,
    'message' => "Thank you, {$name}! We have received your inquiry. Our senior technical team will review your requirements and reach out within 24 hours with an initial estimate."
]);
exit;
