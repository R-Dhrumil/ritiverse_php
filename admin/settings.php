<?php
/**
 * RiTiVerse — Site Configuration & SEO Connectivity Center
 * Manage Google Analytics, Google Search Console, Bing, Meta Pixel, SEO & Brand Coordinates
 */
$active_tab = 'settings';
$admin_title = 'Site Configuration & SEO Connectivity Center';
$admin_subtitle = 'Manage Google Analytics, Search Console, Bing, Meta Pixel, SEO metadata & official channels';

require_once __DIR__ . '/admin_header.php';
require_once __DIR__ . '/../includes/smtp_mailer.php';

$db = get_db();
$message = '';
$error = '';
$test_logs = [];
$test_success = null;

// Handle Form Submissions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Please reload the page.';
    } elseif (isset($_POST['action']) && $_POST['action'] === 'test_smtp') {
        // --- 1. Test SMTP Connection over TLS/SSL ---
        $test_recipient = trim($_POST['test_email'] ?? '');
        if (empty($test_recipient) || !filter_var($test_recipient, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please provide a valid recipient email address to receive the test message.';
        } else {
            $test_config = [
                'host' => trim($_POST['smtp_host'] ?? 'mail.ritiverse.in'),
                'port' => (int)($_POST['smtp_port'] ?? 587),
                'encryption' => trim($_POST['smtp_encryption'] ?? 'tls'),
                'username' => trim($_POST['smtp_username'] ?? 'info@ritiverse.in'),
                'password' => !empty($_POST['smtp_password']) ? trim($_POST['smtp_password']) : get_setting('smtp_password', defined('SMTP_PASS') ? SMTP_PASS : ''),
                'from_email' => trim($_POST['smtp_from_email'] ?? 'info@ritiverse.in'),
                'from_name' => trim($_POST['smtp_from_name'] ?? 'RiTiVerse Studio'),
                'allow_self_signed' => isset($_POST['smtp_allow_self_signed']) ? 1 : 0
            ];
            
            $testMailer = new RiTiVerseSMTPMailer($test_config);
            $test_res = $testMailer->sendTestEmail($test_recipient);
            $test_logs = $test_res['log'] ?? [];
            if ($test_res['success']) {
                $test_success = true;
                $message = "✓ TLS SMTP Handshake Successful! Verification email was accepted and dispatched to {$test_recipient}.";
            } else {
                $test_success = false;
                $error = "✕ TLS SMTP Test Failed: " . ($test_res['error'] ?? 'Connection error. Check log below.');
            }
        }
    } elseif ($db) {
        // --- 2. Save All Site Settings & SMTP Config ---
        $settings_to_update = [
            // 1. General & Coordinates
            'site_name' => trim($_POST['site_name'] ?? APP_NAME),
            'site_tagline' => trim($_POST['site_tagline'] ?? APP_TAGLINE),
            'contact_email' => trim($_POST['contact_email'] ?? CONTACT_EMAIL),
            'support_email' => trim($_POST['support_email'] ?? SUPPORT_EMAIL),
            'contact_phone' => trim($_POST['contact_phone'] ?? CONTACT_PHONE),
            'office_location' => trim($_POST['office_location'] ?? 'Ahmedabad / Mumbai, India • Global Client Delivery'),
            'whatsapp_number' => trim($_POST['whatsapp_number'] ?? '+919426782646'),

            // 2. SEO & Webmaster Verification
            'google_site_verification' => trim($_POST['google_site_verification'] ?? ''),
            'bing_site_verification' => trim($_POST['bing_site_verification'] ?? '37D47CA67C44D215674E7B6D860E11FE'),
            'seo_primary_keywords' => trim($_POST['seo_primary_keywords'] ?? SEO_PRIMARY_KEYWORDS),
            'seo_author' => trim($_POST['seo_author'] ?? SEO_AUTHOR),

            // 3. Analytics & Ad Pixels
            'google_analytics_id' => trim($_POST['google_analytics_id'] ?? ''),
            'meta_pixel_id' => trim($_POST['meta_pixel_id'] ?? ''),

            // 4. Social Media Channels
            'social_linkedin' => trim($_POST['social_linkedin'] ?? SOCIAL_LINKEDIN),
            'social_instagram' => trim($_POST['social_instagram'] ?? SOCIAL_INSTAGRAM),
            'social_github' => trim($_POST['social_github'] ?? SOCIAL_GITHUB),
            'social_x' => trim($_POST['social_x'] ?? SOCIAL_X),
            'social_facebook' => trim($_POST['social_facebook'] ?? SOCIAL_FACEBOOK),

            // 5. Email & SMTP Delivery (TLS/SSL Zero-Spam Setup)
            'smtp_enabled' => isset($_POST['smtp_enabled']) ? '1' : '0',
            'smtp_host' => trim($_POST['smtp_host'] ?? 'mail.ritiverse.in'),
            'smtp_port' => trim($_POST['smtp_port'] ?? '587'),
            'smtp_encryption' => trim($_POST['smtp_encryption'] ?? 'tls'),
            'smtp_username' => trim($_POST['smtp_username'] ?? 'info@ritiverse.in'),
            'smtp_from_email' => trim($_POST['smtp_from_email'] ?? 'info@ritiverse.in'),
            'smtp_from_name' => trim($_POST['smtp_from_name'] ?? 'RiTiVerse Studio'),
            'smtp_recipient_email' => trim($_POST['smtp_recipient_email'] ?? 'info@ritiverse.in'),
            'smtp_allow_self_signed' => isset($_POST['smtp_allow_self_signed']) ? '1' : '0'
        ];

        // Only update password if a new one was provided
        if (!empty($_POST['smtp_password'])) {
            $settings_to_update['smtp_password'] = trim($_POST['smtp_password']);
        }

        try {
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES (?, ?, 'general') ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
            foreach ($settings_to_update as $key => $val) {
                $stmt->execute([$key, $val]);
            }
            $message = 'Settings, SEO & SMTP email parameters updated successfully in database.';
        } catch (Exception $e) {
            $error = 'Failed to update settings: ' . $e->getMessage();
        }
    }
}

// Read current settings with fallback to config constants
$current_settings = [
    // General
    'site_name' => get_setting('site_name', APP_NAME),
    'site_tagline' => get_setting('site_tagline', APP_TAGLINE),
    'contact_email' => get_setting('contact_email', CONTACT_EMAIL),
    'support_email' => get_setting('support_email', SUPPORT_EMAIL),
    'contact_phone' => get_setting('contact_phone', CONTACT_PHONE),
    'office_location' => get_setting('office_location', 'Ahmedabad / Mumbai, India • Global Client Delivery'),
    'whatsapp_number' => get_setting('whatsapp_number', '+919426782646'),

    // SEO & Webmasters
    'google_site_verification' => get_setting('google_site_verification', defined('GOOGLE_SITE_VERIFICATION') ? GOOGLE_SITE_VERIFICATION : ''),
    'bing_site_verification' => get_setting('bing_site_verification', defined('BING_SITE_VERIFICATION') ? BING_SITE_VERIFICATION : '37D47CA67C44D215674E7B6D860E11FE'),
    'seo_primary_keywords' => get_setting('seo_primary_keywords', defined('SEO_PRIMARY_KEYWORDS') ? SEO_PRIMARY_KEYWORDS : ''),
    'seo_author' => get_setting('seo_author', defined('SEO_AUTHOR') ? SEO_AUTHOR : 'RiTiVerse Engineering Studio'),

    // Analytics & Tracking
    'google_analytics_id' => get_setting('google_analytics_id', defined('GOOGLE_ANALYTICS_ID') ? GOOGLE_ANALYTICS_ID : ''),
    'meta_pixel_id' => get_setting('meta_pixel_id', defined('META_PIXEL_ID') ? META_PIXEL_ID : ''),

    // Social Media
    'social_linkedin' => get_setting('social_linkedin', defined('SOCIAL_LINKEDIN') ? SOCIAL_LINKEDIN : 'https://www.linkedin.com/company/ritiverse'),
    'social_instagram' => get_setting('social_instagram', defined('SOCIAL_INSTAGRAM') ? SOCIAL_INSTAGRAM : ''),
    'social_github' => get_setting('social_github', defined('SOCIAL_GITHUB') ? SOCIAL_GITHUB : ''),
    'social_x' => get_setting('social_x', defined('SOCIAL_X') ? SOCIAL_X : ''),
    'social_facebook' => get_setting('social_facebook', defined('SOCIAL_FACEBOOK') ? SOCIAL_FACEBOOK : ''),

    // Email & Authenticated SMTP (TLS/SSL) Transport
    'smtp_enabled' => get_setting('smtp_enabled', defined('SMTP_ENABLED') ? (SMTP_ENABLED ? '1' : '0') : '1'),
    'smtp_host' => get_setting('smtp_host', defined('SMTP_HOST') ? SMTP_HOST : 'mail.ritiverse.in'),
    'smtp_port' => get_setting('smtp_port', defined('SMTP_PORT') ? SMTP_PORT : '587'),
    'smtp_encryption' => get_setting('smtp_encryption', defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : 'tls'),
    'smtp_username' => get_setting('smtp_username', defined('SMTP_USER') ? SMTP_USER : 'info@ritiverse.in'),
    'smtp_password' => get_setting('smtp_password', defined('SMTP_PASS') ? SMTP_PASS : ''),
    'smtp_from_email' => get_setting('smtp_from_email', defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'info@ritiverse.in'),
    'smtp_from_name' => get_setting('smtp_from_name', defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'RiTiVerse Studio'),
    'smtp_recipient_email' => get_setting('smtp_recipient_email', defined('SMTP_RECIPIENT_EMAIL') ? SMTP_RECIPIENT_EMAIL : 'info@ritiverse.in'),
    'smtp_allow_self_signed' => get_setting('smtp_allow_self_signed', '1')
];

// Connectivity statuses
$has_ga = !empty($current_settings['google_analytics_id']);
$has_gsc = !empty($current_settings['google_site_verification']);
$has_bing = !empty($current_settings['bing_site_verification']);
$has_pixel = !empty($current_settings['meta_pixel_id']);
$has_smtp = !empty($current_settings['smtp_enabled']) && !empty($current_settings['smtp_password']);
?>

<div style="max-width: 1200px; margin: 0 auto;">

  <!-- Feedback Notifications -->
  <?php if (!empty($message)): ?>
    <div style="background: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
      <span>✓ <?= e($message) ?></span>
      <button onclick="this.parentElement.remove()" style="background:none; border:none; cursor:pointer; color:#065F46; font-size:16px;">✕</button>
    </div>
  <?php endif; ?>

  <?php if (!empty($error)): ?>
    <div style="background: #FEE2E2; border: 1px solid #EF4444; color: #B91C1C; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
      <span>⚠ <?= e($error) ?></span>
      <button onclick="this.parentElement.remove()" style="background:none; border:none; cursor:pointer; color:#B91C1C; font-size:16px;">✕</button>
    </div>
  <?php endif; ?>

  <!-- Live Connectivity Status Dashboard -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 30px;">
    <!-- Google Analytics Status -->
    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Google Analytics</span>
        <div class="admin-stat-icon <?= $has_ga ? 'icon-emerald' : 'icon-orange' ?>">📊</div>
      </div>
      <div>
        <div style="font-size: 14px; font-weight: 700; color: var(--admin-text-main); margin-bottom: 4px;">
          <?= $has_ga ? e($current_settings['google_analytics_id']) : 'Not Configured' ?>
        </div>
        <div class="admin-stat-foot">
          <?= $has_ga ? '<span style="color:#059669; font-weight:700;">● Active on all pages</span>' : 'Add Measurement ID below' ?>
        </div>
      </div>
    </div>

    <!-- Google Search Console Status -->
    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Search Console</span>
        <div class="admin-stat-icon <?= $has_gsc ? 'icon-emerald' : 'icon-blue' ?>">🔍</div>
      </div>
      <div>
        <div style="font-size: 14px; font-weight: 700; color: var(--admin-text-main); margin-bottom: 4px;">
          <?= $has_gsc ? 'Google Verified' : 'Pending Verification' ?>
        </div>
        <div class="admin-stat-foot">
          <?= $has_gsc ? '<span style="color:#059669; font-weight:700;">● Meta tag active</span>' : 'Paste verification token below' ?>
        </div>
      </div>
    </div>

    <!-- Bing Webmaster Status -->
    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Bing Webmaster</span>
        <div class="admin-stat-icon icon-emerald">⚡</div>
      </div>
      <div>
        <div style="font-size: 14px; font-weight: 700; color: var(--admin-text-main); margin-bottom: 4px; font-family: var(--admin-font-mono);">
          <?= substr(e($current_settings['bing_site_verification']), 0, 14) ?>...
        </div>
        <div class="admin-stat-foot">
          <span style="color:#059669; font-weight:700;">● Active (Bing &amp; Yahoo)</span>
        </div>
      </div>
    </div>

    <!-- Meta Pixel Status -->
    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Meta Pixel (Ads)</span>
        <div class="admin-stat-icon <?= $has_pixel ? 'icon-indigo' : 'icon-blue' ?>">🎯</div>
      </div>
      <div>
        <div style="font-size: 14px; font-weight: 700; color: var(--admin-text-main); margin-bottom: 4px;">
          <?= $has_pixel ? e($current_settings['meta_pixel_id']) : 'Not Configured' ?>
        </div>
        <div class="admin-stat-foot">
          <?= $has_pixel ? '<span style="color:#4338CA; font-weight:700;">● Pixel tracking active</span>' : 'Add Meta Pixel ID below' ?>
        </div>
      </div>
    </div>

    <!-- SMTP TLS Delivery Status -->
    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Email / SMTP TLS</span>
        <div class="admin-stat-icon <?= $has_smtp ? 'icon-emerald' : 'icon-orange' ?>">✉</div>
      </div>
      <div>
        <div style="font-size: 14px; font-weight: 700; color: var(--admin-text-main); margin-bottom: 4px;">
          <?= $has_smtp ? 'TLS Encrypted' : 'cPanel Sendmail' ?>
        </div>
        <div class="admin-stat-foot">
          <?= $has_smtp ? '<span style="color:#059669; font-weight:700;">● Authenticated (Inbox-Grade)</span>' : '<span style="color:#D97706; font-weight:700;">▲ Enter password below</span>' ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Diagnostic SMTP Test Transcript Modal / Card -->
  <?php if (!empty($test_logs)): ?>
    <div style="background: #0F172A; border: 1px solid <?= $test_success ? '#10B981' : '#EF4444' ?>; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
        <span style="font-size: 13px; font-weight: 700; color: <?= $test_success ? '#34D399' : '#F87171' ?>; text-transform: uppercase; letter-spacing: 0.05em;">
          <?= $test_success ? '✓ Live SMTP &amp; TLS Handshake Transcript (Inbox Verified)' : '✕ Live SMTP &amp; TLS Socket Transcript (Error Detected)' ?>
        </span>
        <button type="button" onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: #94A3B8; cursor: pointer; font-size: 16px;">✕</button>
      </div>
      <pre style="margin: 0; font-family: monospace; font-size: 12px; color: #E2E8F0; line-height: 1.6; max-height: 240px; overflow-y: auto; background: rgba(0,0,0,0.3); padding: 12px; border-radius: 6px;"><?= e(implode("\n", $test_logs)) ?></pre>
    </div>
  <?php endif; ?>

  <!-- Main Settings Form -->
  <form method="POST" action="settings.php" id="settingsForm">
    <?= csrf_field() ?>

    <!-- Section 1: Analytics & Advertising Pixels -->
    <div class="admin-table-card" style="margin-bottom: 28px;">
      <div class="admin-card-header" style="background: rgba(2, 132, 199, 0.04);">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 20px;">📊</span>
          <div>
            <h3 class="admin-card-title">Analytics &amp; Advertising Pixel Connectivity</h3>
            <p style="font-size: 12px; color: var(--admin-text-muted); margin: 0;">Configure tracking scripts for traffic analytics, lead conversions, and advertising ROI</p>
          </div>
        </div>
      </div>

      <div style="padding: 26px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 12px;">
          <!-- Google Analytics GA4 -->
          <div class="admin-form-group">
            <label class="admin-form-label" style="display: flex; align-items: center; justify-content: space-between;">
              <span>Google Analytics 4 / GTM ID</span>
              <span style="font-size: 11px; text-transform: none; color: #0284C7; font-weight: 600;">gtag.js Tracking</span>
            </label>
            <input type="text" name="google_analytics_id" class="admin-input" placeholder="e.g. G-ABC123XYZ or GTM-XXXXXXX" value="<?= e($current_settings['google_analytics_id']) ?>">
            <span style="font-size: 11.5px; color: var(--admin-text-muted); display: block; margin-top: 5px;">
              Format: <code>G-XXXXXXXXXX</code> (from Google Analytics &gt; Data Streams &gt; Measurement ID)
            </span>
          </div>

          <!-- Meta Pixel ID -->
          <div class="admin-form-group">
            <label class="admin-form-label" style="display: flex; align-items: center; justify-content: space-between;">
              <span>Meta Pixel (Facebook / Instagram Ads) ID</span>
              <span style="font-size: 11px; text-transform: none; color: #4338CA; font-weight: 600;">fbq Pixel</span>
            </label>
            <input type="text" name="meta_pixel_id" class="admin-input" placeholder="e.g. 123456789012345" value="<?= e($current_settings['meta_pixel_id']) ?>">
            <span style="font-size: 11.5px; color: var(--admin-text-muted); display: block; margin-top: 5px;">
              From Meta Events Manager &gt; Data Sources. Injects official Pixel with automatic PageView tracking.
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 2: SEO & Search Engine Webmaster Verification -->
    <div class="admin-table-card" style="margin-bottom: 28px;">
      <div class="admin-card-header" style="background: rgba(248, 104, 0, 0.04);">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 20px;">🔍</span>
          <div>
            <h3 class="admin-card-title">SEO Directives &amp; Webmaster Console Verification</h3>
            <p style="font-size: 12px; color: var(--admin-text-muted); margin: 0;">Domain ownership tokens for Google Search Console, Bing Webmaster, and meta keywords</p>
          </div>
        </div>
      </div>

      <div style="padding: 26px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
          <!-- Google Search Console -->
          <div class="admin-form-group">
            <label class="admin-form-label" style="display: flex; align-items: center; justify-content: space-between;">
              <span>Google Search Console Verification Token</span>
              <span style="font-size: 11px; text-transform: none; color: var(--admin-text-muted);">google-site-verification</span>
            </label>
            <input type="text" name="google_site_verification" class="admin-input" placeholder="e.g. dF3q_4bS8... or paste token" value="<?= e($current_settings['google_site_verification']) ?>">
            <span style="font-size: 11.5px; color: var(--admin-text-muted); display: block; margin-top: 5px;">
              Renders <code>&lt;meta name="google-site-verification" content="..."&gt;</code> in site header.
            </span>
          </div>

          <!-- Bing Webmaster Tools -->
          <div class="admin-form-group">
            <label class="admin-form-label" style="display: flex; align-items: center; justify-content: space-between;">
              <span>Bing Webmaster Tools Token (msvalidate.01)</span>
              <span style="font-size: 11px; text-transform: none; color: #059669; font-weight: 600;">Active in BingSiteAuth.xml</span>
            </label>
            <input type="text" name="bing_site_verification" class="admin-input" placeholder="e.g. 37D47CA67C44D215674E7B6D860E11FE" value="<?= e($current_settings['bing_site_verification']) ?>">
            <span style="font-size: 11.5px; color: var(--admin-text-muted); display: block; margin-top: 5px;">
              Pre-filled from <code>BingSiteAuth.xml</code>. Renders <code>&lt;meta name="msvalidate.01" content="..."&gt;</code>.
            </span>
          </div>
        </div>

        <!-- SEO Primary Keywords -->
        <div class="admin-form-group" style="margin-bottom: 20px;">
          <label class="admin-form-label">Global Primary SEO Keywords (Comma-Separated)</label>
          <textarea name="seo_primary_keywords" class="admin-input" rows="3" placeholder="website making, custom CRM development, ERP billing software..."><?= e($current_settings['seo_primary_keywords']) ?></textarea>
          <span style="font-size: 11.5px; color: var(--admin-text-muted); display: block; margin-top: 5px;">
            Target search terms for #1 rankings on Google search results across all web pages.
          </span>
        </div>

        <!-- Author / Entity -->
        <div class="admin-form-group" style="margin-bottom: 0;">
          <label class="admin-form-label">SEO Author / Technical Studio Identity</label>
          <input type="text" name="seo_author" class="admin-input" value="<?= e($current_settings['seo_author']) ?>">
        </div>
      </div>
    </div>

    <!-- Section 3: Official Social Media Channels -->
    <div class="admin-table-card" style="margin-bottom: 28px;">
      <div class="admin-card-header" style="background: rgba(16, 185, 129, 0.04);">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 20px;">🌐</span>
          <div>
            <h3 class="admin-card-title">Official Social Media Profiles</h3>
            <p style="font-size: 12px; color: var(--admin-text-muted); margin: 0;">Links displayed in header fullscreen navigation, footer buttons, and Google Knowledge Graph</p>
          </div>
        </div>
      </div>

      <div style="padding: 26px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
          <!-- LinkedIn -->
          <div class="admin-form-group">
            <label class="admin-form-label">LinkedIn Company Page URL</label>
            <input type="url" name="social_linkedin" class="admin-input" value="<?= e($current_settings['social_linkedin']) ?>">
          </div>

          <!-- Instagram -->
          <div class="admin-form-group">
            <label class="admin-form-label">Instagram Profile URL</label>
            <input type="url" name="social_instagram" class="admin-input" value="<?= e($current_settings['social_instagram']) ?>">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
          <!-- GitHub -->
          <div class="admin-form-group">
            <label class="admin-form-label">GitHub Organization</label>
            <input type="url" name="social_github" class="admin-input" value="<?= e($current_settings['social_github']) ?>">
          </div>

          <!-- X / Twitter -->
          <div class="admin-form-group">
            <label class="admin-form-label">X (Twitter) Profile</label>
            <input type="url" name="social_x" class="admin-input" value="<?= e($current_settings['social_x']) ?>">
          </div>

          <!-- Facebook -->
          <div class="admin-form-group">
            <label class="admin-form-label">Facebook Business Page</label>
            <input type="url" name="social_facebook" class="admin-input" value="<?= e($current_settings['social_facebook']) ?>">
          </div>
        </div>
      </div>
    </div>

    <!-- Section 4: Studio Coordinates & Contact Information -->
    <div class="admin-table-card" style="margin-bottom: 30px;">
      <div class="admin-card-header">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 20px;">🏢</span>
          <div>
            <h3 class="admin-card-title">Studio Branding &amp; Contact Coordinates</h3>
            <p style="font-size: 12px; color: var(--admin-text-muted); margin: 0;">Global contact coordinates, support mailboxes, and office location</p>
          </div>
        </div>
      </div>

      <div style="padding: 26px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Brand / Agency Name</label>
            <input type="text" name="site_name" class="admin-input" value="<?= e($current_settings['site_name']) ?>" required>
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">Primary Tagline</label>
            <input type="text" name="site_tagline" class="admin-input" value="<?= e($current_settings['site_tagline']) ?>" required>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Primary Consultation Email</label>
            <input type="email" name="contact_email" class="admin-input" value="<?= e($current_settings['contact_email']) ?>" required>
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">Technical Support Email</label>
            <input type="email" name="support_email" class="admin-input" value="<?= e($current_settings['support_email']) ?>" required>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Official Phone Number</label>
            <input type="text" name="contact_phone" class="admin-input" value="<?= e($current_settings['contact_phone']) ?>">
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">WhatsApp Number (e.g. +919426782646)</label>
            <input type="text" name="whatsapp_number" class="admin-input" value="<?= e($current_settings['whatsapp_number']) ?>">
          </div>
        </div>

        <div class="admin-form-group" style="margin-bottom: 0;">
          <label class="admin-form-label">Office Headquarters / Global Delivery Location</label>
          <input type="text" name="office_location" class="admin-input" value="<?= e($current_settings['office_location']) ?>">
        </div>
      </div>
    </div>

    <!-- Section 5: Email Delivery & Authenticated SMTP (TLS / SSL Zero-Spam Setup) -->
    <div class="admin-table-card" style="margin-bottom: 30px;" id="smtp-settings-card">
      <div class="admin-card-header" style="justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 20px;">🔒</span>
          <div>
            <h3 class="admin-card-title">Email Delivery &amp; SMTP Security (TLS / SSL Encryption)</h3>
            <p style="font-size: 12px; color: var(--admin-text-muted); margin: 0;">Configure authenticated TLS/SSL mail transport to prevent contact form inquiries from landing in Spam</p>
          </div>
        </div>
        <div>
          <?= $has_smtp ? '<span class="status-pill status-converted">✓ TLS Authenticated</span>' : '<span class="status-pill status-in_progress">⚠ Password Needed</span>' ?>
        </div>
      </div>

      <div style="padding: 26px;">
        <!-- Explanatory Deliverability Notice -->
        <div style="background: rgba(248,104,0,0.06); border: 1px solid rgba(248,104,0,0.25); border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; font-size: 13px; line-height: 1.6; color: #475569;">
          <strong style="color: var(--admin-accent); display: block; margin-bottom: 4px;">Why Contact Emails Go to Spam (TLS &amp; DMARC Explanation):</strong>
          When emails are sent using PHP's default <code>mail()</code>, cPanel dispatches them unauthenticated without TLS encryption and with an unaligned Return-Path. Google, Microsoft, and Yahoo flag these as <em>"Unencrypted / Unauthenticated"</em> and send them directly to Spam.
          <br>By entering your <strong>cPanel Webmail SMTP</strong> (or <strong>Gmail SMTP</strong>) below, emails are transmitted across an authenticated TLS 1.2/1.3 socket directly to your Primary Inbox with 100% SPF/DKIM compliance.
        </div>

        <!-- Toggle SMTP Active -->
        <div style="margin-bottom: 22px; padding: 12px 16px; background: #FAF7EE; border-radius: 8px; border: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between;">
          <div>
            <label style="font-weight: 700; font-size: 14px; color: var(--admin-text-main); display: block;">
              Enable Authenticated SMTP Delivery
            </label>
            <span style="font-size: 12px; color: var(--admin-text-muted);">
              Route contact inquiries via TLS encrypted socket instead of local server mail()
            </span>
          </div>
          <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
            <input type="checkbox" name="smtp_enabled" value="1" <?= !empty($current_settings['smtp_enabled']) ? 'checked' : '' ?> style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
            <span style="font-weight: 600; font-size: 13px;">Active</span>
          </label>
        </div>

        <!-- Quick Provider Presets Strip -->
        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
          <span style="font-size: 11.5px; font-weight: 700; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Quick Provider Presets:</span>
          <button type="button" onclick="applySmtpPreset('zoho_in')" class="admin-btn admin-btn-outline admin-btn-sm" style="font-size: 12px; border-color: #0284C7; color: #0284C7; font-weight: 700; background: #F0F9FF;">
            ⚡ Zoho Mail (.in - India)
          </button>
          <button type="button" onclick="applySmtpPreset('zoho_com')" class="admin-btn admin-btn-outline admin-btn-sm" style="font-size: 12px; border-color: #0284C7; color: #0284C7;">
            Zoho Mail (.com - Global)
          </button>
          <button type="button" onclick="applySmtpPreset('gmail')" class="admin-btn admin-btn-outline admin-btn-sm" style="font-size: 12px;">
            Google Workspace / Gmail
          </button>
          <button type="button" onclick="applySmtpPreset('cpanel')" class="admin-btn admin-btn-outline admin-btn-sm" style="font-size: 12px;">
            cPanel Webmail
          </button>
        </div>

        <!-- Zoho Mail Specific Guidance Callout -->
        <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 10px; padding: 16px 20px; margin-bottom: 22px; font-size: 13px; line-height: 1.6; color: #1E40AF;">
          <strong style="color: #1D4ED8; display: block; margin-bottom: 6px; font-size: 13.5px;">✓ Zoho Mail Setup Checklist:</strong>
          <ul style="margin: 0; padding-left: 20px; line-height: 1.7;">
            <li><strong>SMTP Server:</strong> <code>smtppro.zoho.in</code> (India accounts) ya <code>smtppro.zoho.com</code> (Global accounts).</li>
            <li><strong>Port &amp; Security:</strong> Port <code>465</code> with <strong>SSL</strong> (ya Port <code>587</code> with <strong>TLS</strong>).</li>
            <li><strong>Zoho App Password:</strong> Agar Zoho me <strong>Two-Factor Authentication (2FA / OneAuth)</strong> chalu hai, to normal password SMTP me kaam nahi karega. <a href="https://accounts.zoho.in/home#security/app_password" target="_blank" rel="noopener noreferrer" style="color: #2563EB; font-weight: 700; text-decoration: underline;">accounts.zoho.in/home#security/app_password</a> par jayein &rarr; <strong>Security</strong> &rarr; <strong>Application-Specific Passwords</strong> &rarr; Naya App Password generate karein (e.g. "RiTiVerse Website") aur yaha paste karein.</li>
            <li><strong>Sender Alignment:</strong> Zoho me <strong>Sender Email (From)</strong> aur <strong>SMTP Username</strong> dono aapka Zoho email address (e.g. <code>info@ritiverse.in</code>) hona chahiye.</li>
          </ul>
        </div>

        <!-- Grid 1: Server & Protocol -->
        <div style="display: grid; grid-template-columns: 2fr 1fr 1.2fr; gap: 20px; margin-bottom: 20px;">
          <div class="admin-form-group">
            <label class="admin-form-label">SMTP Host / Server *</label>
            <input type="text" name="smtp_host" class="admin-input" value="<?= e($current_settings['smtp_host']) ?>" placeholder="e.g. smtppro.zoho.in or smtp.gmail.com" required>
            <span style="font-size: 11px; color: var(--admin-text-muted);">Zoho India: <code>smtppro.zoho.in</code> | Zoho Global: <code>smtppro.zoho.com</code></span>
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">Port *</label>
            <select name="smtp_port" class="admin-input" style="padding: 10px 14px;">
              <option value="587" <?= ($current_settings['smtp_port'] == 587) ? 'selected' : '' ?>>587 (TLS / STARTTLS — Recommended)</option>
              <option value="465" <?= ($current_settings['smtp_port'] == 465) ? 'selected' : '' ?>>465 (SSL Encrypted)</option>
              <option value="25" <?= ($current_settings['smtp_port'] == 25) ? 'selected' : '' ?>>25 (Plain / Unencrypted)</option>
            </select>
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">Encryption Type *</label>
            <select name="smtp_encryption" class="admin-input" style="padding: 10px 14px;">
              <option value="tls" <?= ($current_settings['smtp_encryption'] === 'tls') ? 'selected' : '' ?>>TLS (STARTTLS — Port 587)</option>
              <option value="ssl" <?= ($current_settings['smtp_encryption'] === 'ssl') ? 'selected' : '' ?>>SSL (Port 465)</option>
              <option value="none" <?= ($current_settings['smtp_encryption'] === 'none') ? 'selected' : '' ?>>None (Plain)</option>
            </select>
          </div>
        </div>

        <!-- Grid 2: Credentials -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
          <div class="admin-form-group">
            <label class="admin-form-label">SMTP Username *</label>
            <input type="text" name="smtp_username" class="admin-input" value="<?= e($current_settings['smtp_username']) ?>" placeholder="e.g. info@ritiverse.in" required>
            <span style="font-size: 11px; color: var(--admin-text-muted);">Your full email address created in cPanel Email Accounts.</span>
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">SMTP Password *</label>
            <div style="position: relative;">
              <input type="password" id="smtpPassInput" name="smtp_password" class="admin-input" value="" placeholder="<?= !empty($current_settings['smtp_password']) ? '•••••••••••••••• (Leave blank to keep saved password)' : 'Enter mailbox / app password' ?>" style="padding-right: 44px;">
              <button type="button" onclick="togglePassVisibility()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748B; font-size: 14px;" title="Toggle Password">👁</button>
            </div>
            <span style="font-size: 11px; color: var(--admin-text-muted);">
              Password is saved securely in your private database.
            </span>
          </div>
        </div>

        <!-- Grid 3: Identity & Notifications -->
        <div style="display: grid; grid-template-columns: 1fr 1fr 1.2fr; gap: 20px; margin-bottom: 20px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Sender Email (From)</label>
            <input type="email" name="smtp_from_email" class="admin-input" value="<?= e($current_settings['smtp_from_email']) ?>" placeholder="info@ritiverse.in">
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">Sender Name</label>
            <input type="text" name="smtp_from_name" class="admin-input" value="<?= e($current_settings['smtp_from_name']) ?>" placeholder="RiTiVerse Studio">
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">New Lead Recipient Email</label>
            <input type="email" name="smtp_recipient_email" class="admin-input" value="<?= e($current_settings['smtp_recipient_email']) ?>" placeholder="Where inquiries are sent (e.g. info@ritiverse.in)">
          </div>
        </div>

        <!-- SSL Context Option -->
        <div style="margin-bottom: 24px;">
          <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 13px; color: var(--admin-text-main);">
            <input type="checkbox" name="smtp_allow_self_signed" value="1" <?= !empty($current_settings['smtp_allow_self_signed']) ? 'checked' : '' ?> style="accent-color: var(--admin-accent); width: 17px; height: 17px;">
            <span><strong>Allow cPanel Server Hostname SSL Certificates</strong> (Recommended — prevents OpenSSL handshake failures if cPanel shared host uses a server-wide certificate).</span>
          </label>
        </div>

        <!-- Diagnostic Live Test Sub-Section -->
        <div style="background: #FAF7EE; border: 1px dashed rgba(226, 218, 204, 0.95); border-radius: 12px; padding: 20px 22px;">
          <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 12px;">
            <div>
              <span style="font-weight: 700; font-size: 13.5px; color: var(--admin-text-main); display: block;">⚡ Live TLS Handshake &amp; Deliverability Test</span>
              <span style="font-size: 12px; color: var(--admin-text-muted);">Send an instant test email to any inbox to verify the TLS 1.2/1.3 socket and check Spam filtering in real time.</span>
            </div>
          </div>

          <div style="display: flex; gap: 10px; max-width: 600px; flex-wrap: wrap;">
            <input type="email" id="testEmailInput" placeholder="Enter recipient email (e.g. your Gmail or Yahoo)" class="admin-input" style="flex: 1; min-width: 260px; background: #FFFFFF;" value="<?= e($current_settings['contact_email']) ?>">
            <button type="button" onclick="runSMTPTest()" class="admin-btn admin-btn-outline" style="border-color: var(--admin-accent); color: var(--admin-accent); padding: 10px 18px; font-size: 13px; white-space: nowrap;">
              Send TLS Test Email →
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Sticky / Bottom Save Action Bar -->
    <div style="display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1px solid var(--admin-border); border-radius: 12px; padding: 18px 24px; margin-bottom: 30px; box-shadow: var(--admin-shadow);">
      <div style="font-size: 13px; color: var(--admin-text-muted);">
        Changes take effect immediately across all live pages on <code>ritiverse.in</code>
      </div>
      <button type="submit" class="admin-btn admin-btn-primary" style="padding: 12px 32px; font-size: 14px;">
        ✓ Save All Configuration, SEO &amp; SMTP Settings
      </button>
    </div>

  </form>

</div>

<script>
function applySmtpPreset(type) {
  const form = document.getElementById('settingsForm');
  if (!form) return;

  const hostInput = form.querySelector('input[name="smtp_host"]');
  const portSelect = form.querySelector('select[name="smtp_port"]');
  const encSelect = form.querySelector('select[name="smtp_encryption"]');
  const enabledCheckbox = form.querySelector('input[name="smtp_enabled"]');
  const userInput = form.querySelector('input[name="smtp_username"]');
  const fromEmailInput = form.querySelector('input[name="smtp_from_email"]');
  const passInput = document.getElementById('smtpPassInput');

  if (enabledCheckbox) enabledCheckbox.checked = true;

  if (type === 'zoho_in') {
    if (hostInput) hostInput.value = 'smtppro.zoho.in';
    if (portSelect) portSelect.value = '465';
    if (encSelect) encSelect.value = 'ssl';
    if (userInput && !userInput.value) userInput.value = 'info@ritiverse.in';
    if (fromEmailInput && !fromEmailInput.value) fromEmailInput.value = 'info@ritiverse.in';
  } else if (type === 'zoho_com') {
    if (hostInput) hostInput.value = 'smtppro.zoho.com';
    if (portSelect) portSelect.value = '465';
    if (encSelect) encSelect.value = 'ssl';
    if (userInput && !userInput.value) userInput.value = 'info@ritiverse.in';
    if (fromEmailInput && !fromEmailInput.value) fromEmailInput.value = 'info@ritiverse.in';
  } else if (type === 'gmail') {
    if (hostInput) hostInput.value = 'smtp.gmail.com';
    if (portSelect) portSelect.value = '587';
    if (encSelect) encSelect.value = 'tls';
  } else if (type === 'cpanel') {
    if (hostInput) hostInput.value = 'mail.ritiverse.in';
    if (portSelect) portSelect.value = '465';
    if (encSelect) encSelect.value = 'ssl';
  }

  // Highlight the card briefly
  const card = document.getElementById('smtp-settings-card');
  if (card) {
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    card.style.transition = 'box-shadow 0.3s ease';
    card.style.boxShadow = '0 0 0 3px rgba(2, 132, 199, 0.4)';
    setTimeout(() => { card.style.boxShadow = ''; }, 1500);
  }

  if (passInput && !passInput.value) {
    passInput.focus();
  }
}

function togglePassVisibility() {
  const input = document.getElementById('smtpPassInput');
  if (input) {
    input.type = input.type === 'password' ? 'text' : 'password';
  }
}

function runSMTPTest() {
  const emailInput = document.getElementById('testEmailInput');
  const recipient = (emailInput ? emailInput.value : '').trim();
  if (!recipient || !recipient.includes('@')) {
    alert('Please enter a valid recipient email address (e.g. your personal Gmail) to run the test.');
    if (emailInput) emailInput.focus();
    return;
  }

  const form = document.getElementById('settingsForm');
  if (!form) return;

  // Add hidden action=test_smtp and test_email fields
  let actionInput = form.querySelector('input[name="action"]');
  if (!actionInput) {
    actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    form.appendChild(actionInput);
  }
  actionInput.value = 'test_smtp';

  let testEmailField = form.querySelector('input[name="test_email"]');
  if (!testEmailField) {
    testEmailField = document.createElement('input');
    testEmailField.type = 'hidden';
    testEmailField.name = 'test_email';
    form.appendChild(testEmailField);
  }
  testEmailField.value = recipient;

  form.submit();
}
</script>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
