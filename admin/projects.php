<?php
/**
 * RiTiVerse — Projects & Architecture Showcase Manager
 * Complete CRUD: Add, Edit, Delete, Toggle Featured, Image Upload & Telemetry Metrics
 */
$active_tab = 'projects';
$admin_title = 'Projects & Reference Architectures';
$admin_subtitle = 'Manage client showcase case studies, screenshots, live links and technical telemetry';

require_once __DIR__ . '/admin_header.php';

$db = get_db();
$message = '';
$error = '';

// Auto-migrate missing columns if running with older database schema
if ($db) {
    try {
        $cols = $db->query("SHOW COLUMNS FROM projects")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('client_name', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN client_name VARCHAR(150) NOT NULL DEFAULT '' AFTER title");
        }
        if (!in_array('image_url', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN image_url VARCHAR(255) NOT NULL DEFAULT '' AFTER description");
        }
        if (!in_array('live_url', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN live_url VARCHAR(255) NOT NULL DEFAULT '' AFTER image_url");
        }
    } catch (Exception $e) {
        // Silently continue
    }
}

// Ensure upload directory exists
$upload_dir = dirname(__DIR__) . '/uploads/projects/';
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0755, true);
}

// Handle Form Submissions (Create / Update / Toggle / Delete via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $db) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Please reload the page.';
    } else {
        $action = $_POST['action'];

        // 1. Quick Toggle Featured
        if ($action === 'toggle_featured') {
            $proj_id = (int)($_POST['id'] ?? 0);
            $new_val = (int)($_POST['featured'] ?? 0) ? 0 : 1;
            try {
                $stmt = $db->prepare("UPDATE projects SET is_featured = ? WHERE id = ?");
                $stmt->execute([$new_val, $proj_id]);
                $message = "Project #{$proj_id} visibility updated.";
            } catch (Exception $e) {
                $error = "Failed to update project visibility: " . $e->getMessage();
            }
        }

        // 2. Delete Project via POST
        elseif ($action === 'delete') {
            $del_id = (int)($_POST['id'] ?? 0);
            try {
                $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
                $stmt->execute([$del_id]);
                $message = "Project #{$del_id} deleted successfully.";
            } catch (Exception $e) {
                $error = "Delete failed: " . $e->getMessage();
            }
        }

        // 2b. Purge All Projects (Remove dummy / all records)
        elseif ($action === 'delete_all') {
            try {
                $db->exec("TRUNCATE TABLE projects");
                $message = "All projects removed successfully. Showcase is now clean.";
            } catch (Exception $e) {
                $error = "Failed to clear projects: " . $e->getMessage();
            }
        }

        // 3. Create or Update Project
        elseif ($action === 'create' || $action === 'update') {
            $title = trim($_POST['title'] ?? '');
            $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
            $client_name = trim($_POST['client_name'] ?? '');
            $category = trim($_POST['category'] ?? 'web');
            $tag_label = trim($_POST['tag_label'] ?? 'Production Architecture');
            $description = trim($_POST['description'] ?? '');
            $live_url = trim($_POST['live_url'] ?? '');
            $metric_1_val = trim($_POST['metric_1_val'] ?? '');
            $metric_1_lbl = trim($_POST['metric_1_lbl'] ?? '');
            $metric_2_val = trim($_POST['metric_2_val'] ?? '');
            $metric_2_lbl = trim($_POST['metric_2_lbl'] ?? '');
            $metric_3_val = trim($_POST['metric_3_val'] ?? '');
            $metric_3_lbl = trim($_POST['metric_3_lbl'] ?? '');
            $tech_tags = trim($_POST['tech_tags'] ?? '');
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $display_order = (int)($_POST['display_order'] ?? 0);

            // Handle Cover Image: Upload or Manual URL / Presets
            $image_url = trim($_POST['image_url_existing'] ?? '');

            if (!empty($_POST['preset_asset'])) {
                $image_url = trim($_POST['preset_asset']);
            }

            if (!empty($_POST['image_url_custom'])) {
                $image_url = trim($_POST['image_url_custom']);
            }

            // File Upload takes precedence if provided
            if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['project_image'];
                $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
                $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if (!in_array($file_ext, $allowed_exts)) {
                    $error = 'Invalid image type. Allowed: JPG, PNG, WEBP, SVG, GIF.';
                } elseif ($file['size'] > 10 * 1024 * 1024) {
                    $error = 'Image file exceeds maximum 10MB limit.';
                } else {
                    $new_filename = 'proj_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
                    $target_file = $upload_dir . $new_filename;

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {
                        $image_url = 'uploads/projects/' . $new_filename;
                    } else {
                        $error = 'Failed to save uploaded file. Check directory permissions.';
                    }
                }
            }

            if (empty($title) || empty($description)) {
                $error = 'Project title and description are required.';
            } elseif (empty($error)) {
                try {
                    if ($action === 'create') {
                        $stmt = $db->prepare("INSERT INTO projects (title, slug, client_name, category, tag_label, description, image_url, live_url, metric_1_val, metric_1_lbl, metric_2_val, metric_2_lbl, metric_3_val, metric_3_lbl, tech_tags, is_featured, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                        $stmt->execute([$title, $slug, $client_name, $category, $tag_label, $description, $image_url, $live_url, $metric_1_val, $metric_1_lbl, $metric_2_val, $metric_2_lbl, $metric_3_val, $metric_3_lbl, $tech_tags, $is_featured, $display_order]);
                        $message = "Project '{$title}' created successfully.";
                    } elseif ($action === 'update') {
                        $proj_id = (int)$_POST['id'];
                        $stmt = $db->prepare("UPDATE projects SET title = ?, slug = ?, client_name = ?, category = ?, tag_label = ?, description = ?, image_url = ?, live_url = ?, metric_1_val = ?, metric_1_lbl = ?, metric_2_val = ?, metric_2_lbl = ?, metric_3_val = ?, metric_3_lbl = ?, tech_tags = ?, is_featured = ?, display_order = ? WHERE id = ?");
                        $stmt->execute([$title, $slug, $client_name, $category, $tag_label, $description, $image_url, $live_url, $metric_1_val, $metric_1_lbl, $metric_2_val, $metric_2_lbl, $metric_3_val, $metric_3_lbl, $tech_tags, $is_featured, $display_order, $proj_id]);
                        $message = "Project '{$title}' updated successfully.";
                    }
                } catch (Exception $e) {
                    $error = "Database error: " . $e->getMessage();
                }
            }
        }
    }
}

// Handle GET delete for legacy / direct link safety
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

// Check if editing a specific project
$edit_project = null;
if (isset($_GET['edit']) && $db) {
    $edit_id = (int)$_GET['edit'];
    $e_stmt = $db->prepare("SELECT * FROM projects WHERE id = ? LIMIT 1");
    $e_stmt->execute([$edit_id]);
    $edit_project = $e_stmt->fetch();
}

// Fetch Projects List & Category Counts
$projects_list = [];
$total_count = 0;
$featured_count = 0;
if ($db) {
    try {
        $stmt = $db->query("SELECT * FROM projects ORDER BY display_order ASC, id ASC");
        $projects_list = $stmt->fetchAll();
        $total_count = count($projects_list);
        foreach ($projects_list as $p) {
            if (!empty($p['is_featured'])) $featured_count++;
        }
    } catch (Exception $e) {
        $error = "Could not fetch projects: " . $e->getMessage();
    }
}
?>

<div style="max-width: 1400px; margin: 0 auto;">

  <!-- Alert Notifications -->
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

  <!-- Top Metrics & Quick Link Bar -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 28px;">
    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Total Case Studies</span>
        <div class="admin-stat-icon icon-orange">📁</div>
      </div>
      <div class="admin-stat-val" style="font-size: 26px;"><?= $total_count ?></div>
      <div class="admin-stat-foot">In master database</div>
    </div>

    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Live On Showcase</span>
        <div class="admin-stat-icon icon-emerald">🚀</div>
      </div>
      <div class="admin-stat-val" style="font-size: 26px; color: #059669;"><?= $featured_count ?></div>
      <div class="admin-stat-foot">Visible to public visitors</div>
    </div>

    <div class="admin-stat-card" style="padding: 16px 20px;">
      <div class="admin-stat-head">
        <span class="admin-stat-lbl">Draft / Hidden</span>
        <div class="admin-stat-icon icon-blue">🔒</div>
      </div>
      <div class="admin-stat-val" style="font-size: 26px; color: #64748B;"><?= max(0, $total_count - $featured_count) ?></div>
      <div class="admin-stat-foot">Work in progress</div>
    </div>

    <div class="admin-stat-card" style="padding: 16px 20px; justify-content: center; background: linear-gradient(135deg, rgba(248,104,0,0.08) 0%, rgba(0,140,216,0.06) 100%);">
      <div style="display: flex; flex-direction: column; gap: 8px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--admin-text-main); text-transform: uppercase;">Public Page Test</span>
        <a href="../projects.php" target="_blank" class="admin-btn admin-btn-primary" style="justify-content: center; font-size: 13px; text-decoration: none;">
          View Public projects.php ↗
        </a>
      </div>
    </div>
  </div>

  <!-- Create / Edit Form Card -->
  <div class="admin-table-card" id="project-editor-card" style="margin-bottom: 32px; border: 1px solid <?= $edit_project ? 'var(--admin-accent)' : 'var(--admin-border)' ?>;">
    <div class="admin-card-header" style="background: <?= $edit_project ? 'rgba(248,104,0,0.04)' : '#FFFFFF' ?>;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 20px;"><?= $edit_project ? '✏️' : '➕' ?></span>
        <div>
          <h3 class="admin-card-title" style="margin-bottom: 2px;">
            <?= $edit_project ? 'Edit Project: ' . e($edit_project['title']) : 'Publish New Reference Project / Case Study' ?>
          </h3>
          <p style="font-size: 12px; color: var(--admin-text-muted); margin: 0;">
            <?= $edit_project ? 'Modify title, cover screenshot, technical metrics, or live demo link' : 'Add a new client software system, web app, CRM, or ERP to your portfolio' ?>
          </p>
        </div>
      </div>

      <?php if ($edit_project): ?>
        <a href="projects.php" class="admin-btn admin-btn-outline admin-btn-sm">✕ Cancel Editing</a>
      <?php endif; ?>
    </div>

    <div style="padding: 28px;">
      <form method="POST" action="projects.php" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="<?= $edit_project ? 'update' : 'create' ?>">
        <?php if ($edit_project): ?>
          <input type="hidden" name="id" value="<?= $edit_project['id'] ?>">
          <input type="hidden" name="image_url_existing" value="<?= e($edit_project['image_url'] ?? '') ?>">
        <?php endif; ?>

        <!-- SEO, AEO & GEO Automated Badge -->
        <div style="background: linear-gradient(135deg, rgba(248,104,0,0.06) 0%, rgba(16,185,129,0.06) 100%); border: 1px solid rgba(248,104,0,0.2); border-radius: 10px; padding: 12px 16px; margin-bottom: 22px; display: flex; align-items: flex-start; gap: 12px;">
          <div style="font-size: 18px; line-height: 1;">⚡</div>
          <div style="font-size: 12px; line-height: 1.5; color: var(--admin-text-main);">
            <strong style="color: #F86800;">Automated SEO, AEO &amp; GEO Active:</strong> Every project added here automatically generates Schema.org <code>SoftwareApplication</code> JSON-LD markup, Google Image Alt tags with brand attribution, and AI-readable portfolio schema for answer engines (Perplexity, SGE, ChatGPT).
          </div>
        </div>

        <!-- Row 1: Title, Client Name, Category, Eyebrow Tag -->
        <div class="admin-grid-4">
          <div>
            <label class="admin-form-label">Project Title *</label>
            <input type="text" name="title" class="admin-input" placeholder="e.g. Enterprise Logistics ERP / Modern E-Commerce Platform" value="<?= e($edit_project['title'] ?? '') ?>" required>
          </div>

          <div>
            <label class="admin-form-label">Client / Organization</label>
            <input type="text" name="client_name" class="admin-input" placeholder="e.g. Mehta Logistics / FintechCore" value="<?= e($edit_project['client_name'] ?? '') ?>">
          </div>

          <div>
            <label class="admin-form-label">Primary Category *</label>
            <select name="category" class="admin-input" style="cursor: pointer;">
              <?php
                $cat_val = $edit_project['category'] ?? 'web';
                $cats = [
                  'web' => 'Web Application',
                  'crm' => 'CRM Platform',
                  'erp' => 'Enterprise ERP',
                  'mobile' => 'Mobile Application',
                  'ecommerce' => 'E-Commerce Store',
                  'custom' => 'Custom Software',
                  'cloud' => 'Hosting & Cloud',
                  'ai' => 'AI Automation',
                  'custom web' => 'Custom Web Platform',
                  'cloud custom' => 'Cloud & Microservices'
                ];
                foreach ($cats as $k => $label):
              ?>
                <option value="<?= $k ?>" <?= ($cat_val === $k) ? 'selected' : '' ?>><?= $label ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="admin-form-label">Tag Badge (Eyebrow)</label>
            <input type="text" name="tag_label" class="admin-input" placeholder="e.g. FinTech Architecture" value="<?= e($edit_project['tag_label'] ?? 'Production Architecture') ?>">
          </div>
        </div>

        <!-- Row 2: Live Demo URL & Project Description -->
        <div class="admin-grid-2">
          <div>
            <label class="admin-form-label">Live Demo / Project URL (Optional)</label>
            <input type="url" name="live_url" class="admin-input" placeholder="https://example.com" value="<?= e($edit_project['live_url'] ?? '') ?>">
            <span style="font-size: 11px; color: var(--admin-text-muted); display: block; margin-top: 4px;">
              Will display a direct "Visit Live ↗" button on public card &amp; modal
            </span>
          </div>

          <div>
            <label class="admin-form-label">Short Description / Problem Solved *</label>
            <textarea name="description" class="admin-input" rows="3" placeholder="Brief technical summary: what does this platform do, what was the throughput or business impact achieved..." required><?= e($edit_project['description'] ?? '') ?></textarea>
          </div>
        </div>

        <!-- Row 3: Image Upload & Preset Assets -->
        <div style="background: #FAF7EE; border: 1px solid var(--admin-border); border-radius: 12px; padding: 20px; margin-bottom: 22px;">
          <label class="admin-form-label" style="margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
            <span>Project Cover Image / Screenshot</span>
            <span style="font-size: 11px; text-transform: none; color: var(--admin-text-muted);">Recommended: 16:9 or 4:3 high-res image (JPG, PNG, WEBP)</span>
          </label>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">
            <!-- File Upload Option -->
            <div>
              <span style="font-size: 12px; font-weight: 600; color: var(--admin-text-main); display: block; margin-bottom: 6px;">Option A: Upload Image File</span>
              <input type="file" name="project_image" accept="image/*" class="admin-input" style="background: #FFFFFF; padding: 8px;">
              <span style="font-size: 11px; color: var(--admin-text-muted); display: block; margin-top: 4px;">Saved securely to <code>uploads/projects/</code></span>
            </div>

            <!-- Preset / URL Option -->
            <div>
              <span style="font-size: 12px; font-weight: 600; color: var(--admin-text-main); display: block; margin-bottom: 6px;">Option B: Select from Studio Assets or Custom Path</span>
              <select name="preset_asset" class="admin-input" style="background: #FFFFFF; margin-bottom: 8px;">
                <option value="">-- Choose from existing studio assets (WebP Optimized) --</option>
                <option value="assets/card_web_apps.webp" <?= (in_array($edit_project['image_url'] ?? '', ['assets/card_web_apps.webp', 'assets/card_web_apps.jpg'])) ? 'selected' : '' ?>>Web Apps Mockup (card_web_apps.webp)</option>
                <option value="assets/card_software_apis.webp" <?= (in_array($edit_project['image_url'] ?? '', ['assets/card_software_apis.webp', 'assets/card_software_apis.jpg'])) ? 'selected' : '' ?>>Software APIs (card_software_apis.webp)</option>
                <option value="assets/card_cloud_devops.webp" <?= (in_array($edit_project['image_url'] ?? '', ['assets/card_cloud_devops.webp', 'assets/card_cloud_devops.jpg'])) ? 'selected' : '' ?>>Cloud &amp; DevOps (card_cloud_devops.webp)</option>
                <option value="assets/card_ai_agents.webp" <?= (in_array($edit_project['image_url'] ?? '', ['assets/card_ai_agents.webp', 'assets/card_ai_agents.jpg'])) ? 'selected' : '' ?>>AI Workspace (card_ai_agents.webp)</option>
                <option value="assets/card_cloud_ai.webp" <?= (in_array($edit_project['image_url'] ?? '', ['assets/card_cloud_ai.webp', 'assets/card_cloud_ai.jpg'])) ? 'selected' : '' ?>>Cloud AI (card_cloud_ai.webp)</option>
                <option value="assets/featured-work.jpg" <?= (($edit_project['image_url'] ?? '') === 'assets/featured-work.jpg') ? 'selected' : '' ?>>Featured Work (featured-work.jpg)</option>
              </select>

              <input type="text" name="image_url_custom" class="admin-input" placeholder="Or enter custom URL/path: https://... or assets/..." value="<?= (!empty($edit_project['image_url']) && !str_starts_with($edit_project['image_url'], 'uploads/')) ? e($edit_project['image_url']) : '' ?>" style="background: #FFFFFF;">
            </div>
          </div>

          <?php if (!empty($edit_project['image_url'])): ?>
            <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--admin-border); display: flex; align-items: center; gap: 14px;">
              <span style="font-size: 12px; font-weight: 600; color: var(--admin-text-muted);">Current Active Image:</span>
              <div style="width: 70px; height: 46px; border-radius: 6px; overflow: hidden; border: 1px solid var(--admin-border); background: #eee;">
                <img src="../<?= e($edit_project['image_url']) ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='../assets/logo.png'">
              </div>
              <code style="font-size: 11px; color: var(--admin-text-main);"><?= e($edit_project['image_url']) ?></code>
            </div>
          <?php endif; ?>
        </div>

        <!-- Row 4: 3 Performance & Architecture Metrics Strip -->
        <div style="background: #FFFFFF; border: 1px solid var(--admin-border); border-radius: 12px; padding: 20px; margin-bottom: 22px;">
          <label class="admin-form-label" style="margin-bottom: 12px;">3 Key Technical / Business Metrics</label>
          <div class="admin-grid-3">
            <!-- Metric 1 -->
            <div style="background: #FAF7EE; padding: 12px 14px; border-radius: 8px; border: 1px solid var(--admin-border);">
              <span style="font-size: 11.5px; font-weight: 700; color: var(--admin-accent); display: block; margin-bottom: 8px;">METRIC 1</span>
              <div style="display: flex; gap: 8px;">
                <input type="text" name="metric_1_val" class="admin-input" placeholder="e.g. 0.12s or 99.9%" value="<?= e($edit_project['metric_1_val'] ?? '') ?>" style="background: #FFFFFF;">
                <input type="text" name="metric_1_lbl" class="admin-input" placeholder="e.g. Global Latency" value="<?= e($edit_project['metric_1_lbl'] ?? '') ?>" style="background: #FFFFFF;">
              </div>
            </div>

            <!-- Metric 2 -->
            <div style="background: #FAF7EE; padding: 12px 14px; border-radius: 8px; border: 1px solid var(--admin-border);">
              <span style="font-size: 11.5px; font-weight: 700; color: #0284C7; display: block; margin-bottom: 8px;">METRIC 2</span>
              <div style="display: flex; gap: 8px;">
                <input type="text" name="metric_2_val" class="admin-input" placeholder="e.g. Real-Time" value="<?= e($edit_project['metric_2_val'] ?? '') ?>" style="background: #FFFFFF;">
                <input type="text" name="metric_2_lbl" class="admin-input" placeholder="e.g. Data Streams" value="<?= e($edit_project['metric_2_lbl'] ?? '') ?>" style="background: #FFFFFF;">
              </div>
            </div>

            <!-- Metric 3 -->
            <div style="background: #FAF7EE; padding: 12px 14px; border-radius: 8px; border: 1px solid var(--admin-border);">
              <span style="font-size: 11.5px; font-weight: 700; color: #059669; display: block; margin-bottom: 8px;">METRIC 3</span>
              <div style="display: flex; gap: 8px;">
                <input type="text" name="metric_3_val" class="admin-input" placeholder="e.g. 100%" value="<?= e($edit_project['metric_3_val'] ?? '') ?>" style="background: #FFFFFF;">
                <input type="text" name="metric_3_lbl" class="admin-input" placeholder="e.g. Code Owned" value="<?= e($edit_project['metric_3_lbl'] ?? '') ?>" style="background: #FFFFFF;">
              </div>
            </div>
          </div>
        </div>

        <!-- Row 5: Technologies, Order, Featured Toggle & Submit -->
        <div class="admin-grid-bottom">
          <div>
            <label class="admin-form-label">Technologies (Comma-separated pills)</label>
            <input type="text" name="tech_tags" class="admin-input" placeholder="e.g. React 19, PHP 8.3, MySQL, Redis, TailwindCSS, Docker" value="<?= e($edit_project['tech_tags'] ?? '') ?>">
          </div>

          <div>
            <label class="admin-form-label">Order</label>
            <input type="number" name="display_order" class="admin-input" value="<?= (int)($edit_project['display_order'] ?? 0) ?>" min="0">
          </div>

          <div style="padding-bottom: 10px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: var(--admin-text-main);">
              <input type="checkbox" name="is_featured" value="1" <?= (!isset($edit_project) || !empty($edit_project['is_featured'])) ? 'checked' : '' ?> style="width: 20px; height: 20px; accent-color: var(--admin-accent);">
              Showcase on Public Site
            </label>
          </div>

          <div>
            <button type="submit" class="admin-btn admin-btn-primary" style="padding: 12px 28px; font-size: 14px;">
              <?= $edit_project ? '✓ Update Project' : '+ Publish Showcase Project' ?>
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- Published Projects List Table Card -->
  <div class="admin-table-card">
    <div class="admin-card-header">
      <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
        <h3 class="admin-card-title">All Showcase Projects (<?= count($projects_list) ?>)</h3>
        <input type="text" id="projectSearchInput" placeholder="Filter projects by title, category, or tech..." class="admin-input" style="width: 320px; padding: 6px 14px; font-size: 13px;">
        <?php if (!empty($projects_list)): ?>
          <form method="POST" action="projects.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete ALL showcase projects? This cannot be undone.');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="delete_all">
            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" style="font-size: 11.5px; padding: 6px 12px;">
              ✕ Delete All Projects
            </button>
          </form>
        <?php endif; ?>
      </div>

      <span style="font-size: 12px; color: var(--admin-text-muted);">
        Rendered live on <code>projects.php</code>
      </span>
    </div>

    <div class="admin-table-wrap">
      <table class="admin-table" id="projectsTable">
        <thead>
          <tr>
            <th style="width: 60px;">Cover</th>
            <th>Project Title &amp; Client</th>
            <th>Category</th>
            <th>Metrics Preview</th>
            <th>Tech Stack</th>
            <th style="text-align: center;">Showcase</th>
            <th style="width: 80px; text-align: center;">Order</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($projects_list)): ?>
            <?php foreach ($projects_list as $p): ?>
              <tr class="project-table-row" data-search="<?= strtolower(e($p['title'] . ' ' . ($p['client_name'] ?? '') . ' ' . $p['category'] . ' ' . $p['tech_tags'])) ?>">
                <!-- Thumbnail -->
                <td>
                  <div style="width: 54px; height: 40px; border-radius: 6px; overflow: hidden; background: #FAF7EE; border: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: center;">
                    <?php if (!empty($p['image_url'])): ?>
                      <img src="../<?= e($p['image_url']) ?>" alt="Thumb" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                      <span style="display:none; font-size: 18px;">💻</span>
                    <?php else: ?>
                      <span style="font-size: 18px;">💻</span>
                    <?php endif; ?>
                  </div>
                </td>

                <!-- Title & Client -->
                <td>
                  <span class="status-pill status-contacted" style="font-size: 9.5px; padding: 2px 7px; margin-bottom: 4px;"><?= e($p['tag_label']) ?></span>
                  <br>
                  <strong style="color: var(--admin-text-main); font-size: 14.5px;"><?= e($p['title']) ?></strong>
                  <?php if (!empty($p['client_name'])): ?>
                    <span style="font-size: 12px; color: var(--admin-text-muted); display: block;">Client: <?= e($p['client_name']) ?></span>
                  <?php endif; ?>
                  <?php if (!empty($p['live_url'])): ?>
                    <a href="<?= e($p['live_url']) ?>" target="_blank" style="font-size: 11.5px; color: var(--admin-accent); text-decoration: none; display: inline-flex; align-items: center; gap: 3px; margin-top: 2px;">
                      Live Demo ↗
                    </a>
                  <?php endif; ?>
                </td>

                <!-- Category -->
                <td>
                  <span class="status-pill status-in_progress" style="font-size: 10px;">
                    <?= strtoupper(e($p['category'])) ?>
                  </span>
                </td>

                <!-- Metrics -->
                <td style="font-family: var(--admin-font-mono); font-size: 12px;">
                  <?php if (!empty($p['metric_1_val'])): ?>
                    <strong><?= e($p['metric_1_val']) ?></strong> <span style="font-size: 10px; color: var(--admin-text-muted);"><?= e($p['metric_1_lbl']) ?></span><br>
                  <?php endif; ?>
                  <?php if (!empty($p['metric_2_val'])): ?>
                    <span style="color: #64748B; font-size: 11px;"><?= e($p['metric_2_val']) ?> (<?= e($p['metric_2_lbl']) ?>)</span>
                  <?php endif; ?>
                </td>

                <!-- Tech Tags -->
                <td style="font-size: 12px; max-width: 220px; color: var(--admin-text-muted);">
                  <?= e($p['tech_tags']) ?>
                </td>

                <!-- Toggle Featured -->
                <td style="text-align: center;">
                  <form method="POST" action="projects.php" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="toggle_featured">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="featured" value="<?= $p['is_featured'] ?>">
                    <button type="submit" title="Click to toggle showcase visibility" style="background: none; border: none; cursor: pointer; padding: 0;">
                      <?= $p['is_featured'] ? '<span class="status-pill status-converted" style="cursor: pointer;">✓ Visible</span>' : '<span class="status-pill status-archived" style="cursor: pointer;">Draft</span>' ?>
                    </button>
                  </form>
                </td>

                <!-- Display Order -->
                <td style="text-align: center; font-family: var(--admin-font-mono); font-size: 12px;">
                  <?= (int)$p['display_order'] ?>
                </td>

                <!-- Actions -->
                <td style="text-align: right;">
                  <div style="display: inline-flex; gap: 6px;">
                    <a href="projects.php?edit=<?= $p['id'] ?>#project-editor-card" class="admin-btn admin-btn-outline admin-btn-sm" title="Edit Project">
                      Edit
                    </a>

                    <form method="POST" action="projects.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= $p['id'] ?>">
                      <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete Project">
                        ✕
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                <?php if (is_db_connected()): ?>
                  No projects currently in database. Use the form above to add your first client showcase project!
                <?php else: ?>
                  Database offline. Please check your MySQL credentials or import <code>database.sql</code> into phpMyAdmin.
                <?php endif; ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
// Live Table Filter by Keyword
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('projectSearchInput');
  const rows = document.querySelectorAll('.project-table-row');

  if (searchInput && rows.length) {
    searchInput.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      rows.forEach(r => {
        const text = r.dataset.search || '';
        r.style.display = (q === '' || text.includes(q)) ? '' : 'none';
      });
    });
  }
});
</script>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
