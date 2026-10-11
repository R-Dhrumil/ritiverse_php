<?php
/**
 * RiTiVerse — Global Master Footer & Script Bundle
 * Included across all PHP templates for unified, DRY maintenance
 */
require_once __DIR__ . '/config.php';

$show_footer_cta = isset($show_footer_cta) ? $show_footer_cta : false;
$include_gsap = isset($include_gsap) ? $include_gsap : true;
$extra_js = isset($extra_js) && is_array($extra_js) ? $extra_js : [];
?>
  <!-- Global Footer -->
  <footer class="synex-footer" id="contact">
    <div class="footer-container">

      <?php if ($show_footer_cta): ?>
        <!-- Reusable High-Converting Consultation CTA Banner -->
        <div class="footer-cta-card">
          <div class="footer-cta-glow" aria-hidden="true"></div>
          <span class="footer-eyebrow">Ready to Build Your Project?</span>
          <h2 class="footer-headline">Talk directly with our development team today.</h2>
          <p class="footer-subtext">No pushy sales calls or confusing technical jargon. Get honest advice, transparent milestones, and a clear project estimate.</p>
          <a href="contact.php" class="footer-cta-btn">
            Schedule Free Consultation
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>
      <?php endif; ?>

      <!-- 3-Column Architectural Footer Sitemap (Website Services & Contacts) -->
      <div class="footer-sitemap-grid">
        <!-- Col 1: Brand Wordmark & Direct Contacts -->
        <div class="footer-brand-col">
          <div class="footer-brand" style="gap: 10px;">
            <img src="assets/logo.png" alt="RiTiVerse Logo" style="height: 28px; width: auto;" />
            <span class="footer-logo"><?= e(APP_NAME) ?></span>
          </div>
          <p class="footer-col-desc">
            Custom website, mobile app, CRM, ERP, and software development. Built with modern technology and delivered with 100% code ownership from Day 1.
          </p>
          <div class="footer-contact-mini">
            <span><strong>Inquiries:</strong> <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></span>
            <span><strong>Support:</strong> <a href="mailto:<?= e(SUPPORT_EMAIL) ?>"><?= e(SUPPORT_EMAIL) ?></a></span>
            <span><strong>Consultation:</strong> <a href="contact.php">Book Free Consultation</a></span>
          </div>
        </div>

        <!-- Col 2: Core Engineering Services -->
        <div class="footer-sitemap-col">
          <h3 class="footer-col-title">Services</h3>
          <ul class="footer-links-list">
            <li><a href="services.php#services-showcase">Website Development</a></li>
            <li><a href="services.php#services-showcase">Application Development</a></li>
            <li><a href="services.php#services-showcase">E-Commerce Solutions</a></li>
            <li><a href="services.php#services-showcase">CRM Platforms</a></li>
            <li><a href="services.php#services-showcase">ERP Systems</a></li>
            <li><a href="services.php#services-showcase">Custom Software Development</a></li>
          </ul>
        </div>

        <!-- Col 3: Studio & Direct Navigation -->
        <div class="footer-sitemap-col">
          <h3 class="footer-col-title">Studio &amp; Trust</h3>
          <ul class="footer-links-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">All Services</a></li>
            <li><a href="projects.php">Featured Projects</a></li>
            <li><a href="about.php">Philosophy &amp; Standards</a></li>
            <li><a href="index.php#faq">Frequently Asked Questions</a></li>
            <li><a href="contact.php">Start a Consultation</a></li>
          </ul>
        </div>
      </div>

      <!-- Bottom Row -->
      <div class="footer-bottom-row">
        <div class="footer-brand">
          <span class="footer-copy">© <?= date('Y') ?> <?= e(APP_NAME) ?>. All rights reserved. 100% Client Source Code Ownership Guaranteed.</span>
        </div>
        <div class="footer-status-pill">
          <span class="footer-status-dot"></span>
          Zero Vendor Lock-In • 100% Code Ownership
        </div>
      </div>

    </div>
  </footer>

  <?php if ($include_gsap): ?>
    <!-- GSAP & ScrollTrigger Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <?php endif; ?>

  <!-- Core Interactive Navigation Logic -->
  <script src="js/nav.js?v=2.1"></script>

  <!-- Page-Specific Modular Scripts -->
  <?php foreach ($extra_js as $js_path): ?>
    <script src="<?= e($js_path) ?>?v=2.1"></script>
  <?php endforeach; ?>
</body>

</html>
