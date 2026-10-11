<?php
/**
 * RiTiVerse — Site Settings & Contact Coordinates
 */
$active_tab = 'settings';
$admin_title = 'Site Configuration & Coordinates';
$admin_subtitle = 'Update global contact details, agency metadata & support channels';

require_once __DIR__ . '/admin_header.php';

$db = get_db();
$message = '';
$error = '';

// Handle Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Please reload the page.';
    } else {
        $settings_to_update = [
            'site_name' => trim($_POST['site_name'] ?? APP_NAME),
            'site_tagline' => trim($_POST['site_tagline'] ?? APP_TAGLINE),
            'contact_email' => trim($_POST['contact_email'] ?? CONTACT_EMAIL),
            'support_email' => trim($_POST['support_email'] ?? SUPPORT_EMAIL),
            'contact_phone' => trim($_POST['contact_phone'] ?? CONTACT_PHONE),
            'office_location' => trim($_POST['office_location'] ?? 'Ahmedabad / Mumbai, India'),
            'whatsapp_number' => trim($_POST['whatsapp_number'] ?? '+919876543210')
        ];

        try {
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES (?, ?, 'general') ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
            foreach ($settings_to_update as $key => $val) {
                $stmt->execute([$key, $val]);
            }
            $message = 'Site settings updated successfully in database.';
        } catch (Exception $e) {
            $error = 'Failed to update settings: ' . $e->getMessage();
        }
    }
}

// Read current settings
$current_settings = [
    'site_name' => get_setting('site_name', APP_NAME),
    'site_tagline' => get_setting('site_tagline', APP_TAGLINE),
    'contact_email' => get_setting('contact_email', CONTACT_EMAIL),
    'support_email' => get_setting('support_email', SUPPORT_EMAIL),
    'contact_phone' => get_setting('contact_phone', CONTACT_PHONE),
    'office_location' => get_setting('office_location', 'Ahmedabad / Mumbai, India • Global Client Delivery'),
    'whatsapp_number' => get_setting('whatsapp_number', '+919876543210')
];
?>

<?php if (!empty($message)): ?>
  <div style="background: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px;">
    <?= e($message) ?>
  </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
  <div style="background: #FEE2E2; border: 1px solid #EF4444; color: #B91C1C; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px;">
    <?= e($error) ?>
  </div>
<?php endif; ?>

<div class="admin-table-card" style="max-width: 800px;">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Agency Coordinates &amp; Branding</h3>
  </div>

  <div style="padding: 28px;">
    <form method="POST" action="settings.php">
      <?= csrf_field() ?>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="admin-form-group">
          <label class="admin-form-label">Brand / Agency Name</label>
          <input type="text" name="site_name" class="admin-input" value="<?= e($current_settings['site_name']) ?>" required>
        </div>

        <div class="admin-form-group">
          <label class="admin-form-label">Primary Tagline</label>
          <input type="text" name="site_tagline" class="admin-input" value="<?= e($current_settings['site_tagline']) ?>" required>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="admin-form-group">
          <label class="admin-form-label">Primary Inquiries Email</label>
          <input type="email" name="contact_email" class="admin-input" value="<?= e($current_settings['contact_email']) ?>" required>
          <span style="font-size: 11px; color: var(--admin-text-muted);">Inquiries from contact form are routed here</span>
        </div>

        <div class="admin-form-group">
          <label class="admin-form-label">Client Support Email</label>
          <input type="email" name="support_email" class="admin-input" value="<?= e($current_settings['support_email']) ?>" required>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="admin-form-group">
          <label class="admin-form-label">Direct Phone / WhatsApp</label>
          <input type="text" name="contact_phone" class="admin-input" value="<?= e($current_settings['contact_phone']) ?>">
        </div>

        <div class="admin-form-group">
          <label class="admin-form-label">WhatsApp Number (Direct Link Format)</label>
          <input type="text" name="whatsapp_number" class="admin-input" value="<?= e($current_settings['whatsapp_number']) ?>">
        </div>
      </div>

      <div class="admin-form-group" style="margin-bottom: 28px;">
        <label class="admin-form-label">Office Location / Studio Headquarters</label>
        <input type="text" name="office_location" class="admin-input" value="<?= e($current_settings['office_location']) ?>">
      </div>

      <button type="submit" class="admin-btn admin-btn-primary" style="padding: 12px 24px;">
        Save Site Settings
      </button>
    </form>
  </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
