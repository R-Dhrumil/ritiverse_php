/**
 * RITIVERSE — CONTACT PAGE DEDICATED LOGIC
 * Consultation dispatch handler & interactive FAQ accordion
 */

document.addEventListener('DOMContentLoaded', () => {
  initFaqAccordion();
});

function initFaqAccordion() {
  // Handled globally across all pages by initGlobalFaqAccordion in nav.js
  if (typeof initGlobalFaqAccordion === 'function') {
    initGlobalFaqAccordion();
    return;
  }

  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const trigger = item.querySelector('.faq-question-btn');
    if (!trigger || trigger.dataset.faqBound === 'true' || trigger._faqInitialized) return;
    trigger.dataset.faqBound = 'true';
    trigger._faqInitialized = true;

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const isOpen = item.classList.contains('is-open');

      // Close all others for crisp accordion behavior
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('is-open');
          const otherBtn = otherItem.querySelector('.faq-question-btn');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        }
      });

      // Toggle current
      if (isOpen) {
        item.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('is-open');
        trigger.setAttribute('aria-expanded', 'true');
      }
    });
  });
}

function handleContactSubmit() {
  const form = document.getElementById('contact-inquiry-form');
  const btn = document.getElementById('contact-submit-btn');
  const status = document.getElementById('contact-form-status');
  if (!form) return;

  const consentBox = document.getElementById('dpdp_consent');
  if (consentBox && !consentBox.checked) {
    if (status) {
      status.style.display = 'block';
      status.style.background = 'rgba(239, 68, 68, 0.1)';
      status.style.border = '1px solid rgba(239, 68, 68, 0.3)';
      status.style.color = '#EF4444';
      status.textContent = 'Please accept the DPDP Act 2023 Privacy Notice consent checkbox to proceed.';
    }
    consentBox.focus();
    return;
  }

  const formData = new FormData(form);

  if (btn) {
    btn.disabled = true;
    btn.innerHTML = 'Submitting Inquiry...';
  }

  fetch('api/contact-process.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (btn) {
        btn.innerHTML = 'Inquiry Sent Successfully ✓';
        btn.style.background = '#10B981';
      }
      if (status) {
        status.style.display = 'block';
        status.style.background = 'rgba(254, 243, 199, 0.9)';
        status.style.border = '1px solid rgba(245, 158, 11, 0.4)';
        status.style.color = '#B45309';
        status.textContent = data.message;
      }
      form.reset();
    } else {
      throw new Error(data.message || 'Submission failed');
    }
  })
  .catch(err => {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = 'Send Project Inquiry (Free Estimate)';
      btn.style.background = '';
    }
    if (status) {
      status.style.display = 'block';
      status.style.background = 'rgba(239, 68, 68, 0.1)';
      status.style.border = '1px solid rgba(239, 68, 68, 0.3)';
      status.style.color = '#EF4444';
      status.textContent = err.message || 'Something went wrong. Please email us directly at info@ritiverse.in';
    }
  });
}
