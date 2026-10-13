<?php
/**
 * RiTiVerse — Inquiries & Lead Management CRM
 */
$active_tab = 'inquiries';
$admin_title = 'Client Inquiries & Leads';
$admin_subtitle = 'Track, review, and convert prospective client consultation requests';

require_once __DIR__ . '/admin_header.php';

$db = get_db();
$message = '';
$error = '';

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv' && $db) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ritiverse_leads_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Client Name', 'Email', 'Company', 'Scope', 'Timeline', 'Details', 'Status', 'Submitted At']);

    $export_stmt = $db->query("SELECT id, name, email, company, scope, timeline, details, status, created_at FROM inquiries ORDER BY created_at DESC");
    while ($row = $export_stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// Handle Status & Notes Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_inquiry' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch. Please reload the page.";
    } else {
        $inquiry_id = (int)($_POST['id'] ?? 0);
        $new_status = $_POST['status'] ?? 'new';
        $notes = trim($_POST['admin_notes'] ?? '');

        try {
            $stmt = $db->prepare("UPDATE inquiries SET status = ?, admin_notes = ? WHERE id = ?");
            $stmt->execute([$new_status, $notes, $inquiry_id]);
            $message = "Inquiry #{$inquiry_id} successfully updated.";
        } catch (Exception $e) {
            $error = "Update failed: " . $e->getMessage();
        }
    }
}

// Handle Delete Inquiry
if (isset($_GET['delete']) && $db) {
    if (!verify_csrf_token($_GET['csrf'] ?? '')) {
        $error = "Invalid or expired security token for delete operation.";
    } else {
        $del_id = (int)$_GET['delete'];
        try {
            $stmt = $db->prepare("DELETE FROM inquiries WHERE id = ?");
            $stmt->execute([$del_id]);
            $message = "Inquiry #{$del_id} removed.";
        } catch (Exception $e) {
            $error = "Delete failed: " . $e->getMessage();
        }
    }
}

// Filters & Query
$filter_status = $_GET['status'] ?? 'all';
$search_query = trim($_GET['q'] ?? '');
$inquiries_list = [];

if ($db) {
    try {
        $sql = "SELECT * FROM inquiries WHERE 1=1";
        $params = [];

        if ($filter_status !== 'all') {
            $sql .= " AND status = ?";
            $params[] = $filter_status;
        }

        if (!empty($search_query)) {
            $sql .= " AND (name LIKE ? OR email LIKE ? OR company LIKE ? OR details LIKE ?)";
            $wildcard = "%{$search_query}%";
            $params[] = $wildcard;
            $params[] = $wildcard;
            $params[] = $wildcard;
            $params[] = $wildcard;
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $inquiries_list = $stmt->fetchAll();
    } catch (Exception $e) {
        $error = "Query error: " . $e->getMessage();
    }
}

// Selected inquiry for detail modal/drawer
$view_inquiry = null;
if (isset($_GET['view']) && $db) {
    $v_id = (int)$_GET['view'];
    $v_stmt = $db->prepare("SELECT * FROM inquiries WHERE id = ? LIMIT 1");
    $v_stmt->execute([$v_id]);
    $view_inquiry = $v_stmt->fetch();
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

<!-- Detail Drawer / Modal if Viewing -->
<?php if ($view_inquiry): ?>
  <div style="background: #FFFFFF; border: 2px solid var(--admin-accent); border-radius: var(--admin-radius); padding: 28px; margin-bottom: 30px; box-shadow: 0 20px 40px rgba(248, 104, 0, 0.1);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
      <div>
        <span class="status-pill status-<?= e($view_inquiry['status']) ?>" style="margin-bottom: 8px;">
          <?= ucfirst(str_replace('_', ' ', e($view_inquiry['status']))) ?>
        </span>
        <h2 style="font-family: var(--admin-font-display); font-size: 22px; color: var(--admin-text-main); margin-top: 4px;">
          <?= e($view_inquiry['name']) ?> — <?= e($view_inquiry['company']) ?>
        </h2>
        <p style="font-size: 13px; color: var(--admin-text-muted);">
          Submitted on <?= date('F j, Y \a\t g:i A', strtotime($view_inquiry['created_at'])) ?>
        </p>
      </div>
      <a href="inquiries.php" class="admin-btn admin-btn-outline admin-btn-sm">✕ Close Detail</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; background: #FAF7EE; padding: 16px; border-radius: 10px; margin-bottom: 24px;">
      <div>
        <span style="font-size: 11px; font-weight: 700; color: var(--admin-text-muted); text-transform: uppercase;">Direct Email:</span>
        <p style="font-weight: 600;"><a href="mailto:<?= e($view_inquiry['email']) ?>" style="color: var(--admin-accent);"><?= e($view_inquiry['email']) ?></a></p>
      </div>
      <div>
        <span style="font-size: 11px; font-weight: 700; color: var(--admin-text-muted); text-transform: uppercase;">Project Scope:</span>
        <p style="font-weight: 600; text-transform: uppercase;"><?= e($view_inquiry['scope']) ?></p>
      </div>
      <div>
        <span style="font-size: 11px; font-weight: 700; color: var(--admin-text-muted); text-transform: uppercase;">Target Timeline:</span>
        <p style="font-weight: 600;"><?= e($view_inquiry['timeline']) ?></p>
      </div>
    </div>

    <div style="margin-bottom: 24px;">
      <h3 style="font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--admin-text-muted); margin-bottom: 8px;">
        Project Requirements &amp; Client Description:
      </h3>
      <div style="background: #FFFFFF; border: 1px solid var(--admin-border); padding: 18px; border-radius: 10px; font-size: 14.5px; line-height: 1.7; white-space: pre-wrap; color: #1E293B;">
        <?= e(html_entity_decode((string)$view_inquiry['details'], ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?>
      </div>
    </div>

    <!-- Status & Notes Form -->
    <form method="POST" action="inquiries.php">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="update_inquiry">
      <input type="hidden" name="id" value="<?= $view_inquiry['id'] ?>">

      <div style="display: grid; grid-template-columns: 220px 1fr; gap: 16px; align-items: flex-start; margin-bottom: 20px;">
        <div>
          <label class="admin-form-label">Update Status</label>
          <select name="status" class="admin-input" style="cursor: pointer;">
            <option value="new" <?= ($view_inquiry['status'] === 'new') ? 'selected' : '' ?>>New (Unreviewed)</option>
            <option value="contacted" <?= ($view_inquiry['status'] === 'contacted') ? 'selected' : '' ?>>Contacted / Estimate Sent</option>
            <option value="in_progress" <?= ($view_inquiry['status'] === 'in_progress') ? 'selected' : '' ?>>In Negotiation</option>
            <option value="converted" <?= ($view_inquiry['status'] === 'converted') ? 'selected' : '' ?>>Converted to Active Project</option>
            <option value="archived" <?= ($view_inquiry['status'] === 'archived') ? 'selected' : '' ?>>Archived / Closed</option>
          </select>
        </div>

        <div>
          <label class="admin-form-label">Internal Engineering Notes</label>
          <input type="text" name="admin_notes" class="admin-input" placeholder="e.g. Sent architecture estimate of ₹1.5L, awaiting client review on Friday..." value="<?= e($view_inquiry['admin_notes'] ?? '') ?>">
        </div>
      </div>

      <div style="display: flex; justify-content: space-between;">
        <button type="submit" class="admin-btn admin-btn-primary">
          Save Status &amp; Notes
        </button>
        <a href="inquiries.php?delete=<?= $view_inquiry['id'] ?>" onclick="return confirm('Permanently delete this inquiry?');" class="admin-btn admin-btn-danger admin-btn-sm">
          Delete Inquiry
        </a>
      </div>
    </form>
  </div>
<?php endif; ?>

<!-- Filter & Search Controls Bar -->
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 24px;">
  <div style="display: flex; gap: 6px; flex-wrap: wrap;">
    <a href="inquiries.php?status=all" class="admin-btn <?= ($filter_status === 'all') ? 'admin-btn-primary' : 'admin-btn-outline' ?> admin-btn-sm">All</a>
    <a href="inquiries.php?status=new" class="admin-btn <?= ($filter_status === 'new') ? 'admin-btn-primary' : 'admin-btn-outline' ?> admin-btn-sm">New Leads</a>
    <a href="inquiries.php?status=contacted" class="admin-btn <?= ($filter_status === 'contacted') ? 'admin-btn-primary' : 'admin-btn-outline' ?> admin-btn-sm">Contacted</a>
    <a href="inquiries.php?status=converted" class="admin-btn <?= ($filter_status === 'converted') ? 'admin-btn-primary' : 'admin-btn-outline' ?> admin-btn-sm">Converted</a>
    <a href="inquiries.php?status=archived" class="admin-btn <?= ($filter_status === 'archived') ? 'admin-btn-primary' : 'admin-btn-outline' ?> admin-btn-sm">Archived</a>
  </div>

  <div style="display: flex; gap: 10px;">
    <form method="GET" action="inquiries.php" style="display: flex; gap: 8px;">
      <input type="hidden" name="status" value="<?= e($filter_status) ?>">
      <input type="text" name="q" value="<?= e($search_query) ?>" placeholder="Search client, email..." class="admin-input" style="width: 220px; padding: 7px 12px; font-size: 13px;">
      <button type="submit" class="admin-btn admin-btn-outline admin-btn-sm">Search</button>
    </form>

    <?php if (is_db_connected()): ?>
      <a href="inquiries.php?export=csv" class="admin-btn admin-btn-outline admin-btn-sm" title="Download spreadsheet of inquiries">
        Export CSV ↓
      </a>
    <?php endif; ?>
  </div>
</div>

<!-- Main Table Card -->
<div class="admin-table-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Inquiry Records (<?= count($inquiries_list) ?>)</h3>
    <span style="font-size: 12px; color: var(--admin-text-muted);">Click "Review" on any client inquiry to read full scope and change status</span>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Client &amp; Contact</th>
          <th>Company</th>
          <th>Scope</th>
          <th>Timeline</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($inquiries_list)): ?>
          <?php foreach ($inquiries_list as $row): ?>
            <tr style="<?= ($row['status'] === 'new') ? 'background: rgba(254, 243, 199, 0.25);' : '' ?>">
              <td style="font-family: var(--admin-font-mono); font-size: 12px; color: var(--admin-text-muted);">#<?= $row['id'] ?></td>
              <td>
                <strong><?= e($row['name']) ?></strong><br>
                <a href="mailto:<?= e($row['email']) ?>" style="font-size: 12px; color: var(--admin-text-muted); text-decoration: none;"><?= e($row['email']) ?></a>
              </td>
              <td><?= e($row['company']) ?></td>
              <td><span class="status-pill status-contacted"><?= strtoupper(e($row['scope'])) ?></span></td>
              <td><?= e($row['timeline']) ?></td>
              <td style="font-family: var(--admin-font-mono); font-size: 12px;"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
              <td>
                <span class="status-pill status-<?= e($row['status']) ?>">
                  <?= ucfirst(str_replace('_', ' ', e($row['status']))) ?>
                </span>
              </td>
              <td>
                <div style="display: flex; gap: 6px;">
                  <a href="inquiries.php?view=<?= $row['id'] ?><?= ($filter_status !== 'all' ? '&status=' . $filter_status : '') ?>" class="admin-btn admin-btn-outline admin-btn-sm">
                    Review
                  </a>
                  <a href="inquiries.php?delete=<?= $row['id'] ?>&csrf=<?= csrf_token() ?><?= ($filter_status !== 'all' ? '&status=' . $filter_status : '') ?>" onclick="return confirm('Delete this record?');" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete">
                    ✕
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
              No inquiry records matching your current filter.
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
