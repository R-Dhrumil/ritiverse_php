<?php
/**
 * RiTiVerse — Master Privacy Notice & DPDP Act 2023 Statutory Policy
 * Compliant with the Digital Personal Data Protection Act, 2023 (Act No. 22 of 2023, India)
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

$page_title = 'Privacy Policy & DPDP Act 2023 Notice — ' . APP_NAME;
$page_description = 'Official Privacy Policy of RiTiVerse Studio in compliance with India\'s Digital Personal Data Protection Act, 2023 (DPDP Act 2023). Learn how your personal data is protected.';
$current_page = 'privacy-policy';
$extra_css = ['css/contact.css'];

$dpo = get_dpo_details();
require_once __DIR__ . '/includes/header.php';
?>

  <section class="subpage-hero" style="padding-top: 130px; padding-bottom: 50px; background: radial-gradient(circle at 50% 10%, rgba(248, 104, 0, 0.08) 0%, transparent 60%);">
    <div class="site-container" style="max-width: 900px; margin: 0 auto; padding: 0 24px; text-align: center;">
      <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(248, 104, 0, 0.1); border: 1px solid rgba(248, 104, 0, 0.25); border-radius: 99px; padding: 6px 16px; margin-bottom: 18px;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#F86800" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
          <path d="M9 12l2 2 4-4"></path>
        </svg>
        <span style="font-size: 12px; font-weight: 700; color: #F86800; text-transform: uppercase; letter-spacing: 0.05em;">Statutory Compliance Notice</span>
      </div>
      <h1 style="font-size: clamp(30px, 4vw, 44px); font-weight: 800; color: #0F172A; letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 14px;">
        Privacy Notice &amp; Data Protection Policy
      </h1>
      <p style="font-size: 15px; color: #64748B; max-width: 650px; margin: 0 auto;">
        Effective Date: October 2024 &nbsp;|&nbsp; Statutory Version: <?= DPDP_NOTICE_VERSION ?> &nbsp;|&nbsp; Governed by the Digital Personal Data Protection Act, 2023 (DPDP Act 2023, India)
      </p>
    </div>
  </section>

  <!-- Legal Body Content Section -->
  <section class="section-container" style="padding-bottom: 90px;">
    <div class="site-container" style="max-width: 920px; margin: 0 auto; padding: 0 24px;">
      
      <div style="background: #FFFFFF; border: 1px solid rgba(226, 218, 204, 0.9); border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04); font-size: 15px; line-height: 1.75; color: #334155;">

        <!-- 1. Preamble & Data Fiduciary Identity -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 0; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          1. Identity of the Data Fiduciary &amp; Overview
        </h2>
        <p>
          This Privacy Notice is published by <strong><?= e(APP_LEGAL_NAME) ?></strong> (operating the official digital domain <a href="https://ritiverse.in" style="color: #F86800; font-weight: 600;">ritiverse.in</a>), hereinafter referred to as the <strong>"Data Fiduciary"</strong>, in compliance with Section 5 of the <strong>Digital Personal Data Protection Act, 2023 (Act No. 22 of 2023, Parliament of India)</strong>.
        </p>
        <p>
          At <strong>RiTiVerse</strong>, we engineer bespoke websites, CRM systems, ERP platforms, and custom software delivered with <strong>100% client source code ownership</strong> and zero vendor lock-in. We hold the protection of your personal digital data to the highest standards of integrity, transparency, and legal accountability.
        </p>

        <!-- 2. Categories of Personal Data Collected -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          2. Categories of Personal Data We Process
        </h2>
        <p>
          In accordance with the principle of <em>Data Minimization</em>, we only collect digital personal data that is directly necessary to respond to your technical consultation requests, formulate engineering proposals, or fulfill production milestones:
        </p>
        <ul style="padding-left: 20px;">
          <li><strong>Direct Identification Details:</strong> Full Name, Business/Personal Email Address, Contact Telephone Number, and Company/Organization Name.</li>
          <li><strong>Project Specifications:</strong> Consultation briefs, technology scope requirements, target milestones, and functional descriptions submitted via our consultation portal.</li>
          <li><strong>Technical Telemetry &amp; Network Identifiers:</strong> Internet Protocol (IP) address, approximate geographic city/region, browser agent, and CSRF authentication tokens.</li>
          <li><strong>Analytics &amp; Cookie Preferences:</strong> Non-essential analytics (Google Analytics gtag.js) and marketing attribution (Meta Pixel) are processed <strong>only upon your affirmative consent</strong> via our DPDP Cookie Preference Center.</li>
        </ul>

        <!-- 3. Lawful Grounds & Purpose of Processing -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          3. Lawful Purposes for Data Processing
        </h2>
        <p>Under Section 4 and Section 6 of the DPDP Act 2023, your personal data is processed solely for specified, lawful purposes:</p>
        <ul style="padding-left: 20px;">
          <li>To evaluate software architecture specifications and dispatch accurate project estimates and timeline blueprints.</li>
          <li>To establish direct developer communications regarding custom CRM, ERP, mobile app, or website engineering projects.</li>
          <li>To ensure cryptographic defense against Cross-Site Request Forgery (CSRF), brute-force bots, and distributed denial-of-service attempts.</li>
          <li>To comply with statutory legal, taxation (GST / Income Tax Act), and regulatory obligations in the Republic of India.</li>
        </ul>

        <!-- 4. Affirmative Consent Architecture -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          4. Consent Mechanism &amp; Right of Withdrawal
        </h2>
        <p>
          Under Section 6 of the DPDP Act 2023, your consent is <strong>free, specific, informed, unconditional, and unambiguous with clear affirmative action</strong>. We never employ pre-ticked checkboxes or deceptive dark patterns.
        </p>
        <p>
          <strong>Right to Withdraw Consent (Section 6(4)):</strong> You have the sovereign right to withdraw previously granted consent at any time as easily as it was given. Upon receipt of withdrawal, RiTiVerse will cease processing your personal data within 7 business days, unless retention is strictly required by statutory tax or corporate laws.
        </p>

        <!-- 5. Data Principal Sovereign Rights -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          5. Sovereign Rights of the Data Principal
        </h2>
        <p>As a Data Principal under Chapter III of the DPDP Act 2023, you are entitled to the following statutory rights:</p>
        <div style="display: grid; gap: 14px; margin: 18px 0;">
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
            <strong style="color: #0F172A;">Right to Access Information (Section 11):</strong>
            <p style="margin: 4px 0 0 0; font-size: 13.5px; color: #475569;">You may request a summary of your personal data processed by RiTiVerse and the identities of all third parties or cloud servers where it has been handled.</p>
          </div>
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
            <strong style="color: #0F172A;">Right to Correction &amp; Completion (Section 12):</strong>
            <p style="margin: 4px 0 0 0; font-size: 13.5px; color: #475569;">You may request correction of inaccurate data, completion of incomplete records, or updating of changed coordinates.</p>
          </div>
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
            <strong style="color: #0F172A;">Right to Erasure / "Right to be Forgotten" (Section 12(3)):</strong>
            <p style="margin: 4px 0 0 0; font-size: 13.5px; color: #475569;">You may request permanent erasure of your personal data once the project consultation or contract period has concluded.</p>
          </div>
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
            <strong style="color: #0F172A;">Right of Grievance Redressal (Section 13):</strong>
            <p style="margin: 4px 0 0 0; font-size: 13.5px; color: #475569;">You have the right to accessible grievance redressal provided by our designated Grievance Redressal Officer with an SLA of 30 days.</p>
          </div>
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px;">
            <strong style="color: #0F172A;">Right to Nominate (Section 14):</strong>
            <p style="margin: 4px 0 0 0; font-size: 13.5px; color: #475569;">You may designate an individual who shall exercise your data rights in the unfortunate event of death or incapacity.</p>
          </div>
        </div>
        <p>
          To exercise any of these rights, visit our dedicated <a href="privacy-request.php" style="color: #F86800; font-weight: 600; text-decoration: underline;">Data Principal Rights Portal</a>.
        </p>

        <!-- 6. Data Storage Limitation & Retention Policy -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          6. Storage Limitation &amp; Data Retention
        </h2>
        <p>
          Under Section 8(7) of the DPDP Act 2023, RiTiVerse retains personal consultation inquiries only for as long as necessary to fulfill the initial inquiry or contract execution (standard retention: <strong>365 calendar days</strong>). Following this window, inactive records are systematically scrubbed or anonymized.
        </p>

        <!-- 7. Technical Security Safeguards -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          7. Technical &amp; Operational Security Safeguards
        </h2>
        <p>
          Under Section 8(5), RiTiVerse enforces bank-grade technical safeguards to prevent unauthorized access, alteration, disclosure, or personal data breach:
        </p>
        <ul style="padding-left: 20px;">
          <li><strong>Transport Layer Security:</strong> 256-bit TLS 1.3 encryption across all incoming and outgoing connections (HSTS enabled).</li>
          <li><strong>Database Defenses:</strong> PDO parameterized queries preventing SQL injection, strict IP rate limiting on APIs, and Bcrypt password hashing for administrative access.</li>
          <li><strong>PII Masking &amp; Pseudonymization:</strong> IP addresses and sensitive identifiers in administrative audit logs are masked.</li>
        </ul>

        <!-- 8. Protection of Children's Personal Data -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          8. Children's Personal Data (Section 9 Compliance)
        </h2>
        <p>
          RiTiVerse is an enterprise B2B software engineering and custom website studio. We do not provide services directed to individuals under 18 years of age (minors), nor do we track children's behavior or process children's personal data.
        </p>

        <!-- 9. Grievance Redressal Officer & Appeals -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          9. Grievance Redressal Officer &amp; Statutory Escalation
        </h2>
        <p>
          In accordance with Section 8 and Section 13 of the DPDP Act 2023, RiTiVerse has designated a <strong>Grievance Redressal Officer (GRO)</strong> to address any concerns regarding data handling:
        </p>
        <div style="background: rgba(248, 104, 0, 0.05); border: 1px solid rgba(248, 104, 0, 0.2); border-radius: 12px; padding: 20px 24px; margin: 18px 0;">
          <p style="margin: 0 0 6px 0;"><strong>Officer Name:</strong> <?= e($dpo['name']) ?></p>
          <p style="margin: 0 0 6px 0;"><strong>Designation:</strong> <?= e($dpo['designation']) ?></p>
          <p style="margin: 0 0 6px 0;"><strong>Statutory Desk Email:</strong> <a href="mailto:<?= e($dpo['email']) ?>" style="color: #F86800; font-weight: 700;"><?= e($dpo['email']) ?></a></p>
          <p style="margin: 0 0 6px 0;"><strong>Jurisdiction:</strong> <?= e($dpo['jurisdiction']) ?></p>
          <p style="margin: 0;"><strong>Response SLA:</strong> Within 30 calendar days of verified submission.</p>
        </div>
        <p style="font-size: 13.5px; color: #64748B;">
          <strong>Escalation to Data Protection Board of India (DPBI):</strong> If your grievance is not resolved to your satisfaction within 30 days of submission to our Grievance Redressal Officer, you have the statutory right under Section 13(3) of the DPDP Act 2023 to file a complaint before the Data Protection Board of India.
        </p>

        <!-- 10. Modifications to this Notice -->
        <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid rgba(248, 104, 0, 0.2); padding-bottom: 8px;">
          10. Policy Amendments
        </h2>
        <p>
          RiTiVerse may update this statutory policy periodically to reflect statutory notifications, rules issued under the DPDP Act 2023, or technological upgrades. Any changes will be published here with an updated version stamp.
        </p>

      </div>

    </div>
  </section>

<?php
$show_footer_cta = false;
require_once __DIR__ . '/includes/footer.php';
?>
