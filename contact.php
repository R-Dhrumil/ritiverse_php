<?php
/**
 * RiTiVerse — Contact & Project Consultation Page
 */
$page_title = 'Get Project Quote — Website Making, CRM & ERP Software Development | RiTiVerse';
$page_description = 'Talk directly with senior developers for a free project estimate on website making, custom CRM, ERP software, or mobile apps. 24-hour response guarantee.';
$current_page = 'contact';
$extra_css = ['css/contact.css'];

require_once __DIR__ . '/includes/header.php';
?>

  <!-- Hero Section -->
  <main class="subpage-hero">
    <div class="subpage-hero-container">
      <div class="subpage-badge">
        <span class="subpage-badge-dot"></span>
        Direct Developer Communication
      </div>
      <h1 class="subpage-title">
        Get in Touch for a <span class="accent-text">Free Project Consultation.</span>
      </h1>
      <p class="subpage-subtitle">
        No pushy sales calls or confusing agency jargon. Talk directly with our senior development team to discuss your project requirements and get an honest, transparent estimate.
      </p>
    </div>
  </main>

  <!-- Interactive Contact Grid Section -->
  <section class="subpage-section">
    <div class="subpage-container">
      <div class="contact-grid-wrap">

        <!-- Left Form Column -->
        <div class="contact-card-box">
          <div style="margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 700; color: var(--text-primary-dark); margin-bottom: 8px;">Tell Us About Your Project
            </h2>
            <p style="font-size: 14px; color: var(--text-secondary-dark);">Fill in your details below and we will get back to you with a project estimate within 24 hours.</p>
          </div>

          <form id="contact-inquiry-form" method="POST" action="api/contact-process.php" onsubmit="event.preventDefault(); handleContactSubmit();">
            <!-- Hidden bot protection honeypot field -->
            <input type="text" name="website_hp" style="display:none !important;" tabindex="-1" autocomplete="off">

            <div class="form-group-wrap">
              <div class="form-row-dual">
                <div class="form-field">
                  <label for="contact-name">Full Name *</label>
                  <input type="text" id="contact-name" name="name" class="form-input-control" placeholder="Rahul Sharma" required
                    autocomplete="name">
                </div>
                <div class="form-field">
                  <label for="contact-email">Email Address *</label>
                  <input type="email" id="contact-email" name="email" class="form-input-control" placeholder="rahul@company.com"
                    required autocomplete="email">
                </div>
              </div>

              <div class="form-row-dual">
                <div class="form-field">
                  <label for="contact-company">Company / Business Name *</label>
                  <input type="text" id="contact-company" name="company" class="form-input-control" placeholder="Sharma Enterprises / My Startup"
                    required>
                </div>
                <div class="form-field">
                  <label for="contact-scope">Project Type *</label>
                  <select id="contact-scope" name="scope" class="form-input-control" required style="cursor: pointer;">
                    <option value="" disabled selected>Select Your Project Type...</option>
                    <option value="website">Website Development</option>
                    <option value="app">Mobile App (Android / iOS)</option>
                    <option value="ecommerce">E-Commerce Storefront</option>
                    <option value="crm">Custom CRM Platform</option>
                    <option value="erp">ERP &amp; Billing System</option>
                    <option value="custom">Custom Software Development</option>
                  </select>
                </div>
              </div>

              <div class="form-field">
                <label for="contact-timeline">Target Timeline</label>
                <select id="contact-timeline" name="timeline" class="form-input-control" style="cursor: pointer;">
                  <option value="immediate">Immediate (&lt; 1 month)</option>
                  <option value="1-2 months" selected>1 – 2 months</option>
                  <option value="2-4 months">2 – 4 months</option>
                  <option value="exploratory">Just exploring / Need estimate</option>
                </select>
              </div>

              <div class="form-field">
                <label for="contact-details">Project Details &amp; Requirements *</label>
                <textarea id="contact-details" name="details" class="form-input-control" rows="5"
                  placeholder="Tell us what you are looking to build, key features needed, or any specific requirements..."
                  required></textarea>
              </div>

              <button type="submit" id="contact-submit-btn" class="btn-primary"
                style="justify-content: center; width: 100%; padding: 16px;">
                Send Project Inquiry (Free Estimate)
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </button>

              <div id="contact-form-status"
                style="display: none; padding: 14px; border-radius: 8px; font-size: 13px; text-align: center;"></div>
            </div>
          </form>
        </div>

        <!-- Right Coordinates & FAQ Column -->
        <div class="direct-contacts-box">

          <!-- Inquiries Email Item -->
          <div class="direct-contact-item">
            <div class="contact-icon-bubble">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
            </div>
            <div class="contact-detail-text">
              <h4>Direct Project Inquiries</h4>
              <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a>
              <p style="font-size: 11px; color: #10B981; margin-top: 2px;">● Guaranteed 24-Hour Response Time</p>
            </div>
          </div>

          <!-- Support Email Item -->
          <div class="direct-contact-item">
            <div class="contact-icon-bubble">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
              </svg>
            </div>
            <div class="contact-detail-text">
              <h4>Client &amp; Technical Support</h4>
              <a href="mailto:<?= e(SUPPORT_EMAIL) ?>"><?= e(SUPPORT_EMAIL) ?></a>
              <p style="font-size: 11px; color: var(--text-secondary-dark); margin-top: 2px;">Dedicated support for ongoing projects and updates</p>
            </div>
          </div>

          <!-- Direct Engineering Studio Item -->
          <div class="direct-contact-item">
            <div class="contact-icon-bubble">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
              </svg>
            </div>
            <div class="contact-detail-text">
              <h4>Direct Developer Access</h4>
              <p>Speak directly with the engineers building your software. No middlemen or endless delays.</p>
            </div>
          </div>

          <!-- Client Ownership Guarantee Card -->
          <div
            style="background: rgba(248, 104, 0, 0.06); border: 1px solid var(--accent-terracotta-border); border-radius: 14px; padding: 22px;">
            <h4
              style="font-size: 14px; font-weight: 700; color: var(--text-primary-dark); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
              <span style="color: var(--accent-terracotta);">✓</span>
              The RiTiVerse Ownership Guarantee
            </h4>
            <p style="font-size: 13px; line-height: 1.6; color: var(--text-secondary-dark);">
              You get 100% complete ownership of your code, database, and accounts once the project is delivered. No monthly platform rent, no vendor lock-in, and no hidden fees.
            </p>
          </div>

          <!-- Quick FAQ Accordion -->
          <div class="faq-accordion-wrap">
            <div class="faq-item is-open">
              <button class="faq-question-btn" type="button" aria-expanded="true">
                <span class="faq-q-text">What core services does RiTiVerse build?</span>
                <span class="faq-icon-indicator">+</span>
              </button>
              <div class="faq-answer-wrap">
                <div class="faq-answer-body">
                  We specialize in 6 core services: Custom Websites, Android &amp; iOS Mobile Apps, E-Commerce Storefronts, Custom CRM Platforms, ERP &amp; Billing Systems, and Tailored Custom Software.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question-btn" type="button" aria-expanded="false">
                <span class="faq-q-text">Do we own 100% of the code &amp; accounts?</span>
                <span class="faq-icon-indicator">+</span>
              </button>
              <div class="faq-answer-wrap">
                <div class="faq-answer-body">
                  Yes, 100%. All source code, database setups, and cloud hosting accounts are created in your name from Day 1. You have complete legal and technical ownership with zero monthly hostage fees.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question-btn" type="button" aria-expanded="false">
                <span class="faq-q-text">Where will our website or software be hosted?</span>
                <span class="faq-icon-indicator">+</span>
              </button>
              <div class="faq-answer-wrap">
                <div class="faq-answer-body">
                  Directly on your own server or hosting account (AWS, DigitalOcean, Hostinger, or your preferred provider). You pay the hosting provider directly with zero agency markup.
                </div>
              </div>
            </div>

            <div class="faq-item">
              <button class="faq-question-btn" type="button" aria-expanded="false">
                <span class="faq-q-text">How long does it take to launch?</span>
                <span class="faq-icon-indicator">+</span>
              </button>
              <div class="faq-answer-wrap">
                <div class="faq-answer-body">
                  Most standard websites and apps launch within 2 to 4 weeks. We share live test links every week so you can test features and track real progress.
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

<?php
$show_footer_cta = false;
$extra_js = ['js/contact.js'];
require_once __DIR__ . '/includes/footer.php';
?>
