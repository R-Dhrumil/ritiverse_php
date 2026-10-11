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
  const btn = document.getElementById('contact-submit-btn');
  const status = document.getElementById('contact-form-status');
  const nameInput = document.getElementById('contact-name');
  const name = nameInput ? nameInput.value : '';

  if (btn) {
    btn.disabled = true;
    btn.innerHTML = 'Transmitting Scope...';
  }

  setTimeout(() => {
    if (btn) {
      btn.innerHTML = 'Inquiry Dispatched ✓';
      btn.style.background = '#10B981';
    }

    if (status) {
      status.style.display = 'block';
      status.style.background = 'rgba(16, 185, 129, 0.15)';
      status.style.border = '1px solid rgba(52, 211, 153, 0.3)';
      status.style.color = '#34D399';
      status.textContent = 'Thank you, ' + name + '. Your architectural inquiry has been routed to our principal engineering team. We will review your scope and respond within 24 hours.';
    }

    const form = document.getElementById('contact-inquiry-form');
    if (form) form.reset();
  }, 1200);
}
