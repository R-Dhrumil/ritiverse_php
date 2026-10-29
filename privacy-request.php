<?php
/**
 * RiTiVerse — Data Principal Statutory Rights Portal
 * Compliant with Digital Personal Data Protection Act, 2023 (DPDP Act 2023)
 * Empowers users to exercise Rights of Access, Correction, Erasure, Withdrawal & Grievance.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

$page_title = 'Exercise Data Principal Rights (DPDP Act 2023) — ' . APP_NAME;
$page_description = 'Exercise your statutory data privacy rights under India\'s Digital Personal Data Protection Act, 2023. Request data access, correction, erasure, or contact the Grievance Officer.';
$current_page = 'privacy-request';
$extra_css = ['css/contact.css'];

$dpo = get_dpo_details();
require_once __DIR__ . '/includes/header.php';
?>

  <!-- Subpage Hero Header Section -->
  <section class="subpage-hero" style="padding-top: 130px; padding-bottom: 50px; background: radial-gradient(circle at 50% 10%, rgba(248, 104, 0, 0.08) 0%, transparent 60%);">
    <div class="site-container" style="max-width: 900px; margin: 0 auto; padding: 0 24px; text-align: center;">
      <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(248, 104, 0, 0.1); border: 1px solid rgba(248, 104, 0, 0.25); border-radius: 99px; padding: 6px 16px; margin-bottom: 18px;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#F86800" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
          <path d="M9 12l2 2 4-4"></path>
        </svg>
        <span style="font-size: 12px; font-weight: 700; color: #F86800; text-transform: uppercase; letter-spacing: 0.05em;">DPDP Act 2023 Statutory Portal</span>
      </div>
      <h1 style="font-size: clamp(30px, 4vw, 44px); font-weight: 800; color: var(--text-primary-dark, #0F172A); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 14px;">
        Data Principal Rights &amp; Grievance Redressal
      </h1>
      <p style="font-size: 16px; line-height: 1.6; color: var(--text-secondary-dark, #475569); max-width: 680px; margin: 0 auto;">
        As a Data Principal under India's <strong>Digital Personal Data Protection Act, 2023</strong>, you have full sovereign rights over your personal data processed by <strong><?= e(APP_LEGAL_NAME) ?></strong>. Submit statutory requests below.
      </p>
    </div>
  </section>

  <!-- Interactive Statutory Request Portal -->
  <section class="section-container" style="padding-bottom: 80px;">
    <div class="site-container" style="max-width: 1040px; margin: 0 auto; padding: 0 24px;">
      
      <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 36px; align-items: start;">
        
        <!-- Left: Interactive Form -->
        <div style="background: #FFFFFF; border: 1px solid rgba(226, 218, 204, 0.9); border-radius: 18px; padding: 32px; box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);">
          <h2 style="font-size: 20px; font-weight: 700; color: #0F172A; margin-bottom: 8px;">
            Submit Statutory Data Request
          </h2>
          <p style="font-size: 13.5px; color: #64748B; margin-bottom: 24px; line-height: 1.5;">
            Select your statutory right below. Our Grievance Redressal Desk will verify your identity and fulfill your request within <strong>30 calendar days</strong>.
          </p>

          <form id="dpdp-request-form" onsubmit="event.preventDefault(); submitDPDPRequest();">
            <?= csrf_field() ?>
            <!-- Honeypot -->
            <input type="text" name="security_hp" style="display:none !important;" tabindex="-1" autocomplete="off">

            <div style="display: flex; flex-direction: column; gap: 18px;">
              
              <div class="form-field">
                <label for="req-type" style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                  Statutory Right to Exercise *
                </label>
                <select id="req-type" name="request_type" class="form-input-control" required style="cursor: pointer; width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #CBD5E1; font-family: inherit; font-size: 14px; background: #FFFFFF;">
                  <option value="" disabled selected>Select DPDP statutory right...</option>
                  <option value="access">1. Right to Access Information (Section 11) — Summary of Data Processed</option>
                  <option value="correction">2. Right to Correction &amp; Updation (Section 12) — Update Inaccurate Records</option>
                  <option value="erasure">3. Right to Erasure / Right to be Forgotten (Section 12(3)) — Delete Personal Data</option>
                  <option value="withdraw_consent">4. Right to Withdraw Consent (Section 6(4)) — Revoke Marketing/Contact Consent</option>
                  <option value="grievance">5. Right of Grievance Redressal (Section 13) — Formal Complaint to DPO</option>
                </select>
              </div>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-field">
                  <label for="req-name" style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                    Full Legal Name *
                  </label>
                  <input type="text" id="req-name" name="name" class="form-input-control" placeholder="Jane Doe" required
                    style="width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #CBD5E1; font-family: inherit; font-size: 14px;">
                </div>
                <div class="form-field">
                  <label for="req-email" style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                    Associated Email Address *
                  </label>
                  <input type="email" id="req-email" name="email" class="form-input-control" placeholder="jane@example.com" required
                    style="width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #CBD5E1; font-family: inherit; font-size: 14px;">
                </div>
              </div>

              <div class="form-field">
                <label for="req-phone" style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                  Contact Phone (Optional, for Identity Verification)
                </label>
                <input type="tel" id="req-phone" name="phone" class="form-input-control" placeholder="+91 98765 43210"
                  style="width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #CBD5E1; font-family: inherit; font-size: 14px;">
              </div>

              <div class="form-field">
                <label for="req-details" style="font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; display: block;">
                  Request Specifics &amp; Justification *
                </label>
                <textarea id="req-details" name="details" class="form-input-control" rows="4" required
                  placeholder="Specify what personal data you want accessed, corrected, or erased, or detail your grievance..."
                  style="width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #CBD5E1; font-family: inherit; font-size: 14px; resize: vertical;"></textarea>
              </div>

              <!-- DPDP Identity Declaration -->
              <div class="dpdp-consent-group" style="margin-top: 4px; margin-bottom: 8px;">
                <label class="dpdp-checkbox-label" for="req-declaration">
                  <input type="checkbox" id="req-declaration" name="declaration" value="1" required>
                  <span>
                    I solemnly declare that I am the Data Principal or lawful representative authorized under Section 14 of the DPDP Act 2023 to submit this request, and the provided email address is registered in my name.
                  </span>
                </label>
              </div>

              <button type="submit" id="dpdp-submit-btn" class="btn-primary" style="justify-content: center; width: 100%; padding: 15px; font-size: 14px; border-radius: 8px;">
                Submit Statutory Request
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </button>

              <div id="dpdp-form-status" style="display: none; padding: 14px; border-radius: 8px; font-size: 13px; text-align: center;"></div>
            </div>
          </form>
        </div>

        <!-- Right: Legal Explanation & Grievance Redressal Officer Info -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
          
          <!-- DPO Contact Card -->
          <div style="background: #FFFFFF; border: 1px solid rgba(226, 218, 204, 0.9); border-radius: 16px; padding: 24px; box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.04);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
              <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(248, 104, 0, 0.1); display: flex; align-items: center; justify-content: center; color: #F86800;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </div>
              <div>
                <h3 style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0;">Grievance Redressal Officer (GRO)</h3>
                <span style="font-size: 12px; color: #64748B;">Appointed per DPDP Act Section 13</span>
              </div>
            </div>
            
            <div style="font-size: 13px; color: #334155; line-height: 1.6;">
              <p style="margin: 0 0 6px 0;"><strong>Officer:</strong> <?= e($dpo['name']) ?></p>
              <p style="margin: 0 0 6px 0;"><strong>Designation:</strong> <?= e($dpo['designation']) ?></p>
              <p style="margin: 0 0 6px 0;"><strong>Direct Desk Email:</strong> <a href="mailto:<?= e($dpo['email']) ?>" style="color: #F86800; font-weight: 600; text-decoration: none;"><?= e($dpo['email']) ?></a></p>
              <p style="margin: 0 0 6px 0;"><strong>Statutory SLA:</strong> <?= e($dpo['response_sla']) ?></p>
              <p style="margin: 0;"><strong>Jurisdiction:</strong> <?= e($dpo['jurisdiction']) ?></p>
            </div>
          </div>

          <!-- Statutory Rights Summary -->
          <div style="background: rgba(248, 104, 0, 0.04); border: 1px solid rgba(248, 104, 0, 0.18); border-radius: 16px; padding: 22px;">
            <h4 style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0 0 10px 0; display: flex; align-items: center; gap: 8px;">
              <span style="color: #F86800;">⚖</span>
              Your Sovereign Rights under DPDP Act 2023
            </h4>
            <ul style="font-size: 12.5px; line-height: 1.6; color: #475569; padding-left: 18px; margin: 0;">
              <li><strong>Right to Access:</strong> You can request a copy of all personal inquiries and consultation notes tied to your email.</li>
              <li><strong>Right to Erasure:</strong> You can request immediate erasure ("Right to be Forgotten") once project consultation concludes.</li>
              <li><strong>Zero Vendor Lock-In:</strong> Any code, databases, or deliverables created for your company belong 100% to you.</li>
              <li><strong>Appeals:</strong> If not satisfied with the Grievance Redressal Officer's resolution within 30 days, you have the statutory right to escalate to the <strong>Data Protection Board of India (DPBI)</strong>.</li>
            </ul>
          </div>

          <!-- Quick Links -->
          <div style="text-align: center; font-size: 13px; color: #64748B;">
            Need more information? Read our <a href="privacy-policy.php" style="color: #F86800; font-weight: 600; text-decoration: underline;">Comprehensive DPDP Privacy Policy</a>.
          </div>

        </div>

      </div>

    </div>
  </section>

  <script>
    function submitDPDPRequest() {
      const form = document.getElementById('dpdp-request-form');
      const btn = document.getElementById('dpdp-submit-btn');
      const status = document.getElementById('dpdp-form-status');
      if (!form) return;

      const formData = new FormData(form);

      if (btn) {
        btn.disabled = true;
        btn.innerHTML = 'Verifying &amp; Logging Request...';
      }

      fetch('api/privacy-request.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          if (btn) {
            btn.innerHTML = 'Request Registered Successfully ✓';
            btn.style.background = '#10B981';
          }
          if (status) {
            status.style.display = 'block';
            status.style.background = 'rgba(16, 185, 129, 0.1)';
            status.style.border = '1px solid rgba(16, 185, 129, 0.4)';
            status.style.color = '#065F46';
            status.innerHTML = `<strong>Ticket #${data.ticket_id}:</strong> ${data.message}`;
          }
          form.reset();
        } else {
          throw new Error(data.message || 'Submission failed');
        }
      })
      .catch(err => {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = 'Submit Statutory Request';
          btn.style.background = '';
        }
        if (status) {
          status.style.display = 'block';
          status.style.background = 'rgba(239, 68, 68, 0.1)';
          status.style.border = '1px solid rgba(239, 68, 68, 0.3)';
          status.style.color = '#EF4444';
          status.textContent = err.message || 'Something went wrong. You may email the Grievance Officer directly at <?= e($dpo['email']) ?>';
        }
      });
    }
  </script>

<?php
$show_footer_cta = false;
require_once __DIR__ . '/includes/footer.php';
?>
