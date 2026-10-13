<?php
/**
 * RiTiVerse — Global Master Footer & Script Bundle
 * Included across all PHP templates for unified, DRY maintenance
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

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
            <span><strong>Phone:</strong> <a href="tel:+919426782646">+91 94267 82646</a> , <a href="tel:+919104253289">+91 91042 53289</a></span>
          </div>
          <style>
            .footer-contact-mini a,
            .footer-contact-mini a:visited {
              color: var(--brand-orange, #f86800);
              text-decoration: none;
              font-weight: 600;
            }
            .footer-contact-mini a:hover {
              text-decoration: underline;
            }
            .footer-social-links {
              display: flex;
              align-items: center;
              flex-wrap: wrap;
              gap: 8px;
              margin-top: 14px;
            }
            .footer-social-link,
            .footer-social-link:visited {
              display: inline-flex;
              align-items: center;
              gap: 6px;
              font-size: 12px;
              font-weight: 600;
              color: #475569 !important;
              text-decoration: none !important;
              padding: 5px 11px;
              background: rgba(255, 255, 255, 0.75);
              border: 1px solid rgba(226, 218, 204, 0.9);
              border-radius: 6px;
              transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .footer-social-link svg {
              display: inline-block;
              vertical-align: middle;
              flex-shrink: 0;
            }
            .footer-social-link:hover {
              color: var(--brand-orange, #f86800) !important;
              border-color: var(--brand-orange-border, rgba(248, 104, 0, 0.24));
              background: var(--brand-orange-subtle, rgba(248, 104, 0, 0.08));
              transform: translateY(-1.5px);
              box-shadow: 0 4px 10px -2px rgba(248, 104, 0, 0.15);
              text-decoration: none !important;
            }
          </style>
          <?php
            $f_social_linkedin = get_setting('social_linkedin', defined('SOCIAL_LINKEDIN') ? SOCIAL_LINKEDIN : 'https://www.linkedin.com/company/ritiverse');
            $f_social_instagram = get_setting('social_instagram', defined('SOCIAL_INSTAGRAM') ? SOCIAL_INSTAGRAM : '');
            $f_social_github = get_setting('social_github', defined('SOCIAL_GITHUB') ? SOCIAL_GITHUB : '');
            $f_social_x = get_setting('social_x', defined('SOCIAL_X') ? SOCIAL_X : '');
            $f_social_facebook = get_setting('social_facebook', defined('SOCIAL_FACEBOOK') ? SOCIAL_FACEBOOK : '');
          ?>
          <div class="footer-social-links">
            <a href="<?= e($f_social_linkedin) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link" title="LinkedIn" aria-label="RiTiVerse on LinkedIn">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true">
                <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.2a1.62 1.62 0 1 0 0 3.24 1.62 1.62 0 0 0 0-3.24z"/>
              </svg>
              <span>LinkedIn</span>
            </a>
            <a href="<?= e($f_social_instagram) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link" title="Instagram" aria-label="RiTiVerse on Instagram">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
              </svg>
              <span>Instagram</span>
            </a>
            <a href="<?= e($f_social_github) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link" title="GitHub" aria-label="RiTiVerse on GitHub">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true">
                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/>
              </svg>
              <span>GitHub</span>
            </a>
            <a href="<?= e($f_social_x) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link" title="X (Twitter)" aria-label="RiTiVerse on X">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
              </svg>
              <span>X (Twitter)</span>
            </a>
            <a href="<?= e($f_social_facebook) ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link" title="Facebook" aria-label="RiTiVerse on Facebook">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
              <span>Facebook</span>
            </a>
          </div>
        </div>

        <!-- Col 2: Core Engineering Services -->
        <div class="footer-sitemap-col">
          <h3 class="footer-col-title">Services</h3>
          <ul class="footer-links-list">
            <li><a href="website-development.php">Website Development</a></li>
            <li><a href="mobile-app-development.php">Mobile App Development</a></li>
            <li><a href="ecommerce-development.php">E-Commerce Solutions</a></li>
            <li><a href="crm-development.php">CRM Platforms</a></li>
            <li><a href="erp-development.php">ERP Systems</a></li>
            <li><a href="custom-software-development.php">Custom Software Development</a></li>
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
  <?php 
    $nav_js_file = __DIR__ . '/../js/nav.js';
    $nav_js_ver = file_exists($nav_js_file) ? filemtime($nav_js_file) : '2.3';
  ?>
  <script src="js/nav.js?v=<?= $nav_js_ver ?>"></script>

  <!-- Page-Specific Modular Scripts -->
  <?php foreach ($extra_js as $js_path): 
    $full_js = __DIR__ . '/../' . ltrim($js_path, '/');
    $jver = file_exists($full_js) ? filemtime($full_js) : '2.3';
  ?>
    <script src="<?= e($js_path) ?>?v=<?= $jver ?>"></script>
  <?php endforeach; ?>
</body>

</html>
