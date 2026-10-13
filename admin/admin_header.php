<?php
/**
 * RiTiVerse — Admin Shared Header & Navigation Framework
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

$active_tab = $active_tab ?? 'dashboard';
$admin_title = $admin_title ?? 'Dashboard';
$admin_subtitle = $admin_subtitle ?? 'Overview of client inquiries and production architectures';

// Count unread inquiries and total projects if DB connected
$new_inquiries_count = 0;
$total_projects_count = 0;
$total_services_count = 0;
$db = get_db();
if ($db) {
    try {
        $stmt = $db->query("SELECT COUNT(*) FROM inquiries WHERE status = 'new'");
        $new_inquiries_count = (int)$stmt->fetchColumn();
        $p_stmt = $db->query("SELECT COUNT(*) FROM projects");
        $total_projects_count = (int)$p_stmt->fetchColumn();
        $s_stmt = $db->query("SELECT COUNT(*) FROM services");
        $total_services_count = (int)$s_stmt->fetchColumn();
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($admin_title) ?> — RiTiVerse Control Center</title>
  <link rel="shortcut icon" href="../assets/logo.png" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-layout">

  <!-- Desktop Executive Sidebar -->
  <aside class="admin-sidebar">
    <div>
      <a href="index.php" class="admin-brand">
        <img src="../assets/logo.png" alt="RiTiVerse" class="admin-brand-logo">
        <span class="admin-brand-text">RiTiVerse</span>
        <span class="admin-brand-badge">ADMIN</span>
      </a>

      <nav class="admin-nav-group">
        <a href="index.php" class="admin-nav-link <?= ($active_tab === 'dashboard') ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
          Dashboard
        </a>

        <a href="inquiries.php" class="admin-nav-link <?= ($active_tab === 'inquiries') ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
            <polyline points="22,6 12,13 2,6"></polyline>
          </svg>
          Inquiries / Leads
          <?php if ($new_inquiries_count > 0): ?>
            <span class="admin-nav-pill"><?= $new_inquiries_count ?></span>
          <?php endif; ?>
        </a>

        <a href="projects.php" class="admin-nav-link <?= ($active_tab === 'projects') ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
            <polyline points="2 17 12 22 22 17"></polyline>
            <polyline points="2 12 12 17 22 12"></polyline>
          </svg>
          Projects &amp; Case Studies
          <?php if ($total_projects_count > 0): ?>
            <span class="admin-nav-pill"><?= $total_projects_count ?></span>
          <?php endif; ?>
        </a>

        <a href="services.php" class="admin-nav-link <?= ($active_tab === 'services') ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
            <line x1="8" y1="21" x2="16" y2="21"></line>
            <line x1="12" y1="17" x2="12" y2="21"></line>
          </svg>
          Services &amp; Pages
          <?php if ($total_services_count > 0): ?>
            <span class="admin-nav-pill"><?= $total_services_count ?></span>
          <?php endif; ?>
        </a>

        <a href="settings.php" class="admin-nav-link <?= ($active_tab === 'settings') ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
          </svg>
          SEO &amp; Settings
        </a>

        <a href="../index.php" target="_blank" class="admin-nav-link" style="margin-top: 18px; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 16px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="2" y1="12" x2="22" y2="12"></line>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
          </svg>
          View Live Website ↗
        </a>
      </nav>
    </div>

    <!-- User Profile & Logout -->
    <div class="admin-user-block">
      <div class="admin-user-info">
        <div class="admin-user-avatar">
          <?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
        </div>
        <div class="admin-user-meta">
          <span class="admin-user-name"><?= e($_SESSION['admin_name'] ?? 'Administrator') ?></span>
          <span class="admin-user-role"><?= e($_SESSION['admin_role'] ?? 'super_admin') ?></span>
        </div>
      </div>
      <a href="logout.php" class="admin-logout-btn" title="Sign Out">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
      </a>
    </div>
  </aside>

  <!-- Main Container -->
  <main class="admin-main">

    <!-- Mobile Top Navigation Bar (Active on tablets & mobile screens) -->
    <nav class="admin-mobile-nav">
      <div class="admin-mobile-brand">
        <img src="../assets/logo.png" alt="RiTiVerse" class="admin-mobile-logo">
        <span class="admin-mobile-title">RiTiVerse Admin</span>
      </div>
      <div class="admin-mobile-links">
        <a href="index.php" class="admin-m-link <?= ($active_tab === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
        <a href="inquiries.php" class="admin-m-link <?= ($active_tab === 'inquiries') ? 'active' : '' ?>">Leads <?= $new_inquiries_count > 0 ? "($new_inquiries_count)" : '' ?></a>
        <a href="projects.php" class="admin-m-link <?= ($active_tab === 'projects') ? 'active' : '' ?>">Projects</a>
        <a href="services.php" class="admin-m-link <?= ($active_tab === 'services') ? 'active' : '' ?>">Services <?= $total_services_count > 0 ? "($total_services_count)" : '' ?></a>
        <a href="settings.php" class="admin-m-link <?= ($active_tab === 'settings') ? 'active' : '' ?>">SEO &amp; Settings</a>
        <a href="../index.php" target="_blank" class="admin-m-link">Live ↗</a>
        <a href="logout.php" class="admin-m-link m-logout">Exit</a>
      </div>
    </nav>

    <!-- Top Bar -->
    <header class="admin-topbar">
      <div class="admin-topbar-title">
        <h1><?= e($admin_title) ?></h1>
        <p><?= e($admin_subtitle) ?></p>
      </div>

      <div class="admin-topbar-actions">
        <?php if (is_db_connected()): ?>
          <span class="status-pill status-converted" title="MySQL Connected">
            ● DB Connected
          </span>
        <?php else: ?>
          <span class="status-pill status-new" title="Import database.sql to MySQL">
            ⚠ DB Offline (Using Fallback)
          </span>
        <?php endif; ?>

        <a href="inquiries.php" class="admin-btn admin-btn-outline admin-btn-sm">
          Leads (<?= $new_inquiries_count ?>)
        </a>
      </div>
    </header>

    <div class="admin-content-wrap">
