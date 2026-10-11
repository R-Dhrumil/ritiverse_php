<?php
/**
 * RiTiVerse — 404 Page Not Found
 */
http_response_code(404);
$page_title = 'Page Not Found (404) — ' . APP_NAME;
$page_description = 'The requested page could not be found. Return to RiTiVerse homepage or explore our software services.';
$current_page = '404';

require_once __DIR__ . '/includes/header.php';
?>

<main class="subpage-hero" style="min-height: 70vh; display: flex; align-items: center;">
  <div class="subpage-hero-container" style="text-align: center; max-width: 650px; margin: 0 auto;">
    <div class="subpage-badge" style="margin: 0 auto 20px;">
      <span class="subpage-badge-dot"></span>
      Error 404 • Resource Not Found
    </div>
    <h1 class="subpage-title" style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 16px;">
      Looking for Something <span class="accent-text">Specific?</span>
    </h1>
    <p class="subpage-subtitle" style="margin: 0 auto 36px; font-size: 15px; color: var(--text-secondary-dark);">
      The page or link you followed could not be found. It may have been moved, updated, or temporarily disconnected.
    </p>
    <div class="subpage-cta-group" style="justify-content: center; gap: 14px;">
      <a href="index.php" class="btn-primary">
        Back to Homepage
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"></line>
          <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
      </a>
      <a href="services.php" class="btn-secondary">Explore Services</a>
      <a href="contact.php" class="btn-secondary">Talk to Us</a>
    </div>
  </div>
</main>

<?php
$show_footer_cta = true;
require_once __DIR__ . '/includes/footer.php';
?>
