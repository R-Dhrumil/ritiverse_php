<?php
/**
 * RiTiVerse — Official Terms of Service & Client Ownership Charter
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

$page_title = 'Terms of Service & Code Ownership Charter — ' . APP_NAME;
$page_description = 'Official Terms of Service for RiTiVerse Studio. Learn about our 100% client source code ownership guarantee, milestone delivery, and zero vendor lock-in.';
$current_page = 'terms';
$extra_css = ['css/contact.css'];

require_once __DIR__ . '/includes/header.php';
?>

  <section class="subpage-hero" style="padding-top: 130px; padding-bottom: 50px; background: radial-gradient(circle at 50% 10%, rgba(248, 104, 0, 0.08) 0%, transparent 60%);">
    <div class="site-container" style="max-width: 900px; margin: 0 auto; padding: 0 24px; text-align: center;">
      <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(248, 104, 0, 0.1); border: 1px solid rgba(248, 104, 0, 0.25); border-radius: 99px; padding: 6px 16px; margin-bottom: 18px;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#F86800" stroke-width="2">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span style="font-size: 12px; font-weight: 700; color: #F86800; text-transform: uppercase; letter-spacing: 0.05em;">100% Client Ownership Guarantee</span>
      </div>
      <h1 style="font-size: clamp(30px, 4vw, 44px); font-weight: 800; color: #0F172A; letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 14px;">
        Terms of Service &amp; Studio Standards
      </h1>
      <p style="font-size: 15px; color: #64748B; max-width: 650px; margin: 0 auto;">
        Clear, honest engineering commitments with zero fine print, zero recurring platform hostage fees, and full legal ownership of your technology.
      </p>
    </div>
  </section>

  <section class="section-container" style="padding-bottom: 90px;">
    <div class="site-container" style="max-width: 920px; margin: 0 auto; padding: 0 24px;">
      
      <div style="background: #FFFFFF; border: 1px solid rgba(226, 218, 204, 0.9); border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04); font-size: 15px; line-height: 1.75; color: #334155;">

        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 0; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          1. The RiTiVerse Ownership Charter (Zero Vendor Lock-In)
        </h2>
        <p>
          Unlike legacy agencies that rent platforms to clients on recurring monthly retainers, <strong>RiTiVerse guarantees 100% full legal and technical source code ownership</strong>:
        </p>
        <ul style="padding-left: 20px;">
          <li>Every repository commit, database schema, and asset created for your milestone is transferred directly to your organization's GitHub / GitLab accounts upon completion.</li>
          <li>You own your software perpetually with <strong>zero recurring per-user SaaS fees</strong> or royalty claims from RiTiVerse.</li>
          <li>All hosting and cloud accounts (AWS, DigitalOcean, Hostinger, GCP) are registered in your corporate name with direct billing to you.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          2. Transparent Milestone Delivery &amp; Approvals
        </h2>
        <p>
          Projects are structured into clear, verifiable engineering sprints. We provide staging preview links every week so you can test features in real-time. Payments are milestone-contingent based on mutually approved Statement of Work (SOW) deliverables.
        </p>

        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          3. Confidentiality &amp; Non-Disclosure
        </h2>
        <p>
          We treat your proprietary business logic, client lists, API credentials, and trade secrets with strict confidentiality. All team members operate under binding Non-Disclosure Agreements (NDAs).
        </p>

        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          4. Warranty &amp; Post-Launch Handover
        </h2>
        <p>
          Every custom website, mobile app, CRM, and ERP delivered by RiTiVerse includes a complimentary <strong>30-day post-launch warranty</strong> covering defect rectification and engineering assistance. We provide full documentation and video handover walkthroughs so your internal team can operate the systems independently.
        </p>

        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          5. Data Protection Compliance
        </h2>
        <p>
          All interactions and project communications comply strictly with India's <strong>Digital Personal Data Protection Act, 2023 (DPDP Act 2023)</strong>. For details on how we safeguard personal data and handle statutory rights, please review our <a href="privacy-policy.php" style="color: #F86800; font-weight: 600;">Privacy Notice</a>.
        </p>

        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          6. Governing Law &amp; Jurisdiction
        </h2>
        <p>
          These Terms are governed by and construed in accordance with the laws of the <strong>Republic of India</strong>. Any dispute arising out of or in connection with engineering agreements with RiTiVerse shall be subject to the exclusive jurisdiction of the competent courts in Gujarat, India.
        </p>

      </div>

    </div>
  </section>

<?php
$show_footer_cta = false;
require_once __DIR__ . '/includes/footer.php';
?>
