<?php
/**
 * RiTiVerse — Site Configuration & SEO Connectivity Center
 * Manage Google Analytics, Google Search Console, Bing, Meta Pixel, SEO & Brand Coordinates
 */
$active_tab = 'settings';
$admin_title = 'Site Configuration & SEO Connectivity Center';
$admin_subtitle = 'Manage Google Analytics, Search Console, Bing, Meta Pixel, SEO metadata & official channels';

require_once __DIR__ . '/admin_header.php';

$db = get_db();
$message = '';
$error = '';

// Handle Settings Update (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Please reload the page.';
    } else {
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
            'social_facebook' => trim($_POST['social_facebook'] ?? SOCIAL_FACEBOOK)
        ];

        try {
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES (?, ?, 'general') ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
            foreach ($settings_to_update as $key => $val) {
                $stmt->execute([$key, $val]);
            }
            $message = 'Settings & SEO connectivity parameters updated successfully in database.';
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
    'social_facebook' => get_setting('social_facebook', defined('SOCIAL_FACEBOOK') ? SOCIAL_FACEBOOK : '')
];

// Connectivity statuses
$has_ga = !empty($current_settings['google_analytics_id']);
$has_gsc = !empty($current_settings['google_site_verification']);
$has_bing = !empty($current_settings['bing_site_verification']);
$has_pixel = !empty($current_settings['meta_pixel_id']);
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
  </div>

  <!-- Main Settings Form -->
  <form method="POST" action="settings.php">
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

    <!-- Sticky / Bottom Save Action Bar -->
    <div style="display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1px solid var(--admin-border); border-radius: 12px; padding: 18px 24px; margin-bottom: 30px; box-shadow: var(--admin-shadow);">
      <div style="font-size: 13px; color: var(--admin-text-muted);">
        Changes take effect immediately across all live pages on <code>ritiverse.in</code>
      </div>
      <button type="submit" class="admin-btn admin-btn-primary" style="padding: 12px 32px; font-size: 14px;">
        ✓ Save All Configuration &amp; SEO Settings
      </button>
    </div>

  </form>

</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
