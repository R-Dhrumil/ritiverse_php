<?php
/**
 * RiTiVerse — Global Master Header & Fullscreen Navigation Overlay
 * Included across all PHP templates for unified, DRY maintenance
 */
require_once __DIR__ . '/config.php';

// Safe Defaults
$page_title = isset($page_title) ? $page_title : (APP_NAME . ' — ' . APP_TAGLINE);
$page_description = isset($page_description) ? $page_description : APP_DESCRIPTION;
$current_page = isset($current_page) ? $current_page : 'home';
$extra_css = isset($extra_css) && is_array($extra_css) ? $extra_css : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title) ?></title>
  <meta name="description" content="<?= e($page_description) ?>">
  <!-- High-Resolution Favicons & Google Search Brand Icons -->
  <link rel="icon" type="image/png" sizes="192x192" href="<?= SITE_URL ?>/assets/logo.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= SITE_URL ?>/assets/logo.png">
  <link rel="icon" type="image/png" sizes="48x48" href="<?= SITE_URL ?>/assets/logo.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_URL ?>/assets/logo.png">
  <link rel="shortcut icon" href="<?= SITE_URL ?>/assets/logo.png" type="image/png">
  <link rel="apple-touch-icon" href="<?= SITE_URL ?>/assets/logo.png">

  <!-- Universal Progressive Web App Manifest & Browser Theme Colors -->
  <link rel="manifest" href="<?= SITE_URL ?>/site.webmanifest">
  <meta name="theme-color" content="#FAF7EE">
  <meta name="msapplication-TileColor" content="#F86800">
  <meta name="msapplication-TileImage" content="<?= SITE_URL ?>/assets/logo.png">

<?php
// Canonical & Page Metadata
$canonical_url = SITE_URL . '/' . ($current_page === 'home' ? '' : ($current_page . '.php'));
$seo_keywords = defined('SEO_PRIMARY_KEYWORDS') ? SEO_PRIMARY_KEYWORDS : 'website making, CRM software, ERP development, software development company';
?>
  <!-- High-Ranking SEO & Indexing Meta Tags -->
  <link rel="canonical" href="<?= e($canonical_url) ?>">
  <meta name="keywords" content="<?= e($seo_keywords) ?>">
  <meta name="author" content="RiTiVerse Studio">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="geo.region" content="IN">
  <meta name="geo.placename" content="India">
  <?php if (defined('GOOGLE_SITE_VERIFICATION') && GOOGLE_SITE_VERIFICATION !== ''): ?>
  <meta name="google-site-verification" content="<?= e(GOOGLE_SITE_VERIFICATION) ?>">
  <?php endif; ?>
  <?php if (defined('BING_SITE_VERIFICATION') && BING_SITE_VERIFICATION !== ''): ?>
  <meta name="msvalidate.01" content="<?= e(BING_SITE_VERIFICATION) ?>">
  <?php endif; ?>

  <!-- Open Graph / Facebook / WhatsApp Rich Previews -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= e($canonical_url) ?>">
  <meta property="og:title" content="<?= e($page_title) ?>">
  <meta property="og:description" content="<?= e($page_description) ?>">
  <meta property="og:image" content="<?= SITE_URL ?>/assets/logo.png">
  <meta property="og:site_name" content="<?= e(APP_NAME) ?>">
  <meta property="og:locale" content="en_IN">

  <!-- Twitter Card Data -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= e($canonical_url) ?>">
  <meta name="twitter:title" content="<?= e($page_title) ?>">
  <meta name="twitter:description" content="<?= e($page_description) ?>">
  <meta name="twitter:image" content="<?= SITE_URL ?>/assets/logo.png">

  <!-- Performance: DNS Prefetch & Font Preconnect -->
  <link rel="dns-prefetch" href="https://fonts.googleapis.com">
  <link rel="dns-prefetch" href="https://fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Google Structured Data (JSON-LD) for #1 Rankings on Website Making, CRM, ERP & Software Dev -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": ["ProfessionalService", "Organization"],
        "@id": "<?= SITE_URL ?>/#organization",
        "name": "RiTiVerse",
        "alternateName": ["RiTiVerse Official", "RiTiVerse Studio", "RiTiVerse Software Studio", "ritiverse.in"],
        "legalName": "RiTiVerse Studio",
        "url": "<?= SITE_URL ?>",
        "logo": "<?= SITE_URL ?>/assets/logo.png",
        "image": "<?= SITE_URL ?>/assets/logo.png",
        "brand": {
          "@type": "Brand",
          "name": "RiTiVerse",
          "url": "<?= SITE_URL ?>"
        },
        "description": "Official website of RiTiVerse — Top-rated Website Making, Custom CRM, ERP Software Development, and Mobile Application Engineering Company with 100% Client Code Ownership.",
        "email": "info@ritiverse.in",
        "telephone": "+91-94267-82646",
        "sameAs": [
          "<?= e(SOCIAL_INSTAGRAM) ?>",
          "<?= e(SOCIAL_GITHUB) ?>",
          "<?= e(SOCIAL_X) ?>",
          "<?= e(SOCIAL_FACEBOOK) ?>"
        ],
        "priceRange": "$$",
        "address": {
          "@type": "PostalAddress",
          "addressCountry": "IN"
        },
        "areaServed": ["IN", "US", "GB", "AE", "CA", "AU"],
        "hasOfferCatalog": {
          "@type": "OfferCatalog",
          "name": "Software Engineering Services",
          "itemListElement": [
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Website Making & Web Development",
                "description": "High-converting, ultra-fast custom business websites built with React and modern PHP."
              }
            },
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Custom CRM Software Development",
                "description": "Tailored CRM platforms for sales pipelines, automated client follow-ups, and lead tracking."
              }
            },
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Enterprise ERP & Billing Software",
                "description": "Custom ERP systems, inventory management, and automated GST billing software with zero monthly lock-in."
              }
            },
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Custom Software & API Development",
                "description": "Scalable full-stack software development with 100% client code ownership and microservices architecture."
              }
            },
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Mobile Application Development",
                "description": "High-performance iOS and Android mobile applications with native device integrations."
              }
            }
          ]
        }
      },
      {
        "@type": "WebSite",
        "@id": "<?= SITE_URL ?>/#website",
        "url": "<?= SITE_URL ?>",
        "name": "RiTiVerse",
        "alternateName": ["RiTiVerse Official Website", "ritiverse.in", "RiTiVerse Studio"],
        "description": "Official Website of RiTiVerse — Custom Website Making, CRM & ERP Software Development",
        "publisher": {
          "@id": "<?= SITE_URL ?>/#organization"
        }
      },
      {
        "@type": "BreadcrumbList",
        "@id": "<?= e($canonical_url) ?>/#breadcrumb",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "<?= SITE_URL ?>/"
          }
          <?php if ($current_page !== 'home'): ?>
          ,
          {
            "@type": "ListItem",
            "position": 2,
            "name": "<?= ucfirst($current_page) ?>",
            "item": "<?= e($canonical_url) ?>"
          }
          <?php endif; ?>
        ]
      }
      <?php if ($current_page === 'home' || $current_page === 'services'): ?>
      ,
      {
        "@type": "FAQPage",
        "@id": "<?= e($canonical_url) ?>/#faq",
        "mainEntity": [
          {
            "@type": "Question",
            "name": "What core services does RiTiVerse specialize in?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "RiTiVerse specializes in Custom Website Making, Custom CRM Platforms, Enterprise Resource Planning (ERP) Systems, Mobile Applications, E-Commerce Stores, and Bespoke Software Development with 100% client code ownership."
            }
          },
          {
            "@type": "Question",
            "name": "Why build a custom CRM or ERP instead of paying monthly SaaS subscriptions?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Off-the-shelf SaaS tools charge expensive monthly per-user fees that increase as your team grows. A custom CRM or ERP built by RiTiVerse is tailored 100% to your workflows, with zero monthly license fees and permanent code ownership."
            }
          },
          {
            "@type": "Question",
            "name": "Do we truly own 100% of the website and software source code?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Yes. Every line of code, database schema, and server account is transferred directly to your organization with zero vendor lock-in."
            }
          },
          {
            "@type": "Question",
            "name": "How fast do your custom websites and web applications load?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "We engineer websites with sub-2-second loading times, 95+ Google PageSpeed scores, clean Semantic HTML5, and high Core Web Vitals optimization."
            }
          }
        ]
      }
      <?php endif; ?>
    ]
  }
  </script>

  <!-- Google Fonts: Outfit, Plus Jakarta Sans & JetBrains Mono -->
  <link
    href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
    rel="stylesheet">

  <!-- Core Base Stylesheet (Design System & Tokens) -->
  <link rel="stylesheet" href="css/base.css?v=2.2">

  <!-- Page-Specific Modular Stylesheets -->
  <?php foreach ($extra_css as $css_path): ?>
    <link rel="stylesheet" href="<?= e($css_path) ?>?v=2.2">
  <?php endforeach; ?>
</head>

<body>

  <!-- Top Floating Minimalist Navigation (Closed State) -->
  <header class="synex-nav" id="synex-nav">
    <div class="synex-nav-left">
      <!-- Modern & Minimal Floating Brand Wordmark with Logo -->
      <a href="index.php" class="synex-brand" aria-label="RiTiVerse Home">
        <img src="assets/logo.png" alt="RiTiVerse Logo" class="synex-brand-logo" />
        <span class="synex-brand-name"><?= e(APP_NAME) ?></span>
      </a>
    </div>

    <!-- Navigation Right Controls: 3-Line Animated Hamburger Trigger -->
    <div class="synex-nav-right">
      <button class="synex-menu-trigger" id="synex-menu-trigger" aria-label="Open Fullscreen Navigation"
        aria-expanded="false" aria-controls="synex-fs-menu">
        <div class="hamburger-box">
          <span class="hamburger-line line-1"></span>
          <span class="hamburger-line line-2"></span>
          <span class="hamburger-line line-3"></span>
        </div>
      </button>
    </div>
  </header>

  <!-- Fullscreen Architectural Navigation Overlay (Open State) -->
  <div class="synex-fs-menu" id="synex-fs-menu" aria-hidden="true" role="dialog" aria-modal="true"
    aria-label="Navigation Menu">
    <!-- Architectural Framer-Style Grid Background -->
    <div class="fs-grid-overlay" aria-hidden="true">
      <div class="fs-grid-col"></div>
      <div class="fs-grid-col"></div>
      <div class="fs-grid-col"></div>
      <div class="fs-grid-col"></div>
      <div class="fs-grid-cross cross-1">+</div>
      <div class="fs-grid-cross cross-2">+</div>
      <div class="fs-grid-cross cross-3">+</div>
      <div class="fs-grid-cross cross-4">+</div>
      <div class="fs-ambient-glow" aria-hidden="true"></div>
    </div>

    <!-- Fullscreen Menu Top Navigation Bar -->
    <div class="fs-menu-header">
      <div class="synex-nav-left">
        <a href="index.php" class="synex-brand" aria-label="RiTiVerse Home">
          <img src="assets/logo.png" alt="RiTiVerse Logo" class="synex-brand-logo" />
          <span class="synex-brand-name"><?= e(APP_NAME) ?></span>
        </a>
      </div>
      <div class="synex-nav-right">
        <button class="fs-close-btn" id="fs-close-btn" aria-label="Close Navigation Menu">
          <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>
    </div>

    <!-- Fullscreen Menu Content -->
    <div class="fs-menu-container">
      <div class="fs-nav-main-col">
        <div class="fs-nav-links-grid">
          <!-- Navigation Column 1: Core Offerings -->
          <div class="fs-links-group">
            <ul class="fs-nav-list">
              <li class="fs-nav-item">
                <a href="index.php" class="fs-nav-link <?= is_active('home', $current_page) ?>">
                  <span class="nav-text">Home</span>
                  <span class="nav-arrow">↗</span>
                </a>
              </li>
              <li class="fs-nav-item">
                <a href="services.php" class="fs-nav-link <?= is_active('services', $current_page) ?>">
                  <span class="nav-text">Services</span>
                  <span class="nav-arrow">↗</span>
                </a>
              </li>
              <li class="fs-nav-item">
                <a href="projects.php" class="fs-nav-link <?= is_active('projects', $current_page) ?>">
                  <span class="nav-text">Projects</span>
                  <span class="nav-arrow">↗</span>
                </a>
              </li>
            </ul>
          </div>

          <!-- Navigation Column 2: Studio & Contact -->
          <div class="fs-links-group">
            <ul class="fs-nav-list">
              <li class="fs-nav-item">
                <a href="about.php" class="fs-nav-link <?= is_active('about', $current_page) ?>">
                  <span class="nav-text">About</span>
                  <span class="nav-arrow">↗</span>
                </a>
              </li>
              <li class="fs-nav-item">
                <a href="contact.php" class="fs-nav-link <?= is_active('contact', $current_page) ?>">
                  <span class="nav-text">Contact</span>
                  <span class="nav-arrow">↗</span>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Menu Footer: Social Follow & Direct Contact Info -->
        <div class="fs-menu-footer">
          <div class="fs-meta-block">
            <span class="fs-meta-label">FOLLOW</span>
            <div class="fs-social-links">
              <a href="<?= e(SOCIAL_INSTAGRAM) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">Instagram</a>
              <a href="<?= e(SOCIAL_GITHUB) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">GitHub</a>
              <a href="<?= e(SOCIAL_X) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">X (Twitter)</a>
              <a href="<?= e(SOCIAL_FACEBOOK) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">Facebook</a>
            </div>
          </div>

          <div class="fs-meta-block">
            <span class="fs-meta-label">DIRECT CONTACT</span>
            <div class="fs-contact-info">
              <a href="mailto:<?= e(CONTACT_EMAIL) ?>" class="fs-contact-email"><?= e(CONTACT_EMAIL) ?></a>
              <a href="mailto:<?= e(SUPPORT_EMAIL) ?>" class="fs-contact-email" style="margin-top: 4px;"><?= e(SUPPORT_EMAIL) ?></a>
              <span class="fs-contact-address">Modern Engineering Studio • 100% Client Ownership</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
