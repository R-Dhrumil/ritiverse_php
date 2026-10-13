<?php
/**
 * RiTiVerse — Services Management Center
 * Full CRUD: Add, Edit, Delete, Toggle Active, Image Upload & Order Management
 */
$active_tab = 'services';
$admin_title = 'Services & Standalone Pages Manager';
$admin_subtitle = 'Manage specialized engineering domains, standalone landing pages, deliverables, and tech stacks';

require_once __DIR__ . '/admin_header.php';
require_once __DIR__ . '/../includes/services_helper.php';

$db = get_db();
$message = '';
$error = '';

// Ensure services table is ready
if ($db) {
    ensure_services_table();
}

// Ensure upload directory exists
$upload_dir = dirname(__DIR__) . '/uploads/services/';
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0755, true);
}

// Handle Form Submissions via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Please reload the page.';
    } elseif (!$db) {
        $error = 'Database is currently offline. Connect MySQL database to save changes.';
    } else {
        $action = $_POST['action'];

        // 1. Quick Toggle Active Status
        if ($action === 'toggle_active') {
            $svc_id = (int)($_POST['id'] ?? 0);
            $new_val = (int)($_POST['current_active'] ?? 0) ? 0 : 1;
            try {
                $stmt = $db->prepare("UPDATE services SET is_active = ? WHERE id = ?");
                $stmt->execute([$new_val, $svc_id]);
                $message = "Service #{$svc_id} visibility updated (" . ($new_val ? 'Active' : 'Draft') . ").";
            } catch (Exception $e) {
                $error = "Failed to update service status: " . $e->getMessage();
            }
        }

        // 2. Delete Service
        elseif ($action === 'delete') {
            $del_id = (int)($_POST['id'] ?? 0);
            try {
                $stmt = $db->prepare("DELETE FROM services WHERE id = ?");
                $stmt->execute([$del_id]);
                $message = "Service #{$del_id} removed successfully.";
            } catch (Exception $e) {
                $error = "Delete failed: " . $e->getMessage();
            }
        }

        // 3. Reseed Defaults
        elseif ($action === 'reseed_defaults') {
            try {
                $defaults = get_default_services_data();
                $stmt = $db->prepare("INSERT INTO services (id, title, slug, icon, tagline, short_desc, full_desc, deliverables, tech_stack, timeline, starting_price, image_url, is_active, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), tagline = VALUES(tagline), short_desc = VALUES(short_desc), full_desc = VALUES(full_desc), deliverables = VALUES(deliverables), tech_stack = VALUES(tech_stack), timeline = VALUES(timeline), image_url = VALUES(image_url), is_active = VALUES(is_active)");
                foreach ($defaults as $svc) {
                    $stmt->execute([
                        $svc['id'],
                        $svc['title'],
                        $svc['slug'],
                        $svc['icon'],
                        $svc['tagline'],
                        $svc['short_desc'],
                        $svc['full_desc'],
                        $svc['deliverables'],
                        $svc['tech_stack'],
                        $svc['timeline'],
                        $svc['starting_price'],
                        $svc['image_url'],
                        $svc['is_active'],
                        $svc['display_order']
                    ]);
                }
                $message = "All 6 core services successfully reseeded and synced.";
            } catch (Exception $e) {
                $error = "Reseed failed: " . $e->getMessage();
            }
        }

        // 4. Create or Update Service
        elseif ($action === 'create' || $action === 'update') {
            $title = trim($_POST['title'] ?? '');
            $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
            $icon = trim($_POST['icon'] ?? 'web');
            $tagline = trim($_POST['tagline'] ?? '');
            $short_desc = trim($_POST['short_desc'] ?? '');
            $full_desc = trim($_POST['full_desc'] ?? '');
            $deliverables = trim($_POST['deliverables'] ?? '');
            $tech_stack = trim($_POST['tech_stack'] ?? '');
            $timeline = trim($_POST['timeline'] ?? '2 – 4 Weeks');
            $starting_price = trim($_POST['starting_price'] ?? '');
            $display_order = (int)($_POST['display_order'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            // Handle Cover Image: Upload or Manual URL / Presets
            $image_url = trim($_POST['image_url_existing'] ?? '');

            if (!empty($_POST['preset_asset'])) {
                $image_url = trim($_POST['preset_asset']);
            }

            if (!empty($_POST['image_url_custom'])) {
                $image_url = trim($_POST['image_url_custom']);
            }

            // File Upload takes precedence if provided
            if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['service_image'];
                $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
                $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if (!in_array($file_ext, $allowed_exts)) {
                    $error = 'Invalid image type. Allowed: JPG, PNG, WEBP, SVG, GIF.';
                } elseif ($file['size'] > 10 * 1024 * 1024) {
                    $error = 'Image file exceeds maximum 10MB limit.';
                } else {
                    $new_filename = 'svc_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
                    $target_file = $upload_dir . $new_filename;

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {
                        $image_url = 'uploads/services/' . $new_filename;
                    } else {
                        $error = 'Failed to save uploaded file. Check directory permissions.';
                    }
                }
            }

            if (empty($title) || empty($short_desc) || empty($full_desc)) {
                $error = 'Service title, short description, and full description are required.';
            } elseif (empty($error)) {
                try {
                    if ($action === 'create') {
                        $stmt = $db->prepare("INSERT INTO services (title, slug, icon, tagline, short_desc, full_desc, deliverables, tech_stack, timeline, starting_price, image_url, is_active, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                        $stmt->execute([$title, $slug, $icon, $tagline, $short_desc, $full_desc, $deliverables, $tech_stack, $timeline, $starting_price, $image_url, $is_active, $display_order]);
                        $message = "Service '{$title}' created successfully.";
                    } elseif ($action === 'update') {
                        $svc_id = (int)$_POST['id'];
                        $stmt = $db->prepare("UPDATE services SET title = ?, slug = ?, icon = ?, tagline = ?, short_desc = ?, full_desc = ?, deliverables = ?, tech_stack = ?, timeline = ?, starting_price = ?, image_url = ?, is_active = ?, display_order = ? WHERE id = ?");
                        $stmt->execute([$title, $slug, $icon, $tagline, $short_desc, $full_desc, $deliverables, $tech_stack, $timeline, $starting_price, $image_url, $is_active, $display_order, $svc_id]);
                        $message = "Service '{$title}' updated successfully.";
                    }
                } catch (Exception $e) {
                    $error = "Database error: " . $e->getMessage();
                }
            }
        }
    }
}

// Fetch all services for management table
$services_list = get_all_services(true);

// Studio preset images available
$preset_assets = [
    'assets/card_web_apps.jpg' => 'Website Development (Browser & UI)',
    'assets/card_cloud_ai.jpg' => 'Mobile App Development (Cloud & Mobile)',
    'assets/card_software_apis.jpg' => 'Custom Software & APIs (Backend & Engine)',
    'assets/card_ai_agents.jpg' => 'Custom ERP Systems (Enterprise Platform)',
    'assets/card_cloud_devops.jpg' => 'Custom CRM Platforms (Pipelines & DevOps)',
    'assets/featured-work.jpg' => 'E-Commerce Storefronts (Storefront & Payments)'
];
?>

<?php if ($message): ?>
  <div class="admin-alert admin-alert-success" style="margin-bottom: 24px; padding: 14px 18px; border-radius: 10px; background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; font-weight: 600; display: flex; align-items: center; gap: 10px;">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
    <span><?= e($message) ?></span>
  </div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="admin-alert admin-alert-error" style="margin-bottom: 24px; padding: 14px 18px; border-radius: 10px; background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; font-weight: 600; display: flex; align-items: center; gap: 10px;">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
    <span><?= e($error) ?></span>
  </div>
<?php endif; ?>

<!-- Control Strip: Header & Actions -->
<div class="admin-card" style="margin-bottom: 24px; padding: 20px 24px;">
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div>
      <h2 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 4px 0; display: flex; align-items: center; gap: 10px;">
        <span>Active Engineering Services</span>
        <span class="status-pill status-contacted" style="font-size: 11px; padding: 2px 8px;"><?= count($services_list) ?> Total</span>
      </h2>
      <p style="font-size: 13.5px; color: #64748B; margin: 0;">
        Each service automatically generates its dedicated, SEO-optimized landing page with capabilities, deliverables, and pricing guides.
      </p>
    </div>

    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <button type="button" class="admin-btn admin-btn-primary" onclick="openServiceModal('create')">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        ＋ Add New Service
      </button>

      <form method="POST" onsubmit="return confirm('Reseed/restore the default 6 core engineering services? Existing IDs will be synchronized.');" style="display: inline;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="reseed_defaults">
        <button type="submit" class="admin-btn admin-btn-outline" title="Reset/Synchronize Core Services">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
          Restore Defaults
        </button>
      </form>

      <a href="../services.php" target="_blank" class="admin-btn admin-btn-outline" title="View Public Services Page">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
        Public View ↗
      </a>
    </div>
  </div>
</div>

<!-- Services Table -->
<div class="admin-card" style="padding: 0; overflow: hidden;">
  <div class="admin-table-wrap">
    <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left;">
      <thead>
        <tr style="background: #F8FAFC; border-bottom: 1px solid var(--admin-border);">
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700; width: 60px;">Order</th>
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700;">Service Domain</th>
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700;">Standalone URL</th>
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700;">Timeline</th>
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700;">Tech Stack</th>
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700;">Status</th>
          <th style="padding: 14px 18px; font-size: 12px; text-transform: uppercase; color: #64748B; font-weight: 700; text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($services_list)): ?>
          <tr>
            <td colspan="7" style="padding: 40px; text-align: center; color: #64748B;">
              No services found. Click <strong>"Restore Defaults"</strong> above to populate the 6 core engineering services.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($services_list as $svc): ?>
            <?php 
              // Check if dedicated standalone file exists, else use service.php?slug=...
              $static_file = dirname(__DIR__) . '/' . $svc['slug'] . '.php';
              $live_url = file_exists($static_file) ? ('../' . $svc['slug'] . '.php') : ('../service.php?slug=' . urlencode($svc['slug']));
              $img_thumb = !empty($svc['image_url']) ? ('../' . $svc['image_url']) : '../assets/card_web_apps.jpg';
            ?>
            <tr style="border-bottom: 1px solid var(--admin-border); transition: background 0.15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
              <!-- Order -->
              <td style="padding: 16px 18px; font-family: var(--admin-font-mono); font-size: 13px; color: #64748B; font-weight: 600;">
                #<?= (int)($svc['display_order'] ?? 0) ?>
              </td>

              <!-- Service Title & Cover -->
              <td style="padding: 16px 18px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                  <img src="<?= e($img_thumb) ?>" alt="<?= e($svc['title']) ?>" style="width: 52px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid var(--admin-border); flex-shrink: 0;" onerror="this.src='../assets/logo.png'">
                  <div>
                    <a href="<?= e($live_url) ?>" target="_blank" style="font-size: 14.5px; font-weight: 700; color: #0F172A; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                      <?= e($svc['title']) ?>
                      <span style="font-size: 11px; color: var(--admin-accent);">↗</span>
                    </a>
                    <div style="font-size: 12px; color: #64748B; margin-top: 2px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      <?= e($svc['tagline'] ?: $svc['short_desc']) ?>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Standalone URL Slug -->
              <td style="padding: 16px 18px;">
                <a href="<?= e($live_url) ?>" target="_blank" style="font-family: var(--admin-font-mono); font-size: 12px; color: #0369A1; background: #F0F9FF; padding: 4px 8px; border-radius: 5px; border: 1px solid #BAE6FD; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                  /<?= e($svc['slug']) ?>.php
                </a>
              </td>

              <!-- Timeline -->
              <td style="padding: 16px 18px; font-size: 13px; color: #334155; font-weight: 600; white-space: nowrap;">
                <?= e($svc['timeline'] ?: '2 – 4 Weeks') ?>
              </td>

              <!-- Tech Stack Tags -->
              <td style="padding: 16px 18px;">
                <span style="font-size: 12px; color: #475569; display: inline-block; max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= e($svc['tech_stack']) ?>">
                  <?= e($svc['tech_stack'] ?: 'PHP, React, Node.js') ?>
                </span>
              </td>

              <!-- Status Toggle -->
              <td style="padding: 16px 18px;">
                <form method="POST" style="display: inline;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="toggle_active">
                  <input type="hidden" name="id" value="<?= (int)$svc['id'] ?>">
                  <input type="hidden" name="current_active" value="<?= (int)$svc['is_active'] ?>">
                  <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                    <?php if (!empty($svc['is_active'])): ?>
                      <span class="status-pill status-converted" style="cursor: pointer;" title="Click to hide (Draft)">● Active</span>
                    <?php else: ?>
                      <span class="status-pill status-new" style="cursor: pointer;" title="Click to publish">○ Inactive (Draft)</span>
                    <?php endif; ?>
                  </button>
                </form>
              </td>

              <!-- Actions -->
              <td style="padding: 16px 18px; text-align: right;">
                <div style="display: inline-flex; align-items: center; gap: 6px;">
                  <!-- View Live -->
                  <a href="<?= e($live_url) ?>" target="_blank" class="admin-btn admin-btn-outline admin-btn-sm" title="Preview Dedicated Landing Page">
                    View ↗
                  </a>

                  <!-- Edit Button -->
                  <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" onclick="editService(<?= htmlspecialchars(json_encode($svc), ENT_QUOTES, 'UTF-8') ?>)" title="Edit Service">
                    Edit
                  </button>

                  <!-- Delete Button -->
                  <form method="POST" onsubmit="return confirm('Are you sure you want to delete \'<?= addslashes($svc['title']) ?>\'? This action cannot be undone.');" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$svc['id'] ?>">
                    <button type="submit" class="admin-btn admin-btn-outline admin-btn-sm" style="color: #DC2626; border-color: rgba(220, 38, 38, 0.3);" title="Delete Service">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- =========================================================================
     MODAL: Add / Edit Service Modal Drawer
     ========================================================================= -->
<div id="serviceModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(5px); overflow-y: auto; padding: 24px 16px;">
  <div style="max-width: 860px; margin: 30px auto; background: #FFFFFF; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid var(--admin-border); overflow: hidden;">
    
    <!-- Modal Header -->
    <div style="padding: 20px 24px; background: #F8FAFC; border-bottom: 1px solid var(--admin-border); display: flex; justify-content: space-between; align-items: center;">
      <div>
        <h3 id="modalTitle" style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0;">Add New Service</h3>
        <p style="font-size: 13px; color: #64748B; margin: 3px 0 0 0;">Create a specialized service domain and generate its dedicated landing page.</p>
      </div>
      <button type="button" onclick="closeServiceModal()" style="background: none; border: none; font-size: 24px; line-height: 1; color: #64748B; cursor: pointer; padding: 4px 8px;">✕</button>
    </div>

    <!-- Modal Form -->
    <form method="POST" enctype="multipart/form-data" style="padding: 24px;">
      <?= csrf_field() ?>
      <input type="hidden" name="action" id="formAction" value="create">
      <input type="hidden" name="id" id="serviceId" value="0">
      <input type="hidden" name="image_url_existing" id="imageUrlExisting" value="">

      <!-- Row 1: Title, Slug, Icon, Order -->
      <div class="admin-grid-4">
        <div>
          <label class="admin-form-label">Service Title *</label>
          <input type="text" name="title" id="serviceTitle" required class="admin-input" placeholder="e.g. AI Agent Engineering" onkeyup="autoGenerateSlug(this.value)">
        </div>
        <div>
          <label class="admin-form-label">URL Slug *</label>
          <input type="text" name="slug" id="serviceSlug" required class="admin-input" placeholder="e.g. ai-agent-engineering">
        </div>
        <div>
          <label class="admin-form-label">Domain Icon</label>
          <select name="icon" id="serviceIcon" class="admin-input">
            <option value="web">Web (Globe / UI)</option>
            <option value="mobile">Mobile (Smartphone)</option>
            <option value="software">Software (Code / APIs)</option>
            <option value="erp">ERP (Enterprise Hub)</option>
            <option value="crm">CRM (Sales / Users)</option>
            <option value="ecommerce">E-Commerce (Store / Cart)</option>
            <option value="cloud">Cloud (DevOps / Infra)</option>
            <option value="ai">AI (Agents / Models)</option>
          </select>
        </div>
        <div>
          <label class="admin-form-label">Display Order</label>
          <input type="number" name="display_order" id="serviceOrder" class="admin-input" value="1" min="0">
        </div>
      </div>

      <!-- Row 2: Tagline -->
      <div class="admin-form-group">
        <label class="admin-form-label">High-Impact Hero Tagline</label>
        <input type="text" name="tagline" id="serviceTagline" class="admin-input" placeholder="e.g. Custom Multi-Agent Systems & Private Enterprise LLM Workspaces">
      </div>

      <!-- Row 3: Short Description -->
      <div class="admin-form-group">
        <label class="admin-form-label">Short Summary (For Cards & SEO Meta) *</label>
        <textarea name="short_desc" id="serviceShortDesc" required rows="2" class="admin-input" placeholder="2-3 sentence overview displayed on the services showcase matrix and social share snippets..."></textarea>
      </div>

      <!-- Row 4: Full In-Depth Architecture Overview -->
      <div class="admin-form-group">
        <label class="admin-form-label">Full Technical Architecture & Value Proposition *</label>
        <textarea name="full_desc" id="serviceFullDesc" required rows="5" class="admin-input" placeholder="Comprehensive engineering narrative explaining why your architecture is superior, what exact problems it eliminates, and your 100% code ownership guarantee..."></textarea>
      </div>

      <!-- Row 5: Deliverables & Capabilities List (Line Separated) -->
      <div class="admin-form-group">
        <label class="admin-form-label">Deliverables & Included Capabilities (1 item per line)</label>
        <textarea name="deliverables" id="serviceDeliverables" rows="6" class="admin-input" placeholder="Sub-2-second page load times on mobile & desktop&#10;Bespoke UI/UX design calibrated to your brand identity&#10;Technical SEO meta structure & Schema.org rich snippets&#10;Integrated inquiry capture forms with instant alerts&#10;100% Source code ownership on private GitHub repo&#10;Free 30-day post-launch warranty & handover training"></textarea>
        <span style="font-size: 11.5px; color: #64748B; margin-top: 4px; display: block;">Each line will render as an interactive capability badge and deliverable bullet on the dedicated page.</span>
      </div>

      <!-- Row 6: Tech Stack, Timeline, Starting Price -->
      <div class="admin-grid-3">
        <div>
          <label class="admin-form-label">Tech Stack Tags</label>
          <input type="text" name="tech_stack" id="serviceTechStack" class="admin-input" placeholder="e.g. React 19, PHP 8.3, MySQL, Redis, Docker">
        </div>
        <div>
          <label class="admin-form-label">Expected Timeline</label>
          <input type="text" name="timeline" id="serviceTimeline" class="admin-input" placeholder="e.g. 2 – 4 Weeks">
        </div>
        <div>
          <label class="admin-form-label">Starting Price / Scope</label>
          <input type="text" name="starting_price" id="serviceStartingPrice" class="admin-input" placeholder="e.g. Milestone-Based Scope">
        </div>
      </div>

      <!-- Row 7: Cover Image Handling -->
      <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 10px; padding: 16px; margin: 20px 0;">
        <label class="admin-form-label" style="margin-bottom: 8px;">Hero Showcase Image</label>
        <div class="admin-grid-3">
          <div>
            <label style="font-size: 11.5px; color: #475569; display: block; margin-bottom: 4px;">1. Upload File (JPG/PNG/WEBP)</label>
            <input type="file" name="service_image" accept="image/*" class="admin-input" style="padding: 6px;">
          </div>
          <div>
            <label style="font-size: 11.5px; color: #475569; display: block; margin-bottom: 4px;">2. Or Choose Studio Asset</label>
            <select name="preset_asset" id="servicePresetAsset" class="admin-input">
              <option value="">-- Choose Preset Asset --</option>
              <?php foreach ($preset_assets as $path => $lbl): ?>
                <option value="<?= e($path) ?>"><?= e($lbl) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label style="font-size: 11.5px; color: #475569; display: block; margin-bottom: 4px;">3. Or Custom Image URL</label>
            <input type="text" name="image_url_custom" id="serviceImageCustom" class="admin-input" placeholder="assets/card_web_apps.jpg">
          </div>
        </div>
        <div id="imagePreviewContainer" style="margin-top: 10px; display: none; align-items: center; gap: 10px;">
          <span style="font-size: 12px; color: #64748B;">Current Image:</span>
          <img id="imagePreview" src="" alt="Preview" style="height: 38px; border-radius: 6px; border: 1px solid var(--admin-border);">
        </div>
      </div>

      <!-- Active Checkbox & Submit Row -->
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding-top: 12px; border-top: 1px solid var(--admin-border);">
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #0F172A;">
          <input type="checkbox" name="is_active" id="serviceIsActive" value="1" checked style="width: 17px; height: 17px; accent-color: var(--admin-accent);">
          Publish Live on Website (Active)
        </label>

        <div style="display: flex; gap: 10px;">
          <button type="button" class="admin-btn admin-btn-outline" onclick="closeServiceModal()">Cancel</button>
          <button type="submit" class="admin-btn admin-btn-primary" id="modalSubmitBtn">Save Service</button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
function autoGenerateSlug(text) {
  const formAction = document.getElementById('formAction').value;
  if (formAction === 'create') {
    const slug = text.toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/[\s-]+/g, '-');
    document.getElementById('serviceSlug').value = slug;
  }
}

function openServiceModal(mode) {
  document.getElementById('serviceModal').style.display = 'block';
  document.body.style.overflow = 'hidden';

  if (mode === 'create') {
    document.getElementById('modalTitle').textContent = 'Add New Service';
    document.getElementById('modalSubmitBtn').textContent = 'Create Service';
    document.getElementById('formAction').value = 'create';
    document.getElementById('serviceId').value = '0';
    document.getElementById('serviceTitle').value = '';
    document.getElementById('serviceSlug').value = '';
    document.getElementById('serviceIcon').value = 'web';
    document.getElementById('serviceTagline').value = '';
    document.getElementById('serviceShortDesc').value = '';
    document.getElementById('serviceFullDesc').value = '';
    document.getElementById('serviceDeliverables').value = '';
    document.getElementById('serviceTechStack').value = '';
    document.getElementById('serviceTimeline').value = '2 – 4 Weeks';
    document.getElementById('serviceStartingPrice').value = 'Fixed Milestone Scope';
    document.getElementById('serviceOrder').value = '<?= count($services_list) + 1 ?>';
    document.getElementById('imageUrlExisting').value = '';
    document.getElementById('serviceImageCustom').value = '';
    document.getElementById('servicePresetAsset').value = '';
    document.getElementById('imagePreviewContainer').style.display = 'none';
    document.getElementById('serviceIsActive').checked = true;
  }
}

function closeServiceModal() {
  document.getElementById('serviceModal').style.display = 'none';
  document.body.style.overflow = '';
}

function editService(svc) {
  document.getElementById('serviceModal').style.display = 'block';
  document.body.style.overflow = 'hidden';

  document.getElementById('modalTitle').textContent = 'Edit Service: ' + svc.title;
  document.getElementById('modalSubmitBtn').textContent = 'Update Service';
  document.getElementById('formAction').value = 'update';
  document.getElementById('serviceId').value = svc.id;
  document.getElementById('serviceTitle').value = svc.title || '';
  document.getElementById('serviceSlug').value = svc.slug || '';
  document.getElementById('serviceIcon').value = svc.icon || 'web';
  document.getElementById('serviceTagline').value = svc.tagline || '';
  document.getElementById('serviceShortDesc').value = svc.short_desc || '';
  document.getElementById('serviceFullDesc').value = svc.full_desc || '';
  document.getElementById('serviceDeliverables').value = svc.deliverables || '';
  document.getElementById('serviceTechStack').value = svc.tech_stack || '';
  document.getElementById('serviceTimeline').value = svc.timeline || '2 – 4 Weeks';
  document.getElementById('serviceStartingPrice').value = svc.starting_price || '';
  document.getElementById('serviceOrder').value = svc.display_order || 0;
  document.getElementById('imageUrlExisting').value = svc.image_url || '';
  document.getElementById('serviceImageCustom').value = svc.image_url || '';
  document.getElementById('servicePresetAsset').value = svc.image_url || '';
  document.getElementById('serviceIsActive').checked = (parseInt(svc.is_active) === 1);

  if (svc.image_url) {
    document.getElementById('imagePreview').src = '../' + svc.image_url;
    document.getElementById('imagePreviewContainer').style.display = 'flex';
  } else {
    document.getElementById('imagePreviewContainer').style.display = 'none';
  }
}

// Close on escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeServiceModal();
  }
});
</script>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
