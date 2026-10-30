<?php
/**
 * RiTiVerse — Projects & Client Reference Architectures
 * Showcase of production software engines, custom websites, CRM, ERP, and mobile systems
 */
$page_title = 'Projects & Case Studies — Web, CRM & ERP Software Built in Vadodara | RiTiVerse';
$page_description = 'See real-world websites, CRM platforms, ERP systems, and mobile apps built by RiTiVerse in Vadodara with 100% source code ownership. No vendor lock-in.';
$current_page = 'projects';
$extra_css = ['css/projects.css'];
$seo_keywords = 'software development projects Vadodara, CRM ERP development case studies India, website development portfolio Vadodara Gujarat, RiTiVerse projects';

require_once __DIR__ . '/includes/header.php';

$db = get_db();
$db_projects = [];

if ($db) {
    try {
        $stmt = $db->query("SELECT * FROM projects WHERE is_featured = 1 ORDER BY display_order ASC, id ASC");
        $db_projects = $stmt->fetchAll();
    } catch (Exception $e) {
        $db_projects = [];
    }
}

// No dummy fallback — real projects are loaded from database or managed in admin
$has_projects = !empty($db_projects);
?>

  <!-- Subpage Hero Section -->
  <main class="subpage-hero">
    <div class="subpage-hero-container">
      <div class="subpage-badge">
        <span class="subpage-badge-dot"></span>
        Production Reference Architectures &amp; Client Deliveries
      </div>
      <h1 class="subpage-title">
        Engineered Systems.<br>
        <span class="accent-text">Real Client Case Studies.</span>
      </h1>
      <p class="subpage-subtitle">
        Explore bespoke websites, enterprise CRM &amp; ERP platforms, mobile apps, and distributed cloud systems architected by
        RiTiVerse—delivered with 100% full source ownership and zero vendor lock-in.
      </p>

      <?php if ($has_projects): ?>
      <!-- Search & Category Controls -->
      <div class="projects-controls-container">
        <!-- Live Search Bar -->
        <div class="projects-search-bar">
          <span class="projects-search-icon">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </span>
          <input type="text" id="projectSearch" class="projects-search-input" placeholder="Search projects by title, industry, or tech (React, PHP, Node)..." aria-label="Search projects">
          <button id="projectSearchClear" class="projects-search-clear" aria-label="Clear search">✕</button>
        </div>

        <!-- Category Filter Pills -->
        <div class="projects-filter-bar">
          <button class="project-filter-btn active" data-filter="all">
            All Projects <span class="filter-count"><?= count($db_projects) ?></span>
          </button>
          <button class="project-filter-btn" data-filter="web">
            Web Applications <span class="filter-count">0</span>
          </button>
          <button class="project-filter-btn" data-filter="crm-erp">
            CRM &amp; ERP <span class="filter-count">0</span>
          </button>
          <button class="project-filter-btn" data-filter="custom">
            Custom Software <span class="filter-count">0</span>
          </button>
          <button class="project-filter-btn" data-filter="cloud">
            Cloud &amp; DevOps <span class="filter-count">0</span>
          </button>
          <button class="project-filter-btn" data-filter="ai">
            AI Automation <span class="filter-count">0</span>
          </button>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Projects Grid / Curation Section -->
  <section class="subpage-section">
    <div class="subpage-container">
      <?php if ($has_projects): ?>
        <div class="projects-grid" id="projectsGrid">

          <?php foreach ($db_projects as $proj): 
            $category = strtolower($proj['category'] ?? 'web');
            $cover_image = !empty($proj['image_url']) ? $proj['image_url'] : 'assets/card_web_apps.jpg';
            $client_name = !empty($proj['client_name']) ? $proj['client_name'] : '';
            $live_url = !empty($proj['live_url']) ? $proj['live_url'] : '';
            $search_data = strtolower($proj['title'] . ' ' . $client_name . ' ' . $category . ' ' . $proj['tag_label'] . ' ' . $proj['tech_tags'] . ' ' . $proj['description']);
          ?>
            <article class="case-study-card" 
              data-id="<?= $proj['id'] ?>"
              data-category="<?= e($category) ?>"
              data-title="<?= e($proj['title']) ?>"
              data-client="<?= e($client_name) ?>"
              data-tag="<?= e($proj['tag_label']) ?>"
              data-image="<?= e($cover_image) ?>"
              data-desc="<?= e($proj['description']) ?>"
              data-live="<?= e($live_url) ?>"
              data-m1-val="<?= e($proj['metric_1_val']) ?>"
              data-m1-lbl="<?= e($proj['metric_1_lbl']) ?>"
              data-m2-val="<?= e($proj['metric_2_val']) ?>"
              data-m2-lbl="<?= e($proj['metric_2_lbl']) ?>"
              data-m3-val="<?= e($proj['metric_3_val']) ?>"
              data-m3-lbl="<?= e($proj['metric_3_lbl']) ?>"
              data-tech="<?= e($proj['tech_tags']) ?>"
              data-search="<?= e($search_data) ?>">
              
              <!-- Visual Hero Cover with Image & Badges -->
              <div class="case-card-hero">
                <span class="case-tag-pill"><?= e($proj['tag_label']) ?></span>
                
                <?php if (!empty($client_name)): ?>
                  <span class="case-client-badge">Client: <?= e($client_name) ?></span>
                <?php endif; ?>

                <img src="<?= e($cover_image) ?>" alt="<?= e($proj['title']) ?>" class="case-card-cover-img" loading="lazy" onerror="this.onerror=null; this.src='assets/card_web_apps.jpg';">
                <div class="case-card-hero-overlay"></div>
              </div>

              <!-- Card Body -->
              <div class="case-card-body">
                <div>
                  <h2 class="case-card-title"><?= e($proj['title']) ?></h2>
                  <p class="case-card-desc"><?= e($proj['description']) ?></p>
                </div>

                <div>
                  <!-- Key Architecture Metrics -->
                  <div class="case-metrics-strip">
                    <?php if (!empty($proj['metric_1_val'])): ?>
                    <div class="case-metric-box">
                      <span class="case-metric-val"><?= e($proj['metric_1_val']) ?></span>
                      <span class="case-metric-lbl"><?= e($proj['metric_1_lbl']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($proj['metric_2_val'])): ?>
                    <div class="case-metric-box">
                      <span class="case-metric-val"><?= e($proj['metric_2_val']) ?></span>
                      <span class="case-metric-lbl"><?= e($proj['metric_2_lbl']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($proj['metric_3_val'])): ?>
                    <div class="case-metric-box">
                      <span class="case-metric-val"><?= e($proj['metric_3_val']) ?></span>
                      <span class="case-metric-lbl"><?= e($proj['metric_3_lbl']) ?></span>
                    </div>
                    <?php endif; ?>
                  </div>

                  <!-- Technology Pills -->
                  <div class="case-tech-tags">
                    <?php foreach (explode(',', $proj['tech_tags']) as $tag): ?>
                      <?php if (trim($tag)): ?>
                        <span class="case-tech-pill"><?= e(trim($tag)) ?></span>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>

                  <!-- Action Strip: Quick View & Live Demo -->
                  <div class="case-card-actions">
                    <button type="button" class="case-btn-secondary open-case-modal-btn">
                      <span>Explore Architecture</span>
                      <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"></path>
                        <path d="M12 5l7 7-7 7"></path>
                      </svg>
                    </button>

                    <?php if (!empty($live_url)): ?>
                      <a href="<?= e($live_url) ?>" target="_blank" rel="noopener noreferrer" class="case-btn-primary">
                        <span>Visit Live</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                          <polyline points="15 3 21 3 21 9"></polyline>
                          <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                      </a>
                    <?php else: ?>
                      <a href="contact.php?scope=<?= urlencode(explode(' ', $category)[0]) ?>&project=<?= urlencode($proj['title']) ?>" class="case-btn-primary">
                        <span>Request Build</span>
                        <span style="font-size: 14px;">↗</span>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

            </article>
          <?php endforeach; ?>

          <!-- Empty Filter State -->
          <div class="projects-empty-state" id="projectsEmptyState">
            <div class="projects-empty-icon">🔍</div>
            <h3 class="projects-empty-title">No matching reference projects found</h3>
            <p class="projects-empty-desc">
              Try adjusting your search keywords or explore another engineering category above.
            </p>
            <button type="button" class="btn-primary" id="resetFiltersBtn" style="padding: 9px 22px; font-size: 13px;">
              Reset All Filters
            </button>
          </div>

        </div>

      <?php else: ?>
        <!-- Executive Portfolio Curation & NDA Notice State -->
        <div class="projects-curation-state">
          <div class="curation-badge">
            <span class="curation-badge-dot"></span>
            Proprietary Client Architecture &amp; NDAs
          </div>

          <h2 class="curation-title">Production Deliveries Under Client NDA</h2>
          <p class="curation-desc">
            At RiTiVerse, every web platform, custom CRM, and enterprise ERP is built with 100% intellectual property transfer and zero vendor lock-in. Because our clients own their complete source code, production repositories and architectures are held under strict non-disclosure agreements.
          </p>

          <div class="curation-grid">
            <div class="curation-card">
              <div class="curation-icon">🛡️</div>
              <h3 class="curation-card-title">100% Client Code Ownership</h3>
              <p class="curation-card-desc">
                No monthly license hostage fees or encrypted files. You receive complete repositories, database schemas, and documentation.
              </p>
            </div>

            <div class="curation-card">
              <div class="curation-icon">⚡</div>
              <h3 class="curation-card-title">Modern Production Stacks</h3>
              <p class="curation-card-desc">
                Enterprise systems engineered on PHP 8, React, Node.js, Next.js, MySQL, and scalable cloud container infrastructure.
              </p>
            </div>

            <div class="curation-card">
              <div class="curation-icon">🤝</div>
              <h3 class="curation-card-title">Private Architecture Demos</h3>
              <p class="curation-card-desc">
                We provide private 1-on-1 walkthroughs and live architecture demonstrations during qualified client discovery calls.
              </p>
            </div>
          </div>

          <div class="curation-actions">
            <a href="contact.php?scope=project-inquiry" class="btn-primary" style="padding: 13px 28px;">
              <span>Schedule Architecture Consultation</span>
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
            <a href="services.php" class="btn-secondary" style="padding: 13px 24px;">
              Explore Engineering Services
            </a>
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
              <a href="admin/projects.php" class="btn-secondary" style="border-color: var(--brand-orange); color: var(--brand-orange); padding: 13px 20px;">
                ⚙️ Add Projects in Admin
              </a>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <?php if ($has_projects): ?>
  <!-- Interactive Case Study Quick View Modal Dialog -->
  <div class="project-modal-backdrop" id="projectModalBackdrop" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="project-modal-dialog">
      <!-- Close Button -->
      <button type="button" class="project-modal-close-btn" id="projectModalClose" aria-label="Close Case Study">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>

      <!-- Modal Hero Image -->
      <div class="project-modal-hero">
        <img id="modalImg" src="assets/card_web_apps.jpg" alt="Case Study Cover" class="project-modal-img">
        <div class="project-modal-hero-overlay"></div>
      </div>

      <!-- Modal Content Body -->
      <div class="project-modal-content">
        <div class="project-modal-header">
          <div class="project-modal-tags">
            <span class="case-tag-pill" id="modalTag" style="position: static;">Production Architecture</span>
            <span class="status-pill status-in_progress" id="modalCategory" style="font-size: 10px;">WEB</span>
          </div>
          <h2 class="project-modal-title" id="modalTitle">Project Title</h2>
          <div class="project-modal-client" id="modalClient">Client: Organization</div>
        </div>

        <p class="project-modal-body-text" id="modalDesc">
          Comprehensive breakdown of system architecture and business results.
        </p>

        <!-- Dynamic Metrics Grid -->
        <div class="project-modal-metrics" id="modalMetrics"></div>

        <!-- Tech Stack Pills -->
        <div>
          <span style="font-size: 12px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 10px;">
            Technical Stack &amp; Infrastructure
          </span>
          <div class="project-modal-tech-list" id="modalTechList"></div>
        </div>

        <!-- Modal Actions Footer -->
        <div class="project-modal-actions">
          <a href="#" target="_blank" rel="noopener noreferrer" class="case-btn-secondary" id="modalLiveBtn" style="display: none;">
            <span>Visit Live Platform ↗</span>
          </a>
          <a href="contact.php" class="case-btn-primary" id="modalConsultBtn">
            <span>Talk to Engineers About This Stack</span>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Bottom CTA Banner -->
  <section class="subpage-section" style="padding-top: 0;">
    <div class="subpage-container">
      <div class="stats-banner" style="background: linear-gradient(135deg, rgba(248,104,0,0.06) 0%, rgba(0,140,216,0.06) 100%); border-radius: 20px; border: 1px solid rgba(226,218,204,0.9); padding: 48px 32px; text-align: center; display: flex; flex-direction: column; align-items: center;">
        <span class="subpage-badge" style="margin-bottom: 14px;">100% Code Ownership • Zero Retainers</span>
        <h2 style="font-family: var(--font-display); font-size: 32px; font-weight: 800; color: #0F172A; margin-bottom: 12px; line-height: 1.25;">
          Have a Custom Software or Web Project to Build?
        </h2>
        <p style="font-size: 16px; color: #475569; max-width: 620px; margin-bottom: 28px; line-height: 1.6;">
          Our senior developers architect custom platforms built to last without locking you into monthly agency hostage fees. Turnaround estimate within 24 hours.
        </p>
        <div style="display: flex; gap: 14px; flex-wrap: wrap; justify-content: center;">
          <a href="contact.php" class="btn-primary">
            Request Architectural Consultation
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
          <a href="services.php" class="btn-secondary">Explore All Services</a>
        </div>
      </div>
    </div>
  </section>

<?php
$show_footer_cta = false; // Already has custom CTA above
$extra_js = ['js/projects.js'];
require_once __DIR__ . '/includes/footer.php';
?>
