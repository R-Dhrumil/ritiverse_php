<?php
/**
 * RiTiVerse — RItiverse — Elite Website & Software Development
 */
$page_title = 'RiTiVerse — Custom Website, CRM & ERP Software Development';
$page_description = 'RiTiVerse builds custom websites, CRM platforms, ERP billing systems, and mobile apps with 100% source code ownership and zero monthly lock-in.';
$current_page = 'home';
$extra_css = ['css/index.css'];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Hero Section -->
  <main class="synex-hero" id="synex-hero">

    <!-- 3D Particle Silk-Dust Motion Canvas -->
    <div class="hero-motion-bg" aria-hidden="true">
      <canvas id="synex-motion-canvas"></canvas>
    </div>

    <!-- Hero Header & Typography -->
    <div class="hero-header">
      <div class="subpage-badge" style="margin-bottom: 16px;">
        <span class="subpage-badge-dot"></span>
        RiTiVerse Official Studio
      </div>
      <h1 class="hero-title">
        <span class="hero-title-main">You Own It.</span>
        <span class="hero-rotator-wrapper" aria-label="Zero Lock-In.">
          <span class="hero-rotator" id="hero-rotator">
            <span class="rotator-item is-active">Zero Lock-In.</span>
            <span class="rotator-item">You Control It.</span>
            <span class="rotator-item">You Scale It.</span>
            <span class="rotator-item">100% Freedom.</span>
          </span>
        </span>
      </h1>
      <p class="hero-description">
        Custom-built websites and software with full source ownership, so your technology never depends on us
      </p>

      <!-- Interactive Email Capture Capsule -->
      <form class="hero-cta-form" id="hero-cta-form">
        <input type="email" class="hero-cta-input" id="hero-email-input"
          placeholder="Enter work email for consultation..." required autocomplete="email" aria-label="Work email">
        <button type="submit" class="hero-cta-btn" id="hero-submit-btn">
          Start a project
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </button>
        <div class="cta-status-message" id="cta-status-message"></div>
      </form>
    </div>

    <!-- Hero Stage Container (Apple-Style Clean Scale Anchor) -->
    <div class="hero-stage-container" id="hero-stage">

      <!-- GSAP Scroll-Linked Scale Target (Apple-Style Clean Reveal) -->
      <div class="dashboard-scroll-target" id="dashboard-scroll-target">

        <!-- =========================================================================
             TAILORED CLIENT ADMIN CONSOLE (Interactive Scroll Reveal Centerpiece)
             ========================================================================= -->
        <div class="console admin-console" id="admin-control">

          <!-- Top bar: macOS / Studio Chrome Header -->
          <div class="console-top">
            <div class="console-top-left">
              <div class="dots" aria-hidden="true">
                <span class="dot rose"></span>
                <span class="dot amber"></span>
                <span class="dot emerald"></span>
              </div>
              <span class="console-title">Client Admin Console</span>
              <span class="console-path" aria-hidden="true">ritiverse://studio/live-v2.4</span>
            </div>
            <div class="console-live">
              <span class="ping" aria-hidden="true"></span>
              <span class="mono">Live Interactive Demo</span>
            </div>
          </div>

          <!-- Navigation Tab Bar -->
          <div class="tabs" id="tabs" role="tablist" aria-label="Admin Control Modules">
            <span class="tab-indicator" id="tabIndicator" aria-hidden="true"></span>
            <button class="tab active" role="tab" data-tab="cms" id="tab-cms" aria-selected="true">
              <svg class="icon"><use href="#i-file-text"/></svg>
              <span>Website Content</span>
            </button>
            <button class="tab" role="tab" data-tab="toggles" id="tab-toggles" aria-selected="false">
              <svg class="icon"><use href="#i-sliders"/></svg>
              <span>Feature Toggles</span>
            </button>
            <button class="tab" role="tab" data-tab="leads" id="tab-leads" aria-selected="false">
              <svg class="icon"><use href="#i-inbox"/></svg>
              <span>Customer Inquiries</span>
            </button>
            <button class="tab" role="tab" data-tab="roles" id="tab-roles" aria-selected="false">
              <svg class="icon"><use href="#i-users"/></svg>
              <span>Staff Permissions</span>
            </button>
          </div>

          <!-- Main Interactive Console Body -->
          <div class="console-body">
            <div class="panels">

              <!-- Module 1: CMS Live Content Management -->
              <div class="panel stack-5 active" id="panel-cms" role="tabpanel" aria-labelledby="tab-cms">
                <div class="panel-head between">
                  <div class="panel-head-left">
                    <span class="label">Live Website Content Editor</span>
                    <span class="label-sub">Update site copy, prices, and banners instantly without waiting for developers</span>
                  </div>
                  <span class="badge-amber">
                    <span class="badge-dot"></span>
                    Instant Live Sync
                  </span>
                </div>
                <div class="grid cols-2 gap-6">
                  <div class="cms-input-col">
                    <label class="field-label" for="heroInput">Hero Headline (Live Preview)</label>
                    <input type="text" id="heroInput" class="input" value="Grow Your Business With Modern Websites &amp; Custom Software" placeholder="Type new headline to preview..." autocomplete="off" />
                    <div class="chip-row">
                      <button type="button" class="chip active-preset" data-heading="Grow Your Business With Modern Websites &amp; Custom Software">Example: Business Website</button>
                      <button type="button" class="chip" data-heading="Complete ERP &amp; Billing Portal for Operations">Example: ERP &amp; Billing</button>
                      <button type="button" class="chip" data-heading="High-Converting Online Store With Instant UPI &amp; Razorpay">Example: E-Commerce Store</button>
                    </div>
                  </div>
                  <div class="preview-box">
                    <div class="mono-label">
                      <svg class="icon amber"><use href="#i-eye"/></svg>
                      <span>Live Customer Viewport</span>
                      <span class="live-pill"><span class="live-pill-dot"></span>Loads in 0.02s</span>
                    </div>
                    <div class="preview-card">
                      <h5 id="heroPreview">Grow Your Business With Modern Websites &amp; Custom Software</h5>
                      <p>Changes update immediately across all visitor screens once you save.</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Module 2: Feature Switches & Toggles -->
              <div class="panel stack-5" id="panel-toggles" role="tabpanel" aria-labelledby="tab-toggles">
                <div class="panel-head between">
                  <div class="panel-head-left">
                    <span class="label">Feature Switches &amp; Banners</span>
                    <span class="label-sub">Turn customer-facing features on or off with a single click—no code changes required</span>
                  </div>
                  <span class="badge-status">3 Services Connected</span>
                </div>
                <div class="grid cols-3 gap-4">
                  <div class="card toggle-card" id="card-toggle-promo">
                    <div class="between">
                      <div class="card-title-group">
                        <span class="card-icon-wrap emerald"><svg class="card-icon"><use href="#i-sliders"/></svg></span>
                        <span class="card-title">Festival Offer Banner</span>
                      </div>
                      <button class="toggle-btn" data-toggle="promo" data-on-color="emerald" data-on="Active on Site" data-off="Disabled" aria-pressed="true" aria-label="Toggle Festival Offer Banner">
                        <svg class="toggle-icon"><use href="#i-toggle-right"/></svg>
                      </button>
                    </div>
                    <span class="toggle-status"></span>
                  </div>
                  <div class="card toggle-card" id="card-toggle-chat">
                    <div class="between">
                      <div class="card-title-group">
                        <span class="card-icon-wrap emerald"><svg class="card-icon"><use href="#i-users"/></svg></span>
                        <span class="card-title">WhatsApp Chat Widget</span>
                      </div>
                      <button class="toggle-btn" data-toggle="chat" data-on-color="emerald" data-on="Enabled" data-off="Disabled" aria-pressed="true" aria-label="Toggle WhatsApp Chat Widget">
                        <svg class="toggle-icon"><use href="#i-toggle-right"/></svg>
                      </button>
                    </div>
                    <span class="toggle-status"></span>
                  </div>
                  <div class="card toggle-card" id="card-toggle-maintenance">
                    <div class="between">
                      <div class="card-title-group">
                        <span class="card-icon-wrap amber"><svg class="card-icon"><use href="#i-shield-check"/></svg></span>
                        <span class="card-title">Maintenance Notice</span>
                      </div>
                      <button class="toggle-btn" data-toggle="maintenance" data-on-color="amber" data-on="Active Notice" data-off="Off" aria-pressed="false" aria-label="Toggle Maintenance Notice">
                        <svg class="toggle-icon"><use href="#i-toggle-left"/></svg>
                      </button>
                    </div>
                    <span class="toggle-status"></span>
                  </div>
                </div>
              </div>

              <!-- Module 3: Leads & Direct Inquiries -->
              <div class="panel stack-5" id="panel-leads" role="tabpanel" aria-labelledby="tab-leads">
                <div class="panel-head between">
                  <div class="panel-head-left">
                    <span class="label">Real-Time Customer Inquiries</span>
                    <span class="label-sub">Direct submissions from your website with instant alerts</span>
                  </div>
                  <button type="button" class="btn-dark" id="exportLeadsBtn">
                    <svg class="btn-icon"><use href="#i-file-text"/></svg>
                    <span>Export to Excel/CSV</span>
                  </button>
                </div>
                <div class="stack-2-5">
                  <div class="card lead between">
                    <div class="lead-info">
                      <div class="lead-header-row">
                        <p class="lead-name">Amit Sharma</p>
                        <span class="lead-time">9m ago</span>
                      </div>
                      <p class="lead-sub">Custom Web App + Admin Portal &bull; ₹2,50,000 Budget</p>
                    </div>
                    <button type="button" class="status-btn" id="lead1" title="Click to update status">New Lead</button>
                  </div>
                  <div class="card lead between">
                    <div class="lead-info">
                      <div class="lead-header-row">
                        <p class="lead-name">Pooja Verma</p>
                        <span class="lead-time">42m ago</span>
                      </div>
                      <p class="lead-sub">E-Commerce Store &amp; Inventory &bull; Launch Scope</p>
                    </div>
                    <button type="button" class="status-btn blue" id="lead2" title="Click to update status">Contacted</button>
                  </div>
                </div>
              </div>

              <!-- Module 4: Role-Based Access Control -->
              <div class="panel stack-4" id="panel-roles" role="tabpanel" aria-labelledby="tab-roles">
                <div class="panel-head between">
                  <div class="panel-head-left">
                    <span class="label">Staff &amp; Team Permissions</span>
                    <span class="label-sub">Control who can access accounts, customer leads, and website settings</span>
                  </div>
                  <span class="badge-status">Enterprise Security</span>
                </div>
                <div class="grid cols-3 gap-4">
                  <div class="card role">
                    <div class="role-title">
                      <svg class="icon lg emerald"><use href="#i-shield-check"/></svg>
                      <span>Admin Owner</span>
                    </div>
                    <p>Full control over website settings, billing, team accounts, and database backups.</p>
                    <span class="role-pill emerald">Full Ownership</span>
                  </div>
                  <div class="card role">
                    <div class="role-title">
                      <svg class="icon lg blue"><use href="#i-file-text"/></svg>
                      <span>Content Editor</span>
                    </div>
                    <p>Can edit page headlines, upload product photos, publish blogs, and update banners.</p>
                    <span class="role-pill blue">Publish &amp; Edit</span>
                  </div>
                  <div class="card role">
                    <div class="role-title">
                      <svg class="icon lg amber"><use href="#i-inbox"/></svg>
                      <span>Sales &amp; Support</span>
                    </div>
                    <p>Review customer inquiries, manage client quotes, and follow up with new leads.</p>
                    <span class="role-pill amber">Inquiry Access</span>
                  </div>
                </div>
              </div>

            </div>

            <!-- Bottom callout: Studio Ownership Guarantee -->
            <div class="callout">
              <div class="callout-text">
                <div class="callout-icon-badge">
                  <svg class="icon emerald"><use href="#i-check"/></svg>
                </div>
                <span>Built specifically for your business workflow. 100% full source code ownership handed over upon delivery.</span>
              </div>
              <a href="contact.php" class="cta">
                <span>Get a Custom Software Quote</span>
                <svg class="icon"><use href="#i-arrow-right"/></svg>
              </a>
            </div>
          </div>
        </div><!-- /.admin-console -->

<!-- =========================================================================
             PREVIOUS ARCHITECTURE TELEMETRY CONSOLE (SAFELY COMMENTED OUT)
             =========================================================================
/* =========================================================================
             PREVIOUS ARCHITECTURE TELEMETRY CONSOLE (COMMENTED OUT)
             ========================================================================= */
        /*
<div class="synex-dashboard-window" id="synex-dashboard">

          /* Sidebar Navigation */
          <aside class="dash-sidebar">
            <div>
              /* Workspace Profile */
              <div class="sidebar-profile">
                <div class="profile-avatar">R</div>
                <div class="profile-info">
                  <span class="profile-name">RiTiVerse Studio</span>
                  <span class="profile-plan">
                    <span class="profile-plan-dot"></span>
                    Studio Architecture
                  </span>
                </div>
              </div>

              /* Engineering OS Navigation */
              <div class="sidebar-section">
                <div class="sidebar-section-title">Engineering OS</div>
                <ul class="sidebar-nav-list">
                  <li class="sidebar-nav-item active">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                      </svg>
                      Deployment Pipeline
                    </div>
                  </li>
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                      </svg>
                      Web Applications
                    </div>
                  </li>
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                      </svg>
                      Custom Software & APIs
                    </div>
                  </li>
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                      </svg>
                      Cloud & Microservices
                    </div>
                  </li>
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                      </svg>
                      Lighthouse Speed (100)
                    </div>
                  </li>
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                      </svg>
                      Security & Audits
                    </div>

                  </li>
                </ul>
              </div>

              /* Client Deliverables */
              <div class="sidebar-section">
                <div class="sidebar-section-title">Client Deliverables</div>
                <ul class="sidebar-nav-list">
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                      </svg>
                      Client Staging Envs
                    </div>
                  </li>
                  <li class="sidebar-nav-item">
                    <div class="nav-item-left">
                      <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                      </svg>
                      Live CI/CD Feeds
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            /* Sidebar Footer */
            <div class="sidebar-footer">
              <a href="#docs" class="sidebar-footer-link">
                <svg class="nav-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                  <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                Engineering Docs (v4.2)
              </a>
            </div>
          </aside>

          /* Main Dashboard View Area */
          <div class="dash-content">

            /* Top Bar with User & Range Filters */
            <div class="dash-top-bar">
              <div class="dash-user-welcome">
                <div class="dash-avatar-mini">RI</div>
                <div class="dash-user-meta">
                  <h3>Architecture Console</h3>
                  <p>Interactive Telemetry Model • Live Architecture Demo</p>
                </div>
              </div>

              <div class="dash-top-actions">
                /* Sprint Status Pill */
                <button class="dash-pill-btn" type="button">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  100% On-Time Milestones
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="width:10px; height:10px;">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                </button>

                /* Currency Switcher */
                <div class="dash-currency-toggle">
                  <button class="currency-option" data-curr="EUR">RUPE (₹)</button>
                  <button class="currency-option active" data-curr="USD">USD ($)</button>

                </div>

                /* Quick Search Button */
                <button class="dash-pill-btn" type="button" title="Quick Search">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                  ⌘K
                </button>
              </div>
            </div>

            /* Production Value Hero Metric */
            <div class="dash-metric-hero">
              <div class="metric-hero-left">
                <span class="metric-eyebrow">Interactive Platform Model</span>
                <div class="metric-large-value">
                  <span class="currency-symbol" id="currency-symbol">$ </span>
                  <span class="amount-value" id="hero-amount-val">348,720.00</span>
                  <span class="metric-growth-badge" id="hero-growth-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                      stroke-linejoin="round">
                      <polyline points="18 15 12 9 6 15"></polyline>
                    </svg>
                    +28.4% Efficiency
                  </span>
                </div>
              </div>

              <div class="metric-hero-right">
                <div class="metric-ath-label">System Architecture Target</div>
                <div class="metric-ath-value">99.9% Uptime Target</div>
              </div>
            </div>

            /* 3 Submetrics Cards Row */
            <div class="dash-submetrics-row">
              <div class="submetric-card">
                <div class="submetric-header">
                  <span class="submetric-title">Automated Testing</span>
                  <span class="submetric-tag">100% Pass</span>
                </div>
                <div class="submetric-amount">CI/CD Verified</div>
              </div>

              <div class="submetric-card">
                <div class="submetric-header">
                  <span class="submetric-title">Global TTFB Speed</span>
                  <span class="submetric-tag">-64% Latency</span>
                </div>
                <div class="submetric-amount">0.19s Sub-second</div>
              </div>

              <div class="submetric-card">
                <div class="submetric-header">
                  <span class="submetric-title">Source IP Rights</span>
                  <span class="submetric-tag">Day 1</span>
                </div>
                <div class="submetric-amount">100% Transferred</div>
              </div>
            </div>

            /* Interactive Chart Area */
            <div class="dash-chart-section">
              <div class="chart-header">
                <div class="chart-title-group">
                  <span class="chart-title">Ship Velocity & Deployment Volume</span>
                  <span class="chart-benchmark">
                    <span class="benchmark-line-sample"></span>
                    High SLA Target
                  </span>
                </div>
                <span class="chart-benchmark">Live Cluster Feed</span>
              </div>

              <div class="chart-body-wrapper">
                /* Background Horizontal Gridlines */
                <div class="chart-guidelines">
                  <div class="guideline"></div>
                  <div class="guideline"></div>
                  <div class="guideline"></div>
                </div>

                /* Interactive Bars for 12 Months */
                <div class="chart-bars-container">
                  <div class="chart-bar-col" data-month="jan">
                    <div class="chart-tooltip">$182,400</div>
                    <div class="bar-fill" style="height: 48%;"></div>
                    <span class="bar-month-label">Jan</span>
                  </div>
                  <div class="chart-bar-col" data-month="feb">
                    <div class="chart-tooltip">$204,120</div>
                    <div class="bar-fill" style="height: 54%;"></div>
                    <span class="bar-month-label">Feb</span>
                  </div>
                  <div class="chart-bar-col" data-month="mar">
                    <div class="chart-tooltip">$219,800</div>
                    <div class="bar-fill" style="height: 58%;"></div>
                    <span class="bar-month-label">Mar</span>
                  </div>
                  <div class="chart-bar-col" data-month="apr">
                    <div class="chart-tooltip">$235,100</div>
                    <div class="bar-fill" style="height: 62%;"></div>
                    <span class="bar-month-label">Apr</span>
                  </div>
                  <div class="chart-bar-col" data-month="may">
                    <div class="chart-tooltip">$248,900</div>
                    <div class="bar-fill" style="height: 66%;"></div>
                    <span class="bar-month-label">May</span>
                  </div>
                  <div class="chart-bar-col" data-month="jun">
                    <div class="chart-tooltip">$271,400</div>
                    <div class="bar-fill" style="height: 72%;"></div>
                    <span class="bar-month-label">Jun</span>
                  </div>
                  <div class="chart-bar-col" data-month="jul">
                    <div class="chart-tooltip">$289,650</div>
                    <div class="bar-fill" style="height: 76%;"></div>
                    <span class="bar-month-label">Jul</span>
                  </div>
                  <div class="chart-bar-col" data-month="aug">
                    <div class="chart-tooltip">$301,200</div>
                    <div class="bar-fill" style="height: 80%;"></div>
                    <span class="bar-month-label">Aug</span>
                  </div>
                  <div class="chart-bar-col" data-month="sep">
                    <div class="chart-tooltip">$318,450</div>
                    <div class="bar-fill" style="height: 84%;"></div>
                    <span class="bar-month-label">Sep</span>
                  </div>
                  <div class="chart-bar-col" data-month="oct">
                    <div class="chart-tooltip">$332,100</div>
                    <div class="bar-fill" style="height: 88%;"></div>
                    <span class="bar-month-label">Oct</span>
                  </div>
                  <div class="chart-bar-col highlighted" data-month="nov">
                    <div class="chart-tooltip">$348,720</div>
                    <div class="bar-fill" style="height: 94%;"></div>
                    <span class="bar-month-label">Nov</span>
                  </div>
                  <div class="chart-bar-col" data-month="dec">
                    <div class="chart-tooltip">$365,400</div>
                    <div class="bar-fill" style="height: 98%;"></div>
                    <span class="bar-month-label">Dec</span>
                  </div>
                </div>
              </div>

              /* Stack Breakdown Bottom Row */
              <div class="dash-allocations-row">
                <div class="allocation-item">
                  <span class="alloc-dot" style="background-color: var(--brand-orange);"></span>
                  <span class="alloc-label">Web Applications:</span>
                  <span class="alloc-pct">42%</span>
                </div>
                <div class="allocation-item">
                  <span class="alloc-dot" style="background-color: var(--brand-blue);"></span>
                  <span class="alloc-label">Custom Software:</span>
                  <span class="alloc-pct">31%</span>
                </div>
                <div class="allocation-item">
                  <span class="alloc-dot" style="background-color: var(--brand-red);"></span>
                  <span class="alloc-label">Cloud Systems:</span>
                  <span class="alloc-pct">18%</span>
                </div>
                <div class="allocation-item">
                  <span class="alloc-dot" style="background-color: #34D399;"></span>
                  <span class="alloc-label">AI Automation:</span>
                  <span class="alloc-pct">9%</span>
                </div>
              </div>
            </div>

          </div>
        </div>
        */


        ========================================================================= -->
      </div><!-- /.dashboard-scroll-target -->

    </div><!-- /#hero-stage -->

    <!-- Apple-Style Floating Scroll Prompt -->
    <div class="hero-scroll-prompt" id="hero-scroll-prompt" aria-hidden="true">
      <div class="scroll-mouse-pill">
        <span class="scroll-wheel-dot"></span>
      </div>
      <span class="scroll-prompt-label">Scroll to reveal</span>
    </div>

  </main>

  <!-- ==========================================================================
       ICON SPRITE FOR ADMIN CONSOLE (Lucide Icons)
       ========================================================================== -->
  <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    <symbol id="i-file-text" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></symbol>
    <symbol id="i-sliders" viewBox="0 0 24 24"><line x1="21" x2="14" y1="4" y2="4"/><line x1="10" x2="3" y1="4" y2="4"/><line x1="21" x2="12" y1="12" y2="12"/><line x1="8" x2="3" y1="12" y2="12"/><line x1="21" x2="16" y1="20" y2="20"/><line x1="12" x2="3" y1="20" y2="20"/><line x1="14" x2="14" y1="2" y2="6"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="16" x2="16" y1="18" y2="22"/></symbol>
    <symbol id="i-inbox" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="i-eye" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="i-arrow-right" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></symbol>
    <symbol id="i-shield-check" viewBox="0 0 24 24"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></symbol>
    <symbol id="i-toggle-right" viewBox="0 0 24 24"><rect width="20" height="12" x="2" y="6" rx="6"/><circle cx="16" cy="12" r="2"/></symbol>
    <symbol id="i-toggle-left" viewBox="0 0 24 24"><rect width="20" height="12" x="2" y="6" rx="6"/><circle cx="8" cy="12" r="2"/></symbol>
  </svg>



  <!-- ==========================================================================
       SECTION 2: CAPABILITIES SHOWCASE (Interactive Expanding Accordion)
       ========================================================================== -->
  <section class="synex-showcase-section" id="services">
    <div class="showcase-container">

      <div class="showcase-main-grid">

        <!-- Left Column: Bold Typography & Action Box (Matching Image 1) -->
        <div class="showcase-left-col">
          <div class="showcase-badge">
            <span class="showcase-badge-dot"></span>
            OUR CORE SERVICES
          </div>

          <h2 class="showcase-title">
            <span class="title-word">Building</span>
            <span class="title-word">Modern Websites</span>
            <span class="title-word">&amp; Custom Software</span>
          </h2>

          <p class="showcase-subtitle">
            Fast, reliable, and easy to manage. We design and build high-quality websites, mobile apps, and custom business software tailored to help your business grow.
          </p>

          <!-- Interactive Search / Vision Input Capsule (Matching Image 1) -->
          <form class="showcase-search-box" id="showcase-search-form">
            <input type="text" class="showcase-search-input" id="showcase-query-input"
              placeholder="Website, Mobile App, CRM, ERP, E-Commerce..." required aria-label="Project requirement">
            <button type="submit" class="showcase-search-btn" aria-label="Start consultation">
              <span>Start</span>
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="7" y1="17" x2="17" y2="7"></line>
                <polyline points="7 7 17 7 17 17"></polyline>
              </svg>
            </button>
          </form>
          <div class="showcase-search-feedback" id="showcase-feedback"></div>
        </div>

        <!-- Right Column: Interactive Expanding Accordion Card Deck (Matching Image 1) -->
        <!-- Right Column: Interactive Expanding Accordion Card Deck (The 6 Core Services) -->
        <div class="showcase-right-col">
          <div class="showcase-accordion-deck" id="capabilities-accordion">

            <!-- Card 1: Website Development (Default Active) -->
            <div class="accordion-card is-active" data-index="0" tabindex="0" role="button" aria-expanded="true"
              aria-label="Website Development">
              <div class="card-media-wrap">
                <img src="assets/card_web_apps.jpg" alt="Website Development" class="card-media-img" />
                <div class="card-gradient-overlay"></div>
              </div>

              <!-- Collapsed Vertical Title Strip -->
              <div class="card-collapsed-strip" aria-hidden="true">
                <span class="strip-text">Website Dev</span>
              </div>

              <!-- Expanded Card Bottom Overlay Content -->
              <div class="card-expanded-footer">
                <div class="footer-meta-top">
                  <span class="footer-chip">MODERN WEB DEVELOPMENT</span>
                  <div class="footer-stat-pill">
                    <span class="stat-big">&lt; 2 SEC</span>
                    <span class="stat-unit">LOAD TIME</span>
                  </div>
                </div>
                <h3 class="footer-power-title">Custom Websites.<br>Fast &amp; Mobile-Ready.</h3>
                <span class="footer-power-sub">Website Development</span>
                <div class="footer-power-tags">
                  <span class="power-tag">PHP &amp; Laravel</span>
                  <span class="power-tag">React</span>
                  <span class="power-tag">Responsive Design</span>
                  <span class="power-tag">SEO Ready</span>
                </div>
              </div>
            </div>

            <!-- Card 2: Application Development -->
            <div class="accordion-card" data-index="1" tabindex="0" role="button" aria-expanded="false"
              aria-label="Application Development">
              <div class="card-media-wrap">
                <img src="assets/card_cloud_ai.jpg" alt="Application Development" class="card-media-img" />
                <div class="card-gradient-overlay"></div>
              </div>

              <!-- Collapsed Vertical Title Strip -->
              <div class="card-collapsed-strip" aria-hidden="true">
                <span class="strip-text">App Development</span>
              </div>

              <!-- Expanded Card Bottom Overlay Content -->
              <div class="card-expanded-footer">
                <div class="footer-meta-top">
                  <span class="footer-chip">MOBILE &amp; WEB APPS</span>
                  <div class="footer-stat-pill">
                    <span class="stat-big">SMOOTH</span>
                    <span class="stat-unit">UI &amp; SPEED</span>
                  </div>
                </div>
                <h3 class="footer-power-title">Custom Apps.<br>Android &amp; iOS.</h3>
                <span class="footer-power-sub">Application Development</span>
                <div class="footer-power-tags">
                  <span class="power-tag">Android &amp; iOS</span>
                  <span class="power-tag">Web Portals</span>
                  <span class="power-tag">Offline Support</span>
                  <span class="power-tag">Fast Backend</span>
                </div>
              </div>
            </div>

            <!-- Card 3: E-Commerce Development -->
            <div class="accordion-card" data-index="2" tabindex="0" role="button" aria-expanded="false"
              aria-label="E-Commerce Development">
              <div class="card-media-wrap">
                <img src="assets/featured-work.jpg" alt="E-Commerce Development" class="card-media-img" />
                <div class="card-gradient-overlay"></div>
              </div>

              <!-- Collapsed Vertical Title Strip -->
              <div class="card-collapsed-strip" aria-hidden="true">
                <span class="strip-text">E-Commerce</span>
              </div>

              <!-- Expanded Card Bottom Overlay Content -->
              <div class="card-expanded-footer">
                <div class="footer-meta-top">
                  <span class="footer-chip">ONLINE STOREFRONTS</span>
                  <div class="footer-stat-pill">
                    <span class="stat-big">FAST CHECKOUT</span>
                    <span class="stat-unit">UPI &amp; CARDS</span>
                  </div>
                </div>
                <h3 class="footer-power-title">Online Stores.<br>Razorpay &amp; UPI.</h3>
                <span class="footer-power-sub">E-Commerce Development</span>
                <div class="footer-power-tags">
                  <span class="power-tag">Razorpay &amp; UPI</span>
                  <span class="power-tag">Product Catalog</span>
                  <span class="power-tag">Order Tracking</span>
                  <span class="power-tag">Stock Sync</span>
                </div>
              </div>
            </div>

            <!-- Card 4: CRM Platforms -->
            <div class="accordion-card" data-index="3" tabindex="0" role="button" aria-expanded="false"
              aria-label="CRM Platforms">
              <div class="card-media-wrap">
                <img src="assets/card_cloud_devops.jpg" alt="CRM Platforms" class="card-media-img" />
                <div class="card-gradient-overlay"></div>
              </div>

              <!-- Collapsed Vertical Title Strip -->
              <div class="card-collapsed-strip" aria-hidden="true">
                <span class="strip-text">CRM Platforms</span>
              </div>

              <!-- Expanded Card Bottom Overlay Content -->
              <div class="card-expanded-footer">
                <div class="footer-meta-top">
                  <span class="footer-chip">SALES &amp; LEAD MANAGEMENT</span>
                  <div class="footer-stat-pill">
                    <span class="stat-big">AUTOMATED</span>
                    <span class="stat-unit">FOLLOW-UPS</span>
                  </div>
                </div>
                <h3 class="footer-power-title">Track Leads.<br>Close More Deals.</h3>
                <span class="footer-power-sub">Custom CRM Platforms</span>
                <div class="footer-power-tags">
                  <span class="power-tag">Lead Pipelines</span>
                  <span class="power-tag">WhatsApp Alerts</span>
                  <span class="power-tag">Customer History</span>
                  <span class="power-tag">Team Reminders</span>
                </div>
              </div>
            </div>

            <!-- Card 5: ERP Systems -->
            <div class="accordion-card" data-index="4" tabindex="0" role="button" aria-expanded="false"
              aria-label="ERP Systems">
              <div class="card-media-wrap">
                <img src="assets/card_ai_agents.jpg" alt="ERP Systems" class="card-media-img" />
                <div class="card-gradient-overlay"></div>
              </div>

              <!-- Collapsed Vertical Title Strip -->
              <div class="card-collapsed-strip" aria-hidden="true">
                <span class="strip-text">ERP Systems</span>
              </div>

              <!-- Expanded Card Bottom Overlay Content -->
              <div class="card-expanded-footer">
                <div class="footer-meta-top">
                  <span class="footer-chip">OPERATIONS &amp; BILLING</span>
                  <div class="footer-stat-pill">
                    <span class="stat-big">ALL-IN-ONE</span>
                    <span class="stat-unit">MANAGEMENT</span>
                  </div>
                </div>
                <h3 class="footer-power-title">Smooth Ops.<br>Billing &amp; Stock.</h3>
                <span class="footer-power-sub">Custom ERP Systems</span>
                <div class="footer-power-tags">
                  <span class="power-tag">Inventory Control</span>
                  <span class="power-tag">GST Invoicing</span>
                  <span class="power-tag">Order Dispatch</span>
                  <span class="power-tag">Staff Permissions</span>
                </div>
              </div>
            </div>

            <!-- Card 6: Custom Software Development -->
            <div class="accordion-card" data-index="5" tabindex="0" role="button" aria-expanded="false"
              aria-label="Custom Software Development">
              <div class="card-media-wrap">
                <img src="assets/card_software_apis.jpg" alt="Custom Software Development" class="card-media-img" />
                <div class="card-gradient-overlay"></div>
              </div>

              <!-- Collapsed Vertical Title Strip -->
              <div class="card-collapsed-strip" aria-hidden="true">
                <span class="strip-text">Custom Software</span>
              </div>

              <!-- Expanded Card Bottom Overlay Content -->
              <div class="card-expanded-footer">
                <div class="footer-meta-top">
                  <span class="footer-chip">TAILORED SOFTWARE &amp; APIS</span>
                  <div class="footer-stat-pill">
                    <span class="stat-big">CLEAN CODE</span>
                    <span class="stat-unit">ZERO LOCK-IN</span>
                  </div>
                </div>
                <h3 class="footer-power-title">Custom Software.<br>100% Owned by You.</h3>
                <span class="footer-power-sub">Custom Software &amp; APIs</span>
                <div class="footer-power-tags">
                  <span class="power-tag">Laravel</span>
                  <span class="power-tag">Express.js</span>
                  <span class="power-tag">Python</span>
                  <span class="power-tag">MySQL Database</span>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ==========================================================================
       SECTION 3: HIGH-TRUST ENTERPRISE TELEMETRY & DOMAIN MARQUEE
       ========================================================================== -->
  <section class="synex-trust-section" id="proof">
    <div class="trust-container">
      <div class="trust-eyebrow-center">
        <span class="trust-marquee-label">
          <span class="trust-marquee-label-dot"></span>
          Core Technology Stack • Modern Web &amp; Application Engineering
        </span>
      </div>

      <!-- Technology Sliding Animation Track -->
      <div class="tech-slider-wrapper" aria-label="Core Technologies We Build With">
        <div class="tech-slider-track">
          <!-- Item 1: PHP -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-php">PHP</span>
            <div class="tech-info-block">
              <span class="tech-name">PHP</span>
              <span class="tech-sub-role">Modern PHP 8+</span>
            </div>
            <span class="tech-badge-tag">Backend</span>
          </div>

          <!-- Item 2: Laravel -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-laravel">LV</span>
            <div class="tech-info-block">
              <span class="tech-name">Laravel</span>
              <span class="tech-sub-role">MVC Framework</span>
            </div>
            <span class="tech-badge-tag">Full-Stack</span>
          </div>

          <!-- Item 3: React -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-react">⚛</span>
            <div class="tech-info-block">
              <span class="tech-name">React</span>
              <span class="tech-sub-role">Component UI &amp; SPA</span>
            </div>
            <span class="tech-badge-tag">Frontend</span>
          </div>

          <!-- Item 4: Express.js -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-express">EX</span>
            <div class="tech-info-block">
              <span class="tech-name">Express.js</span>
              <span class="tech-sub-role">Fast REST APIs</span>
            </div>
            <span class="tech-badge-tag">API Layer</span>
          </div>

          <!-- Item 5: Python -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-python">PY</span>
            <div class="tech-info-block">
              <span class="tech-name">Python</span>
              <span class="tech-sub-role">Automation &amp; Scripts</span>
            </div>
            <span class="tech-badge-tag">Backend</span>
          </div>

          <!-- Item 6: JavaScript -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-js">JS</span>
            <div class="tech-info-block">
              <span class="tech-name">JavaScript</span>
              <span class="tech-sub-role">Modern ES6+ Logic</span>
            </div>
            <span class="tech-badge-tag">Interactive</span>
          </div>

          <!-- Item 7: HTML5 -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-html">&lt;/&gt;</span>
            <div class="tech-info-block">
              <span class="tech-name">HTML5</span>
              <span class="tech-sub-role">Semantic Markup</span>
            </div>
            <span class="tech-badge-tag">Structure</span>
          </div>

          <!-- Item 8: CSS3 -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-css">{ }</span>
            <div class="tech-info-block">
              <span class="tech-name">CSS3</span>
              <span class="tech-sub-role">Responsive &amp; Motion</span>
            </div>
            <span class="tech-badge-tag">Styling</span>
          </div>

          <!-- Item 9: Node.js -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-node">NODE</span>
            <div class="tech-info-block">
              <span class="tech-name">Node.js</span>
              <span class="tech-sub-role">JavaScript Runtime</span>
            </div>
            <span class="tech-badge-tag">Runtime</span>
          </div>

          <!-- Item 10: MySQL -->
          <div class="tech-slide-card">
            <span class="tech-icon-pill icon-mysql">SQL</span>
            <div class="tech-info-block">
              <span class="tech-name">MySQL</span>
              <span class="tech-sub-role">Relational Database</span>
            </div>
            <span class="tech-badge-tag">Database</span>
          </div>

          <!-- DUPLICATE SET FOR INFINITE SEAMLESS LOOP -->
          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-php">PHP</span>
            <div class="tech-info-block">
              <span class="tech-name">PHP</span>
              <span class="tech-sub-role">Modern PHP 8+</span>
            </div>
            <span class="tech-badge-tag">Backend</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-laravel">LV</span>
            <div class="tech-info-block">
              <span class="tech-name">Laravel</span>
              <span class="tech-sub-role">MVC Framework</span>
            </div>
            <span class="tech-badge-tag">Full-Stack</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-react">⚛</span>
            <div class="tech-info-block">
              <span class="tech-name">React</span>
              <span class="tech-sub-role">Component UI &amp; SPA</span>
            </div>
            <span class="tech-badge-tag">Frontend</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-express">EX</span>
            <div class="tech-info-block">
              <span class="tech-name">Express.js</span>
              <span class="tech-sub-role">Fast REST APIs</span>
            </div>
            <span class="tech-badge-tag">API Layer</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-python">PY</span>
            <div class="tech-info-block">
              <span class="tech-name">Python</span>
              <span class="tech-sub-role">Automation &amp; Scripts</span>
            </div>
            <span class="tech-badge-tag">Backend</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-js">JS</span>
            <div class="tech-info-block">
              <span class="tech-name">JavaScript</span>
              <span class="tech-sub-role">Modern ES6+ Logic</span>
            </div>
            <span class="tech-badge-tag">Interactive</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-html">&lt;/&gt;</span>
            <div class="tech-info-block">
              <span class="tech-name">HTML5</span>
              <span class="tech-sub-role">Semantic Markup</span>
            </div>
            <span class="tech-badge-tag">Structure</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-css">{ }</span>
            <div class="tech-info-block">
              <span class="tech-name">CSS3</span>
              <span class="tech-sub-role">Responsive &amp; Motion</span>
            </div>
            <span class="tech-badge-tag">Styling</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-node">NODE</span>
            <div class="tech-info-block">
              <span class="tech-name">Node.js</span>
              <span class="tech-sub-role">JavaScript Runtime</span>
            </div>
            <span class="tech-badge-tag">Runtime</span>
          </div>

          <div class="tech-slide-card" aria-hidden="true">
            <span class="tech-icon-pill icon-mysql">SQL</span>
            <div class="tech-info-block">
              <span class="tech-name">MySQL</span>
              <span class="tech-sub-role">Relational Database</span>
            </div>
            <span class="tech-badge-tag">Database</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       SECTION 4: "ZERO VENDOR LOCK-IN" PHILOSOPHY & COMPARISON MATRIX
       ========================================================================== -->
  <section class="synex-philosophy-section" id="philosophy">
    <div class="philosophy-container">
      <div class="section-head-center">
        
        <h2 class="section-main-heading">
          The End of Agency Lock-In.<br>
          <span class="text-flame">100% Code Ownership &amp; Transparency.</span>
        </h2>
        
      </div>

      <!-- Side-by-Side Comparison Table -->
      <div class="philosophy-table-card">
        <div class="table-scroll-wrap">
          <table class="compare-table">
            <thead>
              <tr>
                <th scope="col" class="th-dim">CATEGORY</th>
                <th scope="col" class="th-legacy">TRADITIONAL AGENCIES</th>
                <th scope="col" class="th-ritiverse hl">
                  <span class="th-brand-pill">RITIVERSE</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <!-- Row 1: Simple Text, Price & Banner Edits -->
              <tr>
                <td class="td-dim">
                  <strong class="dim-title">Simple Text, Price &amp; Banner Edits</strong>
                </td>
                <td class="td-legacy">
                  <div class="cell-content">
                    <span class="diff-icon diff-no" aria-hidden="true">✕</span>
                    <span class="cell-text">Submit support ticket, wait 2–5 days</span>
                  </div>
                </td>
                <td class="td-ritiverse hl">
                  <div class="cell-content">
                    <span class="diff-icon diff-yes" aria-hidden="true">✓</span>
                    <span class="cell-text">Instant updates via your custom Admin Panel (0 sec)</span>
                  </div>
                </td>
              </tr>

              <!-- Row 2: Code & Cloud Ownership -->
              <tr>
                <td class="td-dim">
                  <strong class="dim-title">Code &amp; Cloud Ownership</strong>
                </td>
                <td class="td-legacy">
                  <div class="cell-content">
                    <span class="diff-icon diff-no" aria-hidden="true">✕</span>
                    <span class="cell-text">Agency keeps your code and hosting hostage</span>
                  </div>
                </td>
                <td class="td-ritiverse hl">
                  <div class="cell-content">
                    <span class="diff-icon diff-yes" aria-hidden="true">✓</span>
                    <span class="cell-text">100% transferred to your own GitHub &amp; cloud</span>
                  </div>
                </td>
              </tr>

              <!-- Row 3: Monthly Platform Rent -->
              <tr>
                <td class="td-dim">
                  <strong class="dim-title">Monthly Platform Charges</strong>
                </td>
                <td class="td-legacy">
                  <div class="cell-content">
                    <span class="diff-icon diff-no" aria-hidden="true">✕</span>
                    <span class="cell-text">₹4,000–₹25,000/month recurring fees to stay online</span>
                  </div>
                </td>
                <td class="td-ritiverse hl">
                  <div class="cell-content">
                    <span class="diff-icon diff-yes" aria-hidden="true">✓</span>
                    <span class="cell-text">₹0 monthly platform charges—you own the software</span>
                  </div>
                </td>
              </tr>

              <!-- Row 4: Delivery Turnaround -->
              <tr>
                <td class="td-dim">
                  <strong class="dim-title">Delivery Turnaround</strong>
                </td>
                <td class="td-legacy">
                  <div class="cell-content">
                    <span class="diff-icon diff-no" aria-hidden="true">✕</span>
                    <span class="cell-text">Months of delays and vague hourly bills</span>
                  </div>
                </td>
                <td class="td-ritiverse hl">
                  <div class="cell-content">
                    <span class="diff-icon diff-yes" aria-hidden="true">✓</span>
                    <span class="cell-text">Fixed 2–4 week milestone delivery with weekly demos</span>
                  </div>
                </td>
              </tr>

              <!-- Row 5: Handover & Training -->
              <tr>
                <td class="td-dim">
                  <strong class="dim-title">Handover &amp; Support</strong>
                </td>
                <td class="td-legacy">
                  <div class="cell-content">
                    <span class="diff-icon diff-no" aria-hidden="true">✕</span>
                    <span class="cell-text">ZIP file sent with zero guidance or support</span>
                  </div>
                </td>
                <td class="td-ritiverse hl">
                  <div class="cell-content">
                    <span class="diff-icon diff-yes" aria-hidden="true">✓</span>
                    <span class="cell-text">Live 1-on-1 video call + video guides + 30-day warranty</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


    </div>
  </section>

  <!-- ==========================================================================
       SECTION 5: FEATURED PRODUCTION FLAGSHIPS & CASE STUDIES
       ========================================================================== -->
  <!-- <section class="synex-flagships-section" id="projects">
    <div class="flagships-container">
      <div class="section-head-center">
        <div class="section-eyebrow-pill">
          <span class="section-eyebrow-dot"></span>
          Production Flagships & Telemetry
        </div>
        <h2 class="section-main-heading">
          Battle-Tested Software.<br>
          <span class="text-flame">Measurable Business Velocity.</span>
        </h2>
        <p class="section-main-subtitle">
          We don't build vaporware or mockups. Explore high-performance platforms, distributed backends, and cloud engines engineered by RiTiVerse.
        </p>
      </div>

      /* 3D Revolving Card Orbit Showcase */
      <div class="flagships-showcase-grid">

        /* Left Column: Editorial & Dynamic Meta Context */
        <div class="flagships-editorial-col">
          <div class="flagship-meta-badge">
            <span class="flagship-badge-dot" id="fBadgeDot"></span>
            <span class="flagship-badge-text" id="fBadgeCategory">FINTECH &amp; TELEMETRY</span>
          </div>

          <div class="flagship-headline-wrap">
            <p class="flagship-client-lead" id="fSubheading">Aegis Capital • High-Frequency Systems</p>
            <h3 class="flagship-active-title" id="fTitle">Aegis Financial Telemetry OS</h3>
          </div>

          <p class="flagship-active-desc" id="fDescription">
            High-frequency algorithmic portfolio monitoring platform streaming real-time market data across 12 global exchanges with sub-50ms latency.
          </p>

          /* Dynamic Feature Metrics Strip */
          <div class="flagship-metrics-grid" id="fMetricsGrid">
            <div class="f-metric-card">
              <span class="f-metric-number" id="fMetricVal1">0.12s</span>
              <span class="f-metric-caption" id="fMetricLbl1">Global TTFB</span>
            </div>
            <div class="f-metric-card">
              <span class="f-metric-number" id="fMetricVal2">120K+</span>
              <span class="f-metric-caption" id="fMetricLbl2">Daily Trades</span>
            </div>
            <div class="f-metric-card">
              <span class="f-metric-number" id="fMetricVal3">100%</span>
              <span class="f-metric-caption" id="fMetricLbl3">Client IP</span>
            </div>
          </div>

          /* Dynamic Tech Tags Row */
          <div class="flagship-tags-row" id="fTagsRow">
            <span class="flagship-tag-item">PHP</span>
            <span class="flagship-tag-item">Laravel</span>
            <span class="flagship-tag-item">React</span>
            <span class="flagship-tag-item">MySQL</span>
          </div>

          /* Action Controls: CTA, Stepper, Counter */
          <div class="flagship-controls-bar">
            <a href="projects.php" class="flagship-primary-btn" id="fCtaBtn">
              <span>View Case Study</span>
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>

            <div class="flagship-stepper-group">
              <button type="button" class="flagship-step-btn" id="fPrevBtn" aria-label="Previous Project">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
              </button>
              <button type="button" class="flagship-step-btn" id="fNextBtn" aria-label="Next Project">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
              </button>
            </div>

            <div class="flagship-index-counter">
              <span class="counter-curr" id="fActiveIndex">01</span>
              <span class="counter-sep">/</span>
              <span class="counter-total">05</span>
            </div>
          </div>

          /* Interaction Hint */
          <div class="flagship-drag-hint">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <path d="M12 8v8m-4-4l4-4 4 4"></path>
            </svg>
            <span>DRAG, SCROLL WHEEL, OR CLICK ANY CARD TO ROTATE</span>
          </div>
        </div>

        /* Right Column: Interactive 3D Revolving Card Orbit */
        <div class="flagships-stage-col stage-3d" aria-label="Interactive 3D Revolving Showcase">
          /* Ambient Orbit Rings Background */
          <div class="orbit-rings-backdrop" aria-hidden="true">
            <div class="orbit-glow-disc"></div>
            <div class="orbit-ring ring-outer"></div>
            <div class="orbit-ring ring-middle"></div>
            <div class="orbit-ring ring-inner"></div>
          </div>

          /* 3D Carousel Disc Track */
          <div class="flagships-carousel-disc" id="flagshipsDisc">

            /* Card 0: Aegis Financial OS */
            <article class="orbit-card-item is-active" data-index="0" tabindex="0" role="button" aria-label="Aegis Financial Telemetry OS">
              <div class="orbit-card-inner">
                <div class="orbit-card-media">
                  <img src="assets/card_software_apis.jpg" alt="Aegis Financial Telemetry OS" class="orbit-card-img" />
                  <div class="orbit-card-gradient"></div>
                  <span class="orbit-card-badge"><span class="orbit-badge-dot"></span>FinTech &amp; Telemetry</span>
                  <span class="orbit-card-client">Aegis Capital</span>
                  <span class="orbit-card-kicker">Series A • Production Flagship</span>
                </div>
                <div class="orbit-card-footer">
                  <div>
                    <h4 class="orbit-card-title">Aegis Financial OS</h4>
                    <p class="orbit-card-sub">Algorithmic Trading &amp; Telemetry</p>
                  </div>
                  <div class="orbit-card-meta">
                    <span class="orbit-card-pill"><strong class="pill-val">0.12s</strong> TTFB</span>
                    <span class="orbit-card-pill"><strong class="pill-val">120K+</strong> Trades</span>
                  </div>
                  <div class="orbit-card-tags">
                    <span class="orbit-mini-tag">PHP</span>
                    <span class="orbit-mini-tag">Laravel</span>
                    <span class="orbit-mini-tag">React</span>
                  </div>
                </div>
                <div class="orbit-hologram-shimmer" aria-hidden="true"></div>
              </div>
            </article>

            /* Card 1: Verve Logistics */
            <article class="orbit-card-item" data-index="1" tabindex="0" role="button" aria-label="Verve Global Logistics Engine">
              <div class="orbit-card-inner">
                <div class="orbit-card-media">
                  <img src="assets/card_cloud_devops.jpg" alt="Verve Global Logistics Engine" class="orbit-card-img" />
                  <div class="orbit-card-gradient"></div>
                  <span class="orbit-card-badge"><span class="orbit-badge-dot"></span>Supply Chain Cloud</span>
                  <span class="orbit-card-client">Verve Systems</span>
                  <span class="orbit-card-kicker">Enterprise • Microservices</span>
                </div>
                <div class="orbit-card-footer">
                  <div>
                    <h4 class="orbit-card-title">Verve Logistics Engine</h4>
                    <p class="orbit-card-sub">Dynamic Route Fleet Telemetry</p>
                  </div>
                  <div class="orbit-card-meta">
                    <span class="orbit-card-pill"><strong class="pill-val">99.99%</strong> SLA</span>
                    <span class="orbit-card-pill"><strong class="pill-val">4.2K</strong> Fleet</span>
                  </div>
                  <div class="orbit-card-tags">
                    <span class="orbit-mini-tag">Express.js</span>
                    <span class="orbit-mini-tag">Node.js</span>
                    <span class="orbit-mini-tag">REST APIs</span>
                  </div>
                </div>
                <div class="orbit-hologram-shimmer" aria-hidden="true"></div>
              </div>
            </article>

            /* Card 2: PulseHealth */
            <article class="orbit-card-item" data-index="2" tabindex="0" role="button" aria-label="PulseHealth Diagnostics Portal">
              <div class="orbit-card-inner">
                <div class="orbit-card-media">
                  <img src="assets/card_ai_agents.jpg" alt="PulseHealth Clinical AI" class="orbit-card-img" />
                  <div class="orbit-card-gradient"></div>
                  <span class="orbit-card-badge"><span class="orbit-badge-dot"></span>HealthTech Portal</span>
                  <span class="orbit-card-client">PulseHealth</span>
                  <span class="orbit-card-kicker">Clinical AI • Diagnostics</span>
                </div>
                <div class="orbit-card-footer">
                  <div>
                    <h4 class="orbit-card-title">PulseHealth Portal</h4>
                    <p class="orbit-card-sub">Workflow Intelligence Engine</p>
                  </div>
                  <div class="orbit-card-meta">
                    <span class="orbit-card-pill"><strong class="pill-val">4.8x</strong> Speed</span>
                    <span class="orbit-card-pill"><strong class="pill-val">100%</strong> IP</span>
                  </div>
                  <div class="orbit-card-tags">
                    <span class="orbit-mini-tag">Python</span>
                    <span class="orbit-mini-tag">React</span>
                    <span class="orbit-mini-tag">CSS3</span>
                  </div>
                </div>
                <div class="orbit-hologram-shimmer" aria-hidden="true"></div>
              </div>
            </article>

            /* Card 3: OmniSphere AI */
            <article class="orbit-card-item" data-index="3" tabindex="0" role="button" aria-label="OmniSphere Private AI Workspace">
              <div class="orbit-card-inner">
                <div class="orbit-card-media">
                  <img src="assets/card_cloud_ai.jpg" alt="OmniSphere AI Workspace" class="orbit-card-img" />
                  <div class="orbit-card-gradient"></div>
                  <span class="orbit-card-badge"><span class="orbit-badge-dot"></span>Enterprise AI &amp; RAG</span>
                  <span class="orbit-card-client">OmniSphere Labs</span>
                  <span class="orbit-card-kicker">Air-Gapped • Vector RAG</span>
                </div>
                <div class="orbit-card-footer">
                  <div>
                    <h4 class="orbit-card-title">OmniSphere AI Workspace</h4>
                    <p class="orbit-card-sub">Scientific Document Intelligence</p>
                  </div>
                  <div class="orbit-card-meta">
                    <span class="orbit-card-pill"><strong class="pill-val">85%</strong> Faster</span>
                    <span class="orbit-card-pill"><strong class="pill-val">SOC-2</strong> Ready</span>
                  </div>
                  <div class="orbit-card-tags">
                    <span class="orbit-mini-tag">Python</span>
                    <span class="orbit-mini-tag">FastAPI</span>
                    <span class="orbit-mini-tag">pgvector</span>
                  </div>
                </div>
                <div class="orbit-hologram-shimmer" aria-hidden="true"></div>
              </div>
            </article>

            /* Card 4: Pulse Luxury Flagship */
            <article class="orbit-card-item" data-index="4" tabindex="0" role="button" aria-label="Pulse Luxury Digital Flagship">
              <div class="orbit-card-inner">
                <div class="orbit-card-media">
                  <img src="assets/card_web_apps.jpg" alt="Pulse Luxury Digital Flagship" class="orbit-card-img" />
                  <div class="orbit-card-gradient"></div>
                  <span class="orbit-card-badge"><span class="orbit-badge-dot"></span>Headless Web Platform</span>
                  <span class="orbit-card-client">Pulse Global</span>
                  <span class="orbit-card-kicker">Edge Render • Sub-Second</span>
                </div>
                <div class="orbit-card-footer">
                  <div>
                    <h4 class="orbit-card-title">Pulse Luxury Flagship</h4>
                    <p class="orbit-card-sub">High-Velocity Digital Flagship</p>
                  </div>
                  <div class="orbit-card-meta">
                    <span class="orbit-card-pill"><strong class="pill-val">100/100</strong> Score</span>
                    <span class="orbit-card-pill"><strong class="pill-val">+42%</strong> Lift</span>
                  </div>
                  <div class="orbit-card-tags">
                    <span class="orbit-mini-tag">Next.js</span>
                    <span class="orbit-mini-tag">React</span>
                    <span class="orbit-mini-tag">Cloudflare</span>
                  </div>
                </div>
                <div class="orbit-hologram-shimmer" aria-hidden="true"></div>
              </div>
            </article>

          </div>
        </div>

      </div>

      /* Flagships Bottom Action Bar */
      <div class="flagships-bottom-bar">
        <div class="flagships-pagination-pills" id="fPaginationDots">
          <button type="button" class="orbit-dot is-active" aria-label="Go to project 1" data-target="0"></button>
          <button type="button" class="orbit-dot" aria-label="Go to project 2" data-target="1"></button>
          <button type="button" class="orbit-dot" aria-label="Go to project 3" data-target="2"></button>
          <button type="button" class="orbit-dot" aria-label="Go to project 4" data-target="3"></button>
          <button type="button" class="orbit-dot" aria-label="Go to project 5" data-target="4"></button>
        </div>

        <a href="projects.php" class="btn-all-projects">
          <span>Explore All 6 Production Flagships &amp; Case Studies</span>
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>
    </div>
  </section> -->

  <!-- ==========================================================================
       SECTION 6: 4-STAGE TRANSPARENT DELIVERY BLUEPRINT (HOW IT WORKS)
       ========================================================================== -->
  <section class="synex-process-section hiw" id="process">
    <div class="hiw-lines dark"></div>
    <div class="hiw-lines light"></div>
    <div class="hiw-fade left"></div>
    <div class="hiw-fade right"></div>

    <div class="process-container hiw-inner">
      <div class="section-head-center">

        <h2 class="section-main-heading">
          From Requirement to Live Launch.<br>
          <span class="text-flame">Zero Surprises. 100% Transparency.</span>
        </h2>

      </div>

      <!-- How It Works Interactive Stage -->
      <div class="hiw-stage" id="stage">
        <!-- Curved Dashed Connector Path (Desktop) -->
        <svg class="hiw-path" viewBox="0 0 1000 880" preserveAspectRatio="none" aria-hidden="true">
          <path class="path-line"
            d="M 290 150 C 500 150, 550 270, 710 270 C 850 270, 500 420, 290 530 C 290 650, 520 700, 710 700"></path>
        </svg>

        <!-- Stage 1 -->
        <div class="card theme-orange" data-card style="--rot: 8deg;" data-step="0">
          <div class="card-outer">
            <svg class="pin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              aria-hidden="true">
              <path
                d="M16 3a1 1 0 0 1 .117 1.993l-.117 .007v4.764l1.894 3.789a1 1 0 0 1 .1 .331l.006 .116v2a1 1 0 0 1 -.883 .993l-.117 .007h-4v4a1 1 0 0 1 -1.993 .117l-.007 -.117v-4h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-2a1 1 0 0 1 .06 -.34l.046 -.107l1.894 -3.791v-4.762a1 1 0 0 1 -.117 -1.993l.117 -.007h8z" />
            </svg>
            <div class="card-inner">
              <span class="card-num">01</span>
              <h3 class="card-title">Planning &amp; Architecture</h3>
              <p class="card-desc">We map out your business workflow, design the user screens and database, and provide a fixed quote with clear milestone delivery dates.</p>
            </div>
          </div>
        </div>

        <!-- Stage 2 -->
        <div class="card theme-blue" data-card style="--rot: -8deg;" data-step="1">
          <div class="card-outer">
            <svg class="pin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              aria-hidden="true">
              <path
                d="M16 3a1 1 0 0 1 .117 1.993l-.117 .007v4.764l1.894 3.789a1 1 0 0 1 .1 .331l.006 .116v2a1 1 0 0 1 -.883 .993l-.117 .007h-4v4a1 1 0 0 1 -1.993 .117l-.007 -.117v-4h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-2a1 1 0 0 1 .06 -.34l.046 -.107l1.894 -3.791v-4.762a1 1 0 0 1 -.117 -1.993l.117 -.007h8z" />
            </svg>
            <div class="card-inner">
              <span class="card-num">02</span>
              <h3 class="card-title">Development &amp; Weekly Demos</h3>
              <p class="card-desc">Clean, modern coding with weekly live demo links on a staging URL, so you can test working features and see genuine progress every week.</p>
            </div>
          </div>
        </div>

        <!-- Stage 3 -->
        <div class="card theme-purple" data-card style="--rot: 8deg;" data-step="2">
          <div class="card-outer">
            <svg class="pin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              aria-hidden="true">
              <path
                d="M16 3a1 1 0 0 1 .117 1.993l-.117 .007v4.764l1.894 3.789a1 1 0 0 1 .1 .331l.006 .116v2a1 1 0 0 1 -.883 .993l-.117 .007h-4v4a1 1 0 0 1 -1.993 .117l-.007 -.117v-4h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-2a1 1 0 0 1 .06 -.34l.046 -.107l1.894 -3.791v-4.762a1 1 0 0 1 -.117 -1.993l.117 -.007h8z" />
            </svg>
            <div class="card-inner">
              <span class="card-num">03</span>
              <h3 class="card-title">Testing &amp; Speed Tuning</h3>
              <p class="card-desc">Thorough multi-device testing, speed optimization for sub-2-second loading on mobile data, and complete security checks before launch.</p>
            </div>
          </div>
        </div>

        <!-- Stage 4 -->
        <div class="card theme-orange" data-card style="--rot: -8deg;" data-step="3">
          <div class="card-outer">
            <svg class="pin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              aria-hidden="true">
              <path
                d="M16 3a1 1 0 0 1 .117 1.993l-.117 .007v4.764l1.894 3.789a1 1 0 0 1 .1 .331l.006 .116v2a1 1 0 0 1 -.883 .993l-.117 .007h-4v4a1 1 0 0 1 -1.993 .117l-.007 -.117v-4h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-2a1 1 0 0 1 .06 -.34l.046 -.107l1.894 -3.791v-4.762a1 1 0 0 1 -.117 -1.993l.117 -.007h8z" />
            </svg>
            <div class="card-inner">
              <span class="card-num">04</span>
              <h3 class="card-title">Live Launch &amp; Full Handover</h3>
              <p class="card-desc">We deploy your project live on your own domain and cloud servers, transferring 100% source code ownership directly to you on Day 1.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



  <!-- ==========================================================================
       SECTION 8: CLIENT TESTIMONIALS & REPUTATION
       ========================================================================== -->
  <!-- <section class="synex-reviews-section" id="reviews">
    <div class="reviews-container">
      <div class="section-head-center">
        <div class="section-eyebrow-pill">
          <span class="section-eyebrow-dot"></span>
          Client Confidence & Verified Reputation
        </div>
        <h2 class="section-main-heading">
          Trusted by Engineering Leaders.<br>
          <span class="text-flame">Proven in Production.</span>
        </h2>
        <p class="section-main-subtitle">
          Discover why technical founders, CTOs, and product directors trust RiTiVerse with mission-critical software.
        </p>
      </div>

  3 Testimonial Cards Grid 
      <div class="reviews-grid-3">

        Testimonial 1 
        <div class="review-card">
          <div>
            <div class="review-stars">★★★★★</div>
            <p class="review-quote-text">
              “RiTiVerse built our algorithmic trading telemetry platform from zero to production scale in 7 weeks.
              We received <span class="highlight">100% full source code ownership on Day 1</span> with zero technical debt. Outstanding engineering rigor.”
            </p>
          </div>
          <div class="review-author-wrap">
            <div class="review-avatar-circle">MV</div>
            <div class="review-author-meta">
              <span class="review-author-name">Marcus Vance</span>
              <span class="review-author-title">Chief Technology Officer</span>
              <span class="review-author-company">Aegis Global Capital</span>
            </div>
          </div>
        </div>

         Testimonial 2 
        <div class="review-card">
          <div>
            <div class="review-stars">★★★★★</div>
            <p class="review-quote-text">
              “Unlike typical agencies who lock you into proprietary platforms, RiTiVerse delivered
              <span class="highlight">clean, high-performance Laravel and React architecture</span> that our internal team scaled effortlessly without missing a beat.”
            </p>
          </div>
          <div class="review-author-wrap">
            <div class="review-avatar-circle avatar-orange">ER</div>
            <div class="review-author-meta">
              <span class="review-author-name">Elena Rostova</span>
              <span class="review-author-title">Founder &amp; CEO</span>
              <span class="review-author-company">Verve Cloud Systems</span>
            </div>
          </div>
        </div>

         Testimonial 3 
        <div class="review-card">
          <div>
            <div class="review-stars">★★★★★</div>
            <p class="review-quote-text">
              “The performance telemetry speaks for itself: <span class="highlight">100/100 Lighthouse, sub-180ms TTFB globally</span>, and flawless design execution.
              They are easily in the top 1% of software engineering studios worldwide.”
            </p>
          </div>
          <div class="review-author-wrap">
            <div class="review-avatar-circle">DS</div>
            <div class="review-author-meta">
              <span class="review-author-name">David Sterling</span>
              <span class="review-author-title">VP of Engineering</span>
              <span class="review-author-company">PulseHealth AI</span>
            </div>
          </div>
        </div>

      </div>

       Verified Badges Strip 
      <div class="reviews-badges-strip">
        <div class="v-badge-item">
          <span class="v-badge-dot"></span>
          5.0 / 5.0 Clutch Verified Reviews
        </div>
        <div class="v-badge-item">
          <span class="v-badge-dot"></span>
          GitHub Enterprise Verified Partner
        </div>
        <div class="v-badge-item">
          <span class="v-badge-dot"></span>
          AWS Certified Solutions Architecture
        </div>
        <div class="v-badge-item">
          <span class="v-badge-dot"></span>
          SOC2 Type II Aligned Engineering
        </div>
      </div>
    </div>
  </section> -->

  <!-- ==========================================================================
       SECTION 9: FREQUENTLY ASKED QUESTIONS & RISK REVERSAL
       ========================================================================== -->
  <section class="synex-faq-section" id="faq">
    <div class="faq-container">
      <div class="section-head-center">
        <div class="section-eyebrow-pill">
          <span class="section-eyebrow-dot"></span>
          Clear Answers &amp; Zero Hidden Terms
        </div>
        <h2 class="section-main-heading">
          Frequently Asked Questions.<br>
          <span class="text-flame">Everything Upfront.</span>
        </h2>
        <p class="section-main-subtitle">
          Honest answers about project pricing, 100% source code ownership, delivery timelines, and free post-launch support.
        </p>
      </div>

      <!-- Interactive FAQ List -->
      <div class="faq-list">

        <!-- FAQ Item 1 (Default Open): Core Services Specialization -->
        <div class="faq-item is-open">
          <button class="faq-question-btn" type="button" aria-expanded="true">
            <span class="faq-q-text">What core services does RiTiVerse specialize in?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                We specialize in 6 high-demand areas: <strong>Custom Business Websites</strong>,
                <strong>Android &amp; iOS Mobile Apps</strong>, <strong>Custom CRM Platforms</strong>,
                <strong>Enterprise Resource Planning (ERP) Systems</strong>, <strong>E-Commerce Storefronts</strong>,
                and <strong>Custom Software &amp; APIs</strong>. Every solution is built for speed, security,
                and 100% client code ownership with zero monthly lock-in.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 2: CRM & ERP vs Off-the-Shelf SaaS -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">Why build a custom CRM or ERP instead of subscribing to SaaS platforms?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                Off-the-shelf SaaS tools charge monthly per-user fees that get expensive as your team expands, and they force you into generic templates. A custom CRM or ERP built by RiTiVerse is made 100% for your daily operations, sales pipelines, and billing. You own the software permanently with zero recurring user license fees.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 3: E-Commerce & High-Converting Websites -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">How do you approach E-Commerce and Website Development for speed and conversions?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                We build fast, responsive websites and digital storefronts using React, modern PHP/Laravel, and Node.js.
                We optimize for sub-2-second loading on mobile networks, clean call-to-actions, and integrated payment
                gateways (Razorpay, UPI, Stripe) with automated order and inventory tracking.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 4: Mobile & Web Applications -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">Do you develop cross-platform mobile apps as well as web applications?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                Yes. We build responsive web applications, customer portals, and cross-platform mobile apps for both iOS and Android.
                Our applications feature smooth 60fps animations, intuitive interfaces, offline data storage,
                and fast, secure backends.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 5: 100% Code & IP Ownership -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">Do we truly own 100% of the source code, repositories, and intellectual property?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                <strong>Yes, absolutely and unconditionally.</strong> From Day 1, all source code is stored directly in your
                company's GitHub or GitLab repository. Once milestones are completed, all intellectual property, domain setup,
                and cloud server accounts belong permanently to you. We never charge monthly hostage or licensing fees.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 6: The RiTiVerse Company Difference -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">How is RiTiVerse different from traditional agencies or freelance platforms?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                Traditional agencies often assign junior developers, use slow closed CMS templates, and charge expensive monthly retainers for simple edits. At RiTiVerse, you work directly with experienced senior developers who write clean, documented code using modern open standards—with complete transparency and zero vendor lock-in.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 7: Transparent Milestone Pricing -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">How do project pricing and sprint milestones work?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                We work on transparent, fixed-scope milestone deliverables. Before starting, we provide a clear project plan detailing exact features, timelines, and costs. You test working demo links every week on a staging link before approving each milestone—eliminating budget overruns and surprise bills.
              </p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 8: Post-Launch Handover & Independence -->
        <div class="faq-item">
          <button class="faq-question-btn" type="button" aria-expanded="false">
            <span class="faq-q-text">Can our internal team easily maintain and extend the software after launch?</span>
            <span class="faq-icon-indicator">+</span>
          </button>
          <div class="faq-answer-wrap">
            <div class="faq-answer-body">
              <p>
                Yes. We build every project with clean, modular code, clear documentation, and standard frameworks that any competent developer can easily manage. Every project also includes a free 30-day warranty window for bug fixes, performance checks, and technical walkthroughs at zero extra cost.
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ==========================================================================
       SECTION 10: ARCHITECTURAL CONSULTATION CTA
       ========================================================================== -->
  <section class="synex-cta-section" id="consultation">
    <div class="cta-section-container">
      <!-- Consultation Card -->
      <div class="footer-cta-card">
        <div class="footer-cta-glow" aria-hidden="true"></div>
        <span class="footer-eyebrow">Let's Discuss Your Project</span>
        <h2 class="footer-headline">Planning a new website, mobile app, or custom software?<br>Let's build it together.</h2>
        <p class="footer-subtext">
          Work directly with experienced developers. Get fixed milestone pricing, weekly progress demo links, and 100% source code ownership from Day 1.
        </p>
        <div style="display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap;">
          <a href="contact.php" class="footer-cta-btn">
            Get a Free Project Quote
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
          <a href="services.php" class="btn-inline-link" style="padding: 12px 24px; font-weight: 700;">
            Explore All Services →
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       SECTION 11: DUAL INTERSECTING MARQUEE CTA RIBBONS (Light Version - 100% Full-Bleed)
       ========================================================================== -->
  <section class="ribbon-marquee-section" aria-label="Get in Touch Marquee">
    <div class="ribbon-marquee-wrapper">

      <!-- Underneath Ribbon: Tilted Pill Badges (CONTACT US) -->
      <a href="contact.php" class="ribbon-track-link ribbon-bottom" aria-label="Contact Us">
        <div class="ribbon-strip-track track-reverse">
          <div class="ribbon-pills-group">
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
          </div>
          <div class="ribbon-pills-group" aria-hidden="true">
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
            <span class="ribbon-pill-item pill-solid">CONTACT US</span>
            <span class="ribbon-pill-item pill-outline">CONTACT US</span>
          </div>
        </div>
      </a>

      <!-- Foreground Ribbon: Tilted Giant Tape (GET IN TOUCH ✻) -->
      <a href="contact.php" class="ribbon-track-link ribbon-top" aria-label="Get in Touch">
        <div class="ribbon-strip-track track-forward">
          <div class="ribbon-words-group">
            <span class="ribbon-word-item word-solid">GET IN TOUCH</span>
            <span class="ribbon-star-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
            <span class="ribbon-word-item word-outline">GET IN TOUCH</span>
            <span class="ribbon-star-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
            <span class="ribbon-word-item word-solid">GET IN TOUCH</span>
            <span class="ribbon-star-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
            <span class="ribbon-word-item word-outline">GET IN TOUCH</span>
            <span class="ribbon-star-icon" aria-hidden="true">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
          </div>
          <div class="ribbon-words-group" aria-hidden="true">
            <span class="ribbon-word-item word-solid">GET IN TOUCH</span>
            <span class="ribbon-star-icon">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
            <span class="ribbon-word-item word-outline">GET IN TOUCH</span>
            <span class="ribbon-star-icon">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
            <span class="ribbon-word-item word-solid">GET IN TOUCH</span>
            <span class="ribbon-star-icon">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
            <span class="ribbon-word-item word-outline">GET IN TOUCH</span>
            <span class="ribbon-star-icon">
              <svg viewBox="0 0 32 32" fill="currentColor">
                <path
                  d="M16 0c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5V1.5c0-.8.7-1.5 1.5-1.5zm0 23.8c.8 0 1.5.7 1.5 1.5v5.2c0 .8-.7 1.5-1.5 1.5s-1.5-.7-1.5-1.5v-5.2c0-.8.7-1.5 1.5-1.5zM0 16c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5H1.5c-.8 0-1.5-.7-1.5-1.5zm23.8 0c0-.8.7-1.5 1.5-1.5h5.2c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5h-5.2c-.8 0-1.5-.7-1.5-1.5zM4.7 4.7c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0L4.7 6.8c-.6-.6-.6-1.5 0-2.1zm16.8 16.8c.6-.6 1.5-.6 2.1 0l3.7 3.7c.6.6.6 1.5 0 2.1-.6.6-1.5.6-2.1 0l-3.7-3.7c-.6-.6-.6-1.5 0-2.1zm0-16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0zm-16.8 16.8c.6.6.6 1.5 0 2.1l-3.7 3.7c-.6.6-1.5.6-2.1 0-.6-.6-.6-1.5 0-2.1l3.7-3.7c.6-.6 1.5-.6 2.1 0z" />
              </svg>
            </span>
          </div>
        </div>
      </a>

    </div>
  </section>

  <!-- ==========================================================================
       SECTION 12: ARCHITECTURAL FOOTER SITEMAP
       ========================================================================== -->

<?php
$show_footer_cta = false;
$extra_js = ['js/index.js'];
require_once __DIR__ . '/includes/footer.php';
?>
