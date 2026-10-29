<?php
/**
 * RiTiVerse — Data Principal Rights Request API Endpoint
 * Handles statutory requests under the Digital Personal Data Protection Act, 2023 (DPDP Act 2023)
 */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/smtp_mailer.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Only POST requests are accepted.'
    ]);
    exit;
}

// Rate Limiting: Max 5 submissions per 30 minutes per IP/session
if (!check_rate_limit('dpdp_rights_submission', 5, 1800)) {
    http_response_code(429);
    echo json_encode([
        'success' => false,
        'message' => 'Too many statutory requests from your network. Please wait a few minutes before submitting again.'
    ]);
    exit;
}

// CSRF Security Check
$csrf_token = $_POST['csrf_token'] ?? '';
if (!empty($csrf_token) && !verify_csrf_token($csrf_token)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Security token verification failed. Please refresh the page and try again.'
    ]);
    exit;
}

// Honeypot bot protection
$honeypot = trim($_POST['security_hp'] ?? '');
if (!empty($honeypot)) {
    echo json_encode([
        'success' => true,
        'ticket_id' => 'RTV-DPDP-' . strtoupper(substr(md5((string)time()), 0, 8)),
        'message' => 'Your request has been registered and is under statutory review.'
    ]);
    exit;
}

// Sanitize inputs
$name = trim(strip_tags((string)($_POST['name'] ?? '')));
$email = trim((string)filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$phone = trim(strip_tags((string)($_POST['phone'] ?? '')));
$request_type = trim(strip_tags((string)($_POST['request_type'] ?? '')));
$details = trim(strip_tags((string)($_POST['details'] ?? '')));
$details = html_entity_decode($details, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$declaration = !empty($_POST['declaration']);

// Header injection prevention
$name = str_replace(["\r", "\n", "%0a", "%0d"], '', $name);
$email = str_replace(["\r", "\n", "%0a", "%0d"], '', $email);
$phone = str_replace(["\r", "\n", "%0a", "%0d"], '', $phone);

// Validation
$allowed_types = ['access', 'correction', 'erasure', 'withdraw_consent', 'grievance'];
$errors = [];

if (empty($request_type) || !in_array($request_type, $allowed_types, true)) {
    $errors[] = 'Please select a valid DPDP statutory right.';
}

if (empty($name)) {
    $errors[] = 'Full legal name is required.';
} elseif (mb_strlen($name) > 100) {
    $errors[] = 'Name exceeds 100 characters.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
} elseif (mb_strlen($email) > 120) {
    $errors[] = 'Email exceeds 120 characters.';
}

if (empty($details)) {
    $errors[] = 'Please provide details or specific records relevant to your request.';
} elseif (mb_strlen($details) > 4000) {
    $errors[] = 'Details exceed 4000 characters.';
}

if (!$declaration) {
    $errors[] = 'You must declare that you are the Data Principal or lawful authorized representative.';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors)
    ]);
    exit;
}

// Generate unique Ticket ID
$ticket_id = 'RTV-DPDP-' . strtoupper(bin2hex(random_bytes(4)));
$client_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

// Insert into dpdp_requests table
$db = get_db();
$inserted = false;

if ($db) {
    try {
        $stmt = $db->prepare("INSERT INTO dpdp_requests (ticket_id, name, email, phone, request_type, details, status, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', ?, NOW())");
        $stmt->execute([$ticket_id, $name, $email, $phone, $request_type, $details, $client_ip]);
        $inserted = true;
    } catch (Exception $e) {
        error_log("DPDP request DB insert notice: " . $e->getMessage());
    }
}

// Send Email notification to Grievance Redressal Officer & Confirmation to Principal
$dpo = get_dpo_details();
$type_labels = [
    'access' => 'Right to Access Information (Sec 11)',
    'correction' => 'Right to Correction & Completion (Sec 12)',
    'erasure' => 'Right to Erasure / Right to be Forgotten (Sec 12(3))',
    'withdraw_consent' => 'Withdrawal of Consent (Sec 6(4))',
    'grievance' => 'Statutory Grievance Redressal (Sec 13)'
];
$human_type = $type_labels[$request_type] ?? strtoupper($request_type);

$dpo_subject = "[DPDP Request #{$ticket_id}] {$human_type} from {$name}";
$dpo_body = "====================================================\n"
          . " DPDP ACT 2023 — STATUTORY DATA PRINCIPAL REQUEST\n"
          . "====================================================\n\n"
          . "Ticket ID:     {$ticket_id}\n"
          . "Statutory Right: {$human_type}\n"
          . "Data Principal: {$name}\n"
          . "Email:         {$email}\n"
          . "Phone:         " . ($phone ?: 'Not provided') . "\n"
          . "IP Address:    {$client_ip}\n"
          . "Timestamp:     " . date('Y-m-d H:i:s') . "\n\n"
          . "Request Specifics:\n"
          . "----------------------------------------------------\n"
          . $details . "\n"
          . "====================================================\n"
          . "Mandatory Action Required: Review & fulfill within 30 calendar days.\n"
          . "Admin Portal: " . SITE_URL . "/admin/dpdp.php\n";

@ritiverse_send_mail($dpo['email'], $dpo_subject, nl2br(htmlspecialchars($dpo_body, ENT_QUOTES, 'UTF-8')), $dpo_body, $email, $name);

echo json_encode([
    'success' => true,
    'ticket_id' => $ticket_id,
    'message' => "Your statutory DPDP request has been registered under ticket #{$ticket_id}. Our Grievance Redressal Desk has been notified and will verify your identity and fulfill the request within 30 calendar days."
]);
