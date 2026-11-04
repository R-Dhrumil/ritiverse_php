<?php
/**
 * RiTiVerse — Master Standalone Project & Case Study Page
 * Deep-dive architectural breakdown, challenge-solution analysis, telemetry metrics & inquiry CTA.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/projects_helper.php';

// Determine requested project slug or ID
$target_slug = $project_slug ?? ($_GET['slug'] ?? ($_GET['id'] ?? ''));

if (empty($target_slug)) {
    header('Location: ' . SITE_URL . '/projects.php');
    exit;
}

$project = $project ?? get_project_by_slug_or_id($target_slug);

// If project not found, redirect to projects index
if (!$project) {
    header('HTTP/1.1 404 Not Found');
    $page_title = 'Project Not Found | ' . APP_NAME;
    require_once __DIR__ . '/includes/header.php';
    ?>
    <main class="subpage-hero" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center;">
      <div class="subpage-hero-container">
        <span class="subpage-badge">404 Case Study Notice</span>
        <h1 class="subpage-title" style="margin-top: 14px;">Project Architecture Not Found</h1>
        <p class="subpage-subtitle" style="margin-bottom: 28px;">
          The requested project reference architecture may be under NDA or moved.
        </p>
        <a href="projects.php" class="btn-primary">Browse All Client Case Studies ↗</a>
      </div>
    </main>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Meta & Page Configuration
$page_title = e($project['title']) . ' — Client Case Study & Architecture | ' . APP_NAME;
$page_description = e($project['description']);
$current_page = 'projects';
$canonical_url = SITE_URL . '/project/' . urlencode($project['slug']);
$custom_canonical_url = $canonical_url;
$extra_css = ['css/project-detail.css'];

// Structured data helpers
$client_name = !empty($project['client_name']) ? $project['client_name'] : 'Enterprise Client (NDA Protected)';
$client_industry = !empty($project['client_industry']) ? $project['client_industry'] : 'Enterprise Technology';
$project_duration = !empty($project['project_duration']) ? $project['project_duration'] : 'Production Sprint';
$category_raw = strtolower($project['category'] ?? 'web');
$cover_image = !empty($project['image_url']) ? $project['image_url'] : 'assets/card_web_apps.webp';
$cover_image_full = (strpos($cover_image, 'http') === 0) ? $cover_image : (SITE_URL . '/' . ltrim($cover_image, '/'));
$live_url = !empty($project['live_url']) ? $project['live_url'] : '';

// Parse lists
$tech_tags = array_filter(array_map('trim', explode(',', $project['tech_tags'] ?? '')));
$key_features = array_filter(array_map('trim', explode("\n", $project['key_features'] ?? '')));
$gallery_images = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $project['gallery_images'] ?? '')));

// Adjacent projects for bottom navigation
$adjacent = get_adjacent_projects($project['id']);

require_once __DIR__ . '/includes/header.php';
?>

  <!-- Main Case Study Content -->
  <article class="case-detail-page">

    <!-- Top Sticky / Contextual Breadcrumb Bar -->
    <section class="case-meta-topbar">
      <div class="case-container">
        <nav class="case-breadcrumb" aria-label="Breadcrumb">
          <a href="<?= SITE_URL ?>/">Home</a>
          <span class="case-breadcrumb-sep">/</span>
          <a href="<?= SITE_URL ?>/projects.php">Projects &amp; Case Studies</a>
          <span class="case-breadcrumb-sep">/</span>
          <span class="case-breadcrumb-current"><?= e($project['title']) ?></span>
        </nav>
      </div>
    </section>

    <!-- Case Study Hero Header -->
    <header class="case-hero-section">
      <div class="case-container">
        <div class="case-hero-header">
          <div class="case-hero-tags">
            <span class="case-tag-pill"><?= e($project['tag_label']) ?></span>
            <span class="status-pill status-in_progress"><?= strtoupper(e($category_raw)) ?></span>
            <span class="case-ownership-pill">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
              100% Code Ownership
            </span>
          </div>

          <h1 class="case-hero-title"><?= e($project['title']) ?></h1>

          <p class="case-hero-subtitle">
            <?= e($project['description']) ?>
          </p>

          <!-- Executive Project Meta Strip -->
          <div class="case-info-strip">
            <div class="case-info-item">
              <span class="case-info-label">Client / Partner</span>
              <strong class="case-info-val"><?= e($client_name) ?></strong>
            </div>

            <div class="case-info-item">
              <span class="case-info-label">Industry Domain</span>
              <strong class="case-info-val"><?= e($client_industry) ?></strong>
            </div>

            <div class="case-info-item">
              <span class="case-info-label">Delivery Timeline</span>
              <strong class="case-info-val"><?= e($project_duration) ?></strong>
            </div>

            <div class="case-info-item">
              <span class="case-info-label">Source Rights</span>
              <strong class="case-info-val" style="color: #059669;">Full Repository Handover</strong>
            </div>

            <div class="case-info-actions">
              <?php if (!empty($live_url)): ?>
                <a href="<?= e($live_url) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary" style="padding: 10px 20px; font-size: 13.5px;">
                  <span>Visit Live Platform</span>
                  <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                  </svg>
                </a>
              <?php endif; ?>

              <a href="<?= SITE_URL ?>/contact.php?scope=<?= urlencode(explode(' ', $category_raw)[0]) ?>&project=<?= urlencode($project['title']) ?>" class="btn-secondary" style="padding: 10px 18px; font-size: 13.5px;">
                <span>Request Similar Stack</span>
                <span style="font-size: 14px;">↗</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Hero Visual Showcase -->
        <div class="case-hero-visual">
          <div class="case-visual-frame">
            <img src="<?= e($cover_image_full) ?>" alt="<?= e($project['title']) ?> System Architecture Cover — Engineered by RiTiVerse" class="case-visual-img" onerror="this.onerror=null; this.src='<?= SITE_URL ?>/assets/card_web_apps.webp';">
            <div class="case-visual-overlay"></div>
          </div>

          <!-- 3 Architectural / Business Metrics Strip -->
          <?php if (!empty($project['metric_1_val']) || !empty($project['metric_2_val']) || !empty($project['metric_3_val'])): ?>
            <div class="case-telemetry-banner">
              <?php if (!empty($project['metric_1_val'])): ?>
                <div class="case-telemetry-box">
                  <span class="case-telemetry-number"><?= e($project['metric_1_val']) ?></span>
                  <span class="case-telemetry-label"><?= e($project['metric_1_lbl']) ?></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($project['metric_2_val'])): ?>
                <div class="case-telemetry-box">
                  <span class="case-telemetry-number"><?= e($project['metric_2_val']) ?></span>
                  <span class="case-telemetry-label"><?= e($project['metric_2_lbl']) ?></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($project['metric_3_val'])): ?>
                <div class="case-telemetry-box">
                  <span class="case-telemetry-number"><?= e($project['metric_3_val']) ?></span>
                  <span class="case-telemetry-label"><?= e($project['metric_3_lbl']) ?></span>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </header>

    <!-- Deep-Dive Section: Problem vs Engineering Solution -->
    <section class="case-section case-narrative-section">
      <div class="case-container">
        <div class="case-split-grid">

          <!-- The Challenge Card -->
          <div class="case-card-panel challenge-panel">
            <div class="case-panel-header">
              <span class="case-icon-badge challenge-badge">⚠️</span>
              <div>
                <span class="case-eyebrow-mini">The Bottleneck</span>
                <h2 class="case-panel-title">The Client Challenge</h2>
              </div>
            </div>
            <div class="case-panel-body">
              <?php if (!empty($project['challenge'])): ?>
                <p><?= nl2br(e($project['challenge'])) ?></p>
              <?php else: ?>
                <p>
                  Before engaging RiTiVerse, the organization relied on disparate legacy tools and generic SaaS software that lacked integration, incurred steep recurring license fees, and could not scale with surging transaction volumes. Crucial business logic was locked inside proprietary agency environments.
                </p>
                <ul class="case-bullet-list">
                  <li>High monthly licensing and per-user subscription fees with zero code control.</li>
                  <li>Inability to customize critical business workflows to match operational requirements.</li>
                  <li>Severe throughput slowdowns and data fragmentation across multi-department systems.</li>
                </ul>
              <?php endif; ?>
            </div>
          </div>

          <!-- The Solution Card -->
          <div class="case-card-panel solution-panel">
            <div class="case-panel-header">
              <span class="case-icon-badge solution-badge">⚡</span>
              <div>
                <span class="case-eyebrow-mini">The Architecture</span>
                <h2 class="case-panel-title">Engineering Solution</h2>
              </div>
            </div>
            <div class="case-panel-body">
              <?php if (!empty($project['solution'])): ?>
                <p><?= nl2br(e($project['solution'])) ?></p>
              <?php else: ?>
                <p>
                  RiTiVerse architected a modern, bespoke platform tailored strictly to the client's specifications. Built on open industry standards with zero vendor lock-in, the system decouples critical business workflows into high-speed modules backed by indexed relational data stores and optimized API endpoints.
                </p>
                <ul class="case-bullet-list">
                  <li>100% Full source code handover pushed directly to private client repositories.</li>
                  <li>Sub-second query latencies through relational indexing, redis caching, and async pipelines.</li>
                  <li>Hardened RBAC security, audit logging, and DPDP Act 2023 compliance built into core tables.</li>
                </ul>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Core Capabilities & Feature Highlights Grid -->
    <section class="case-section case-features-section">
      <div class="case-container">
        <div class="section-badge-header">
          <span class="section-eyebrow">
            <span class="section-eyebrow-dot"></span>
            System Modules
          </span>
          <h2 class="section-title">Core Architecture Capabilities</h2>
          <p class="section-subtitle">
            Engineered for reliability, zero downtime, and end-user efficiency.
          </p>
        </div>

        <div class="case-features-grid">
          <?php if (!empty($key_features)): ?>
            <?php foreach ($key_features as $idx => $feat): 
              $icons = ['📦', '🔐', '⚡', '📊', '🌐', '🛡️', '⚙️', '📱'];
              $icon = $icons[$idx % count($icons)];
            ?>
              <div class="case-feature-card">
                <span class="case-feature-icon"><?= $icon ?></span>
                <div class="case-feature-text">
                  <h3 class="case-feature-title"><?= e($feat) ?></h3>
                  <p class="case-feature-desc">Engineered for production scale with automated failover and zero recurring vendor license dependencies.</p>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <!-- Default Core Architecture Highlights -->
            <div class="case-feature-card">
              <span class="case-feature-icon">⚡</span>
              <div class="case-feature-text">
                <h3 class="case-feature-title">Sub-Second Core Engine</h3>
                <p class="case-feature-desc">Ultra-fast response times through optimized server queries, schema indexes, and lightweight frontend bundles.</p>
              </div>
            </div>

            <div class="case-feature-card">
              <span class="case-feature-icon">🔐</span>
              <div class="case-feature-text">
                <h3 class="case-feature-title">Role-Based Access Control (RBAC)</h3>
                <p class="case-feature-desc">Fine-grained permissions and comprehensive audit trail logging across administrator and team roles.</p>
              </div>
            </div>

            <div class="case-feature-card">
              <span class="case-feature-icon">📊</span>
              <div class="case-feature-text">
                <h3 class="case-feature-title">Live Telemetry &amp; Reporting</h3>
                <p class="case-feature-desc">Instant business intelligence dashboards with automated exportable reports and real-time alerts.</p>
              </div>
            </div>

            <div class="case-feature-card">
              <span class="case-feature-icon">🛡️</span>
              <div class="case-feature-text">
                <h3 class="case-feature-title">100% Source Rights Handover</h3>
                <p class="case-feature-desc">All migrations, documentation, and CI/CD scripts transferred with zero monthly platform hostage fees.</p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Technology Stack Breakdown Section -->
    <section class="case-section case-tech-section">
      <div class="case-container">
        <div class="case-tech-container">
          <div class="case-tech-header">
            <span class="case-eyebrow-mini">Engineering Standards</span>
            <h2 class="case-panel-title">Production Technology Stack</h2>
            <p style="color: var(--color-text-secondary, #5a5347); font-size: 14.5px; margin: 0; line-height: 1.6;">
              RiTiVerse builds strictly on battle-tested open standards. We avoid proprietary site-builders or closed CMS plugins that cause vendor lock-in.
            </p>
          </div>

          <div class="case-tech-pills-wrap">
            <?php if (!empty($tech_tags)): ?>
              <?php foreach ($tech_tags as $t): ?>
                <span class="case-tech-tag-chip">
                  <span class="case-tech-chip-dot"></span>
                  <?= e($t) ?>
                </span>
              <?php endforeach; ?>
            <?php else: ?>
              <span class="case-tech-tag-chip"><span class="case-tech-chip-dot"></span>PHP 8.3</span>
              <span class="case-tech-tag-chip"><span class="case-tech-chip-dot"></span>React 19</span>
              <span class="case-tech-tag-chip"><span class="case-tech-chip-dot"></span>MySQL Relational</span>
              <span class="case-tech-tag-chip"><span class="case-tech-chip-dot"></span>RESTful APIs</span>
              <span class="case-tech-tag-chip"><span class="case-tech-chip-dot"></span>Docker Containers</span>
              <span class="case-tech-tag-chip"><span class="case-tech-chip-dot"></span>TailwindCSS</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Additional Gallery / Screenshot Showcase (if available) -->
    <?php if (!empty($gallery_images)): ?>
      <section class="case-section case-gallery-section">
        <div class="case-container">
          <div class="section-badge-header">
            <span class="section-eyebrow">
              <span class="section-eyebrow-dot"></span>
              Visual Workflows
            </span>
            <h2 class="section-title">Platform Screenshots &amp; Dashboards</h2>
            <p class="section-subtitle">Real production user interfaces and operational views.</p>
          </div>

          <div class="case-gallery-grid">
            <?php foreach ($gallery_images as $img): 
              $full_img = (strpos($img, 'http') === 0) ? $img : (SITE_URL . '/' . ltrim($img, '/'));
            ?>
              <div class="case-gallery-item">
                <img src="<?= e($full_img) ?>" alt="Interface Workflow Screenshot" loading="lazy" class="case-gallery-img">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- Business Outcomes & Measurable Impact -->
    <section class="case-section case-impact-section">
      <div class="case-container">
        <div class="case-impact-banner">
          <div class="case-impact-badge">
            <span class="case-badge-dot"></span>
            Measurable Client Impact
          </div>
          <h2 class="case-impact-title">Real Business Results Delivered</h2>
          <p class="case-impact-desc">
            <?php if (!empty($project['impact_summary'])): ?>
              <?= nl2br(e($project['impact_summary'])) ?>
            <?php else: ?>
              By migrating from high-cost vendor SaaS tools to a custom-engineered RiTiVerse solution, the client eliminated recurring software license expenses, reduced dispatch turnaround latency by over 60%, and secured permanent intellectual property rights for their technology stack.
            <?php endif; ?>
          </p>

          <div class="case-impact-highlights">
            <div class="case-impact-point">
              <span class="case-impact-check">✓</span>
              <span>100% Intellectual Property &amp; Code Ownership</span>
            </div>
            <div class="case-impact-point">
              <span class="case-impact-check">✓</span>
              <span>Zero Mandatory Agency Retainers</span>
            </div>
            <div class="case-impact-point">
              <span class="case-impact-check">✓</span>
              <span>30-Day Post-Launch Warranty Included</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Adjacent Case Studies Navigation -->
    <section class="case-nav-section">
      <div class="case-container">
        <div class="case-adjacent-grid">
          <?php if (!empty($adjacent['prev'])): ?>
            <a href="<?= SITE_URL ?>/project/<?= urlencode($adjacent['prev']['slug']) ?>" class="case-nav-card prev-card">
              <span class="case-nav-direction">← Previous Case Study</span>
              <strong class="case-nav-title"><?= e($adjacent['prev']['title']) ?></strong>
              <span class="case-nav-category"><?= strtoupper(e($adjacent['prev']['category'])) ?></span>
            </a>
          <?php else: ?>
            <a href="<?= SITE_URL ?>/projects.php" class="case-nav-card prev-card">
              <span class="case-nav-direction">← Case Studies Directory</span>
              <strong class="case-nav-title">All RiTiVerse Projects</strong>
              <span class="case-nav-category">OVERVIEW</span>
            </a>
          <?php endif; ?>

          <?php if (!empty($adjacent['next'])): ?>
            <a href="<?= SITE_URL ?>/project/<?= urlencode($adjacent['next']['slug']) ?>" class="case-nav-card next-card">
              <span class="case-nav-direction">Next Case Study →</span>
              <strong class="case-nav-title"><?= e($adjacent['next']['title']) ?></strong>
              <span class="case-nav-category"><?= strtoupper(e($adjacent['next']['category'])) ?></span>
            </a>
          <?php else: ?>
            <a href="<?= SITE_URL ?>/projects.php" class="case-nav-card next-card">
              <span class="case-nav-direction">Case Studies Directory →</span>
              <strong class="case-nav-title">Explore All Reference Architectures</strong>
              <span class="case-nav-category">OVERVIEW</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Bottom Scoped Consultation CTA Banner -->
    <section class="case-section" style="padding-top: 0; padding-bottom: 70px;">
      <div class="case-container">
        <div class="case-cta-banner">
          <span class="subpage-badge">Zero Vendor Lock-In • 24hr Turnaround Estimate</span>
          <h2 class="case-cta-title">
            Need an Engineered Platform Like This Built?
          </h2>
          <p class="case-cta-subtitle">
            Speak directly with our senior full-stack architects in Vadodara. We will review your technical requirements, provide milestone roadmaps, and build your system with 100% legal source code ownership.
          </p>
          <div class="case-cta-buttons">
            <a href="<?= SITE_URL ?>/contact.php?scope=<?= urlencode(explode(' ', $category_raw)[0]) ?>&project=<?= urlencode($project['title']) ?>" class="btn-primary" style="padding: 13px 28px; font-size: 14.5px;">
              <span>Schedule Architecture Consultation</span>
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
            <a href="<?= SITE_URL ?>/projects.php" class="btn-secondary" style="padding: 13px 24px; font-size: 14.5px;">
              <span>Browse All Case Studies</span>
            </a>
          </div>
        </div>
      </div>
    </section>

  </article>

<?php
// Dynamic SEO Schemas: BreadcrumbList + SoftwareApplication / TechArticle
$breadcrumb_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => SITE_URL . '/'
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Projects & Case Studies',
            'item' => SITE_URL . '/projects.php'
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $project['title'],
            'item' => $canonical_url
        ]
    ]
];

$article_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    'headline' => $project['title'] . ' — Client Case Study & Architecture',
    'description' => $project['description'],
    'image' => $cover_image_full,
    'url' => $canonical_url,
    'datePublished' => !empty($project['created_at']) ? substr($project['created_at'], 0, 10) : '2026-10-31',
    'dateModified' => !empty($project['updated_at']) ? substr($project['updated_at'], 0, 10) : date('Y-m-d'),
    'author' => [
        '@type' => 'Organization',
        'name' => 'RiTiVerse',
        'url' => 'https://ritiverse.in'
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'RiTiVerse',
        'url' => 'https://ritiverse.in',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => SITE_URL . '/assets/logo.png'
        ]
    ],
    'keywords' => $project['tech_tags'] ?? ''
];
?>
<script type="application/ld+json"><?= json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<script type="application/ld+json"><?= json_encode($article_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>

<?php
$show_footer_cta = false; // Page has its own custom scoped CTA
require_once __DIR__ . '/includes/footer.php';
?>
