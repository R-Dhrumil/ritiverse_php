<?php
/**
 * RiTiVerse — Projects & Client Reference Architectures
 * Showcase of production software engines, custom websites, CRM, ERP, and mobile systems
 */
$page_title = 'Client Projects & Case Studies — RiTiVerse Studio';
$page_description = 'Explore production software engines, custom CRM, ERP platforms, and business websites built by RiTiVerse with 100% full source ownership.';
$current_page = 'projects';
$extra_css = ['css/projects.css'];

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

// Fallback high-fidelity projects if database is empty or offline
if (empty($db_projects)) {
    $db_projects = [
        [
            'id' => 1,
            'title' => 'Aegis Financial Telemetry OS',
            'client_name' => 'FinTech Global Corp',
            'slug' => 'aegis-financial-telemetry',
            'category' => 'custom web',
            'tag_label' => 'FinTech Architecture',
            'image_url' => 'assets/card_software_apis.jpg',
            'live_url' => '',
            'description' => 'High-frequency algorithmic portfolio monitoring reference platform streaming real-time market data across global exchanges with sub-50ms latency.',
            'metric_1_val' => '0.12s',
            'metric_1_lbl' => 'Global Latency',
            'metric_2_val' => 'Real-Time',
            'metric_2_lbl' => 'Data Streams',
            'metric_3_val' => '100%',
            'metric_3_lbl' => 'Source IP',
            'tech_tags' => 'Go, Next.js 15, TimescaleDB, WebSockets, AWS EKS'
        ],
        [
            'id' => 2,
            'title' => 'Verve Global Logistics Engine',
            'client_name' => 'Mehta Logistics India',
            'slug' => 'verve-logistics-engine',
            'category' => 'cloud custom erp',
            'tag_label' => 'Supply Chain Architecture',
            'image_url' => 'assets/card_cloud_devops.jpg',
            'live_url' => '',
            'description' => 'Self-healing containerized microservices architecture demonstrating automated route optimization, telemetry ingestion, and distributed cluster failover.',
            'metric_1_val' => 'High-Avail',
            'metric_1_lbl' => 'Architecture',
            'metric_2_val' => 'Docker/K8s',
            'metric_2_lbl' => 'Containers',
            'metric_3_val' => 'Zero',
            'metric_3_lbl' => 'Lock-In',
            'tech_tags' => 'Express.js, Node.js, MySQL, REST APIs, Server Hosting'
        ],
        [
            'id' => 3,
            'title' => 'OmniSphere Private AI Workspace',
            'client_name' => 'Enterprise Intelligence Corp',
            'slug' => 'omnisphere-ai-workspace',
            'category' => 'ai custom',
            'tag_label' => 'Enterprise AI Architecture',
            'image_url' => 'assets/card_ai_agents.jpg',
            'live_url' => '',
            'description' => 'Air-gapped enterprise intelligence prototype demonstrating proprietary document indexing with vector semantic search, hybrid retrieval, and multi-agent synthesis.',
            'metric_1_val' => 'Sub-second',
            'metric_1_lbl' => 'Vector Search',
            'metric_2_val' => 'pgvector',
            'metric_2_lbl' => 'Embeddings',
            'metric_3_val' => 'Private',
            'metric_3_lbl' => 'VPC Isolation',
            'tech_tags' => 'Python, FastAPI, pgvector, Claude 3.7, TypeScript'
        ],
        [
            'id' => 4,
            'title' => 'Pulse Luxury Digital Flagship',
            'client_name' => 'Pulse Retail Group',
            'slug' => 'pulse-digital-flagship',
            'category' => 'web ecommerce',
            'tag_label' => 'Headless Web Platform',
            'image_url' => 'assets/card_web_apps.jpg',
            'live_url' => '',
            'description' => 'Cinematic, 60fps editorial buying experience reference built with Next.js 15, edge rendering, and bespoke UI interactions with sub-second page transitions.',
            'metric_1_val' => '100/100',
            'metric_1_lbl' => 'Lighthouse Score',
            'metric_2_val' => '60 FPS',
            'metric_2_lbl' => 'Smooth Motion',
            'metric_3_val' => '0.18s',
            'metric_3_lbl' => 'Average TTFB',
            'tech_tags' => 'Next.js 15, React 19, Cloudflare, GSAP, Tailored Tokens'
        ],
        [
            'id' => 5,
            'title' => 'Apex Cloud Observability Console',
            'client_name' => 'Apex Cloud Systems',
            'slug' => 'apex-cloud-observability',
            'category' => 'cloud web',
            'tag_label' => 'Observability Platform',
            'image_url' => 'assets/card_cloud_ai.jpg',
            'live_url' => '',
            'description' => 'Real-time operational dashboard visualizing cluster metrics, multi-tenant container health, and automated anomaly detection alerts.',
            'metric_1_val' => 'Real-Time',
            'metric_1_lbl' => 'Telemetry',
            'metric_2_val' => '45ms',
            'metric_2_lbl' => 'Query Latency',
            'metric_3_val' => '100%',
            'metric_3_lbl' => 'Self-Hosted',
            'tech_tags' => 'Go, ClickHouse, React, Grafana Engine, Docker'
        ],
        [
            'id' => 6,
            'title' => 'Strata Distributed API Gateway',
            'client_name' => 'Strata Networks',
            'slug' => 'strata-api-gateway',
            'category' => 'custom cloud',
            'tag_label' => 'Distributed Systems',
            'image_url' => 'assets/card_software_apis.jpg',
            'live_url' => '',
            'description' => 'High-throughput gRPC and GraphQL routing fabric connecting distributed microservices with cryptographic token verification and zero-downtime blue/green rollouts.',
            'metric_1_val' => 'Sub-millisecond',
            'metric_1_lbl' => 'Proxy Routing',
            'metric_2_val' => 'Zero Downtime',
            'metric_2_lbl' => 'Blue / Green',
            'metric_3_val' => '0 Lock-In',
            'metric_3_lbl' => 'Standard gRPC',
            'tech_tags' => 'Go, gRPC, Envoy, PostgreSQL, AWS'
        ]
    ];
}
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
    </div>
  </main>

  <!-- Projects Grid Section -->
  <section class="subpage-section">
    <div class="subpage-container">
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
    </div>
  </section>

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
  </div>

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
