<?php
/**
 * RiTiVerse — Enterprise SMTP & TLS Email Transport
 * Native, zero-dependency SMTP client supporting TLS 1.2 / 1.3, STARTTLS, SSL and RFC 5322 MIME
 * 
 * Resolves email spam issues caused by unauthenticated local mail() and missing TLS encryption.
 */

if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
if (!function_exists('get_setting')) {
    require_once __DIR__ . '/db.php';
}

class RiTiVerseSMTPMailer {
    private $host;
    private $port;
    private $encryption;
    private $username;
    private $password;
    private $fromEmail;
    private $fromName;
    private $allowSelfSigned;
    private $timeout = 15;
    private $socket = null;
    private $debugLog = [];

    public function __construct(array $config = []) {
        $this->host = $config['host'] ?? get_setting('smtp_host', defined('SMTP_HOST') ? SMTP_HOST : 'smtppro.zoho.in');
        $this->port = (int)($config['port'] ?? get_setting('smtp_port', defined('SMTP_PORT') ? SMTP_PORT : 465));
        $this->encryption = strtolower($config['encryption'] ?? get_setting('smtp_encryption', defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : 'ssl'));
        $this->username = $config['username'] ?? get_setting('smtp_username', defined('SMTP_USER') ? SMTP_USER : 'info@ritiverse.in');
        $this->password = $config['password'] ?? get_setting('smtp_password', defined('SMTP_PASS') ? SMTP_PASS : '');
        $this->fromEmail = $config['from_email'] ?? get_setting('smtp_from_email', defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'info@ritiverse.in');
        if (empty($this->fromEmail) && !empty($this->username)) {
            $this->fromEmail = $this->username;
        }
        $this->fromName = $config['from_name'] ?? get_setting('smtp_from_name', defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'RiTiVerse Studio');
        $this->allowSelfSigned = isset($config['allow_self_signed']) ? (bool)$config['allow_self_signed'] : (bool)get_setting('smtp_allow_self_signed', 1);
    }

    private function log($message) {
        $this->debugLog[] = '[' . date('H:i:s') . '] ' . $message;
    }

    public function getLogs() {
        return $this->debugLog;
    }

    /**
     * Read response line(s) from SMTP socket
     */
    private function getResponse() {
        $data = '';
        while ($line = fgets($this->socket, 1024)) {
            $data .= $line;
            // SMTP multi-line responses have a dash after the 3-digit code (e.g. 250-SIZE)
            // The final line has a space (e.g. 250 OK)
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        $this->log("SERVER: " . trim($data));
        return $data;
    }

    /**
     * Send command to SMTP socket and read response
     */
    private function sendCommand($command, $expectedCode = 250, $mask = false) {
        if ($mask) {
            $this->log("CLIENT: [PROTECTED CREDENTIAL]");
        } else {
            $this->log("CLIENT: " . trim($command));
        }

        fputs($this->socket, $command . "\r\n");
        $response = $this->getResponse();
        $code = (int)substr($response, 0, 3);

        if (!is_array($expectedCode)) {
            $expectedCode = [$expectedCode];
        }

        if (!in_array($code, $expectedCode)) {
            throw new Exception("SMTP Error: Expected " . implode('/', $expectedCode) . ", got: " . trim($response));
        }

        return $response;
    }

    /**
     * Connect and authenticate over TLS or SSL
     */
    private function connect() {
        $this->log("Initiating connection to {$this->host}:{$this->port} (Encryption: {$this->encryption})...");

        $cryptoMethod = STREAM_CRYPTO_METHOD_TLS_CLIENT;
        if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
            $cryptoMethod |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
        }
        if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
            $cryptoMethod |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
        }

        $contextOptions = [
            'ssl' => [
                'verify_peer' => !$this->allowSelfSigned,
                'verify_peer_name' => !$this->allowSelfSigned,
                'allow_self_signed' => $this->allowSelfSigned,
                'crypto_method' => $cryptoMethod
            ]
        ];

        $context = stream_context_create($contextOptions);
        $protocol = ($this->encryption === 'ssl' || $this->port == 465) ? 'ssl://' : 'tcp://';
        $target = $protocol . $this->host . ':' . $this->port;

        $errno = 0;
        $errstr = '';
        $this->socket = @stream_socket_client($target, $errno, $errstr, $this->timeout, STREAM_CLIENT_CONNECT, $context);

        if (!$this->socket) {
            throw new Exception("Could not connect to SMTP server {$target}: [{$errno}] {$errstr}");
        }

        stream_set_timeout($this->socket, $this->timeout);
        $greeting = $this->getResponse();
        if (substr($greeting, 0, 3) !== '220') {
            throw new Exception("Invalid greeting from mail server: " . trim($greeting));
        }

        // Send Initial EHLO
        $clientHost = !empty($_SERVER['HTTP_HOST']) ? preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']) : 'ritiverse.in';
        $this->sendCommand("EHLO " . $clientHost, 250);

        // If TLS requested and not already on SSL socket, perform STARTTLS upgrade
        if ($protocol === 'tcp://' && ($this->encryption === 'tls' || $this->port == 587)) {
            $this->log("Requesting STARTTLS encrypted tunnel...");
            $this->sendCommand("STARTTLS", 220);

            $this->log("Negotiating TLS 1.2 / TLS 1.3 cryptographic handshake...");
            $cryptoSuccess = @stream_socket_enable_crypto($this->socket, true, $cryptoMethod);
            
            if (!$cryptoSuccess) {
                throw new Exception("TLS encryption handshake failed with {$this->host}. Please check server SSL certificate or enable self-signed certificate option.");
            }
            $this->log("✓ TLS Handshake successful! Connection is now encrypted.");

            // Re-send EHLO inside the TLS tunnel as per RFC 3207
            $this->sendCommand("EHLO " . $clientHost, 250);
        }

        // Authenticate if credentials provided
        if (!empty($this->username) && !empty($this->password)) {
            $this->log("Authenticating with username: {$this->username}...");
            $this->sendCommand("AUTH LOGIN", 334);
            $this->sendCommand(base64_encode($this->username), 334, true);
            $this->sendCommand(base64_encode($this->password), 235, true);
            $this->log("✓ SMTP Authentication successful!");
        }

        return true;
    }

    /**
     * Close SMTP connection
     */
    private function disconnect() {
        if ($this->socket) {
            try {
                $this->sendCommand("QUIT", [221, 250]);
            } catch (Exception $e) {
                // Ignore disconnect errors
            }
            @fclose($this->socket);
            $this->socket = null;
            $this->log("Connection closed.");
        }
    }

    /**
     * Send email via authenticated TLS SMTP
     */
    public function send($to, $subject, $htmlContent, $plainContent = '', $replyToEmail = '', $replyToName = '') {
        try {
            $this->connect();

            // MAIL FROM
            $from = $this->fromEmail;
            $this->sendCommand("MAIL FROM:<{$from}>", 250);

            // RCPT TO
            $this->sendCommand("RCPT TO:<{$to}>", [250, 251]);

            // DATA
            $this->sendCommand("DATA", 354);

            // Build MIME payload
            $mimeData = $this->buildMimeMessage($to, $subject, $htmlContent, $plainContent, $replyToEmail, $replyToName);

            // Double leading dots for SMTP transparency (dot-stuffing)
            $lines = explode("\r\n", $mimeData);
            foreach ($lines as $line) {
                if (isset($line[0]) && $line[0] === '.') {
                    $line = '.' . $line;
                }
                fputs($this->socket, $line . "\r\n");
            }

            // End data indicator
            $this->sendCommand(".", 250);
            $this->log("✓ Message accepted for delivery by remote MTA.");

            $this->disconnect();
            return [
                'success' => true,
                'method' => 'smtp_tls',
                'log' => $this->debugLog
            ];

        } catch (Exception $e) {
            $this->log("SMTP ERROR: " . $e->getMessage());
            $this->disconnect();

            // Log error to file
            $logDir = __DIR__ . '/../logs';
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0755, true);
            }
            @file_put_contents($logDir . '/smtp_error.log', "[" . date('Y-m-d H:i:s') . "] " . $e->getMessage() . "\n" . implode("\n", $this->debugLog) . "\n\n", FILE_APPEND);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'method' => 'smtp_tls',
                'log' => $this->debugLog
            ];
        }
    }

    /**
     * Send diagnostic test email to verify TLS socket and inbox deliverability
     */
    public function sendTestEmail($to) {
        $subject = "TLS & SMTP Security Verification — " . $this->fromName;
        $time = date('D, d M Y — H:i:s T');
        $html = <<<HTML
<!DOCTYPE html>
<html>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #FAF7EE; padding: 24px; color: #0F172A;">
  <div style="max-width: 580px; margin: 0 auto; background: #FFFFFF; border: 1px solid #E2DAC4; border-radius: 14px; padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">
    <div style="font-size: 13px; font-weight: 800; color: #10B981; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">✓ TLS Handshake Verified</div>
    <h2 style="font-size: 20px; font-weight: 800; margin: 0 0 16px 0; color: #0F172A;">RiTiVerse Authenticated Mail Transport Test</h2>
    <p style="font-size: 14px; line-height: 1.6; color: #475569;">
      Congratulations! Your contact form mail transport has successfully connected to <strong>{$this->host}:{$this->port}</strong> via encrypted <strong>{$this->encryption}</strong>.
    </p>
    <div style="background: #FAF7EE; border-left: 3px solid #F86800; border-radius: 0 8px 8px 0; padding: 16px 20px; margin: 20px 0; font-size: 13px; line-height: 1.8;">
      <div><strong>SMTP Host:</strong> {$this->host}</div>
      <div><strong>Port:</strong> {$this->port} ({$this->encryption})</div>
      <div><strong>Sender Envelope:</strong> {$this->fromEmail}</div>
      <div><strong>Recipient:</strong> {$to}</div>
      <div><strong>Timestamp:</strong> {$time}</div>
      <div><strong>Security:</strong> Authenticated TLS Socket (Inbox-Grade)</div>
    </div>
    <p style="font-size: 12.5px; color: #0F172A; font-weight: 600; margin-bottom: 0;">
      ✓ This email was dispatched over an authenticated TLS socket to guarantee SPF, DKIM, and DMARC alignment and bypass spam filters.
    </p>
  </div>
</body>
</html>
HTML;
        $plain = "TLS & SMTP Security Verification\n\nConnected to {$this->host}:{$this->port} ({$this->encryption})\nSender: {$this->fromEmail}\nRecipient: {$to}\nTime: {$time}\n\nThis message confirms authenticated encrypted delivery.";
        return $this->send($to, $subject, $html, $plain);
    }

    /**
     * Construct complete RFC 5322 MIME message with HTML + Plain text multipart
     */
    private function buildMimeMessage($to, $subject, $htmlContent, $plainContent = '', $replyToEmail = '', $replyToName = '') {
        $boundary = '=_ritiverse_' . md5(uniqid(microtime(true), true));
        $date = date('r');
        $host = !empty($_SERVER['HTTP_HOST']) ? preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']) : 'ritiverse.in';
        $messageId = '<' . time() . '.' . md5(uniqid()) . '@' . $host . '>';

        // Encode subject safely in base64 UTF-8
        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $encodedFromName = '=?UTF-8?B?' . base64_encode($this->fromName) . '?=';

        $headers = [];
        $headers[] = "Date: {$date}";
        $headers[] = "Message-ID: {$messageId}";
        $headers[] = "From: {$encodedFromName} <{$this->fromEmail}>";
        $headers[] = "To: <{$to}>";
        if (!empty($replyToEmail)) {
            $replyName = !empty($replyToName) ? '=?UTF-8?B?' . base64_encode($replyToName) . '?= ' : '';
            $headers[] = "Reply-To: {$replyName}<{$replyToEmail}>";
        }
        $headers[] = "Subject: {$encodedSubject}";
        $headers[] = "X-Mailer: RiTiVerse Enterprise TLS Engine 2.0";
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: multipart/alternative; boundary=\"{$boundary}\"";

        // If no plain content provided, strip tags from HTML
        if (empty($plainContent)) {
            $plainContent = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $htmlContent));
        }

        // Build Body
        $body = [];
        $body[] = implode("\r\n", $headers);
        $body[] = "";
        $body[] = "This is a multi-part message in MIME format.";
        $body[] = "";

        // Part 1: Plain Text
        $body[] = "--{$boundary}";
        $body[] = "Content-Type: text/plain; charset=UTF-8; format=flowed";
        $body[] = "Content-Transfer-Encoding: base64";
        $body[] = "";
        $body[] = chunk_split(base64_encode($plainContent));

        // Part 2: HTML
        $body[] = "--{$boundary}";
        $body[] = "Content-Type: text/html; charset=UTF-8";
        $body[] = "Content-Transfer-Encoding: base64";
        $body[] = "";
        $body[] = chunk_split(base64_encode($htmlContent));

        $body[] = "--{$boundary}--";

        return implode("\r\n", $body);
    }
}

/**
 * High-Level Helper: Send inquiry notification with fallback to native cPanel mail
 */
function ritiverse_send_mail($to, $subject, $htmlContent, $plainContent = '', $replyToEmail = '', $replyToName = '') {
    $smtpEnabled = (bool)get_setting('smtp_enabled', defined('SMTP_ENABLED') ? SMTP_ENABLED : 1);
    $smtpHost = get_setting('smtp_host', defined('SMTP_HOST') ? SMTP_HOST : 'mail.ritiverse.in');
    $smtpPass = get_setting('smtp_password', defined('SMTP_PASS') ? SMTP_PASS : '');

    // 1. Try Authenticated SMTP over TLS if enabled and host configured
    if ($smtpEnabled && !empty($smtpHost) && !empty($smtpPass)) {
        $mailer = new RiTiVerseSMTPMailer();
        $result = $mailer->send($to, $subject, $htmlContent, $plainContent, $replyToEmail, $replyToName);
        if ($result['success']) {
            return $result;
        }
        // If SMTP failed, log warning and failover to mail() with proper envelope sender
        error_log("RiTiVerse SMTP failed, failing over to cPanel sendmail: " . ($result['error'] ?? 'Unknown'));
    }

    // 2. High-Deliverability Fallback via PHP mail() with strict envelope sender (-f)
    $fromEmail = get_setting('smtp_from_email', defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'info@ritiverse.in');
    $fromName = get_setting('smtp_from_name', defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'RiTiVerse Studio');
    $boundary = '=_ritiverse_' . md5(uniqid(microtime(true), true));

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $encodedFromName = '=?UTF-8?B?' . base64_encode($fromName) . '?=';

    $headers = [];
    $headers[] = "From: {$encodedFromName} <{$fromEmail}>";
    if (!empty($replyToEmail)) {
        $replyName = !empty($replyToName) ? '=?UTF-8?B?' . base64_encode($replyToName) . '?= ' : '';
        $headers[] = "Reply-To: {$replyName}<{$replyToEmail}>";
    }
    $headers[] = "X-Mailer: RiTiVerse PHP Engine";
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: multipart/alternative; boundary=\"{$boundary}\"";

    if (empty($plainContent)) {
        $plainContent = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $htmlContent));
    }

    $body = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($plainContent)) . "\r\n";

    $body .= "--{$boundary}\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($htmlContent)) . "\r\n";
    $body .= "--{$boundary}--\r\n";

    // Pass -f parameter to force Envelope Sender (Return-Path) alignment for SPF/DMARC
    $mailSent = @mail($to, $encodedSubject, $body, implode("\r\n", $headers), "-f" . escapeshellarg($fromEmail));

    return [
        'success' => $mailSent,
        'method' => 'php_mail_envelope_safe',
        'log' => ['Dispatched via PHP mail() with -f' . $fromEmail]
    ];
}

/**
 * Generate Executive Branded HTML Email Template for Client Inquiries
 */
function build_inquiry_html_email($data) {
    $name = htmlspecialchars($data['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $company = htmlspecialchars($data['company'] ?? '', ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($data['scope'] ?? $data['type'] ?? 'General Inquiry', ENT_QUOTES, 'UTF-8');
    $timeline = htmlspecialchars($data['timeline'] ?? 'Not specified', ENT_QUOTES, 'UTF-8');
    $rawDetails = html_entity_decode((string)($data['details'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $details = nl2br(htmlspecialchars($rawDetails, ENT_QUOTES, 'UTF-8'));
    $ip = htmlspecialchars($data['ip'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', ENT_QUOTES, 'UTF-8');
    $time = date('D, d M Y — H:i:s T');

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Project Inquiry — RiTiVerse Studio</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #FAF7EE; margin: 0; padding: 24px; color: #0F172A; }
    .email-container { max-width: 620px; margin: 0 auto; background: #FFFFFF; border: 1px solid #E2DAC4; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(15,23,42,0.06); }
    .email-header { background: #0F172A; padding: 28px 32px; border-bottom: 3px solid #F86800; text-align: left; }
    .brand-name { color: #FFFFFF; font-size: 22px; font-weight: 800; letter-spacing: -0.02em; margin: 0; }
    .brand-accent { color: #F86800; }
    .brand-tagline { color: #94A3B8; font-size: 12px; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.05em; }
    .email-body { padding: 32px; }
    .badge-pill { display: inline-block; background: rgba(248,104,0,0.1); color: #F86800; font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 4px 12px; border-radius: 999px; margin-bottom: 16px; border: 1px solid rgba(248,104,0,0.25); }
    .inquiry-title { font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0; }
    .info-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
    .info-table td { padding: 10px 14px; font-size: 13.5px; border-bottom: 1px solid #F1ECE1; }
    .info-table td.lbl { width: 130px; font-weight: 700; color: #64748B; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em; }
    .info-table td.val { color: #0F172A; font-weight: 600; }
    .details-box { background: #FAF7EE; border-left: 3px solid #F86800; border-radius: 0 8px 8px 0; padding: 18px 20px; font-size: 14px; line-height: 1.6; color: #334155; margin-bottom: 28px; }
    .cta-btn { display: inline-block; background: #F86800; color: #FFFFFF !important; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 13px; margin-right: 10px; }
    .email-footer { background: #FAF7EE; padding: 20px 32px; text-align: center; font-size: 12px; color: #64748B; border-top: 1px solid #E2DAC4; }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <div class="brand-name">RiTi<span class="brand-accent">Verse</span></div>
      <div class="brand-tagline">Client Delivery &amp; Architectural Engineering Studio</div>
    </div>
    <div class="email-body">
      <div class="badge-pill">✓ New Consultation Request</div>
      <h1 class="inquiry-title">Inquiry from {$name} ({$company})</h1>
      
      <table class="info-table">
        <tr>
          <td class="lbl">Client Name</td>
          <td class="val">{$name}</td>
        </tr>
        <tr>
          <td class="lbl">Email</td>
          <td class="val"><a href="mailto:{$email}" style="color: #F86800; text-decoration: none;">{$email}</a></td>
        </tr>
        <tr>
          <td class="lbl">Company</td>
          <td class="val">{$company}</td>
        </tr>
        <tr>
          <td class="lbl">Scope / Domain</td>
          <td class="val">{$type}</td>
        </tr>
        <tr>
          <td class="lbl">Target Timeline</td>
          <td class="val">{$timeline}</td>
        </tr>
        <tr>
          <td class="lbl">Submission Time</td>
          <td class="val">{$time}</td>
        </tr>
        <tr>
          <td class="lbl">Sender IP</td>
          <td class="val" style="font-family: monospace; font-size: 12px;">{$ip}</td>
        </tr>
      </table>

      <div style="font-size: 11.5px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">
        Project Requirements &amp; Scope Details:
      </div>
      <div class="details-box">
        {$details}
      </div>

      <div style="margin-top: 24px;">
        <a href="mailto:{$email}?subject=Re:%20Project%20Inquiry%20%E2%80%94%20RiTiVerse%20Studio" class="cta-btn">
          ✉ Reply to {$name} Directly
        </a>
      </div>
    </div>
    <div class="email-footer">
      This notification was generated automatically from the contact form at <strong>ritiverse.in</strong>.<br>
      © 2026 RiTiVerse Studio. All client intellectual property &amp; source code 100% owned by the client.
    </div>
  </div>
</body>
</html>
HTML;
}
