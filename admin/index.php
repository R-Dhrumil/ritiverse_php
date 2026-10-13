<?php
/**
 * RiTiVerse — Admin Control Center Dashboard
 */
$active_tab = 'dashboard';
$admin_title = 'Executive Dashboard';
$admin_subtitle = 'Live analytics on client inquiries, project assets & hosting telemetry';

require_once __DIR__ . '/admin_header.php';

// Fetch metrics
$db = get_db();
$total_inquiries = 0;
$new_inquiries = 0;
$converted_inquiries = 0;
$total_projects = 0;
$recent_inquiries = [];

if ($db) {
    try {
        $total_inquiries = (int)$db->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
        $new_inquiries = (int)$db->query("SELECT COUNT(*) FROM inquiries WHERE status = 'new'")->fetchColumn();
        $converted_inquiries = (int)$db->query("SELECT COUNT(*) FROM inquiries WHERE status = 'converted'")->fetchColumn();
        $total_projects = (int)$db->query("SELECT COUNT(*) FROM projects")->fetchColumn();

        $stmt = $db->query("SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5");
        $recent_inquiries = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Dashboard query error: " . $e->getMessage());
    }
}
?>

<!-- cPanel Deployment & Database Setup Advisory -->
<?php if (!is_db_connected()): ?>
  <div style="background: #FEF3C7; border: 1px solid #F59E0B; border-radius: 12px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 14px;">
    <span style="font-size: 22px;">💡</span>
    <div style="width: 100%;">
      <h3 style="font-size: 15px; font-weight: 700; color: #B45309; margin-bottom: 6px;">cPanel Deployment &amp; Database Checklist</h3>
      <div style="font-size: 13px; color: #78350F; line-height: 1.6;">
        <p style="margin-bottom: 8px;">
          <strong>1. File Manager Location:</strong> Saara code direct <code>public_html/</code> root folder me hona chahiye (jaise <code>public_html/index.php</code>). Agar zip kisi subfolder me extract ho gayi ho, to use move karke direct <code>public_html/</code> me daalein.
        </p>
        <p style="margin-bottom: 8px;">
          <strong>2. Default index.html:</strong> Agar hosting ki koi default <code>index.html</code> ya <code>default.html</code> file padi ho, to use delete karein taaki aapka <code>index.php</code> direct load ho sake.
        </p>
        <p style="margin-bottom: 0;">
          <strong>3. MySQL Database &amp; User Privileges:</strong> cPanel &gt; <strong>MySQL Databases</strong> me jaakar:
          <br>• Database create karein (e.g. <code>ritivers_main</code>) aur User create karein.
          <br>• <strong>Subse Zaroori Step:</strong> Neeche scroll karke <strong>"Add User To Database"</strong> section me User aur Database select karke <strong>Add</strong> karein, fir <strong>"ALL PRIVILEGES"</strong> check karke <strong>Make Changes</strong> karein.
          <br>• phpMyAdmin open karke <code>database.sql</code> import karein, aur <code>includes/config.php</code> me <code>DB_NAME</code>, <code>DB_USER</code>, aur <code>DB_PASS</code> match karein.
        </p>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- 4 Key Metric Cards -->
<div class="admin-stats-grid">
  <div class="admin-stat-card">
    <div class="admin-stat-head">
      <span class="admin-stat-lbl">Total Inquiries</span>
      <div class="admin-stat-icon icon-orange">📥</div>
    </div>
    <div class="admin-stat-val"><?= $total_inquiries ?></div>
    <div class="admin-stat-foot">Lead submissions from website contact form</div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-head">
      <span class="admin-stat-lbl">New Leads</span>
      <div class="admin-stat-icon icon-blue">⚡</div>
    </div>
    <div class="admin-stat-val" style="color: var(--admin-accent);"><?= $new_inquiries ?></div>
    <div class="admin-stat-foot">Awaiting team review &amp; initial estimate</div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-head">
      <span class="admin-stat-lbl">Converted Clients</span>
      <div class="admin-stat-icon icon-emerald">✓</div>
    </div>
    <div class="admin-stat-val"><?= $converted_inquiries ?></div>
    <div class="admin-stat-foot">Signed projects &amp; active milestone deliveries</div>
  </div>

  <a href="projects.php" class="admin-stat-card" style="text-decoration: none; color: inherit; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
    <div class="admin-stat-head">
      <span class="admin-stat-lbl">Live Flagships</span>
      <div class="admin-stat-icon icon-indigo">🚀</div>
    </div>
    <div class="admin-stat-val"><?= $total_projects ?></div>
    <div class="admin-stat-foot" style="display: flex; justify-content: space-between; align-items: center;">
      <span>Case studies &amp; portfolio showcase</span>
      <span style="color: var(--admin-accent); font-weight: 700; font-size: 11px;">Manage →</span>
    </div>
  </a>
</div>

<!-- Recent Inquiries Table Card -->
<div class="admin-table-card">
  <div class="admin-card-header">
    <div>
      <h2 class="admin-card-title">Recent Client Inquiries</h2>
      <p style="font-size: 12.5px; color: var(--admin-text-muted);">Direct consultation requests from prospective business clients</p>
    </div>
    <div style="display: flex; gap: 8px;">
      <a href="inquiries.php" class="admin-btn admin-btn-primary admin-btn-sm">
        View All Inquiries →
      </a>
    </div>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Client Name</th>
          <th>Company / Business</th>
          <th>Project Type</th>
          <th>Timeline</th>
          <th>Submitted</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($recent_inquiries)): ?>
          <?php foreach ($recent_inquiries as $inq): ?>
            <tr>
              <td>
                <strong><?= e($inq['name']) ?></strong><br>
                <a href="mailto:<?= e($inq['email']) ?>" style="font-size: 12px; color: var(--admin-text-muted); text-decoration: none;"><?= e($inq['email']) ?></a>
              </td>
              <td><?= e($inq['company']) ?></td>
              <td><span class="status-pill status-contacted"><?= strtoupper(e($inq['scope'])) ?></span></td>
              <td><?= e($inq['timeline']) ?></td>
              <td style="font-family: var(--admin-font-mono); font-size: 12px;"><?= date('M d, Y', strtotime($inq['created_at'])) ?></td>
              <td>
                <span class="status-pill status-<?= e($inq['status']) ?>">
                  <?= ucfirst(str_replace('_', ' ', e($inq['status']))) ?>
                </span>
              </td>
              <td>
                <a href="inquiries.php?view=<?= $inq['id'] ?>" class="admin-btn admin-btn-outline admin-btn-sm">Review</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" style="text-align: center; padding: 36px; color: var(--admin-text-muted);">
              <?php if (is_db_connected()): ?>
                No inquiries submitted yet. When clients submit the contact form, they will appear here instantly!
              <?php else: ?>
                Database currently offline. Import <code>database.sql</code> into phpMyAdmin to see live inquiries.
              <?php endif; ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Quick Actions & System Info Grid -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
  <!-- Management Links -->
  <div class="admin-table-card" style="margin-bottom: 0;">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Quick Administration Actions</h3>
    </div>
    <div style="padding: 24px; display: flex; flex-direction: column; gap: 12px;">
      <a href="inquiries.php" class="admin-btn admin-btn-outline" style="justify-content: space-between; padding: 14px;">
        <span>📥 Manage All Leads &amp; Update Inquiry Status</span>
        <span>→</span>
      </a>
      <a href="projects.php" class="admin-btn admin-btn-outline" style="justify-content: space-between; padding: 14px;">
        <span>🚀 Edit Case Studies &amp; Architecture Showcase</span>
        <span>→</span>
      </a>
      <a href="settings.php" class="admin-btn admin-btn-outline" style="justify-content: space-between; padding: 14px;">
        <span>⚙️ Update Contact Coordinates &amp; Site Meta</span>
        <span>→</span>
      </a>
      <a href="../index.php" target="_blank" class="admin-btn admin-btn-outline" style="justify-content: space-between; padding: 14px;">
        <span>🌐 Open Frontend Website (New Tab)</span>
        <span>↗</span>
      </a>
    </div>
  </div>

  <!-- Server Telemetry -->
  <div class="admin-table-card" style="margin-bottom: 0;">
    <div class="admin-card-header">
      <h3 class="admin-card-title">cPanel Server Environment</h3>
    </div>
    <div style="padding: 24px; font-family: var(--admin-font-mono); font-size: 12.5px; display: flex; flex-direction: column; gap: 10px;">
      <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border-subtle); padding-bottom: 8px;">
        <span style="color: var(--admin-text-muted);">PHP Version:</span>
        <strong><?= phpversion() ?></strong>
      </div>
      <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border-subtle); padding-bottom: 8px;">
        <span style="color: var(--admin-text-muted);">Web Server:</span>
        <span><?= e($_SERVER['SERVER_SOFTWARE'] ?? 'Apache/LiteSpeed') ?></span>
      </div>
      <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border-subtle); padding-bottom: 8px;">
        <span style="color: var(--admin-text-muted);">Database Host:</span>
        <span><?= DB_HOST ?> (<?= DB_NAME ?>)</span>
      </div>
      <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border-subtle); padding-bottom: 8px;">
        <span style="color: var(--admin-text-muted);">HTTPS Active:</span>
        <span style="color: #10B981;"><?= (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'Yes (SSL Active)' : 'No (Local/HTTP)' ?></span>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <span style="color: var(--admin-text-muted);">Upload Max:</span>
        <span><?= ini_get('upload_max_filesize') ?></span>
      </div>
    </div>
  </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
