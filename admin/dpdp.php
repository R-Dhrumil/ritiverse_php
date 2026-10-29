<?php
/**
 * RiTiVerse — DPDP Act 2023 Statutory Privacy & Grievance Console
 * Manage Data Principal Requests, Execute Right to Erasure / Access, and Audit Consent.
 */
$active_tab = 'dpdp';
$admin_title = 'DPDP Act 2023 & Privacy Desk';
$admin_subtitle = 'Fulfill Data Principal statutory rights (Access, Correction, Erasure, Grievance Redressal)';

require_once __DIR__ . '/admin_header.php';

$db = get_db();
$message = '';
$error = '';

// Handle Data Export (Right to Access - Section 11)
if (isset($_GET['export_email']) && $db) {
    if (!verify_csrf_token($_GET['csrf'] ?? '')) {
        $error = "Security token mismatch for data export.";
    } else {
        $target_email = trim($_GET['export_email']);
        $export_stmt = $db->prepare("SELECT id, name, email, company, scope, timeline, details, status, consent_given, consent_timestamp, consent_ip, consent_version, is_anonymized, created_at FROM inquiries WHERE email = ? ORDER BY created_at DESC");
        $export_stmt->execute([$target_email]);
        $records = $export_stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename=ritiverse_dpdp_access_' . preg_replace('/[^a-zA-Z0-9]/', '_', $target_email) . '.json');
        echo json_encode([
            'statutory_notice' => 'Personal Data Export generated under Section 11 of the Digital Personal Data Protection Act, 2023',
            'data_fiduciary' => APP_LEGAL_NAME,
            'official_domain' => SITE_URL,
            'data_principal_email' => $target_email,
            'exported_at' => date('Y-m-d H:i:s T'),
            'total_records_found' => count($records),
            'records' => $records
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Handle Single Inquiry Anonymization (Right to Erasure - Section 12(3))
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'anonymize_inquiry' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch. Please reload the page.";
    } else {
        $inquiry_id = (int)($_POST['inquiry_id'] ?? 0);
        if (anonymize_inquiry($inquiry_id)) {
            $message = "Inquiry #{$inquiry_id} has been permanently anonymized per Section 12(3) of DPDP Act 2023.";
        } else {
            $error = "Failed to anonymize inquiry. Please check error logs.";
        }
    }
}

// Handle Bulk Anonymization by Email (Full Right to be Forgotten)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'anonymize_email' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch. Please reload the page.";
    } else {
        $target_email = trim($_POST['target_email'] ?? '');
        $req_id = (int)($_POST['request_id'] ?? 0);

        try {
            $stmt = $db->prepare("UPDATE inquiries SET 
                name = '[Data Principal Requested Erasure]',
                email = 'erased@ritiverse.dpdp',
                company = '[Erased]',
                details = '[Personal details erased per Section 12(3) of DPDP Act 2023]',
                ip_address = '0.0.0.0',
                is_anonymized = 1,
                anonymized_at = NOW()
                WHERE email = ?");
            $stmt->execute([$target_email]);
            $count = $stmt->rowCount();

            // Mark statutory request as fulfilled
            if ($req_id > 0) {
                $fulfill_stmt = $db->prepare("UPDATE dpdp_requests SET status = 'fulfilled', admin_notes = CONCAT(IFNULL(admin_notes,''), '\n[Auto]: Anonymized ', ?, ' associated inquiry record(s).'), resolved_at = NOW() WHERE id = ?");
                $fulfill_stmt->execute([$count, $req_id]);
            }

            $message = "Successfully erased and anonymized {$count} inquiry record(s) matching {$target_email}.";
        } catch (Exception $e) {
            $error = "Bulk erasure failed: " . $e->getMessage();
        }
    }
}

// Handle DPDP Request Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_dpdp_request' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch. Please reload the page.";
    } else {
        $req_id = (int)($_POST['request_id'] ?? 0);
        $new_status = $_POST['status'] ?? 'pending';
        $admin_notes = trim($_POST['admin_notes'] ?? '');
        $resolved_at = ($new_status === 'fulfilled' || $new_status === 'rejected') ? date('Y-m-d H:i:s') : null;

        try {
            $stmt = $db->prepare("UPDATE dpdp_requests SET status = ?, admin_notes = ?, resolved_at = ? WHERE id = ?");
            $stmt->execute([$new_status, $admin_notes, $resolved_at, $req_id]);
            $message = "DPDP Request #{$req_id} updated to " . strtoupper($new_status) . ".";
        } catch (Exception $e) {
            $error = "Update failed: " . $e->getMessage();
        }
    }
}

// Handle Data Retention Scrub (Auto-clean inquiries older than retention period)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'run_retention_scrub' && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch.";
    } else {
        $retention_days = (int)get_setting('dpdp_retention_days', 365);
        if ($retention_days < 30) $retention_days = 30; // Safeguard

        try {
            $scrub_stmt = $db->prepare("UPDATE inquiries SET 
                name = '[Retention Policy Auto-Scrubbed]',
                email = 'retention_scrubbed@ritiverse.dpdp',
                company = '[Scrubbed]',
                details = '[Personal details scrubbed per Data Retention Policy after retention window]',
                ip_address = '0.0.0.0',
                is_anonymized = 1,
                anonymized_at = NOW()
                WHERE is_anonymized = 0 AND created_at < DATE_SUB(NOW(), INTERVAL ? DAY)");
            $scrub_stmt->execute([$retention_days]);
            $scrubbed = $scrub_stmt->rowCount();
            $message = "Data Retention Scrub executed: Anonymized {$scrubbed} inquiry record(s) older than {$retention_days} days.";
        } catch (Exception $e) {
            $error = "Retention scrub notice: " . $e->getMessage();
        }
    }
}

// Metrics
$total_requests = 0;
$pending_requests = 0;
$fulfilled_requests = 0;
$anonymized_count = 0;

if ($db) {
    try {
        $total_requests = (int)$db->query("SELECT COUNT(*) FROM dpdp_requests")->fetchColumn();
        $pending_requests = (int)$db->query("SELECT COUNT(*) FROM dpdp_requests WHERE status = 'pending'")->fetchColumn();
        $fulfilled_requests = (int)$db->query("SELECT COUNT(*) FROM dpdp_requests WHERE status = 'fulfilled'")->fetchColumn();
        $anonymized_count = (int)$db->query("SELECT COUNT(*) FROM inquiries WHERE is_anonymized = 1")->fetchColumn();
    } catch (Exception $e) {}
}

// Filter requests
$filter_status = $_GET['status'] ?? 'all';
$dpdp_list = [];

if ($db) {
    try {
        $sql = "SELECT * FROM dpdp_requests WHERE 1=1";
        $params = [];
        if ($filter_status !== 'all') {
            $sql .= " AND status = ?";
            $params[] = $filter_status;
        }
        $sql .= " ORDER BY created_at DESC LIMIT 50";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $dpdp_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = "Could not fetch DPDP requests: " . $e->getMessage();
    }
}

// Fetch inquiries with DPDP consent info for audit ledger
$consent_audit_list = [];
if ($db) {
    try {
        $audit_stmt = $db->query("SELECT id, name, email, company, status, consent_given, consent_timestamp, consent_ip, consent_version, is_anonymized, created_at FROM inquiries ORDER BY created_at DESC LIMIT 15");
        $consent_audit_list = $audit_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}
?>

<div class="admin-content">

  <?php if (!empty($message)): ?>
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #065F46; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px;">
      <?= e($message) ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($error)): ?>
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #991B1B; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px;">
      <?= e($error) ?>
    </div>
  <?php endif; ?>

  <!-- Telemetry Metrics Grid -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px;">
    
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
      <span style="font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase;">Total Statutory Requests</span>
      <div style="font-size: 28px; font-weight: 800; color: #0F172A; margin-top: 6px;"><?= $total_requests ?></div>
      <span style="font-size: 12px; color: #10B981;">DPDP Act 2023 Logged</span>
    </div>

    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
      <span style="font-size: 12px; font-weight: 700; color: #F86800; text-transform: uppercase;">Pending Review</span>
      <div style="font-size: 28px; font-weight: 800; color: #F86800; margin-top: 6px;"><?= $pending_requests ?></div>
      <span style="font-size: 12px; color: #64748B;">Requires DPO SLA Action</span>
    </div>

    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
      <span style="font-size: 12px; font-weight: 700; color: #10B981; text-transform: uppercase;">Fulfilled Requests</span>
      <div style="font-size: 28px; font-weight: 800; color: #10B981; margin-top: 6px;"><?= $fulfilled_requests ?></div>
      <span style="font-size: 12px; color: #64748B;">Within Statutory SLA</span>
    </div>

    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
      <span style="font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase;">Anonymized Inquiries</span>
      <div style="font-size: 28px; font-weight: 800; color: #0F172A; margin-top: 6px;"><?= $anonymized_count ?></div>
      <span style="font-size: 12px; color: #64748B;">Right to be Forgotten</span>
    </div>

  </div>

  <!-- Statutory Requests Management -->
  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 32px; box-shadow: 0 4px 15px -3px rgba(0,0,0,0.03);">
    
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid #F1F5F9; padding-bottom: 16px;">
      <div>
        <h2 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 4px 0;">
          Data Principal Statutory Requests Queue
        </h2>
        <span style="font-size: 13px; color: #64748B;">Access, Correction, Erasure &amp; Grievance requests under DPDP Act 2023</span>
      </div>

      <!-- Filter Controls -->
      <div style="display: flex; align-items: center; gap: 8px;">
        <a href="dpdp.php?status=all" class="admin-nav-link <?= ($filter_status === 'all') ? 'active' : '' ?>" style="padding: 6px 12px; font-size: 12px; border-radius: 6px;">All (<?= $total_requests ?>)</a>
        <a href="dpdp.php?status=pending" class="admin-nav-link <?= ($filter_status === 'pending') ? 'active' : '' ?>" style="padding: 6px 12px; font-size: 12px; border-radius: 6px;">Pending (<?= $pending_requests ?>)</a>
        <a href="dpdp.php?status=fulfilled" class="admin-nav-link <?= ($filter_status === 'fulfilled') ? 'active' : '' ?>" style="padding: 6px 12px; font-size: 12px; border-radius: 6px;">Fulfilled (<?= $fulfilled_requests ?>)</a>
      </div>
    </div>

    <?php if (empty($dpdp_list)): ?>
      <div style="text-align: center; padding: 40px 20px; color: #64748B;">
        <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="#CBD5E1" stroke-width="1.5" style="margin-bottom: 10px;">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
          <path d="M9 12l2 2 4-4"></path>
        </svg>
        <p style="margin: 0; font-size: 14px;">No statutory requests found matching the current filter.</p>
      </div>
    <?php else: ?>
      <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
          <thead>
            <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0; text-align: left; color: #475569;">
              <th style="padding: 12px 14px;">Ticket</th>
              <th style="padding: 12px 14px;">Data Principal</th>
              <th style="padding: 12px 14px;">Statutory Right</th>
              <th style="padding: 12px 14px;">Status</th>
              <th style="padding: 12px 14px;">Submitted</th>
              <th style="padding: 12px 14px; text-align: right;">Fulfillment Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dpdp_list as $req): ?>
              <tr style="border-bottom: 1px solid #F1F5F9;">
                <td style="padding: 14px; font-weight: 700; font-family: monospace; color: #F86800;">
                  <?= e($req['ticket_id']) ?>
                </td>
                <td style="padding: 14px;">
                  <strong><?= e($req['name']) ?></strong><br>
                  <span style="color: #64748B; font-size: 12px;"><?= e($req['email']) ?></span>
                  <?php if (!empty($req['phone'])): ?>
                    <span style="color: #94A3B8; font-size: 11px;"> • <?= e($req['phone']) ?></span>
                  <?php endif; ?>
                </td>
                <td style="padding: 14px;">
                  <span style="display: inline-block; padding: 3px 8px; border-radius: 6px; font-weight: 600; font-size: 11px; background: #EEF2F6; color: #1E293B;">
                    <?= strtoupper(e($req['request_type'])) ?>
                  </span>
                  <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= e($req['details']) ?>">
                    <?= e($req['details']) ?>
                  </div>
                </td>
                <td style="padding: 14px;">
                  <?php 
                    $badge_colors = [
                      'pending' => 'background: #FEF3C7; color: #B45309;',
                      'in_review' => 'background: #E0E7FF; color: #3730A3;',
                      'fulfilled' => 'background: #D1FAE5; color: #065F46;',
                      'rejected' => 'background: #FEE2E2; color: #991B1B;'
                    ];
                    $badge_style = $badge_colors[$req['status']] ?? 'background: #F1F5F9; color: #334155;';
                  ?>
                  <span style="display: inline-block; padding: 3px 8px; border-radius: 99px; font-weight: 700; font-size: 11px; <?= $badge_style ?>">
                    <?= strtoupper(e($req['status'])) ?>
                  </span>
                </td>
                <td style="padding: 14px; color: #64748B; font-size: 12px;">
                  <?= date('M d, Y H:i', strtotime($req['created_at'])) ?>
                </td>
                <td style="padding: 14px; text-align: right;">
                  <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center; flex-wrap: wrap;">
                    
                    <!-- Right to Access Export JSON -->
                    <a href="dpdp.php?export_email=<?= urlencode($req['email']) ?>&csrf=<?= e(csrf_token()) ?>" 
                       class="admin-btn" style="padding: 5px 9px; font-size: 11px; text-decoration: none;" title="Export all personal records as JSON (Right to Access - Sec 11)">
                      Export JSON
                    </a>

                    <!-- Right to Erasure / Anonymize -->
                    <?php if ($req['status'] !== 'fulfilled'): ?>
                      <form method="POST" action="dpdp.php" style="display: inline;" onsubmit="return confirm('Execute Section 12(3) Right to Erasure? This will permanently scrub all inquiry PII associated with <?= e(addslashes($req['email'])) ?>.');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="anonymize_email">
                        <input type="hidden" name="target_email" value="<?= e($req['email']) ?>">
                        <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                        <button type="submit" class="admin-btn" style="padding: 5px 9px; font-size: 11px; background: rgba(239, 68, 68, 0.1); color: #EF4444; border-color: rgba(239, 68, 68, 0.3);">
                          Erase PII
                        </button>
                      </form>
                    <?php endif; ?>

                    <!-- Status toggle dropdown -->
                    <button type="button" class="admin-btn" style="padding: 5px 9px; font-size: 11px;" onclick="document.getElementById('edit-req-<?= $req['id'] ?>').style.display = (document.getElementById('edit-req-<?= $req['id'] ?>').style.display === 'none' ? 'table-row' : 'none');">
                      Notes / SLA
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Inline Edit Form Row -->
              <tr id="edit-req-<?= $req['id'] ?>" style="display: none; background: #F8FAFC;">
                <td colspan="6" style="padding: 16px 20px;">
                  <form method="POST" action="dpdp.php" style="display: flex; flex-direction: column; gap: 10px;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="update_dpdp_request">
                    <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                    
                    <div style="font-weight: 600; font-size: 12.5px; color: #1E293B;">
                      Update SLA Status for Ticket #<?= e($req['ticket_id']) ?>:
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                      <label style="font-size: 12px; color: #475569;">
                        Status:
                        <select name="status" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #CBD5E1; font-family: inherit;">
                          <option value="pending" <?= ($req['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                          <option value="in_review" <?= ($req['status'] === 'in_review') ? 'selected' : '' ?>>In Review</option>
                          <option value="fulfilled" <?= ($req['status'] === 'fulfilled') ? 'selected' : '' ?>>Fulfilled</option>
                          <option value="rejected" <?= ($req['status'] === 'rejected') ? 'selected' : '' ?>>Rejected</option>
                        </select>
                      </label>
                      <input type="text" name="admin_notes" placeholder="DPO compliance notes or justification..." value="<?= e($req['admin_notes'] ?? '') ?>" style="flex: 1 1 280px; padding: 6px 10px; border-radius: 6px; border: 1px solid #CBD5E1; font-family: inherit; font-size: 12px;">
                      <button type="submit" class="admin-btn" style="background: #F86800; color: #FFFFFF; border: none; padding: 6px 14px; font-size: 12px;">Save SLA</button>
                    </div>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>

  <!-- Consent Ledger & Data Retention Section -->
  <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    
    <!-- Consent Audit Ledger -->
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px;">
      <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px 0;">
        Consent Audit Trail Ledger (Section 6(10) Compliance)
      </h3>
      <p style="font-size: 12.5px; color: #64748B; margin: 0 0 16px 0;">
        Statutory proof of affirmative consent logged at the exact moment of inquiry submission.
      </p>

      <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
          <thead>
            <tr style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0; text-align: left; color: #475569;">
              <th style="padding: 10px;">Inquiry ID</th>
              <th style="padding: 10px;">Client</th>
              <th style="padding: 10px;">Consent State</th>
              <th style="padding: 10px;">Timestamp</th>
              <th style="padding: 10px;">Masked IP</th>
              <th style="padding: 10px; text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($consent_audit_list as $audit): ?>
              <tr style="border-bottom: 1px solid #F1F5F9;">
                <td style="padding: 10px; font-weight: 600;">#<?= $audit['id'] ?></td>
                <td style="padding: 10px;">
                  <?= $audit['is_anonymized'] ? '<em style="color:#94A3B8;">[Anonymized]</em>' : e($audit['name']) ?><br>
                  <span style="color: #64748B; font-size: 11px;"><?= $audit['is_anonymized'] ? 'erased@dpdp' : mask_email($audit['email']) ?></span>
                </td>
                <td style="padding: 10px;">
                  <?php if (!empty($audit['consent_given'])): ?>
                    <span style="color: #10B981; font-weight: 700;">✓ Affirmative (<?= e($audit['consent_version'] ?? 'v1.0') ?>)</span>
                  <?php else: ?>
                    <span style="color: #94A3B8;">Legacy</span>
                  <?php endif; ?>
                </td>
                <td style="padding: 10px; color: #64748B;">
                  <?= !empty($audit['consent_timestamp']) ? date('M d, H:i', strtotime($audit['consent_timestamp'])) : date('M d, H:i', strtotime($audit['created_at'])) ?>
                </td>
                <td style="padding: 10px; font-family: monospace; color: #475569;">
                  <?= mask_ip($audit['consent_ip'] ?? '') ?>
                </td>
                <td style="padding: 10px; text-align: right;">
                  <?php if (!$audit['is_anonymized']): ?>
                    <form method="POST" action="dpdp.php" style="display: inline;" onsubmit="return confirm('Anonymize Inquiry #<?= $audit['id'] ?> per Section 12(3)?');">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action" value="anonymize_inquiry">
                      <input type="hidden" name="inquiry_id" value="<?= $audit['id'] ?>">
                      <button type="submit" class="admin-btn" style="padding: 3px 7px; font-size: 10.5px; color: #EF4444; border-color: rgba(239, 68, 68, 0.3);">
                        Erase
                      </button>
                    </form>
                  <?php else: ?>
                    <span style="color: #10B981; font-size: 11px; font-weight: 600;">Scrubbed ✓</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Data Retention & Storage Limitation (Sec 8(7)) -->
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px;">
      <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 6px 0;">
        Storage Limitation (Sec 8(7))
      </h3>
      <p style="font-size: 12.5px; color: #64748B; margin: 0 0 16px 0; line-height: 1.5;">
        Automated data scrub ensures client inquiry PII is not stored beyond your configured retention window (current setting: <strong><?= (int)get_setting('dpdp_retention_days', 365) ?> days</strong>).
      </p>

      <form method="POST" action="dpdp.php" onsubmit="return confirm('Run Data Retention Scrub now? All non-converted inquiries older than <?= (int)get_setting('dpdp_retention_days', 365) ?> days will have their PII scrubbed.');">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="run_retention_scrub">
        <button type="submit" class="admin-btn" style="width: 100%; justify-content: center; background: #F86800; color: #FFFFFF; border: none; padding: 10px; font-size: 13px;">
          Run Retention Scrub Now
        </button>
      </form>
      <div style="font-size: 11.5px; color: #94A3B8; margin-top: 10px; text-align: center;">
        Can also be triggered via daily cPanel cron job.
      </div>
    </div>

  </div>

</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
