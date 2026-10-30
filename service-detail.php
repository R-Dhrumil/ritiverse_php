<?php
/**
 * RiTiVerse — Master Standalone Service Landing Page Template
 * Loads dynamic content from DB with seamless fallback to high-fidelity seed data
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/services_helper.php';

// Determine requested service
$target_slug = $service_slug ?? ($_GET['slug'] ?? 'website-development');
$service = get_service_by_slug_or_id($target_slug);

if (!$service) {
    // Graceful fallback to website-development if unknown slug
    $service = get_service_by_slug_or_id('website-development');
}

// Meta & Page Settings (High-Intent SEO & Multi-Region Directives)
$page_title = !empty($service['seo_title']) ? $service['seo_title'] : (e($service['title']) . ' Services — 100% Code Ownership | ' . APP_NAME);
$page_description = !empty($service['seo_description']) ? $service['seo_description'] : e($service['tagline'] ? $service['tagline'] . '. ' . $service['short_desc'] : $service['short_desc']);
$seo_keywords = !empty($service['seo_keywords']) ? $service['seo_keywords'] : null;
$current_page = $service['slug'];
$canonical_url = SITE_URL . '/' . $service['slug'] . '.php';
$custom_canonical_url = $canonical_url;
$extra_css = ['css/service-detail.css'];

// Parse deliverables into clean bullet array
$raw_deliverables = array_filter(array_map('trim', explode("\n", $service['deliverables'] ?? '')));
$tech_tags = array_filter(array_map('trim', explode(',', $service['tech_stack'] ?? '')));

// Cover Image URL resolution
$cover_img = !empty($service['image_url']) ? $service['image_url'] : 'assets/card_software_apis.webp';

// Other services for bottom switcher
$all_services = get_all_services(false);

require_once __DIR__ . '/includes/header.php';
?>

  <!-- =========================================================================
       HERO SECTION: Breadcrumbs, High-Impact Title, Meta Pills & Visual
       ========================================================================= -->
  <main class="service-hero-section">
    <div class="service-hero-container">

      <!-- Breadcrumbs -->
      <nav class="service-breadcrumb" aria-label="Breadcrumb">
        <a href="index.php">Home</a>
        <span class="service-breadcrumb-sep">/</span>
        <a href="services.php">Services</a>
        <span class="service-breadcrumb-sep">/</span>
        <span class="service-breadcrumb-current"><?= e($service['title']) ?></span>
      </nav>

      <div class="service-hero-grid">
        <!-- Hero Left Column: Narrative & Value Propositions -->
        <div class="service-hero-content">
          <div class="service-badge-pill">
            <span class="service-badge-dot"></span>
            <span>Zero Vendor Lock-In • 100% Code Ownership</span>
          </div>

          <h1 class="service-hero-title">
            <?= e($service['title']) ?><br>
            <span class="accent">Engineered for Real Growth.</span>
          </h1>

          <?php if (!empty($service['tagline'])): ?>
            <p class="service-hero-tagline">
              <?= e($service['tagline']) ?>
            </p>
          <?php endif; ?>

          <p class="service-hero-desc">
            <?= e($service['short_desc']) ?>
          </p>

          <!-- Key Assurance Pills -->
          <div class="service-meta-strip">
            <div class="service-meta-pill">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              <span>Timeline: <strong><?= e($service['timeline'] ?: '2 – 4 Weeks') ?></strong></span>
            </div>

            <div class="service-meta-pill">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
              <span>GitHub Repo Transfer: <strong>100% Yours</strong></span>
            </div>

            <div class="service-meta-pill">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
              <span>Warranty: <strong>Free 30-Day Bug Fixes</strong></span>
            </div>
          </div>

          <!-- Hero Action CTAs -->
          <div class="service-hero-actions">
            <a href="contact.php?scope=<?= urlencode($service['slug']) ?>" class="btn-primary">
              Get Fixed Project Estimate
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
            <a href="#deliverables" class="btn-secondary">
              Review Deliverables ↓
            </a>
          </div>
        </div>

        <!-- Hero Right Column: Architectural Visual Mockup -->
        <div class="service-showcase-visual">
          <div class="service-visual-card">
            <div class="service-visual-header">
              <div class="service-visual-dots">
                <span></span>
                <span></span>
                <span></span>
              </div>
              <div class="service-visual-url">ritiverse.in/<?= e($service['slug']) ?></div>
              <div style="font-size: 11px; font-weight: 700; color: #10B981;">● PRODUCTION</div>
            </div>

            <div class="service-visual-media">
              <img src="<?= e($cover_img) ?>" alt="<?= e($service['title']) ?> Architecture" onerror="this.src='assets/card_software_apis.webp'">
              <div class="service-visual-overlay-badge">
                <span class="service-visual-badge-text"><?= e($service['title']) ?> Stack</span>
                <span class="service-visual-badge-pill"><?= e($service['starting_price'] ?: 'Milestone Scope') ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- =========================================================================
       TECH STACK STRIP
       ========================================================================= -->
  <?php if (!empty($tech_tags)): ?>
    <section class="service-tech-strip">
      <div class="service-tech-container">
        <div class="service-tech-label">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand-orange, #f86800)" stroke-width="2.5"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
          <span>Modern Technologies We Build With:</span>
        </div>
        <div class="service-tech-pills">
          <?php foreach ($tech_tags as $tag): ?>
            <span class="tech-badge"><?= e($tag) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- =========================================================================
       DEEP-DIVE ARCHITECTURAL OVERVIEW
       ========================================================================= -->
  <section class="service-deliverables-section" style="background: #FFFFFF;">
    <div class="service-deliverables-container">
      <div class="section-head-center">
        <span class="section-head-eyebrow">
          <span class="service-badge-dot"></span>
          Engineering Standard &amp; Philosophy
        </span>
        <h2 class="section-head-title">Built for Performance, Not Quick Shortcuts</h2>
        <p class="section-head-subtitle" style="font-size: 17px; line-height: 1.8; color: #334155;">
          <?= nl2br(e($service['full_desc'])) ?>
        </p>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       DELIVERABLES & CAPABILITIES GRID
       ========================================================================= -->
  <section class="service-deliverables-section" id="deliverables">
    <div class="service-deliverables-container">
      <div class="section-head-center">
        <span class="section-head-eyebrow">
          <span class="service-badge-dot"></span>
          Scope &amp; Included Features
        </span>
        <h2 class="section-head-title">Everything Included in Your <?= e($service['title']) ?></h2>
        <p class="section-head-subtitle">
          Transparent deliverables with zero hidden costs, vendor lock-in, or surprise platform subscription bills.
        </p>
      </div>

      <div class="deliverables-grid">
        <?php if (!empty($raw_deliverables)): ?>
          <?php foreach ($raw_deliverables as $idx => $item): ?>
            <div class="deliverable-card">
              <div class="deliverable-icon-wrap">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              </div>
              <div class="deliverable-content">
                <h4><?= e($item) ?></h4>
                <p>Fully engineered, tested across devices, and delivered with 100% source code ownership pushed to your repository.</p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="deliverable-card">
            <div class="deliverable-icon-wrap">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div class="deliverable-content">
              <h4>100% Source Code Ownership</h4>
              <p>Delivered directly to your company's private GitHub / GitLab repository with zero ongoing license fees.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       WHY RITIVERSE COMPARISON MATRIX
       ========================================================================= -->
  <?php 
    $comparison = $service['comparison'] ?? null;
    $comp_label = $comparison['competitor_label'] ?? 'Traditional Agencies & SaaS Tools';
    $comp_items = $comparison['items'] ?? [
        ['feature' => 'Source Code Ownership', 'ritiverse' => '100% Yours. Pushed directly to your private GitHub repo.', 'competitor' => 'Locked inside proprietary platform or agency servers.'],
        ['feature' => 'Recurring License Fees', 'ritiverse' => '₹0 monthly user license charges. You own it forever.', 'competitor' => 'Mandatory monthly subscriptions that rise as team grows.'],
        ['feature' => 'Platform Speed & Latency', 'ritiverse' => 'Custom-coded for sub-2-second load times.', 'competitor' => 'Bloated templates taking 4 to 8+ seconds to load.'],
        ['feature' => 'Post-Launch Support', 'ritiverse' => 'Free 30-day bug fix warranty & technical handover training.', 'competitor' => 'Expensive retainers just to make minor text updates.']
    ];
  ?>
  <section class="service-matrix-section">
    <div class="service-matrix-container">
      <div class="section-head-center">
        <span class="section-head-eyebrow">
          <span class="service-badge-dot"></span>
          Honest Comparison
        </span>
        <h2 class="section-head-title">RiTiVerse vs. <?= e($comp_label) ?></h2>
        <p class="section-head-subtitle">
          See why growing businesses choose our custom engineering approach over costly monthly SaaS subscriptions.
        </p>
      </div>

      <div class="service-matrix-table-wrap">
        <table class="service-matrix-table">
          <thead>
            <tr>
              <th>What Matters To You</th>
              <th class="col-ritiverse">RiTiVerse</th>
              <th class="col-alt"><?= e($comp_label) ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($comp_items as $ci): ?>
              <tr>
                <td><strong><?= e($ci['feature']) ?></strong></td>
                <td class="col-ritiverse"><?= e($ci['ritiverse']) ?></td>
                <td class="col-alt"><?= e($ci['competitor']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       4-STEP ENGINEERING PROCESS
       ========================================================================= -->
  <section class="service-process-section">
    <div class="service-deliverables-container">
      <div class="section-head-center">
        <span class="section-head-eyebrow">
          <span class="service-badge-dot"></span>
          Predictable Delivery
        </span>
        <h2 class="section-head-title">How We Build Your <?= e($service['title']) ?></h2>
        <p class="section-head-subtitle">
          From first architectural whiteboard to production live deployment in 4 disciplined milestones.
        </p>
      </div>

      <div class="service-process-grid">
        <div class="process-card">
          <span class="process-num">MILESTONE 01</span>
          <h4>Discovery &amp; Scope</h4>
          <p>We analyze your exact business workflows, design user journeys, and establish a fixed scope with transparent milestones.</p>
        </div>

        <div class="process-card">
          <span class="process-num">MILESTONE 02</span>
          <h4>Architecture &amp; Code</h4>
          <p>We build with clean, modular code in React, PHP, and Node.js. You review weekly working staging links at every sprint.</p>
        </div>

        <div class="process-card">
          <span class="process-num">MILESTONE 03</span>
          <h4>Testing &amp; Speed Audits</h4>
          <p>Rigorous testing across real Android and iOS devices, database query latency benchmarks, and security verification.</p>
        </div>

        <div class="process-card">
          <span class="process-num">MILESTONE 04</span>
          <h4>Launch &amp; Code Handover</h4>
          <p>Production server deployment, domain DNS setup, complete GitHub repository transfer, and 30-day post-launch warranty.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       GLOBAL & OFFSHORE CLIENT COLLABORATION MODEL (US, UK, UAE, GLOBAL)
       ========================================================================= -->
  <section class="service-global-delivery-section">
    <div class="service-deliverables-container">
      <div class="section-head-center">
        <span class="section-head-eyebrow">
          <span class="service-badge-dot"></span>
          Offshore &amp; International Delivery
        </span>
        <h2 class="section-head-title">Built for Global Clients Across Timezones</h2>
        <p class="section-head-subtitle">
          Whether you are based in the United States, United Kingdom, Europe, UAE / Middle East, Australia, or India, we provide frictionless remote development with 100% source code ownership.
        </p>
      </div>

      <div class="service-global-grid">
        <div class="global-card">
          <div class="global-card-icon">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          </div>
          <h4>Timezone-Matched Sprints</h4>
          <p>Dedicated daily standups and sprint reviews with 4+ hours of active overlap with US (EST/PST), UK (GMT), UAE (GST), and Australia (AEST).</p>
        </div>

        <div class="global-card">
          <div class="global-card-icon">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
          </div>
          <h4>100% Direct IP &amp; GitHub Handover</h4>
          <p>Zero vendor hostage. Your code is pushed directly to your organization's private GitHub or GitLab repository from milestone one.</p>
        </div>

        <div class="global-card">
          <div class="global-card-icon">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
          </div>
          <h4>Multi-Currency &amp; Milestone Billing</h4>
          <p>Transparent milestone-based invoices in USD ($), GBP (£), EUR (€), AED, or INR (₹) via Stripe, Wise, SWIFT, and Wire Transfer with zero hidden costs.</p>
        </div>

        <div class="global-card">
          <div class="global-card-icon">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </div>
          <h4>Enterprise NDA &amp; Security Standards</h4>
          <p>Rigorous bilateral NDAs, strict data segregation, encrypted communications, and GDPR / SOC2-conscious software architecture.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       DOMAIN-SPECIFIC FAQS
       ========================================================================= -->
  <?php $faqs = $service['faqs'] ?? []; ?>
  <?php if (!empty($faqs)): ?>
    <section class="service-faq-section" id="faq">
      <div class="service-faq-container">
        <div class="section-head-center">
          <span class="section-head-eyebrow">
            <span class="service-badge-dot"></span>
            Clear Answers
          </span>
          <h2 class="section-head-title">Frequently Asked Questions</h2>
          <p class="section-head-subtitle">
            Common questions about our <?= e($service['title']) ?> process, code ownership, and warranties.
          </p>
        </div>

        <div class="faq-accordion-wrap" style="margin-top: 30px;">
          <?php foreach ($faqs as $fidx => $faq): ?>
            <div class="faq-item <?= ($fidx === 0) ? 'is-open' : '' ?>">
              <button class="faq-question-btn" type="button" aria-expanded="<?= ($fidx === 0) ? 'true' : 'false' ?>">
                <span class="faq-q-text"><?= e($faq['q']) ?></span>
                <span class="faq-icon-indicator"><?= ($fidx === 0) ? '−' : '+' ?></span>
              </button>
              <div class="faq-answer-wrap">
                <div class="faq-answer-body">
                  <p><?= e($faq['a']) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- =========================================================================
       OTHER ENGINEERING SERVICES SWITCHER
       ========================================================================= -->
  <section class="other-services-section">
    <div class="other-services-container">
      <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
          <span class="section-head-eyebrow">
            <span class="service-badge-dot"></span>
            Full Engineering Suite
          </span>
          <h3 style="font-family: var(--font-display, sans-serif); font-size: 28px; font-weight: 800; color: #0F172A; margin: 0;">
            Explore Other RiTiVerse Services
          </h3>
        </div>
        <a href="services.php" style="color: var(--brand-orange, #f86800); font-weight: 700; text-decoration: none; font-size: 14px;">
          View All Services Overview →
        </a>
      </div>

      <div class="other-services-grid">
        <?php foreach ($all_services as $s): ?>
          <?php if ($s['slug'] !== $service['slug']): ?>
            <?php 
              $s_link = file_exists(__DIR__ . '/' . $s['slug'] . '.php') ? ($s['slug'] . '.php') : ('service.php?slug=' . urlencode($s['slug']));
            ?>
            <a href="<?= e($s_link) ?>" class="other-service-card">
              <div>
                <div class="other-service-name"><?= e($s['title']) ?></div>
                <div style="font-size: 12px; color: #64748B; margin-top: 2px;"><?= e($s['timeline'] ?: '2 – 4 Weeks') ?></div>
              </div>
              <span class="other-service-arrow">↗</span>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php
$show_footer_cta = true;
$extra_js = ['js/services.js'];
require_once __DIR__ . '/includes/footer.php';
?>
