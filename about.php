<?php
/**
 * RiTiVerse — About Us & Engineering Standards
 */
$page_title = 'About Us & Standards — RiTiVerse';
$page_description = 'Discover how RiTiVerse builds websites, mobile apps, CRM, ERP, and custom software with 100% client code ownership and zero monthly lock-in.';
$current_page = 'about';
$extra_css = ['css/about.css'];

require_once __DIR__ . '/includes/header.php';
?>

  <!-- Hero Section -->
  <main class="subpage-hero">
    <div class="subpage-hero-container">
      <div class="subpage-badge">
        <span class="subpage-badge-dot"></span>
        Our Vision &amp; Core Standards
      </div>
      <h1 class="subpage-title">
        Reliable Software.<br>
        Technology <span class="accent-text">Without Vendor Lock-In.</span>
      </h1>
      <p class="subpage-subtitle">
        We started RiTiVerse to end the culture of recurring agency fees and closed platforms. When you pay for a website or software, you should own 100% of the code, domain, and server accounts.
      </p>
      <div class="subpage-cta-group">
        <a href="contact.php" class="btn-primary">
          Talk to Our Development Team
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
        <a href="services.php" class="btn-secondary">Explore All Services</a>
      </div>
    </div>
  </main>

  <!-- Telemetry Banner -->
  <section class="subpage-section" style="padding-top: 0; padding-bottom: 0;">
    <div class="subpage-container">
      <div class="stats-banner">
        <div class="stat-item">
          <div class="stat-item-num">100%</div>
          <div class="stat-item-label">Source Code Ownership Transferred</div>
        </div>
        <div class="stat-item">
          <div class="stat-item-num">0</div>
          <div class="stat-item-label">Monthly Hostage Charges</div>
        </div>
        <div class="stat-item">
          <div class="stat-item-num">100%</div>
          <div class="stat-item-label">Open Industry Standards</div>
        </div>
        <div class="stat-item">
          <div class="stat-item-num">Direct</div>
          <div class="stat-item-label">Senior Developer Access</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Core Pillars Section -->
  <section class="subpage-section">
    <div class="subpage-container">
      <div class="section-badge-header">
        <span class="section-eyebrow">
          <span class="section-eyebrow-dot"></span>
          Guiding Principles
        </span>
        <h2 class="section-title">Why RiTiVerse Works Differently</h2>
        <p class="section-subtitle">
          Our business model is built around your technical independence, not locking you into endless monthly retainers.
        </p>
      </div>

      <div class="process-grid">
        <div class="process-step-card">
          <span class="process-step-num">PILLAR 01</span>
          <h3 class="process-step-title">100% Code Ownership</h3>
          <p class="process-step-desc">
            We build and deliver all code directly to your GitHub repository. You get complete legal and technical ownership of your project with zero restrictions.
          </p>
        </div>

        <div class="process-step-card">
          <span class="process-step-num">PILLAR 02</span>
          <h3 class="process-step-title">No Proprietary Traps</h3>
          <p class="process-step-desc">
            No closed CMS engines or encrypted code. Everything is built on proven open standards like React, PHP, Laravel, Node.js, and MySQL that your internal team or any developer can easily maintain.
          </p>
        </div>

        <div class="process-step-card">
          <span class="process-step-num">PILLAR 03</span>
          <h3 class="process-step-title">Direct Developer Access</h3>
          <p class="process-step-desc">
            You talk directly with the developers working on your project. No middlemen or sales reps passing messages—just clear, fast, and transparent progress.
          </p>
        </div>

        <div class="process-step-card">
          <span class="process-step-num">PILLAR 04</span>
          <h3 class="process-step-title">Your Own Cloud &amp; Hosting</h3>
          <p class="process-step-desc">
            We configure and deploy websites directly inside your own server or chosen hosting accounts (AWS, DigitalOcean, Hostinger). You pay hosting providers at actual cost with zero agency markup.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Rigorous Engineering Standards -->
  <section class="subpage-section"
    style="background: rgba(250, 247, 238, 0.9); backdrop-filter: blur(20px); border-top: 1px solid rgba(226, 218, 204, 0.85); border-bottom: 1px solid rgba(226, 218, 204, 0.85);">
    <div class="subpage-container">
      <div class="capability-row">
        <div class="capability-content">
          <span class="subpage-badge">Development Standards</span>
          <h3>How We Ensure High-Quality Code</h3>
          <p>
            Every software system engineered by RiTiVerse undergoes thorough testing, speed optimization, and security audits before live deployment.
          </p>
          <ul class="capability-feature-list">
            <li>
              <span class="check-icon-circle">✓</span>
              <span><strong>Clean &amp; Well-Documented Code:</strong> Modular architecture and standard frameworks making it easy to maintain and scale in the future.</span>
            </li>
            <li>
              <span class="check-icon-circle">✓</span>
              <span><strong>Enterprise Security:</strong> Sanitized inputs, CSRF protection, SSL enforcement, and secure API and payment integration.</span>
            </li>
            <li>
              <span class="check-icon-circle">✓</span>
              <span><strong>Weekly Demos &amp; Live Staging:</strong> Live test links shared every week so you can test features and approve milestones with complete peace of mind.</span>
            </li>
            <li>
              <span class="check-icon-circle">✓</span>
              <span><strong>Fast Loading Speeds:</strong> Mobile-optimized code and assets ensuring pages load in under 2 seconds even on standard mobile connections.</span>
            </li>
          </ul>
          <a href="contact.php" class="btn-primary">Book a Free Consultation →</a>
        </div>

        <div class="arch-card">
          <div class="arch-card-header">
            <div class="terminal-dots">
              <span class="term-dot term-red"></span>
              <span class="term-dot term-yellow"></span>
              <span class="term-dot term-green"></span>
            </div>
            <span class="arch-card-title">quality-gate.yml</span>
          </div>
          <div class="arch-card-body">
            <pre
              class="arch-code-block"><code><span class="code-comment"># Automated Production Gate Pipeline</span>
<span class="code-keyword">name</span>: RiTiVerse Production Gate
<span class="code-keyword">on</span>: [push, pull_request]

<span class="code-keyword">jobs</span>:
  <span class="code-prop">verify_standards</span>:
    <span class="code-prop">runs-on</span>: ubuntu-latest
    <span class="code-prop">steps</span>:
      - <span class="code-prop">name</span>: Typecheck &amp; Lint
        <span class="code-prop">run</span>: <span class="code-str">pnpm typecheck &amp;&amp; pnpm lint</span>
      - <span class="code-prop">name</span>: Automated Unit &amp; E2E Tests
        <span class="code-prop">run</span>: <span class="code-str">pnpm test:coverage --threshold=95</span>
      - <span class="code-prop">name</span>: Lighthouse Core Web Vitals
        <span class="code-prop">run</span>: <span class="code-str">lhci autorun --assert.performance=1.0</span>
      - <span class="code-prop">name</span>: OWASP Dependency Vulnerability Scan
        <span class="code-prop">run</span>: <span class="code-str">trivy fs --severity HIGH,CRITICAL .</span></code></pre>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php
$show_footer_cta = true;
require_once __DIR__ . '/includes/footer.php';
?>
