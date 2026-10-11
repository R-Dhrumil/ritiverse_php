<?php
/**
 * RiTiVerse — Projects & Reference Architectures
 */
$page_title = 'Custom Software Development, CRM, ERP & Website Projects — RiTiVerse';
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
?>

  <!-- Hero Section -->
  <main class="subpage-hero">
    <div class="subpage-hero-container">
      <div class="subpage-badge">
        <span class="subpage-badge-dot"></span>
        Reference Architectures &amp; Production Prototypes
      </div>
      <h1 class="subpage-title">
        Engineered Systems.<br>
        <span class="accent-text">Production Reference Architectures.</span>
      </h1>
      <p class="subpage-subtitle">
        Explore digital platforms, custom software engines, and distributed cloud systems architected by
        RiTiVerse—delivered with 100% full source ownership and zero vendor lock-in.
      </p>

      <!-- Category Filter Pills -->
      <div class="projects-filter-bar">
        <button class="project-filter-btn active" data-filter="all">All Architectures (<?= !empty($db_projects) ? count($db_projects) : 6 ?>)</button>
        <button class="project-filter-btn" data-filter="web">Web Applications</button>
        <button class="project-filter-btn" data-filter="custom">Custom Software</button>
        <button class="project-filter-btn" data-filter="cloud">Hosting &amp; Systems</button>
        <button class="project-filter-btn" data-filter="ai">AI Automation</button>
      </div>
    </div>
  </main>

  <!-- Projects Grid Section -->
  <section class="subpage-section">
    <div class="subpage-container">
      <div class="projects-grid">

<?php if (!empty($db_projects)): ?>
  <?php foreach ($db_projects as $proj): ?>
    <div class="case-study-card" data-category="<?= e($proj['category']) ?>">
      <div class="case-card-hero">
        <span class="case-tag-pill"><?= e($proj['tag_label']) ?></span>
        <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="var(--accent-terracotta)" stroke-width="1.5" opacity="0.85">
          <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
          <polyline points="2 17 12 22 22 17"></polyline>
          <polyline points="2 12 12 17 22 12"></polyline>
        </svg>
      </div>
      <div class="case-card-body">
        <div>
          <h3 class="case-card-title"><?= e($proj['title']) ?></h3>
          <p class="case-card-desc"><?= e($proj['description']) ?></p>
        </div>
        <div>
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
          <div class="case-tech-tags">
            <?php foreach (explode(',', $proj['tech_tags']) as $tag): ?>
              <?php if (trim($tag)): ?>
                <span class="case-tech-pill"><?= e(trim($tag)) ?></span>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
        <!-- Project 1: Aegis Financial OS -->
        <div class="case-study-card" data-category="custom web">
          <div class="case-card-hero">
            <span class="case-tag-pill">FinTech Architecture</span>
            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="var(--accent-terracotta)"
              stroke-width="1.5" opacity="0.85">
              <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
              <polyline points="2 17 12 22 22 17"></polyline>
              <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
          </div>
          <div class="case-card-body">
            <div>
              <h3 class="case-card-title">Aegis Financial Telemetry OS</h3>
              <p class="case-card-desc">
                High-frequency algorithmic portfolio monitoring reference platform streaming real-time market data across global exchanges with sub-50ms latency.
              </p>
            </div>
            <div>
              <div class="case-metrics-strip">
                <div class="case-metric-box">
                  <span class="case-metric-val">0.12s</span>
                  <span class="case-metric-lbl">Global Latency</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">Real-Time</span>
                  <span class="case-metric-lbl">Data Streams</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">100%</span>
                  <span class="case-metric-lbl">Source IP</span>
                </div>
              </div>
              <div class="case-tech-tags">
                <span class="case-tech-pill">Go</span>
                <span class="case-tech-pill">Next.js 15</span>
                <span class="case-tech-pill">TimescaleDB</span>
                <span class="case-tech-pill">WebSockets</span>
                <span class="case-tech-pill">AWS EKS</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Project 2: Verve Cloud & Logistics Engine -->
        <div class="case-study-card" data-category="cloud custom">
          <div class="case-card-hero">
            <span class="case-tag-pill">Supply Chain Architecture</span>
            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="#38BDF8" stroke-width="1.5"
              opacity="0.85">
              <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
              <line x1="8" y1="21" x2="16" y2="21"></line>
              <line x1="12" y1="17" x2="12" y2="21"></line>
            </svg>
          </div>
          <div class="case-card-body">
            <div>
              <h3 class="case-card-title">Verve Global Logistics Engine</h3>
              <p class="case-card-desc">
                Self-healing containerized microservices architecture demonstrating automated route optimization, telemetry ingestion, and distributed cluster failover.
              </p>
            </div>
            <div>
              <div class="case-metrics-strip">
                <div class="case-metric-box">
                  <span class="case-metric-val">High-Avail</span>
                  <span class="case-metric-lbl">Architecture</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">Docker/K8s</span>
                  <span class="case-metric-lbl">Containers</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">Zero</span>
                  <span class="case-metric-lbl">Lock-In</span>
                </div>
              </div>
              <div class="case-tech-tags">
                <span class="case-tech-pill">Express.js</span>
                <span class="case-tech-pill">Node.js</span>
                <span class="case-tech-pill">MySQL</span>
                <span class="case-tech-pill">REST APIs</span>
                <span class="case-tech-pill">Server Hosting</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Project 3: OmniSphere AI Research Workspace -->
        <div class="case-study-card" data-category="ai custom">
          <div class="case-card-hero">
            <span class="case-tag-pill">Enterprise AI Architecture</span>
            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="#34D399" stroke-width="1.5"
              opacity="0.85">
              <path
                d="M12 2a4 4 0 0 1 4 4c0 1.5-.8 2.8-2 3.5V11h3a3 3 0 0 1 3 3v2h-2v-2a1 1 0 0 0-1-1h-3v2.5a4 4 0 1 1-2 0V13H8a1 1 0 0 0-1 1v2H5v-2a3 3 0 0 1 3-3h3V9.5C9.8 8.8 9 7.5 9 6a4 4 0 0 1 3-4z">
              </path>
            </svg>
          </div>
          <div class="case-card-body">
            <div>
              <h3 class="case-card-title">OmniSphere Private AI Workspace</h3>
              <p class="case-card-desc">
                Air-gapped enterprise intelligence prototype demonstrating proprietary document indexing with vector semantic search, hybrid retrieval, and multi-agent synthesis.
              </p>
            </div>
            <div>
              <div class="case-metrics-strip">
                <div class="case-metric-box">
                  <span class="case-metric-val">Sub-second</span>
                  <span class="case-metric-lbl">Vector Search</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">pgvector</span>
                  <span class="case-metric-lbl">Embeddings</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">Private</span>
                  <span class="case-metric-lbl">VPC Isolation</span>
                </div>
              </div>
              <div class="case-tech-tags">
                <span class="case-tech-pill">Python</span>
                <span class="case-tech-pill">FastAPI</span>
                <span class="case-tech-pill">pgvector</span>
                <span class="case-tech-pill">Claude 3.7</span>
                <span class="case-tech-pill">TypeScript</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Project 4: Pulse Commerce Flagship -->
        <div class="case-study-card" data-category="web">
          <div class="case-card-hero">
            <span class="case-tag-pill">Headless Web Platform</span>
            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="#F59E0B" stroke-width="1.5"
              opacity="0.85">
              <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
            </svg>
          </div>
          <div class="case-card-body">
            <div>
              <h3 class="case-card-title">Pulse Luxury Digital Flagship</h3>
              <p class="case-card-desc">
                Cinematic, 60fps editorial buying experience reference built with Next.js 15, edge rendering, and bespoke UI interactions with sub-second page transitions.
              </p>
            </div>
            <div>
              <div class="case-metrics-strip">
                <div class="case-metric-box">
                  <span class="case-metric-val">100/100</span>
                  <span class="case-metric-lbl">Lighthouse Score</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">60 FPS</span>
                  <span class="case-metric-lbl">Smooth Motion</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">0.18s</span>
                  <span class="case-metric-lbl">Average TTFB</span>
                </div>
              </div>
              <div class="case-tech-tags">
                <span class="case-tech-pill">Next.js 15</span>
                <span class="case-tech-pill">React 19</span>
                <span class="case-tech-pill">Cloudflare</span>
                <span class="case-tech-pill">GSAP</span>
                <span class="case-tech-pill">Tailored Tokens</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Project 5: Apex Cloud Telemetry Dashboard -->
        <div class="case-study-card" data-category="cloud web">
          <div class="case-card-hero">
            <span class="case-tag-pill">Observability Platform</span>
            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="#818CF8" stroke-width="1.5"
              opacity="0.85">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="8" x2="12" y2="12"></line>
              <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
          </div>
          <div class="case-card-body">
            <div>
              <h3 class="case-card-title">Apex Cloud Observability Console</h3>
              <p class="case-card-desc">
                Real-time operational dashboard visualizing cluster metrics, multi-tenant container health, and automated anomaly detection alerts.
              </p>
            </div>
            <div>
              <div class="case-metrics-strip">
                <div class="case-metric-box">
                  <span class="case-metric-val">Real-Time</span>
                  <span class="case-metric-lbl">Telemetry</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">45ms</span>
                  <span class="case-metric-lbl">Query Latency</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">100%</span>
                  <span class="case-metric-lbl">Self-Hosted</span>
                </div>
              </div>
              <div class="case-tech-tags">
                <span class="case-tech-pill">Go</span>
                <span class="case-tech-pill">ClickHouse</span>
                <span class="case-tech-pill">React</span>
                <span class="case-tech-pill">Grafana Engine</span>
                <span class="case-tech-pill">Docker</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Project 6: Strata Distributed Gateway -->
        <div class="case-study-card" data-category="custom cloud">
          <div class="case-card-hero">
            <span class="case-tag-pill">Distributed Systems</span>
            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="#EC4899" stroke-width="1.5"
              opacity="0.85">
              <polygon points="12 2 19 21 12 17 5 21 12 2"></polygon>
            </svg>
          </div>
          <div class="case-card-body">
            <div>
              <h3 class="case-card-title">Strata Distributed API Gateway</h3>
              <p class="case-card-desc">
                High-throughput gRPC and GraphQL routing fabric connecting distributed microservices with cryptographic token verification and zero-downtime blue/green rollouts.
              </p>
            </div>
            <div>
              <div class="case-metrics-strip">
                <div class="case-metric-box">
                  <span class="case-metric-val">Sub-millisecond</span>
                  <span class="case-metric-lbl">Proxy Routing</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">Zero Downtime</span>
                  <span class="case-metric-lbl">Blue / Green</span>
                </div>
                <div class="case-metric-box">
                  <span class="case-metric-val">0 Lock-In</span>
                  <span class="case-metric-lbl">Standard gRPC</span>
                </div>
              </div>
              <div class="case-tech-tags">
                <span class="case-tech-pill">Go</span>
                <span class="case-tech-pill">gRPC</span>
                <span class="case-tech-pill">Envoy</span>
                <span class="case-tech-pill">PostgreSQL</span>
                <span class="case-tech-pill">AWS</span>
              </div>
            </div>
          </div>
        </div>
<?php endif; ?>
      </div>
    </div>
  </section>

<?php
$show_footer_cta = true;
$extra_js = ['js/projects.js'];
require_once __DIR__ . '/includes/footer.php';
?>
