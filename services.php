<?php
/**
 * RiTiVerse — Our Services — RiTiVerse
 */
$page_title = 'Website Making, CRM & ERP Development Services — RiTiVerse';
$page_description = 'Custom development services for business websites, enterprise CRM platforms, ERP billing systems, and mobile apps with 100% client source code ownership.';
$current_page = 'services';
$extra_css = ['css/services.css'];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
  <main class="subpage-hero">
    <div class="subpage-hero-container">
      <div class="subpage-badge">
        <span class="subpage-badge-dot"></span>
        Our Services &amp; Capabilities
      </div>
      <h1 class="subpage-title">
        Websites &amp; Software Built for Real Business Growth.<br>
        <span class="accent-text">You Own 100% of the Code.</span>
      </h1>
      <p class="subpage-subtitle">
        We build fast websites, mobile apps, custom CRM, ERP software, and e-commerce stores tailored to your business. No monthly platform lock-in, no hidden charges.
      </p>
      <div class="subpage-cta-group">
        <a href="contact.php" class="btn-primary">
          Get a Free Project Quote
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
        <a href="#matrix" class="btn-secondary">See Why We're Different</a>
      </div>
    </div>
  </main>

  <!-- ==========================================================================
       DRIBBLLE-INSPIRED SPECIALIZED SERVICES SHOWCASE
       Featuring: Website Dev, App Dev, Custom Software, ERP, CRM
       ========================================================================== -->
  <section class="dribbble-services-section" id="services-showcase">
    <div class="dribbble-services-container">

      <!-- Header Matching Dribbble Shot (Two-Column Layout) -->
      <div class="dribbble-services-header">
        <div class="dribbble-header-left">
          <div class="dribbble-eyebrow">
            <span class="dribbble-eyebrow-dot"></span>
            OUR CORE SERVICES
          </div>
          <h2 class="dribbble-main-title">
            Services We <span class="dribbble-accent-text">Provide</span><br>
            For Your Business
          </h2>
        </div>
        <div class="dribbble-header-right">
          <p class="dribbble-header-desc">
            We build custom business websites, mobile apps, CRM systems, ERP platforms, and e-commerce stores—with 100% full source code ownership handed over directly to you.
          </p>
        </div>
      </div>

      <!-- Services Interactive List & Dynamic Preview Arena -->
      <div class="dribbble-services-layout">

        <!-- Left Column: The 6 Core Services -->
        <div class="dribbble-services-list" id="servicesList" role="tablist" aria-label="RiTiVerse Services">

          <!-- Item 1: Website Development (Default Active) -->
          <div class="dribbble-service-item is-active" data-service="web" tabindex="0" role="tab" aria-selected="true"
            aria-controls="preview-web">
            <div class="dribbble-item-row">
              <div class="dribbble-item-main">
                <div class="dribbble-item-header">
                  <h3 class="dribbble-item-title">
                    Website Development<span class="dribbble-title-dot">.</span>
                  </h3>
                  <p class="dribbble-item-desc">
                    Fast, clean, and mobile-friendly websites built with React and PHP. Designed to load in under 2 seconds and convert visitors into inquiries.
                    <br><a href="website-development.php" class="dribbble-detail-link">Explore Dedicated Page ↗</a>
                  </p>
                </div>
              </div>
              <a href="website-development.php" class="dribbble-item-arrow" aria-label="Explore Website Development" title="Explore Website Development">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            </div>
          </div>

          <!-- Item 2: App Development -->
          <div class="dribbble-service-item" data-service="app" tabindex="0" role="tab" aria-selected="false"
            aria-controls="preview-app">
            <div class="dribbble-item-row">
              <div class="dribbble-item-main">
                <div class="dribbble-item-header">
                  <h3 class="dribbble-item-title">
                    Mobile App Development<span class="dribbble-title-dot">.</span>
                  </h3>
                  <p class="dribbble-item-desc">
                    High-performance Android and iOS apps with smooth animations, offline data access, and instant push notifications for your users.
                    <br><a href="mobile-app-development.php" class="dribbble-detail-link">Explore Dedicated Page ↗</a>
                  </p>
                </div>
              </div>
              <a href="mobile-app-development.php" class="dribbble-item-arrow" aria-label="Explore Mobile App Development" title="Explore Mobile App Development">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            </div>
          </div>

          <!-- Item 3: Custom Software Development -->
          <div class="dribbble-service-item" data-service="software" tabindex="0" role="tab" aria-selected="false"
            aria-controls="preview-software">
            <div class="dribbble-item-row">
              <div class="dribbble-item-main">
                <div class="dribbble-item-header">
                  <h3 class="dribbble-item-title">
                    Custom Software &amp; APIs<span class="dribbble-title-dot">.</span>
                  </h3>
                  <p class="dribbble-item-desc">
                    Tailored business software that fits your exact workflow. Automate daily manual tasks and connect third-party APIs easily.
                    <br><a href="custom-software-development.php" class="dribbble-detail-link">Explore Dedicated Page ↗</a>
                  </p>
                </div>
              </div>
              <a href="custom-software-development.php" class="dribbble-item-arrow" aria-label="Explore Custom Software Development" title="Explore Custom Software Development">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            </div>
          </div>

          <!-- Item 4: ERP -->
          <div class="dribbble-service-item" data-service="erp" tabindex="0" role="tab" aria-selected="false"
            aria-controls="preview-erp">
            <div class="dribbble-item-row">
              <div class="dribbble-item-main">
                <div class="dribbble-item-header">
                  <h3 class="dribbble-item-title">
                    Custom ERP Systems<span class="dribbble-title-dot">.</span>
                  </h3>
                  <p class="dribbble-item-desc">
                    Complete management software for billing, stock inventory, purchasing, finances, and staff tracking—custom-built for your business.
                    <br><a href="erp-development.php" class="dribbble-detail-link">Explore Dedicated Page ↗</a>
                  </p>
                </div>
              </div>
              <a href="erp-development.php" class="dribbble-item-arrow" aria-label="Explore ERP Systems" title="Explore ERP Systems Details">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            </div>
          </div>

          <!-- Item 5: CRM -->
          <div class="dribbble-service-item" data-service="crm" tabindex="0" role="tab" aria-selected="false"
            aria-controls="preview-crm">
            <div class="dribbble-item-row">
              <div class="dribbble-item-main">
                <div class="dribbble-item-header">
                  <h3 class="dribbble-item-title">
                    Custom CRM Platforms<span class="dribbble-title-dot">.</span>
                  </h3>
                  <p class="dribbble-item-desc">
                    Manage customer inquiries, assign leads to sales reps, set WhatsApp/email reminders, and track conversion pipelines easily.
                    <br><a href="crm-development.php" class="dribbble-detail-link">Explore Dedicated Page ↗</a>
                  </p>
                </div>
              </div>
              <a href="crm-development.php" class="dribbble-item-arrow" aria-label="Explore CRM Platforms" title="Explore CRM Platforms Details">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            </div>
          </div>

          <!-- Item 6: E-Commerce Development -->
          <div class="dribbble-service-item" data-service="ecommerce" tabindex="0" role="tab" aria-selected="false"
            aria-controls="preview-ecommerce">
            <div class="dribbble-item-row">
              <div class="dribbble-item-main">
                <div class="dribbble-item-header">
                  <h3 class="dribbble-item-title">
                    E-Commerce Storefronts<span class="dribbble-title-dot">.</span>
                  </h3>
                  <p class="dribbble-item-desc">
                    Fast online shopping stores with one-click checkout, automated order management, and secure Razorpay, UPI, and card payments.
                    <br><a href="ecommerce-development.php" class="dribbble-detail-link">Explore Dedicated Page ↗</a>
                  </p>
                </div>
              </div>
              <a href="ecommerce-development.php" class="dribbble-item-arrow" aria-label="Explore E-Commerce Storefronts" title="Explore E-Commerce Storefronts Details">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </a>
            </div>
          </div>

        </div>

        <!-- Right Column: Dynamic Preview Arena Matching the Dribbble Hero Graphic -->
        <div class="dribbble-preview-arena" id="previewArena">

          <!-- Preview Card 1: Website Development -->
          <div class="dribbble-preview-card is-visible" id="preview-web" data-preview="web" role="tabpanel">
            <div class="dribbble-mockup-window">
              <!-- Window Top Bar -->
              <div class="mockup-window-header">
                <div class="mockup-window-dots">
                  <span class="m-dot red"></span>
                  <span class="m-dot yellow"></span>
                  <span class="m-dot green"></span>
                </div>
                <div class="mockup-window-url">ritiverse.in/web</div>
                <div class="mockup-window-close">✕</div>
              </div>

              <!-- Main Inner Frame -->
              <div class="mockup-window-body">
                <!-- Floating Badge Top-Left (Avatar / Icon Pill like screenshot) -->
                <div class="floating-pill-badge pill-top-left pill-brand-blue">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  </svg>
                </div>

                <!-- Floating Badge Top-Right ([UX] Badge like screenshot) -->
                <div class="floating-pill-badge pill-top-right pill-brand-bold">
                  UX
                </div>

                <!-- Central Content Card (Profile / Hero Wireframe like screenshot) -->
                <div class="mockup-center-card">
                  <div class="center-card-avatar">
                    <svg viewBox="0 0 24 24" width="34" height="34" fill="none" stroke="#008CD8" stroke-width="2">
                      <circle cx="12" cy="8" r="5"></circle>
                      <path d="M20 21a8 8 0 1 0-16 0"></path>
                    </svg>
                  </div>
                  <div class="center-card-lines">
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                  </div>
                  <div class="center-card-tag">React 19 • 100/100</div>
                </div>

                <!-- Floating Badge Bottom-Left ([UI] Badge like screenshot) -->
                <div class="floating-pill-badge pill-bottom-left pill-slate">
                  UI
                </div>

                <!-- Floating Toggle Switch Bottom-Right (Toggle like screenshot) -->
                <div class="floating-toggle-badge pill-bottom-right">
                  <span class="toggle-track active">
                    <span class="toggle-thumb"></span>
                  </span>
                </div>
              </div>
            </div>
            <a href="website-development.php" class="preview-open-link">
              <span>Explore Dedicated Website Development Page</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>

          <!-- Preview Card 2: App Development -->
          <div class="dribbble-preview-card" id="preview-app" data-preview="app" role="tabpanel">
            <div class="dribbble-mockup-window">
              <div class="mockup-window-header">
                <div class="mockup-window-dots">
                  <span class="m-dot red"></span>
                  <span class="m-dot yellow"></span>
                  <span class="m-dot green"></span>
                </div>
                <div class="mockup-window-url">app.ritiverse.ios</div>
                <div class="mockup-window-close">✕</div>
              </div>

              <div class="mockup-window-body">
                <div class="floating-pill-badge pill-top-left pill-brand-blue">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                  </svg>
                </div>

                <div class="floating-pill-badge pill-top-right pill-brand-bold">
                  iOS
                </div>

                <div class="mockup-center-card">
                  <div class="center-card-avatar phone-icon-wrap">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#008CD8" stroke-width="2">
                      <rect x="5" y="2" width="14" height="20" rx="3"></rect>
                      <path d="M12 18h.01"></path>
                    </svg>
                  </div>
                  <div class="center-card-lines">
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                  </div>
                  <div class="center-card-tag">60 FPS Fluid • Native UI</div>
                </div>

                <div class="floating-pill-badge pill-bottom-left pill-slate">
                  Android
                </div>

                <div class="floating-toggle-badge pill-bottom-right">
                  <span class="toggle-track active">
                    <span class="toggle-thumb"></span>
                  </span>
                </div>
              </div>
            </div>
            <a href="mobile-app-development.php" class="preview-open-link">
              <span>Explore Dedicated Mobile App Page</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>

          <!-- Preview Card 3: Custom Software Development -->
          <div class="dribbble-preview-card" id="preview-software" data-preview="software" role="tabpanel">
            <div class="dribbble-mockup-window">
              <div class="mockup-window-header">
                <div class="mockup-window-dots">
                  <span class="m-dot red"></span>
                  <span class="m-dot yellow"></span>
                  <span class="m-dot green"></span>
                </div>
                <div class="mockup-window-url">api.ritiverse.net</div>
                <div class="mockup-window-close">✕</div>
              </div>

              <div class="mockup-window-body">
                <div class="floating-pill-badge pill-top-left pill-brand-blue">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                  </svg>
                </div>

                <div class="floating-pill-badge pill-top-right pill-brand-bold">
                  API
                </div>

                <div class="mockup-center-card">
                  <div class="center-card-avatar">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#008CD8" stroke-width="2">
                      <rect x="2" y="2" width="20" height="8" rx="2"></rect>
                      <rect x="2" y="14" width="20" height="8" rx="2"></rect>
                      <line x1="6" y1="6" x2="6.01" y2="6"></line>
                      <line x1="6" y1="18" x2="6.01" y2="18"></line>
                    </svg>
                  </div>
                  <div class="center-card-lines">
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                  </div>
                  <div class="center-card-tag">&lt;120ms Latency • High Speed</div>
                </div>

                <div class="floating-pill-badge pill-bottom-left pill-slate">
                  REST
                </div>

                <div class="floating-toggle-badge pill-bottom-right">
                  <span class="toggle-track active">
                    <span class="toggle-thumb"></span>
                  </span>
                </div>
              </div>
            </div>
            <a href="custom-software-development.php" class="preview-open-link">
              <span>Explore Dedicated Custom Software Page</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>

          <!-- Preview Card 4: ERP -->
          <div class="dribbble-preview-card" id="preview-erp" data-preview="erp" role="tabpanel">
            <div class="dribbble-mockup-window">
              <div class="mockup-window-header">
                <div class="mockup-window-dots">
                  <span class="m-dot red"></span>
                  <span class="m-dot yellow"></span>
                  <span class="m-dot green"></span>
                </div>
                <div class="mockup-window-url">erp.enterprise.cloud</div>
                <div class="mockup-window-close">✕</div>
              </div>

              <div class="mockup-window-body">
                <div class="floating-pill-badge pill-top-left pill-brand-blue">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                  </svg>
                </div>

                <div class="floating-pill-badge pill-top-right pill-brand-bold">
                  ERP
                </div>

                <div class="mockup-center-card">
                  <div class="center-card-avatar">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#008CD8" stroke-width="2">
                      <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                      </path>
                      <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                      <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                  </div>
                  <div class="center-card-lines">
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                  </div>
                  <div class="center-card-tag">Real-Time Data • Cloud Sync</div>
                </div>

                <div class="floating-pill-badge pill-bottom-left pill-slate">
                  Supply
                </div>

                <div class="floating-toggle-badge pill-bottom-right">
                  <span class="toggle-track active">
                    <span class="toggle-thumb"></span>
                  </span>
                </div>
              </div>
            </div>
            <a href="erp-development.php" class="preview-open-link">
              <span>Explore Dedicated ERP Systems Page</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>

          <!-- Preview Card 5: CRM -->
          <div class="dribbble-preview-card" id="preview-crm" data-preview="crm" role="tabpanel">
            <div class="dribbble-mockup-window">
              <div class="mockup-window-header">
                <div class="mockup-window-dots">
                  <span class="m-dot red"></span>
                  <span class="m-dot yellow"></span>
                  <span class="m-dot green"></span>
                </div>
                <div class="mockup-window-url">crm.ritiverse.hub</div>
                <div class="mockup-window-close">✕</div>
              </div>

              <div class="mockup-window-body">
                <div class="floating-pill-badge pill-top-left pill-brand-blue">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                  </svg>
                </div>

                <div class="floating-pill-badge pill-top-right pill-brand-bold">
                  CRM
                </div>

                <div class="mockup-center-card">
                  <div class="center-card-avatar">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#008CD8" stroke-width="2">
                      <line x1="12" y1="1" x2="12" y2="23"></line>
                      <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                  </div>
                  <div class="center-card-lines">
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                  </div>
                  <div class="center-card-tag">Pipeline Flow • Lead Tracking</div>
                </div>

                <div class="floating-pill-badge pill-bottom-left pill-slate">
                  Leads
                </div>

                <div class="floating-toggle-badge pill-bottom-right">
                  <span class="toggle-track active">
                    <span class="toggle-thumb"></span>
                  </span>
                </div>
              </div>
            </div>
            <a href="crm-development.php" class="preview-open-link">
              <span>Explore Dedicated CRM Platforms Page</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>

          <!-- Preview Card 6: E-Commerce Development -->
          <div class="dribbble-preview-card" id="preview-ecommerce" data-preview="ecommerce" role="tabpanel">
            <div class="dribbble-mockup-window">
              <div class="mockup-window-header">
                <div class="mockup-window-dots">
                  <span class="m-dot red"></span>
                  <span class="m-dot yellow"></span>
                  <span class="m-dot green"></span>
                </div>
                <div class="mockup-window-url">store.ritiverse.shop</div>
                <div class="mockup-window-close">✕</div>
              </div>

              <div class="mockup-window-body">
                <div class="floating-pill-badge pill-top-left pill-brand-blue">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                </div>

                <div class="floating-pill-badge pill-top-right pill-brand-bold">
                  SHOP
                </div>

                <div class="mockup-center-card">
                  <div class="center-card-avatar">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#008CD8" stroke-width="2">
                      <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                      <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                  </div>
                  <div class="center-card-lines">
                    <div class="card-line long"></div>
                    <div class="card-line short"></div>
                  </div>
                  <div class="center-card-tag">Fast Checkout • Secure Payments</div>
                </div>

                <div class="floating-pill-badge pill-bottom-left pill-slate">
                  Orders
                </div>

                <div class="floating-toggle-badge pill-bottom-right">
                  <span class="toggle-track active">
                    <span class="toggle-thumb"></span>
                  </span>
                </div>
              </div>
            </div>
            <a href="ecommerce-development.php" class="preview-open-link">
              <span>Explore Dedicated E-Commerce Storefronts Page</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>

        </div>

      </div>

    </div>
  </section>

  <section class="subpage-section" id="matrix"
    style="background: rgba(250, 247, 238, 0.9); backdrop-filter: blur(20px); border-top: 1px solid rgba(226, 218, 204, 0.85); border-bottom: 1px solid rgba(226, 218, 204, 0.85);">
    <div class="subpage-container">
      <div class="section-badge-header">
        <span class="section-eyebrow">
          <span class="section-eyebrow-dot"></span>
          Why Choose RiTiVerse?
        </span>
        <h2 class="section-title">RiTiVerse vs. Traditional Agencies &amp; Freelancers</h2>
        <p class="section-subtitle">
          Why growing businesses and startups choose us: complete transparency, fair milestone pricing, and 100% source code ownership.
        </p>
      </div>

      <div class="matrix-table-wrap">
        <table class="matrix-table">
          <thead>
            <tr>
              <th>What Matters To You</th>
              <th class="col-ritiverse">RiTiVerse</th>
              <th class="col-trad">Traditional Agencies &amp; Freelancers</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Source Code Ownership</strong></td>
              <td class="col-ritiverse">100% Yours. Pushed directly to your company's GitHub / GitLab account</td>
              <td class="col-trad">Code is withheld, or charged heavy yearly renewal fees</td>
            </tr>
            <tr>
              <td><strong>Cloud &amp; Hosting Accounts</strong></td>
              <td class="col-ritiverse">Setup directly in your own AWS/GCP/Hostinger account (No hidden markups)</td>
              <td class="col-trad">Hosted on agency servers with expensive monthly retainers</td>
            </tr>
            <tr>
              <td><strong>Developer Lock-In</strong></td>
              <td class="col-ritiverse">Zero. Standard, clean code that any competent developer can maintain</td>
              <td class="col-trad">High. Locked inside rigid templates or proprietary CMS platforms</td>
            </tr>
            <tr>
              <td><strong>Project Updates &amp; Demos</strong></td>
              <td class="col-ritiverse">Weekly live staging demos so you see real working progress every week</td>
              <td class="col-trad">No updates for weeks; unexpected delays right before deadlines</td>
            </tr>
            <tr>
              <td><strong>After-Launch Support</strong></td>
              <td class="col-ritiverse">Free 30-day bug fix warranty and technical handover training</td>
              <td class="col-trad">Costly monthly retainers just to make minor text or image updates</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- 4-Step Engineering Process Section -->
  <section class="subpage-section">
    <div class="subpage-container">
      <div class="section-badge-header">
        <span class="section-eyebrow">
          <span class="section-eyebrow-dot"></span>
          Our Project Process
        </span>
        <h2 class="section-title">How We Work: From Idea to Live Launch</h2>
        <p class="section-subtitle">
          Clear milestones, weekly progress demos, and on-time delivery with zero hidden surprises.
        </p>
      </div>

      <div class="process-grid">
        <div class="process-step-card">
          <span class="process-step-num">STEP 01</span>
          <h3 class="process-step-title">Discovery &amp; Planning</h3>
          <p class="process-step-desc">
            We understand your exact business goals, design the user flow, and give you a transparent project scope with fixed pricing and timelines.
          </p>
        </div>

        <div class="process-step-card">
          <span class="process-step-num">STEP 02</span>
          <h3 class="process-step-title">Design &amp; Development</h3>
          <p class="process-step-desc">
            We build with clean, modular code in React, PHP/Laravel, and Node.js. You get live demo links every week to review real progress.
          </p>
        </div>

        <div class="process-step-card">
          <span class="process-step-num">STEP 03</span>
          <h3 class="process-step-title">Testing &amp; Speed Checks</h3>
          <p class="process-step-desc">
            We test across various Android phones, iPhones, tablets, and laptops to ensure fast loading on mobile networks and complete data security.
          </p>
        </div>

        <div class="process-step-card">
          <span class="process-step-num">STEP 04</span>
          <h3 class="process-step-title">Live Launch &amp; Handover</h3>
          <p class="process-step-desc">
            We deploy your platform live. You receive 100% source code, admin credentials, domain DNS setup, and complete technical training.
          </p>
        </div>
      </div>

      <!-- Modern Tech Stack Showcase -->
      <div class="tech-stack-showcase-box">
        <div class="tech-stack-header">
          <div class="tech-stack-eyebrow">
            <span class="tech-stack-dot"></span>
            <span>Our Technology Stack</span>
          </div>
          <h3 class="tech-stack-heading">Modern Technologies We Build With</h3>
          <p class="tech-stack-subheading">
            Reliable, secure, and industry-standard technologies to ensure your website and software run fast, stay secure, and scale easily.
          </p>
        </div>

        <div class="stack-pills-wrap">
          <div class="stack-pill">
            <span class="stack-pill-icon icon-php">PHP</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">PHP 8+</span>
              <span class="stack-pill-role">Backend Engine</span>
            </div>
            <span class="stack-pill-tag">Core</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-laravel">LV</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">Laravel</span>
              <span class="stack-pill-role">Enterprise MVC</span>
            </div>
            <span class="stack-pill-tag">Framework</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-react">⚛</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">React</span>
              <span class="stack-pill-role">Component UI</span>
            </div>
            <span class="stack-pill-tag">Frontend</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-express">EX</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">Express.js</span>
              <span class="stack-pill-role">Fast REST APIs</span>
            </div>
            <span class="stack-pill-tag">API Layer</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-python">PY</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">Python</span>
              <span class="stack-pill-role">Automation &amp; Data</span>
            </div>
            <span class="stack-pill-tag">Backend</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-js">JS</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">JavaScript</span>
              <span class="stack-pill-role">Modern ES6+</span>
            </div>
            <span class="stack-pill-tag">Logic</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-html">&lt;/&gt;</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">HTML5 &amp; CSS3</span>
              <span class="stack-pill-role">Semantic Design</span>
            </div>
            <span class="stack-pill-tag">Markup</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-node">NODE</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">Node.js</span>
              <span class="stack-pill-role">Async Runtime</span>
            </div>
            <span class="stack-pill-tag">Server</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-mysql">SQL</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">MySQL</span>
              <span class="stack-pill-role">Relational DB</span>
            </div>
            <span class="stack-pill-tag">Database</span>
          </div>

          <div class="stack-pill">
            <span class="stack-pill-icon icon-cloud">SSL</span>
            <div class="stack-pill-text">
              <span class="stack-pill-name">Hosting &amp; SSL</span>
              <span class="stack-pill-role">Cloud &amp; Security</span>
            </div>
            <span class="stack-pill-tag">DevOps</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       SECTION 5: FREQUENTLY ASKED QUESTIONS (Services & Delivery)
       ========================================================================== -->
  <section class="subpage-section" id="faq"
    style="background: rgba(250, 247, 238, 0.9); backdrop-filter: blur(20px); border-top: 1px solid rgba(226, 218, 204, 0.85);">
    <div class="subpage-container" style="max-width: 880px;">
      <div class="section-badge-header">
        <span class="section-eyebrow">
          <span class="section-eyebrow-dot"></span>
          Clear Answers &amp; Zero Ambiguity
        </span>
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle">
          Upfront answers about our 6 core services, 100% code ownership guarantees, and transparent milestone deliveries.
        </p>
      </div>

      <div class="faq-accordion-wrap" style="margin-top: 40px;">

        <!-- FAQ 1 -->
        <div class="faq-item is-open">
          <button class="faq-question-btn" type="button" aria-expanded="true">
            <span class="faq-q-text">What core services does RiTiVerse provide?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                We specialize in 6 main areas: <strong>Custom Website Development</strong>, <strong>Android &amp; iOS Mobile Apps</strong>,
                <strong>Custom CRM Platforms</strong>, <strong>ERP Systems</strong>, <strong>E-Commerce Storefronts</strong>,
                and <strong>Custom Software &amp; APIs</strong>. Every solution is custom-built for your business and comes with 100% full source code ownership.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ 2 -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">Why build a custom CRM or ERP instead of paying monthly SaaS subscriptions?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                Ready-made SaaS tools charge recurring monthly per-user fees that get very expensive as your team expands. Also, they force you into generic templates. A custom CRM or ERP built by RiTiVerse is tailored 100% to your daily workflow, sales pipelines, and billing. You own the software forever with zero recurring user license fees.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ 3 -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">How do you ensure our website or online store loads fast and converts visitors?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                We build fast, clean websites using React, modern PHP/Laravel, and Node.js—never slow, bloated page builders. We optimize images, ensure sub-2-second loading on mobile networks, design clean user journeys, and integrate reliable payment gateways (Razorpay, UPI, Stripe) with automated inventory updates.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ 4 -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">Do we truly own 100% of the source code and accounts?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                <strong>Yes, 100% unconditionally.</strong> From day one, all code is pushed directly to your company's GitHub or GitLab account. Once milestones are delivered, all intellectual property, cloud servers, and domain DNS belong permanently to you. We never withhold code or charge platform lock-in fees.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ 5 -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">How do project milestones and payments work?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                We work on milestone-based payments tied to clear deliverables. Before starting, we provide a clear scope document with exact timelines and fixed costs. You test and approve live working demo links at every milestone before releasing payment, so there are zero surprise bills.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ 6 -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">What support and warranty do you provide after launch?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                Every project includes a free 30-day post-launch warranty for bug fixes, performance checks, and technical walkthroughs. We also offer affordable monthly maintenance plans if you want our team to manage server backups, security, and ongoing updates.
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

<?php
$show_footer_cta = true;
$extra_js = ['js/services.js'];
require_once __DIR__ . '/includes/footer.php';
?>
