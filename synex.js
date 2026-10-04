/**
 * SYNEX — AI FINTECH WEBSITE INTERACTIVITY
 * High-performance UI interactions, number ticker, chart tooltips & mouse parallax
 */

document.addEventListener('DOMContentLoaded', () => {
  initNumberCounter();
  initChartInteractions();
  initCurrencyToggle();
  initMouseParallax();
  initEmailCapture();
  initSidebarNav();
});

/* ==========================================================================
   1. Live Number Counter for Hero Figures
   ========================================================================== */
function initNumberCounter() {
  const amountElement = document.getElementById('hero-amount-val');
  if (!amountElement) return;

  const targetAmount = 348720.00;
  const duration = 1800; // ms
  const startTime = performance.now();

  function formatMoney(num) {
    return num.toLocaleString('en-US', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  function updateCount(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    
    // Ease Out Quart for ultra-smooth deceleration
    const easeOut = 1 - Math.pow(1 - progress, 4);
    const currentVal = targetAmount * easeOut;

    amountElement.textContent = formatMoney(currentVal);

    if (progress < 1) {
      requestAnimationFrame(updateCount);
    } else {
      amountElement.textContent = formatMoney(targetAmount);
    }
  }

  requestAnimationFrame(updateCount);
}

/* ==========================================================================
   2. Interactive Monthly Chart & Bar Highlighting
   ========================================================================== */
function initChartInteractions() {
  const barCols = document.querySelectorAll('.chart-bar-col');
  const amountElement = document.getElementById('hero-amount-val');
  const growthBadge = document.getElementById('hero-growth-badge');

  const monthData = {
    'jan': { val: 182400.00, change: '+6.2%' },
    'feb': { val: 204120.50, change: '+11.9%' },
    'mar': { val: 219800.00, change: '+7.6%' },
    'apr': { val: 235100.80, change: '+7.0%' },
    'may': { val: 248900.00, change: '+5.8%' },
    'jun': { val: 271400.20, change: '+9.0%' },
    'jul': { val: 289650.00, change: '+6.7%' },
    'aug': { val: 301200.40, change: '+4.0%' },
    'sep': { val: 318450.00, change: '+5.7%' },
    'oct': { val: 332100.00, change: '+4.3%' },
    'nov': { val: 348720.00, change: '+28.4%' },
    'dec': { val: 365400.00, change: '+32.1%' }
  };

  barCols.forEach(col => {
    col.addEventListener('mouseenter', () => {
      const month = col.dataset.month;
      if (month && monthData[month]) {
        barCols.forEach(b => b.classList.remove('highlighted'));
        col.classList.add('highlighted');

        // Update hero metric dynamically on hover
        const currSign = document.getElementById('currency-symbol')?.textContent || '$ ';
        if (amountElement) {
          amountElement.textContent = monthData[month].val.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
        }
        if (growthBadge) {
          growthBadge.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
            ${monthData[month].change}
          `;
        }
      }
    });

    col.addEventListener('click', () => {
      barCols.forEach(b => b.classList.remove('highlighted'));
      col.classList.add('highlighted');
    });
  });
}

/* ==========================================================================
   3. Currency Switcher (USD, EUR, GBP)
   ========================================================================== */
function initCurrencyToggle() {
  const currencyBtns = document.querySelectorAll('.currency-option');
  const currencySymbol = document.getElementById('currency-symbol');
  const amountElement = document.getElementById('hero-amount-val');

  const rates = {
    'USD': { symbol: '$ ', factor: 1.0 },
    'EUR': { symbol: '€ ', factor: 0.92 },
    'GBP': { symbol: '£ ', factor: 0.79 }
  };

  const baseUSD = 345398.34;

  currencyBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      currencyBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const curr = btn.dataset.curr || 'USD';
      const info = rates[curr] || rates['USD'];

      if (currencySymbol) currencySymbol.textContent = info.symbol;
      if (amountElement) {
        const converted = baseUSD * info.factor;
        amountElement.textContent = converted.toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }
    });
  });
}

/* ==========================================================================
   4. Smooth Mouse Parallax on Rocks & Dashboard
   ========================================================================== */
function initMouseParallax() {
  const leftRock = document.getElementById('rock-left');
  const rightRock = document.getElementById('rock-right');
  const pebbles = document.getElementById('rock-pebbles');
  const dashboard = document.getElementById('synex-dashboard');
  const stage = document.getElementById('hero-stage');

  if (!stage) return;

  let mouseX = 0;
  let mouseY = 0;
  let targetX = 0;
  let targetY = 0;

  window.addEventListener('mousemove', (e) => {
    const { innerWidth, innerHeight } = window;
    const x = (e.clientX / innerWidth - 0.5) * 2; // -1 to 1
    const y = (e.clientY / innerHeight - 0.5) * 2; // -1 to 1

    targetX = x;
    targetY = y;
  });

  function renderParallax() {
    mouseX += (targetX - mouseX) * 0.05;
    mouseY += (targetY - mouseY) * 0.05;

    if (leftRock) {
      leftRock.style.transform = `translate3d(${mouseX * -16}px, ${mouseY * -8}px, 0)`;
    }
    if (rightRock) {
      rightRock.style.transform = `translate3d(${mouseX * 20}px, ${mouseY * -10}px, 0)`;
    }
    if (pebbles) {
      pebbles.style.transform = `translateX(-50%) translate3d(${mouseX * 10}px, ${mouseY * 4}px, 0)`;
    }
    if (dashboard) {
      const tiltX = mouseY * -3;
      const tiltY = mouseX * 4;
      dashboard.style.transform = `perspective(1200px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translate3d(${mouseX * 5}px, ${mouseY * 5}px, 0)`;
    }

    requestAnimationFrame(renderParallax);
  }

  requestAnimationFrame(renderParallax);
}

/* ==========================================================================
   5. Work Email Capture Form Interaction
   ========================================================================== */
function initEmailCapture() {
  const form = document.getElementById('hero-cta-form');
  const input = document.getElementById('hero-email-input');
  const btn = document.getElementById('hero-submit-btn');
  const msg = document.getElementById('cta-status-message');

  if (!form || !btn) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const val = input.value.trim();

    if (!val || !val.includes('@')) {
      input.focus();
      input.style.boxShadow = '0 0 0 2px #EF4444';
      setTimeout(() => {
        input.style.boxShadow = '';
      }, 1500);
      return;
    }

    btn.disabled = true;
    btn.innerHTML = `
      <svg class="spin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite; width:14px; height:14px;">
        <circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle>
        <path d="M12 2a10 10 0 0 1 10 10"></path>
      </svg>
      Processing...
    `;

    setTimeout(() => {
      btn.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px; height:14px; stroke:#FFFFFF;">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        Consultation Booked
      `;
      btn.style.backgroundColor = '#D95D39';

      if (msg) {
        msg.textContent = 'Engineering team notified. We will reply within 24 hours.';
        msg.classList.add('visible');
      }

      setTimeout(() => {
        input.value = '';
        btn.disabled = false;
        btn.style.backgroundColor = '';
        btn.innerHTML = `
          Start a project
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        `;
        if (msg) msg.classList.remove('visible');
      }, 4000);
    }, 1000);
  });
}

/* ==========================================================================
   6. Sidebar Navigation Active State Toggle
   ========================================================================== */
function initSidebarNav() {
  const navItems = document.querySelectorAll('.sidebar-nav-item');
  navItems.forEach(item => {
    item.addEventListener('click', () => {
      navItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
    });
  });
}
