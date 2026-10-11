<?php
/**
 * RiTiVerse — Projects & Architecture Showcase Manager
 */
$active_tab = 'projects';
$admin_title = 'Projects & Reference Architectures';
$admin_subtitle = 'Manage case studies, telemetry metrics and technical stack pills';

require_once __DIR__ . '/admin_header.php';

$db = get_db();
$message = '';
$error = '';

// Handle Create / Update Project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Please reload the page.';
    } else {
        $action = $_POST['action'];
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
        $category = trim($_POST['category'] ?? 'web');
        $tag_label = trim($_POST['tag_label'] ?? 'Production Architecture');
        $description = trim($_POST['description'] ?? '');
        $metric_1_val = trim($_POST['metric_1_val'] ?? '');
        $metric_1_lbl = trim($_POST['metric_1_lbl'] ?? '');
        $metric_2_val = trim($_POST['metric_2_val'] ?? '');
        $metric_2_lbl = trim($_POST['metric_2_lbl'] ?? '');
        $metric_3_val = trim($_POST['metric_3_val'] ?? '');
        $metric_3_lbl = trim($_POST['metric_3_lbl'] ?? '');
        $tech_tags = trim($_POST['tech_tags'] ?? '');
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;

        if (empty($title) || empty($description)) {
            $error = 'Project title and description are required.';
        } else {
            try {
                if ($action === 'create') {
                    $stmt = $db->prepare("INSERT INTO projects (title, slug, category, tag_label, description, metric_1_val, metric_1_lbl, metric_2_val, metric_2_lbl, metric_3_val, metric_3_lbl, tech_tags, is_featured, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$title, $slug, $category, $tag_label, $description, $metric_1_val, $metric_1_lbl, $metric_2_val, $metric_2_lbl, $metric_3_val, $metric_3_lbl, $tech_tags, $is_featured]);
                    $message = "Project '{$title}' created successfully.";
                } elseif ($action === 'update') {
                    $proj_id = (int)$_POST['id'];
                    $stmt = $db->prepare("UPDATE projects SET title = ?, slug = ?, category = ?, tag_label = ?, description = ?, metric_1_val = ?, metric_1_lbl = ?, metric_2_val = ?, metric_2_lbl = ?, metric_3_val = ?, metric_3_lbl = ?, tech_tags = ?, is_featured = ? WHERE id = ?");
                    $stmt->execute([$title, $slug, $category, $tag_label, $description, $metric_1_val, $metric_1_lbl, $metric_2_val, $metric_2_lbl, $metric_3_val, $metric_3_lbl, $tech_tags, $is_featured, $proj_id]);
                    $message = "Project '{$title}' updated successfully.";
                }
            } catch (Exception $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Handle Delete Project
if (isset($_GET['delete']) && $db) {
    if (!verify_csrf_token($_GET['csrf'] ?? '')) {
        $error = 'Invalid security token for delete operation.';
    } else {
        $del_id = (int)$_GET['delete'];
        try {
            $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
            $stmt->execute([$del_id]);
            $message = "Project #{$del_id} removed.";
        } catch (Exception $e) {
            $error = "Delete failed: " . $e->getMessage();
        }
    }
}

// Fetch Projects List
$projects_list = [];
if ($db) {
    try {
        $stmt = $db->query("SELECT * FROM projects ORDER BY is_featured DESC, id ASC");
        $projects_list = $stmt->fetchAll();
    } catch (Exception $e) {
        $error = "Could not fetch projects: " . $e->getMessage();
    }
}

// Check if editing a specific project
$edit_project = null;
if (isset($_GET['edit']) && $db) {
    $edit_id = (int)$_GET['edit'];
    $e_stmt = $db->prepare("SELECT * FROM projects WHERE id = ? LIMIT 1");
    $e_stmt->execute([$edit_id]);
    $edit_project = $e_stmt->fetch();
}
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

<!-- Create / Edit Form Card -->
<div class="admin-table-card" style="margin-bottom: 30px;">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><?= $edit_project ? 'Edit Architecture: ' . e($edit_project['title']) : 'Add New Reference Architecture' ?></h3>
    <?php if ($edit_project): ?>
      <a href="projects.php" class="admin-btn admin-btn-outline admin-btn-sm">Cancel Edit</a>
    <?php endif; ?>
  </div>

  <div style="padding: 24px;">
    <form method="POST" action="projects.php">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="<?= $edit_project ? 'update' : 'create' ?>">
      <?php if ($edit_project): ?>
        <input type="hidden" name="id" value="<?= $edit_project['id'] ?>">
      <?php endif; ?>

      <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
        <div>
          <label class="admin-form-label">Project Title *</label>
          <input type="text" name="title" class="admin-input" placeholder="e.g. Aegis Financial Telemetry OS" value="<?= e($edit_project['title'] ?? '') ?>" required>
        </div>
        <div>
          <label class="admin-form-label">Tag Label (Eyebrow)</label>
          <input type="text" name="tag_label" class="admin-input" placeholder="e.g. FinTech Architecture" value="<?= e($edit_project['tag_label'] ?? '') ?>">
        </div>
        <div>
          <label class="admin-form-label">Category Filter</label>
          <select name="category" class="admin-input" style="cursor: pointer;">
            <option value="web" <?= (($edit_project['category'] ?? '') === 'web') ? 'selected' : '' ?>>Web Applications</option>
            <option value="custom" <?= (($edit_project['category'] ?? '') === 'custom') ? 'selected' : '' ?>>Custom Software</option>
            <option value="cloud" <?= (($edit_project['category'] ?? '') === 'cloud') ? 'selected' : '' ?>>Hosting &amp; Systems</option>
            <option value="ai" <?= (($edit_project['category'] ?? '') === 'ai') ? 'selected' : '' ?>>AI Automation</option>
            <option value="custom web" <?= (($edit_project['category'] ?? '') === 'custom web') ? 'selected' : '' ?>>Custom Web</option>
          </select>
        </div>
      </div>

      <div class="admin-form-group">
        <label class="admin-form-label">Architecture Description *</label>
        <textarea name="description" class="admin-input" rows="3" placeholder="Brief technical summary of the system, capabilities and throughput..." required><?= e($edit_project['description'] ?? '') ?></textarea>
      </div>

      <!-- 3 Metrics Strip -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; background: #FAF7EE; padding: 18px; border-radius: 10px; margin-bottom: 20px;">
        <div>
          <label class="admin-form-label">Metric 1 (Val &amp; Lbl)</label>
          <div style="display: flex; gap: 8px;">
            <input type="text" name="metric_1_val" class="admin-input" placeholder="0.12s" value="<?= e($edit_project['metric_1_val'] ?? '') ?>">
            <input type="text" name="metric_1_lbl" class="admin-input" placeholder="Global Latency" value="<?= e($edit_project['metric_1_lbl'] ?? '') ?>">
          </div>
        </div>

        <div>
          <label class="admin-form-label">Metric 2 (Val &amp; Lbl)</label>
          <div style="display: flex; gap: 8px;">
            <input type="text" name="metric_2_val" class="admin-input" placeholder="Real-Time" value="<?= e($edit_project['metric_2_val'] ?? '') ?>">
            <input type="text" name="metric_2_lbl" class="admin-input" placeholder="Data Streams" value="<?= e($edit_project['metric_2_lbl'] ?? '') ?>">
          </div>
        </div>

        <div>
          <label class="admin-form-label">Metric 3 (Val &amp; Lbl)</label>
          <div style="display: flex; gap: 8px;">
            <input type="text" name="metric_3_val" class="admin-input" placeholder="100%" value="<?= e($edit_project['metric_3_val'] ?? '') ?>">
            <input type="text" name="metric_3_lbl" class="admin-input" placeholder="Source IP" value="<?= e($edit_project['metric_3_lbl'] ?? '') ?>">
          </div>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px; margin-bottom: 20px;">
        <div>
          <label class="admin-form-label">Technology Pills (Comma-Separated)</label>
          <input type="text" name="tech_tags" class="admin-input" placeholder="Go, Next.js 15, TimescaleDB, WebSockets, AWS EKS" value="<?= e($edit_project['tech_tags'] ?? '') ?>">
        </div>
        <div style="display: flex; align-items: center; gap: 10px; padding-top: 24px;">
          <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">
            <input type="checkbox" name="is_featured" value="1" <?= (!isset($edit_project) || $edit_project['is_featured']) ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: var(--admin-accent);">
            Featured Showcase
          </label>
        </div>
      </div>

      <button type="submit" class="admin-btn admin-btn-primary">
        <?= $edit_project ? 'Update Architecture' : '+ Publish Architecture' ?>
      </button>
    </form>
  </div>
</div>

<!-- Published Projects List Table -->
<div class="admin-table-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Published Showcase Architectures</h3>
    <span style="font-size: 12px; color: var(--admin-text-muted);">Displayed on <code>projects.php</code> and the 3D orbit carousel on <code>index.php</code></span>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Project Title &amp; Tag</th>
          <th>Category</th>
          <th>Key Metrics</th>
          <th>Technologies</th>
          <th>Featured</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($projects_list)): ?>
          <?php foreach ($projects_list as $p): ?>
            <tr>
              <td style="font-family: var(--admin-font-mono); font-size: 12px; color: var(--admin-text-muted);">#<?= $p['id'] ?></td>
              <td>
                <span class="status-pill status-contacted" style="font-size: 9.5px; padding: 2px 7px; margin-bottom: 4px;"><?= e($p['tag_label']) ?></span><br>
                <strong><?= e($p['title']) ?></strong>
              </td>
              <td><span class="status-pill status-in_progress"><?= strtoupper(e($p['category'])) ?></span></td>
              <td style="font-family: var(--admin-font-mono); font-size: 12px;">
                <?= e($p['metric_1_val']) ?> / <?= e($p['metric_2_val']) ?>
              </td>
              <td style="font-size: 12px; max-width: 240px; color: var(--admin-text-muted);">
                <?= e($p['tech_tags']) ?>
              </td>
              <td>
                <?= $p['is_featured'] ? '<span class="status-pill status-converted">✓ Active</span>' : '<span class="status-pill status-archived">Draft</span>' ?>
              </td>
              <td>
                <div style="display: flex; gap: 6px;">
                  <a href="projects.php?edit=<?= $p['id'] ?>" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                  <a href="projects.php?delete=<?= $p['id'] ?>&csrf=<?= csrf_token() ?>" onclick="return confirm('Remove project?');" class="admin-btn admin-btn-danger admin-btn-sm">✕</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" style="text-align: center; padding: 36px; color: var(--admin-text-muted);">
              <?php if (is_db_connected()): ?>
                No projects found in database. Use the form above to publish your first architecture!
              <?php else: ?>
                Database offline. Import <code>database.sql</code> into phpMyAdmin to manage live case studies.
              <?php endif; ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
