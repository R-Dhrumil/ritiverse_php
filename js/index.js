/**
 * RITIVERSE — HOMEPAGE DEDICATED LOGIC
 * Hero metrics, 3D Canvas motion wave, GSAP reveal, blueprints, interactive accordions
 */

document.addEventListener('DOMContentLoaded', () => {
  initNumberCounter();
  initChartInteractions();
  initCurrencyToggle();
  initHeroScrollReveal();
  initMouseParallax();
  initEmailCapture();
  initSidebarNav();
  initHeroRotator();
  initMotionWave();
  initCapabilitiesAccordion();
  initShowcaseSearch();
  initFaqAccordion();
  initProcessLaser();
  initFlagships3DOrbit();
  initAdminControl();
});

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
   4. GSAP Scroll-Linked Scale Animation (Boom Reveal: Small to Full Screen)
   ========================================================================== */

function initHeroScrollReveal() {
  const heroSection = document.getElementById('synex-hero');
  const scrollTarget = document.getElementById('dashboard-scroll-target');
  const heroHeader = document.querySelector('.hero-header');
  const scrollPrompt = document.getElementById('hero-scroll-prompt');

  if (!heroSection || !scrollTarget) return;

  // Graceful fallback if GSAP or ScrollTrigger are not yet loaded (e.g. offline)
  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
    initFallbackScrollScale();
    return;
  }

  // Register GSAP ScrollTrigger plugin
  gsap.registerPlugin(ScrollTrigger);

  ScrollTrigger.matchMedia({
    // Desktop View (992px and up): Apple-Style Pinned Scale Reveal
    "(min-width: 992px)": function() {
      gsap.set(scrollTarget, {
        scale: 0.35,
        y: 350,
        autoAlpha: 0,
        transformOrigin: "center bottom",
        pointerEvents: "none"
      });

      if (heroHeader) {
        gsap.set(heroHeader, {
          opacity: 1,
          scale: 1,
          y: 0,
          visibility: "visible",
          pointerEvents: "auto"
        });
      }

      if (scrollPrompt) {
        gsap.set(scrollPrompt, {
          display: "flex",
          opacity: 1,
          y: 0
        });
      }

      const heroTimeline = gsap.timeline({
        scrollTrigger: {
          trigger: heroSection,
          start: "top top",
          end: "+=1300",
          pin: true,
          scrub: 1.15,
          anticipatePin: 1,
          invalidateOnRefresh: true,
          onUpdate: (self) => {
            const prog = self.progress;
            if (prog > 0.55) {
              scrollTarget.style.pointerEvents = 'auto';
              if (window.refreshAdminIndicator) window.refreshAdminIndicator();
            } else {
              scrollTarget.style.pointerEvents = 'none';
            }
            const blur = Math.round(20 + prog * 45);
            const yOffset = Math.round(8 + prog * 24);
            scrollTarget.style.filter = `drop-shadow(0 ${yOffset}px ${blur}px rgba(217, 119, 6, 0.14))`;
          }
        }
      });

      if (heroHeader) {
        heroTimeline.fromTo(heroHeader, {
          opacity: 1,
          y: 0,
          scale: 1,
          visibility: "visible",
          pointerEvents: "auto"
        }, {
          opacity: 0,
          y: -60,
          scale: 0.9,
          pointerEvents: "none",
          ease: "power2.inOut",
          duration: 0.35
        }, 0);
      }

      if (scrollPrompt) {
        heroTimeline.to(scrollPrompt, {
          opacity: 0,
          y: 12,
          ease: "power1.out",
          duration: 0.18
        }, 0);
      }

      heroTimeline.to(scrollTarget, {
        autoAlpha: 1,
        scale: 1.04,
        y: 0,
        ease: "power2.out",
        duration: 0.88
      }, 0.12);

      return () => {
        heroTimeline.kill();
      };
    },

    // Mobile & Tablet (under 992px): Natural flow without scroll-jacking
    "(max-width: 991px)": function() {
      gsap.set(scrollTarget, {
        clearProps: "all",
        autoAlpha: 1,
        opacity: 1,
        visibility: "visible",
        scale: 1,
        y: 0,
        pointerEvents: "auto"
      });

      if (heroHeader) {
        gsap.set(heroHeader, {
          clearProps: "all",
          opacity: 1,
          scale: 1,
          y: 0,
          visibility: "visible",
          pointerEvents: "auto"
        });
      }

      if (scrollPrompt) {
        gsap.set(scrollPrompt, {
          display: "none"
        });
      }

      setTimeout(() => {
        if (window.refreshAdminIndicator) window.refreshAdminIndicator();
      }, 150);
    }
  });

  window.addEventListener('load', () => {
    ScrollTrigger.refresh();
  });
}

/**
 * Fallback scroll scaler if GSAP CDN is blocked or unavailable
 */

function initFallbackScrollScale() {
  if (window.innerWidth < 992) return;
  const scrollTarget = document.getElementById('dashboard-scroll-target');
  const heroHeader = document.querySelector('.hero-header');
  const scrollPrompt = document.getElementById('hero-scroll-prompt');
  if (!scrollTarget) return;

  function onScroll() {
    if (window.innerWidth < 992) return;
    const scrollY = window.scrollY || window.pageYOffset || 0;
    const progress = Math.min(1, Math.max(0, scrollY / 650));

    if (progress < 0.08) {
      // Completely hidden down at bottom at resting top of page
      scrollTarget.style.opacity = '0';
      scrollTarget.style.visibility = 'hidden';
      scrollTarget.style.transform = 'translateY(350px) scale(0.35)';
      scrollTarget.style.pointerEvents = 'none';
    } else {
      // Ascends up from bottom and scales from small to full size
      const boom = (progress - 0.08) / 0.92;
      const scale = 0.35 + boom * 0.69; // up to 1.04
      const y = (1 - boom) * 350; // rises from 350 to 0
      scrollTarget.style.opacity = Math.min(1, boom * 2.8).toFixed(3);
      scrollTarget.style.visibility = 'visible';
      scrollTarget.style.transform = `translateY(${y.toFixed(2)}px) scale(${scale.toFixed(4)})`;
      scrollTarget.style.pointerEvents = boom > 0.6 ? 'auto' : 'none';
    }

    if (heroHeader) {
      heroHeader.style.opacity = Math.max(0, 1 - progress * 2.5).toFixed(3);
      heroHeader.style.transform = `translateY(${-progress * 50}px) scale(${(1 - progress * 0.1).toFixed(3)})`;
      heroHeader.style.pointerEvents = progress > 0.3 ? 'none' : 'auto';
    }
    if (scrollPrompt) {
      scrollPrompt.style.opacity = Math.max(0, 1 - progress * 4).toFixed(3);
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
}

/* ==========================================================================
   5. Clean Apple Hero Stage Alignment (No 3D Cursor Tilt)
   ========================================================================== */

function initMouseParallax() {
  // 3D tilt removed per user request for clean, flat Apple-style aesthetic.
  // Dynamic motion continues seamlessly in the 3D particle silk-dust background canvas.
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
        Redirecting...
      `;
      btn.style.background = 'linear-gradient(135deg, #10B981 0%, #059669 100%)';

      if (msg) {
        msg.textContent = 'Redirecting you to our secure project consultation desk...';
        msg.classList.add('visible');
      }

      setTimeout(() => {
        window.location.href = 'contact.php?email=' + encodeURIComponent(val);
      }, 700);
    }, 600);
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

/* ==========================================================================
   7. 3D Particle Silk-Dust Motion Wave (Hero Background)
   ========================================================================== */

function initHeroRotator() {
  const rotator = document.getElementById('hero-rotator');
  if (!rotator) return;

  const items = Array.from(rotator.querySelectorAll('.rotator-item'));
  if (items.length <= 1) return;

  let currentIndex = 0;
  const intervalTime = 2800; // Switch dynamic phrase every 2.8 seconds

  setInterval(() => {
    const currentItem = items[currentIndex];
    const nextIndex = (currentIndex + 1) % items.length;
    const nextItem = items[nextIndex];

    // Smooth 3D exit of current word
    currentItem.classList.remove('is-active');
    currentItem.classList.add('is-exiting');

    // Smooth 3D entrance of next word
    nextItem.classList.remove('is-exiting');
    nextItem.classList.add('is-active');

    // Clean up exiting class after transition completes
    setTimeout(() => {
      currentItem.classList.remove('is-exiting');
    }, 700);

    currentIndex = nextIndex;
  }, intervalTime);
}

/* ==========================================================================
   11. Interactive Capabilities Expanding Accordion Card Deck (Framer-Motion Style)
   ========================================================================== */

function initMotionWave() {
  const canvas = document.getElementById('synex-motion-canvas');
  if (!canvas) return;

  const heroSection = document.getElementById('synex-hero') || canvas.parentElement;
  const ctx = canvas.getContext('2d');
  let width = 0, height = 0, dpr = 1;
  const mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
  let time = 0;

  function resize() {
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    width = heroSection.clientWidth || window.innerWidth;
    height = heroSection.clientHeight || window.innerHeight;
    canvas.width = Math.floor(width * dpr);
    canvas.height = Math.floor(height * dpr);
    canvas.style.width = width + 'px';
    canvas.style.height = height + 'px';
  }

  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = heroSection.getBoundingClientRect();
    if (e.clientY >= rect.top && e.clientY <= rect.bottom) {
      mouse.targetX = ((e.clientX - rect.left) / width - 0.5) * 45;
      mouse.targetY = ((e.clientY - rect.top) / height - 0.5) * 35;
    }
  });

  // Generate Ribbon Particle Dust
  const PARTICLE_COUNT = window.innerWidth < 768 ? 2500 : 9000;
  const particles = new Float32Array(PARTICLE_COUNT * 6); // [u, v, jitterX, jitterY, jitterZ, size]

  for (let i = 0; i < PARTICLE_COUNT; i++) {
    const idx = i * 6;
    const u = Math.random(); // position along curve
    const r1 = Math.random();
    const sign = Math.random() > 0.5 ? 1 : -1;
    const v = sign * Math.pow(r1, 1.35); // denser along central spine
    const jx = (Math.random() - 0.5) * 24;
    const jy = (Math.random() - 0.5) * 24;
    const jz = (Math.random() - 0.5) * 40;
    const size = 0.6 + Math.random() * 1.5;

    particles[idx] = u;
    particles[idx + 1] = v;
    particles[idx + 2] = jx;
    particles[idx + 3] = jy;
    particles[idx + 4] = jz;
    particles[idx + 5] = size;
  }

  // Ambient Floating Dust Particles
  const STAR_COUNT = 220;
  const stars = [];
  for (let s = 0; s < STAR_COUNT; s++) {
    stars.push({
      x: Math.random(),
      y: Math.random(),
      baseAlpha: 0.15 + Math.random() * 0.55,
      twinkleSpeed: 0.4 + Math.random() * 1.6,
      twinkleOffset: Math.random() * Math.PI * 2,
      radius: 0.6 + Math.random() * 1.2
    });
  }

  function render() {
    time += 0.0085;
    mouse.x += (mouse.targetX - mouse.x) * 0.05;
    mouse.y += (mouse.targetY - mouse.y) * 0.05;

    ctx.save();
    ctx.scale(dpr, dpr);
    ctx.clearRect(0, 0, width, height);

    // 1. Ambient Floating Stars
    for (let s = 0; s < STAR_COUNT; s++) {
      const st = stars[s];
      const sx = st.x * width + mouse.x * 0.2;
      const sy = st.y * height + mouse.y * 0.2;
      const alpha = st.baseAlpha * (0.6 + 0.4 * Math.sin(time * st.twinkleSpeed + st.twinkleOffset));
      ctx.fillStyle = `rgba(100, 116, 139, ${alpha.toFixed(3)})`;
      ctx.beginPath();
      ctx.arc(sx, sy, st.radius, 0, Math.PI * 2);
      ctx.fill();
    }

    // 2. Subtle Soft Ambient Neutral Tone (Zero Neon Glow)
    const neutralGrad = ctx.createRadialGradient(
      width * 0.5 + mouse.x * 0.4, height * 0.42 + mouse.y * 0.4, width * 0.05,
      width * 0.5 + mouse.x * 0.4, height * 0.45 + mouse.y * 0.4, width * 0.45
    );
    neutralGrad.addColorStop(0, 'rgba(255, 255, 255, 0.4)');
    neutralGrad.addColorStop(0.5, 'rgba(241, 245, 249, 0.2)');
    neutralGrad.addColorStop(1, 'rgba(248, 249, 250, 0)');
    ctx.fillStyle = neutralGrad;
    ctx.fillRect(0, 0, width, height);

    // 3. Render 3D Silk-Dust Ribbon Particles
    const fov = 750;
    for (let i = 0; i < PARTICLE_COUNT; i++) {
      const idx = i * 6;
      const u = particles[idx];
      const v = particles[idx + 1];
      const jx = particles[idx + 2];
      const jy = particles[idx + 3];
      const jz = particles[idx + 4];
      const size = particles[idx + 5];

      // Parametric 3D Infinity Wave Spine
      const sx0 = (u - 0.5) * (width * 1.35) + width * 0.5;
      const waveA = Math.sin(u * Math.PI * 1.75 - time * 0.55) * (height * 0.26);
      const waveB = Math.cos(u * Math.PI * 0.9 + time * 0.35) * (height * 0.13);
      const sy0 = height * (0.35 + 0.22 * Math.sin(u * Math.PI * 0.95)) + waveA + waveB;
      const sz0 = Math.cos(u * Math.PI * 1.5 - time * 0.45) * 220;

      // Ribbon Width & Dynamic 3D Twist
      const ribbonWidth = (Math.sin(u * Math.PI) * 0.72 + 0.28) * (height * 0.56);
      const twist = u * Math.PI * 1.85 + Math.sin(u * 2.8 + time * 0.5) * 0.75 - 0.3;
      const nx = Math.cos(twist);
      const ny = Math.sin(twist);
      const nz = Math.sin(twist + 1.57);

      // 3D Point along Ribbon
      const px = sx0 + nx * (v * ribbonWidth) + jx;
      const py = sy0 + ny * (v * ribbonWidth) + jy;
      const pz = sz0 + nz * (v * ribbonWidth * 0.6) + jz;

      // Perspective Projection
      const scale = fov / (fov + pz);
      const screenX = (px - width * 0.5) * scale + width * 0.5 + mouse.x * (scale * 0.9);
      const screenY = (py - height * 0.5) * scale + height * 0.5 + mouse.y * (scale * 0.9);

      // Alpha & Lighting
      const absV = Math.abs(v);
      const edgeFalloff = Math.max(0, 1 - Math.pow(absV, 1.8));
      const crestLuminance = Math.exp(-Math.pow((v - 0.08) / 0.22, 2)) * 0.7;
      const depthAlpha = Math.max(0.15, Math.min(1.0, (scale - 0.55) * 1.5));
      const alpha = (edgeFalloff * 0.42 + crestLuminance) * depthAlpha;

      if (alpha > 0.015) {
        const r = Math.max(0.4, size * scale);
        // Amber Minimal palette particles: Warm Amber on the crest, Flame Orange highlights, and soft slate base
        if (Math.abs(v - 0.08) < 0.12 && i % 6 === 0) {
          ctx.fillStyle = `rgba(245, 158, 11, ${(alpha * 0.75).toFixed(3)})`;
        } else if (Math.abs(v - 0.18) < 0.14 && i % 7 === 0) {
          ctx.fillStyle = `rgba(248, 104, 0, ${(alpha * 0.75).toFixed(3)})`;
        } else {
          ctx.fillStyle = `rgba(71, 85, 105, ${(alpha * 0.55).toFixed(3)})`;
        }
        ctx.beginPath();
        ctx.arc(screenX, screenY, r, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    ctx.restore();
    requestAnimationFrame(render);
  }

  requestAnimationFrame(render);
}

/* ==========================================================================
   8. Fullscreen Architectural Navigation Overlay (GSAP Animations)
   ========================================================================== */

function initCapabilitiesAccordion() {
  const container = document.getElementById('capabilities-accordion');
  if (!container) return;

  const cards = Array.from(container.querySelectorAll('.accordion-card'));
  if (!cards.length) return;

  function setActiveCard(targetCard) {
    cards.forEach(card => {
      const isActive = card === targetCard;
      card.classList.toggle('is-active', isActive);
      card.setAttribute('aria-expanded', isActive ? 'true' : 'false');
    });
  }

  cards.forEach((card, index) => {
    // Hover interaction (smooth desktop spring expansion)
    card.addEventListener('mouseenter', () => {
      setActiveCard(card);
    });

    // Click / Touch interaction
    card.addEventListener('click', () => {
      setActiveCard(card);
    });

    // Keyboard navigation
    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        setActiveCard(card);
      } else if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        e.preventDefault();
        const nextIndex = (index + 1) % cards.length;
        cards[nextIndex].focus();
        setActiveCard(cards[nextIndex]);
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        e.preventDefault();
        const prevIndex = (index - 1 + cards.length) % cards.length;
        cards[prevIndex].focus();
        setActiveCard(cards[prevIndex]);
      }
    });
  });
}

/* ==========================================================================
   12. Showcase Vision / Requirement Search Form Interaction
   ========================================================================== */

function initShowcaseSearch() {
  const form = document.getElementById('showcase-search-form');
  const input = document.getElementById('showcase-query-input');
  const feedback = document.getElementById('showcase-feedback');
  if (!form || !input) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const query = input.value.trim();
    if (!query) return;

    if (feedback) {
      feedback.textContent = `Looking up options for "${query}"... Taking you to consultation.`;
      setTimeout(() => {
        const contactSection = document.getElementById('contact');
        if (contactSection) {
          contactSection.scrollIntoView({ behavior: 'smooth' });
        }
      }, 600);
    }
  });
}

/* ==========================================================================
   13. Scroll-Triggered Dynamic Typewriter Effect for All Website Headings
   ========================================================================== */

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

/* ==========================================================================
   SMOOTH IN-PAGE ANCHOR SCROLLING
   ========================================================================== */

function initProcessLaser() {
  const stage = document.getElementById('stage');
  if (!stage) return;

  const cards = stage.querySelectorAll('[data-card]');
  if (!cards.length) return;

  cards.forEach((card) => {
    card.setAttribute('tabindex', '0');
    card.setAttribute('role', 'region');
    const titleEl = card.querySelector('.card-title');
    if (titleEl) {
      card.setAttribute('aria-label', titleEl.textContent);
    }
  });
}

/* ==========================================================================
   PRODUCTION FLAGSHIPS: 3D REVOLVING CARD ORBIT CAROUSEL
   Interactive 3D orbit, smooth drag/wheel/stepper, and dynamic editorial update
   ========================================================================== */

function initFlagships3DOrbit() {
  const disc = document.getElementById('flagshipsDisc');
  if (!disc) return;

  const FLAGSHIPS_DATA = [
    {
      index: 0,
      badge: "FinTech & Telemetry",
      client: "Aegis Capital",
      subheading: "Aegis Capital • High-Frequency Systems",
      title: "Aegis Financial Telemetry OS",
      description: "High-frequency algorithmic portfolio monitoring platform streaming real-time market data across 12 global exchanges with sub-50ms latency.",
      metrics: [
        { val: "0.12s", lbl: "Global TTFB" },
        { val: "120K+", lbl: "Daily Trades" },
        { val: "100%", lbl: "Client IP" }
      ],
      tags: ["PHP", "Laravel", "React", "MySQL"],
      link: "projects.html"
    },
    {
      index: 1,
      badge: "Supply Chain Cloud",
      client: "Verve Systems",
      subheading: "Verve Systems • Fleet Telemetry",
      title: "Verve Global Logistics Engine",
      description: "Clean RESTful microservices architecture replacing a legacy monolith, handling dynamic routing for 4,000+ commercial freight vehicles.",
      metrics: [
        { val: "99.99%", lbl: "Uptime SLA" },
        { val: "-68%", lbl: "Dispatch Latency" },
        { val: "4.2K", lbl: "Fleet Units" }
      ],
      tags: ["Express.js", "Node.js", "JavaScript", "REST APIs"],
      link: "projects.html"
    },
    {
      index: 2,
      badge: "HealthTech Portal",
      client: "PulseHealth",
      subheading: "PulseHealth • Clinical Diagnostics",
      title: "PulseHealth Diagnostics Portal",
      description: "High-speed clinical workflow assistant combining automated Python data synthesis with modern responsive React and CSS3 interfaces.",
      metrics: [
        { val: "4.8x", lbl: "Workflow Speed" },
        { val: "100%", lbl: "Client IP" },
        { val: "0.34s", lbl: "Query Speed" }
      ],
      tags: ["Python", "React", "HTML5", "CSS3"],
      link: "projects.html"
    },
    {
      index: 3,
      badge: "Enterprise AI & RAG",
      client: "OmniSphere Labs",
      subheading: "OmniSphere Labs • Document Intelligence",
      title: "OmniSphere Private AI Workspace",
      description: "Air-gapped enterprise intelligence workspace indexing 500,000+ proprietary scientific documents with vector semantic search and multi-agent synthesis.",
      metrics: [
        { val: "85%", lbl: "Faster Research" },
        { val: "SOC2", lbl: "Compliant" },
        { val: "Private", lbl: "VPC Isolated" }
      ],
      tags: ["Python", "FastAPI", "pgvector", "React"],
      link: "projects.html"
    },
    {
      index: 4,
      badge: "Headless Web Platform",
      client: "Pulse Global",
      subheading: "Pulse Global • Digital Flagship",
      title: "Pulse Luxury Digital Flagship",
      description: "Cinematic, 60fps editorial buying experience built with Next.js edge rendering, bespoke responsive interactions, and sub-second page transitions.",
      metrics: [
        { val: "100/100", lbl: "Lighthouse Score" },
        { val: "+42%", lbl: "Conversion Lift" },
        { val: "0.18s", lbl: "Average TTFB" }
      ],
      tags: ["React", "Next.js", "Cloudflare", "Tailored Tokens"],
      link: "projects.html"
    }
  ];

  let activeIndex = 0;
  const totalCards = FLAGSHIPS_DATA.length;
  const cardElements = disc.querySelectorAll('.orbit-card-item');

  const badgeCategory = document.getElementById('fBadgeCategory');
  const subheading = document.getElementById('fSubheading');
  const title = document.getElementById('fTitle');
  const description = document.getElementById('fDescription');
  const activeIndexEl = document.getElementById('fActiveIndex');
  const tagsRow = document.getElementById('fTagsRow');
  const ctaBtn = document.getElementById('fCtaBtn');

  const metricVal1 = document.getElementById('fMetricVal1');
  const metricLbl1 = document.getElementById('fMetricLbl1');
  const metricVal2 = document.getElementById('fMetricVal2');
  const metricLbl2 = document.getElementById('fMetricLbl2');
  const metricVal3 = document.getElementById('fMetricVal3');
  const metricLbl3 = document.getElementById('fMetricLbl3');
  const paginationDots = document.getElementById('fPaginationDots');

  function renderOrbit() {
    const isMobile = window.innerWidth <= 640;
    const isTablet = window.innerWidth <= 1024 && !isMobile;

    const scaleActive = isMobile ? 1.05 : (isTablet ? 1.12 : 1.18);
    const scaleSide = isMobile ? 0.78 : 0.86;
    const scaleFar = isMobile ? 0.64 : 0.72;

    const transXSide = isMobile ? 140 : (isTablet ? 170 : 190);
    const transXFar = isMobile ? 230 : (isTablet ? 275 : 305);

    cardElements.forEach((card) => {
      const itemIdx = parseInt(card.getAttribute('data-index'), 10);
      let diff = (itemIdx - activeIndex) % totalCards;
      if (diff > totalCards / 2) diff -= totalCards;
      if (diff < -totalCards / 2) diff += totalCards;

      if (diff === 0) {
        card.classList.add('is-active');
        card.style.transform = `translateX(0px) translateY(-8px) translateZ(160px) rotateY(0deg) rotateZ(0deg) scale(${scaleActive})`;
      } else if (diff === -1) {
        card.classList.remove('is-active');
        card.style.transform = `translateX(-${transXSide}px) translateY(18px) translateZ(-45px) rotateY(24deg) rotateZ(-10deg) scale(${scaleSide})`;
      } else if (diff === 1) {
        card.classList.remove('is-active');
        card.style.transform = `translateX(${transXSide}px) translateY(18px) translateZ(-45px) rotateY(-24deg) rotateZ(10deg) scale(${scaleSide})`;
      } else if (diff === -2 || diff < -1) {
        card.classList.remove('is-active');
        card.style.transform = `translateX(-${transXFar}px) translateY(45px) translateZ(-190px) rotateY(38deg) rotateZ(-18deg) scale(${scaleFar})`;
      } else if (diff === 2 || diff > 1) {
        card.classList.remove('is-active');
        card.style.transform = `translateX(${transXFar}px) translateY(45px) translateZ(-190px) rotateY(-38deg) rotateZ(18deg) scale(${scaleFar})`;
      }
    });

    updateTextInfo();
  }

  function updateTextInfo() {
    const data = FLAGSHIPS_DATA[activeIndex];
    if (!data) return;

    if (badgeCategory) badgeCategory.textContent = data.badge;
    if (subheading) subheading.textContent = data.subheading;

    if (title) {
      title.textContent = data.title;
      title.classList.remove('f-text-fade-in');
      void title.offsetWidth; // Trigger DOM reflow for CSS keyframe
      title.classList.add('f-text-fade-in');
    }

    if (description) description.textContent = data.description;
    if (activeIndexEl) activeIndexEl.textContent = `0${activeIndex + 1}`;

    if (metricVal1 && data.metrics[0]) {
      metricVal1.textContent = data.metrics[0].val;
      metricLbl1.textContent = data.metrics[0].lbl;
    }
    if (metricVal2 && data.metrics[1]) {
      metricVal2.textContent = data.metrics[1].val;
      metricLbl2.textContent = data.metrics[1].lbl;
    }
    if (metricVal3 && data.metrics[2]) {
      metricVal3.textContent = data.metrics[2].val;
      metricLbl3.textContent = data.metrics[2].lbl;
    }

    if (tagsRow) {
      tagsRow.innerHTML = data.tags.map(t => `<span class="flagship-tag-item">${t}</span>`).join('');
    }

    if (ctaBtn) {
      ctaBtn.href = data.link;
    }

    if (paginationDots) {
      const dots = paginationDots.querySelectorAll('.orbit-dot');
      dots.forEach((dot, idx) => {
        if (idx === activeIndex) {
          dot.classList.add('is-active');
        } else {
          dot.classList.remove('is-active');
        }
      });
    }
  }

  function nextCard() {
    activeIndex = (activeIndex + 1) % totalCards;
    renderOrbit();
  }

  function prevCard() {
    activeIndex = (activeIndex - 1 + totalCards) % totalCards;
    renderOrbit();
  }

  function goToCard(idx) {
    activeIndex = idx;
    renderOrbit();
  }

  cardElements.forEach(card => {
    card.addEventListener('click', () => {
      const targetIdx = parseInt(card.getAttribute('data-index'), 10);
      if (targetIdx !== activeIndex) {
        activeIndex = targetIdx;
        renderOrbit();
      }
    });
  });

  const nextBtn = document.getElementById('fNextBtn');
  const prevBtn = document.getElementById('fPrevBtn');
  if (nextBtn) nextBtn.addEventListener('click', nextCard);
  if (prevBtn) prevBtn.addEventListener('click', prevCard);

  if (paginationDots) {
    const dots = paginationDots.querySelectorAll('.orbit-dot');
    dots.forEach((dot, idx) => {
      dot.addEventListener('click', () => goToCard(idx));
    });
  }

  // Mouse wheel with debounce
  let wheelTimeout = null;
  disc.addEventListener('wheel', (e) => {
    e.preventDefault();
    if (wheelTimeout) return;
    if (e.deltaY > 20 || e.deltaX > 20) {
      nextCard();
      wheelTimeout = setTimeout(() => { wheelTimeout = null; }, 280);
    } else if (e.deltaY < -20 || e.deltaX < -20) {
      prevCard();
      wheelTimeout = setTimeout(() => { wheelTimeout = null; }, 280);
    }
  }, { passive: false });

  // Touch & Pointer drag
  let startX = 0;
  let isDragging = false;

  disc.addEventListener('pointerdown', (e) => {
    isDragging = true;
    startX = e.clientX;
  });

  window.addEventListener('pointermove', (e) => {
    if (!isDragging) return;
    const deltaX = e.clientX - startX;
    if (deltaX > 70) {
      prevCard();
      isDragging = false;
    } else if (deltaX < -70) {
      nextCard();
      isDragging = false;
    }
  });

  window.addEventListener('pointerup', () => {
    isDragging = false;
  });

  // Keyboard navigation when hovering or focusing within the section
  const section = document.getElementById('projects');
  if (section) {
    window.addEventListener('keydown', (e) => {
      const rect = section.getBoundingClientRect();
      const inView = rect.top < window.innerHeight && rect.bottom > 0;
      if (!inView) return;

      if (e.key === 'ArrowRight') nextCard();
      if (e.key === 'ArrowLeft') prevCard();
    });
  }

  // Window resize to recalculate offsets
  window.addEventListener('resize', renderOrbit);

  // Initial render
  renderOrbit();
}

/* ==========================================================================
   TAILORED ADMIN CONTROL CONSOLE (Interactive Demo Logic)
   ========================================================================== */

function initAdminControl() {
  const adminSection = document.getElementById('admin-control');
  if (!adminSection) return;

  // ---------- State ----------
  const state = {
    activeTab: 'cms',
    promo: true,
    chat: true,
    maintenance: false,
    leads: { 1: 'New Lead', 2: 'Contacted' },
  };

  // ---------- Tabs ----------
  const tabsEl = adminSection.querySelector('#tabs');
  if (!tabsEl) return;
  const tabs = [...tabsEl.querySelectorAll('.tab')];
  const indicator = adminSection.querySelector('#tabIndicator');
  let switching = false;

  function moveIndicator() {
    const active = tabsEl.querySelector('.tab.active');
    if (!active || !indicator) return;
    indicator.style.width = active.offsetWidth + 'px';
    indicator.style.height = active.offsetHeight + 'px';
    indicator.style.transform = `translate(${active.offsetLeft}px, ${active.offsetTop}px)`;
  }

  // Expose global hook so GSAP scroll reveal can refresh indicator immediately on scale
  window.refreshAdminIndicator = moveIndicator;

  function setTab(id) {
    if (id === state.activeTab || switching) return;
    switching = true;

    const current = adminSection.querySelector('#panel-' + state.activeTab);
    const next = adminSection.querySelector('#panel-' + id);

    state.activeTab = id;
    tabs.forEach(t => {
      const isCur = t.dataset.tab === id;
      t.classList.toggle('active', isCur);
      t.setAttribute('aria-selected', String(isCur));
    });
    moveIndicator();

    if (current && next) {
      current.classList.remove('active');
      current.classList.add('leaving');
      setTimeout(() => {
        current.classList.remove('leaving');
        next.classList.add('active');
        switching = false;
      }, 200);
    } else {
      switching = false;
    }
  }

  tabs.forEach(t => t.addEventListener('click', () => setTab(t.dataset.tab)));
  window.addEventListener('resize', moveIndicator);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(moveIndicator);
  setTimeout(moveIndicator, 60);

  // ---------- CMS (Live Editor) ----------
  const heroInput = adminSection.querySelector('#heroInput');
  const heroPreview = adminSection.querySelector('#heroPreview');
  const chips = adminSection.querySelectorAll('.chip');

  if (heroInput && heroPreview) {
    heroInput.addEventListener('input', () => {
      heroPreview.textContent = heroInput.value.trim() || 'Transforming Your Business With Modern Technology';
      chips.forEach(c => c.classList.remove('active-preset'));
    });

    chips.forEach(chip => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active-preset'));
        chip.classList.add('active-preset');
        heroInput.value = chip.dataset.heading;
        heroPreview.textContent = chip.dataset.heading;
      });
    });
  }

  // ---------- Feature Toggles ----------
  function renderToggle(btn) {
    const key = btn.dataset.toggle;
    const on = state[key];
    const color = btn.dataset.onColor;
    const card = btn.closest('.toggle-card');
    const status = card ? card.querySelector('.toggle-status') : null;

    btn.setAttribute('aria-pressed', String(on));
    btn.classList.remove('on-emerald', 'on-amber');
    if (status) status.classList.remove('on-emerald', 'on-amber');
    if (card) card.classList.toggle('is-active', on);

    if (on) {
      btn.classList.add('on-' + color);
      if (status) status.classList.add('on-' + color);
    }
    const useEl = btn.querySelector('use');
    if (useEl) {
      useEl.setAttribute('href', on ? '#i-toggle-right' : '#i-toggle-left');
    }
    if (status) {
      status.textContent = on ? btn.dataset.on : btn.dataset.off;
    }
  }

  adminSection.querySelectorAll('.toggle-btn').forEach(btn => {
    renderToggle(btn);
    btn.addEventListener('click', () => {
      state[btn.dataset.toggle] = !state[btn.dataset.toggle];
      renderToggle(btn);
    });
  });

  // ---------- Leads & Inquiries ----------
  const lead1 = adminSection.querySelector('#lead1');
  const lead2 = adminSection.querySelector('#lead2');
  const exportBtn = adminSection.querySelector('#exportLeadsBtn');

  function renderLeads() {
    if (lead1) {
      lead1.textContent = state.leads[1];
      lead1.classList.remove('contacted', 'blue');
      if (state.leads[1] === 'Contacted') lead1.classList.add('contacted');
      else if (state.leads[1] === 'Qualified') lead1.classList.add('blue');
    }
    if (lead2) {
      lead2.textContent = state.leads[2];
      lead2.classList.remove('contacted', 'blue');
      if (state.leads[2] === 'Contacted') lead2.classList.add('blue');
      else if (state.leads[2] === 'Proposal Sent') lead2.classList.add('contacted');
    }
  }

  if (lead1) {
    lead1.addEventListener('click', () => {
      // 3-state cycle
      if (state.leads[1] === 'New Lead') state.leads[1] = 'Contacted';
      else if (state.leads[1] === 'Contacted') state.leads[1] = 'Qualified';
      else state.leads[1] = 'New Lead';
      renderLeads();
    });
  }

  if (lead2) {
    lead2.addEventListener('click', () => {
      // 2-state cycle
      state.leads[2] = state.leads[2] === 'Contacted' ? 'Proposal Sent' : 'Contacted';
      renderLeads();
    });
  }
  renderLeads();

  // Export CSV tactile feedback
  if (exportBtn) {
    exportBtn.addEventListener('click', () => {
      const origHtml = exportBtn.innerHTML;
      exportBtn.innerHTML = '<svg class="btn-icon" style="color: #10B981;"><use href="#i-check"/></svg><span>CSV Exported!</span>';
      exportBtn.style.background = '#065F46';
      setTimeout(() => {
        exportBtn.innerHTML = origHtml;
        exportBtn.style.background = '';
      }, 1600);
    });
  }
}



