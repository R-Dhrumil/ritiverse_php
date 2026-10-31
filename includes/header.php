<?php
/**
 * RiTiVerse — Global Master Header & Fullscreen Navigation Overlay
 * Included across all PHP templates for unified, DRY maintenance
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

// Safe Defaults
$page_title = isset($page_title) ? $page_title : (APP_NAME . ' — ' . APP_TAGLINE);
$page_description = isset($page_description) ? $page_description : APP_DESCRIPTION;
$current_page = isset($current_page) ? $current_page : 'home';
$extra_css = isset($extra_css) && is_array($extra_css) ? $extra_css : [];

$google_analytics_id = trim(get_setting('google_analytics_id', defined('GOOGLE_ANALYTICS_ID') ? GOOGLE_ANALYTICS_ID : 'G-18XT3VN71N'));
if (preg_match('/(G-[A-Z0-9]+|GTM-[A-Z0-9]+|UA-[0-9]+-[0-9]+)/i', $google_analytics_id, $m_ga)) {
    $google_analytics_id = strtoupper($m_ga[1]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google tag (gtag.js) with DPDP Act 2023 Google Consent Mode v2 -->
  <?php if (!empty($google_analytics_id)): ?>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    // Default tracking to 'denied' under DPDP Act 2023 until affirmative consent
    gtag('consent', 'default', {
      'analytics_storage': 'denied',
      'ad_storage': 'denied',
      'ad_user_data': 'denied',
      'ad_personalization': 'denied'
    });
  </script>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($google_analytics_id) ?>"></script>
  <script>
    gtag('js', new Date());
    gtag('config', '<?= e($google_analytics_id) ?>');
  </script>
  <?php endif; ?>
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
// Dynamic Canonical, SEO & Connectivity Directives
if (!isset($canonical_url) || empty($canonical_url)) {
    if (isset($custom_canonical_url) && !empty($custom_canonical_url)) {
        $canonical_url = $custom_canonical_url;
    } else {
        $canonical_base = (defined('IS_PRIMARY_DOMAIN') && IS_PRIMARY_DOMAIN) ? PRIMARY_CANONICAL_URL : SITE_URL;
        $canonical_url = $canonical_base . '/' . ($current_page === 'home' ? '' : ($current_page . '.php'));
    }
}
if (!isset($seo_keywords) || empty($seo_keywords)) {
    $seo_keywords = get_setting('seo_primary_keywords', defined('SEO_PRIMARY_KEYWORDS') ? SEO_PRIMARY_KEYWORDS : 'custom CRM development company, custom ERP software development, website development company, offshore software development India, custom software engineering, hire CRM developers, enterprise ERP systems, bespoke web applications, zero lock-in software');
}
$google_verification = trim(get_setting('google_site_verification', defined('GOOGLE_SITE_VERIFICATION') ? GOOGLE_SITE_VERIFICATION : ''));
if (preg_match('/content=["\']([^"\']+)["\']/i', $google_verification, $m_gsc)) {
    $google_verification = $m_gsc[1];
}

$bing_verification = trim(get_setting('bing_site_verification', defined('BING_SITE_VERIFICATION') ? BING_SITE_VERIFICATION : '37D47CA67C44D215674E7B6D860E11FE'));
if (preg_match('/content=["\']([^"\']+)["\']/i', $bing_verification, $m_bing)) {
    $bing_verification = $m_bing[1];
}

$google_analytics_id = trim(get_setting('google_analytics_id', defined('GOOGLE_ANALYTICS_ID') ? GOOGLE_ANALYTICS_ID : 'G-18XT3VN71N'));
if (preg_match('/(G-[A-Z0-9]+|GTM-[A-Z0-9]+|UA-[0-9]+-[0-9]+)/i', $google_analytics_id, $m_ga)) {
    $google_analytics_id = strtoupper($m_ga[1]);
}

$meta_pixel_id = trim(get_setting('meta_pixel_id', defined('META_PIXEL_ID') ? META_PIXEL_ID : ''));
if (preg_match('/([0-9]{10,20})/', $meta_pixel_id, $m_pixel)) {
    $meta_pixel_id = $m_pixel[1];
}

// Dynamic Social Coordinates
$social_linkedin = get_setting('social_linkedin', defined('SOCIAL_LINKEDIN') ? SOCIAL_LINKEDIN : 'https://www.linkedin.com/company/ritiverse');
$social_instagram = get_setting('social_instagram', defined('SOCIAL_INSTAGRAM') ? SOCIAL_INSTAGRAM : '');
$social_github = get_setting('social_github', defined('SOCIAL_GITHUB') ? SOCIAL_GITHUB : '');
$social_x = get_setting('social_x', defined('SOCIAL_X') ? SOCIAL_X : '');
$social_facebook = get_setting('social_facebook', defined('SOCIAL_FACEBOOK') ? SOCIAL_FACEBOOK : '');
?>
  <!-- High-Ranking SEO & Indexing Meta Tags -->
  <link rel="canonical" href="<?= e($canonical_url) ?>">

  <!-- International Multi-Region Hreflang Targeting Directives -->
  <link rel="alternate" hreflang="x-default" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en-US" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en-GB" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en-CA" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en-AU" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en-AE" href="<?= e($canonical_url) ?>">
  <link rel="alternate" hreflang="en-IN" href="<?= e($canonical_url) ?>">

  <meta name="keywords" content="<?= e($seo_keywords) ?>">
  <meta name="author" content="RiTiVerse Studio">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="distribution" content="global">
  <meta name="rating" content="general">
  <meta name="geo.region" content="IN-GJ">
  <meta name="geo.placename" content="Vadodara, Gujarat, India">
  <meta name="geo.position" content="22.307159;73.181219">
  <meta name="ICBM" content="22.307159, 73.181219">
  <?php if (!empty($google_verification)): ?>
  <meta name="google-site-verification" content="<?= e($google_verification) ?>">
  <?php endif; ?>
  <?php if (!empty($bing_verification)): ?>
  <meta name="msvalidate.01" content="<?= e($bing_verification) ?>">
  <?php endif; ?>



  <?php if (!empty($meta_pixel_id)): ?>
  <!-- Meta Pixel Code with DPDP Consent Gating -->
  <script>
    window._loadMetaPixel = function() {
      if (window._metaPixelLoaded) return;
      window._metaPixelLoaded = true;
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '<?= e($meta_pixel_id) ?>');
      fbq('track', 'PageView');
    };
    // Listen for DPDP affirmative marketing consent
    window.addEventListener('dpdpConsentChanged', function(e) {
      if (e.detail && e.detail.marketing) {
        window._loadMetaPixel();
      }
    });
  </script>
  <!-- End Meta Pixel Code -->
  <?php endif; ?>

  <!-- Open Graph / Facebook / WhatsApp Rich Previews -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= e($canonical_url) ?>">
  <meta property="og:title" content="<?= e($page_title) ?>">
  <meta property="og:description" content="<?= e($page_description) ?>">
  <meta property="og:image" content="<?= SITE_URL ?>/assets/logo.png">
  <meta property="og:site_name" content="<?= e(APP_NAME) ?>">
  <meta property="og:locale" content="en_US">
  <meta property="og:locale:alternate" content="en_GB">
  <meta property="og:locale:alternate" content="en_IN">
  <meta property="og:locale:alternate" content="en_AE">
  <meta property="og:locale:alternate" content="en_CA">
  <meta property="og:locale:alternate" content="en_AU">

  <!-- Twitter Card Data -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= e($canonical_url) ?>">
  <meta name="twitter:title" content="<?= e($page_title) ?>">
  <meta name="twitter:description" content="<?= e($page_description) ?>">
  <meta name="twitter:image" content="<?= SITE_URL ?>/assets/logo.png">

  <!-- DNS prefetch for third-party scripts -->
  <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
  <link rel="dns-prefetch" href="https://www.googletagmanager.com">

  <!-- Google Structured Data (JSON-LD) for #1 Rankings on Website Making, CRM, ERP & Software Dev -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": ["Organization", "ProfessionalService", "LocalBusiness"],
        "@id": "https://ritiverse.in/#organization",
        "name": "RiTiVerse",
        "alternateName": ["RiTiVerse IT Services", "RiTiVerse Official", "RiTiVerse Studio", "RiTiVerse Software Studio", "ritiverse.in"],
        "legalName": "RiTiVerse Studio",
        "url": "https://ritiverse.in",
        "logo": "https://ritiverse.in/assets/logo.png",
        "image": "https://ritiverse.in/assets/logo.png",
        "brand": {
          "@type": "Brand",
          "name": "RiTiVerse",
          "url": "https://ritiverse.in"
        },
        "description": "RiTiVerse is an official IT services and custom software development company in Vadodara, Gujarat. We build high-performance websites, custom CRM platforms, enterprise ERP systems, and mobile applications with 100% source code ownership.",
        "email": "info@ritiverse.in",
        "telephone": "+91-94267-82646",
        "knowsAbout": [
          "IT Services",
          "Custom Software Development",
          "Web Development",
          "CRM Software Development",
          "ERP Software Development",
          "Mobile Application Development",
          "E-Commerce Development"
        ],
        "sameAs": [
          "<?= e($social_linkedin) ?>",
          "<?= e($social_instagram) ?>",
          "<?= e($social_github) ?>",
          "<?= e($social_x) ?>",
          "<?= e($social_facebook) ?>"
        ],
        "priceRange": "$$",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Vadodara",
          "addressRegion": "Gujarat",
          "addressCountry": "IN"
        },
        "geo": {
          "@type": "GeoCoordinates",
          "latitude": "22.307159",
          "longitude": "73.181219"
        },
        "areaServed": [
          {
            "@type": "City",
            "name": "Vadodara"
          },
          {
            "@type": "AdministrativeArea",
            "name": "Gujarat"
          },
          {
            "@type": "Country",
            "name": "India"
          },
          "Worldwide", "US", "GB", "AE", "CA", "AU", "DE", "SG"
        ],
        "hasOfferCatalog": {
          "@type": "OfferCatalog",
          "name": "Software Engineering Services in Vadodara & Worldwide",
          "itemListElement": [
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Web Development Company in Vadodara",
                "description": "High-converting, ultra-fast custom business websites and web portals engineered in Vadodara with React and modern PHP."
              }
            },
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Custom CRM Software Development in Vadodara",
                "description": "Tailored CRM platforms for sales pipelines, automated client follow-ups, and WhatsApp lead tracking for Vadodara and global enterprises."
              }
            },
            {
              "@type": "Offer",
              "itemOffered": {
                "@type": "Service",
                "name": "Enterprise ERP & Billing Software in Vadodara",
                "description": "Custom ERP systems, inventory management, and automated GST billing software with zero monthly license fees."
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
        "@id": "https://ritiverse.in/#website",
        "url": "https://ritiverse.in",
        "name": "RiTiVerse",
        "alternateName": ["RiTiVerse IT Services", "RiTiVerse Official Website", "ritiverse.in", "RiTiVerse Studio"],
        "description": "Official Website of RiTiVerse — IT Services, Custom Website Making, CRM & ERP Software Development",
        "publisher": {
          "@id": "https://ritiverse.in/#organization"
        },
        "potentialAction": {
          "@type": "SearchAction",
          "target": {
            "@type": "EntryPoint",
            "urlTemplate": "https://ritiverse.in/?s={search_term_string}"
          },
          "query-input": "required name=search_term_string"
        }
      }
      <?php if ($current_page !== 'home'): ?>
      ,
      {
        "@type": "BreadcrumbList",
        "@id": "<?= rtrim(e($canonical_url), '/') ?>/#breadcrumb",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "<?= SITE_URL ?>/"
          }
          <?php if ($current_page === 'services'): ?>
          ,
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Services",
            "item": "<?= SITE_URL ?>/services.php"
          }
          <?php elseif (isset($service) && !empty($service)): ?>
          ,
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Services",
            "item": "<?= SITE_URL ?>/services.php"
          },
          {
            "@type": "ListItem",
            "position": 3,
            "name": "<?= e($service['title']) ?>",
            "item": "<?= e($canonical_url) ?>"
          }
          <?php else: ?>
          ,
          {
            "@type": "ListItem",
            "position": 2,
            "name": "<?= ucfirst(str_replace('-', ' ', $current_page)) ?>",
            "item": "<?= e($canonical_url) ?>"
          }
          <?php endif; ?>
        ]
      }
      <?php endif; ?>
      <?php if (!empty($service)): ?>
      ,
      {
        "@type": "Service",
        "@id": "<?= rtrim(e($canonical_url), '/') ?>/#service",
        "name": "<?= e($service['title']) ?>",
        "serviceType": "<?= e($service['title']) ?>",
        "description": "<?= e($page_description) ?>",
        "provider": {
          "@id": "<?= SITE_URL ?>/#organization"
        },
        "areaServed": ["Worldwide", "US", "GB", "AE", "CA", "AU", "IN", "DE", "SG"],
        "termsOfService": "<?= SITE_URL ?>/",
        "offers": {
          "@type": "Offer",
          "price": "0",
          "priceCurrency": "USD",
          "availability": "https://schema.org/InStock",
          "description": "Fixed scope milestone sprints with 100% source code ownership and zero vendor lock-in"
        }
      }
      <?php endif; ?>
      <?php if (!empty($service['faqs'])): ?>
      ,
      {
        "@type": "FAQPage",
        "@id": "<?= rtrim(e($canonical_url), '/') ?>/#faq",
        "mainEntity": [
          <?php 
            $faq_schemas = [];
            foreach ($service['faqs'] as $faq_item) {
                $faq_schemas[] = json_encode([
                    '@type' => 'Question',
                    'name' => $faq_item['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq_item['a']
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            echo implode(",\n          ", $faq_schemas);
          ?>
        ]
      }
      <?php elseif ($current_page === 'home' || $current_page === 'services'): ?>
      ,
      {
        "@type": "FAQPage",
        "@id": "<?= rtrim(e($canonical_url), '/') ?>/#faq",
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

  <!-- Google Fonts: Preconnect + Non-blocking load (prevents render-blocking) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Preload critical font subset for LCP speed -->
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"></noscript>
  <!-- JetBrains Mono loaded async (only used in code blocks, non-critical) -->
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap"></noscript>

  <!-- Core Base Stylesheet (Design System & Tokens) -->
  <?php 
    $base_css_file = __DIR__ . '/../css/base.css';
    $base_css_ver = file_exists($base_css_file) ? filemtime($base_css_file) : '2.3';
    $dpdp_css_file = __DIR__ . '/../css/dpdp.css';
    $dpdp_css_ver = file_exists($dpdp_css_file) ? filemtime($dpdp_css_file) : '1.0';
  ?>
  <!-- Critical inline styles for smooth FCP -->
  <style>
    :root{--bg-page:#FAF7EE;--brand-orange:#F86800;--color-text-primary:#1a1209;}
    body{background:#FAF7EE;color:#1a1209;margin:0;}
  </style>
  <link rel="stylesheet" href="css/base.css?v=<?= $base_css_ver ?>">
  <link rel="stylesheet" href="css/dpdp.css?v=<?= $dpdp_css_ver ?>">

  <!-- Page-Specific Modular Stylesheets -->
  <?php foreach ($extra_css as $css_path): 
    $full_css = __DIR__ . '/../' . ltrim($css_path, '/');
    $cver = file_exists($full_css) ? filemtime($full_css) : '2.3';
  ?>
    <link rel="stylesheet" href="<?= e($css_path) ?>?v=<?= $cver ?>">
  <?php endforeach; ?>
</head>

<body>

  <!-- Top Floating Minimalist Navigation (Closed State) -->
  <header class="synex-nav" id="synex-nav">
    <div class="synex-nav-left">
      <!-- Modern & Minimal Floating Brand Wordmark with Logo -->
      <a href="/" class="synex-brand" aria-label="RiTiVerse Home">
        <img src="assets/logo-nav.webp" alt="RiTiVerse Logo" class="synex-brand-logo" fetchpriority="high" width="32" height="32" />
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
        <a href="/" class="synex-brand" aria-label="RiTiVerse Home">
          <img src="assets/logo-nav.webp" alt="RiTiVerse Logo" class="synex-brand-logo" width="32" height="32" loading="lazy" />
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
                <a href="/" class="fs-nav-link <?= is_active('home', $current_page) ?>">
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
              <a href="<?= e($social_linkedin) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">LinkedIn</a>
              <a href="<?= e($social_instagram) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">Instagram</a>
              <a href="<?= e($social_github) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">GitHub</a>
              <a href="<?= e($social_x) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">X (Twitter)</a>
              <a href="<?= e($social_facebook) ?>" target="_blank" rel="noopener noreferrer" class="fs-social-link">Facebook</a>
            </div>
          </div>

          <div class="fs-meta-block">
            <span class="fs-meta-label">DIRECT CONTACT</span>
            <div class="fs-contact-info">
              <a href="mailto:<?= e(CONTACT_EMAIL) ?>" class="fs-contact-email"><?= e(CONTACT_EMAIL) ?></a>
              <a href="mailto:<?= e(SUPPORT_EMAIL) ?>" class="fs-contact-email" style="margin-top: 4px;"><?= e(SUPPORT_EMAIL) ?></a>
              <span class="fs-contact-address">Vadodara, Gujarat, India • Global Client Delivery (100% Client Ownership)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
