/**
 * RITIVERSE — DPDP ACT 2023 CONSENT & TELEMETRY CONTROLLER
 * Compliant with Digital Personal Data Protection Act, 2023 (DPDP Act 2023)
 * Implements granular consent gating, Google Consent Mode v2, and preference persistence.
 */

(function () {
  'use strict';

  const STORAGE_KEY = 'ritiverse_dpdp_consent_v1';
  const COOKIE_NAME = 'ritiverse_dpdp_consent';
  const COOKIE_DAYS = 180;

  const defaultPreferences = {
    essential: true,
    analytics: false,
    marketing: false,
    timestamp: null,
    version: '2024-v1.0'
  };

  function getStoredConsent() {
    try {
      const local = localStorage.getItem(STORAGE_KEY);
      if (local) return JSON.parse(local);
    } catch (e) {}

    // Fallback to cookie
    const match = document.cookie.match(new RegExp('(^|;\\s*)(' + COOKIE_NAME + ')=([^;]*)'));
    if (match && match[3]) {
      try {
        return JSON.parse(decodeURIComponent(match[3]));
      } catch (e) {}
    }
    return null;
  }

  function saveStoredConsent(prefs) {
    const payload = {
      essential: true,
      analytics: Boolean(prefs.analytics),
      marketing: Boolean(prefs.marketing),
      timestamp: new Date().toISOString(),
      version: '2024-v1.0'
    };

    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
    } catch (e) {}

    const expires = new Date(Date.now() + COOKIE_DAYS * 864e5).toUTCString();
    document.cookie = `${COOKIE_NAME}=${encodeURIComponent(JSON.stringify(payload))}; expires=${expires}; path=/; SameSite=Lax; Secure`;

    applyConsent(payload);
    hideBanner();
    closeModal();
  }

  function applyConsent(prefs) {
    // 1. Google Consent Mode v2 update
    if (typeof window.gtag === 'function') {
      window.gtag('consent', 'update', {
        analytics_storage: prefs.analytics ? 'granted' : 'denied',
        ad_storage: prefs.marketing ? 'granted' : 'denied',
        ad_user_data: prefs.marketing ? 'granted' : 'denied',
        ad_personalization: prefs.marketing ? 'granted' : 'denied'
      });
    }

    // 2. Dispatch custom DOM event for third-party scripts
    window.dispatchEvent(new CustomEvent('dpdpConsentChanged', { detail: prefs }));

    // 3. Optional runtime telemetry triggers
    if (prefs.analytics && window._pendingGoogleAnalytics) {
      window._pendingGoogleAnalytics();
      window._pendingGoogleAnalytics = null;
    }

    if (prefs.marketing && window._pendingMetaPixel) {
      window._pendingMetaPixel();
      window._pendingMetaPixel = null;
    }
  }

  function showBanner() {
    const banner = document.getElementById('dpdp-consent-banner');
    if (banner) {
      banner.classList.add('is-visible');
    }
  }

  function hideBanner() {
    const banner = document.getElementById('dpdp-consent-banner');
    if (banner) {
      banner.classList.remove('is-visible');
    }
  }

  function openModal() {
    const modal = document.getElementById('dpdp-preference-modal');
    if (!modal) return;

    const current = getStoredConsent() || defaultPreferences;
    const analyticsToggle = document.getElementById('dpdp-toggle-analytics');
    const marketingToggle = document.getElementById('dpdp-toggle-marketing');

    if (analyticsToggle) analyticsToggle.checked = Boolean(current.analytics);
    if (marketingToggle) marketingToggle.checked = Boolean(current.marketing);

    modal.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    const modal = document.getElementById('dpdp-preference-modal');
    if (modal) {
      modal.classList.remove('is-active');
      document.body.style.overflow = '';
    }
  }

  // Public Actions exposed on window
  window.dpdpAcceptAll = function () {
    saveStoredConsent({ essential: true, analytics: true, marketing: true });
  };

  window.dpdpRejectNonEssential = function () {
    saveStoredConsent({ essential: true, analytics: false, marketing: false });
  };

  window.dpdpSavePreferences = function () {
    const analyticsToggle = document.getElementById('dpdp-toggle-analytics');
    const marketingToggle = document.getElementById('dpdp-toggle-marketing');
    saveStoredConsent({
      essential: true,
      analytics: analyticsToggle ? analyticsToggle.checked : false,
      marketing: marketingToggle ? marketingToggle.checked : false
    });
  };

  window.openCookieSettings = openModal;
  window.closeCookieSettings = closeModal;
  window.getDPDPConsent = getStoredConsent;

  // Initialization on DOMContentLoaded
  document.addEventListener('DOMContentLoaded', () => {
    const existing = getStoredConsent();
    if (!existing) {
      setTimeout(showBanner, 900);
    } else {
      applyConsent(existing);
    }

    // Modal background click close
    const modal = document.getElementById('dpdp-preference-modal');
    if (modal) {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
      });
    }

    // ESC key close
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeModal();
    });
  });
})();
