/**
 * SYNEX — AI FINTECH WEBSITE INTERACTIVITY
 * High-performance UI interactions, number ticker, chart tooltips & mouse parallax
 */

document.addEventListener('DOMContentLoaded', () => {
  initFullscreenNav();
  initFloatingNavScroll();
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
  initHeadingTypewriter();
  initFaqAccordion();
  initSmoothAnchorScroll();
  initProcessLaser();
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

  // Initial State: Card is positioned down at bottom (y: 350), scaled small (0.35), 0 opacity
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

  // Master Apple-Style Scroll-Linked Scale Timeline (Card ascends from bottom to full screen)
  const heroTimeline = gsap.timeline({
    scrollTrigger: {
      trigger: heroSection,
      start: "top top",
      end: "+=1300", // Pinned scroll track distance for dramatic reveal
      pin: true,
      scrub: 1.15, // Weighted physics scrub lag for buttery smooth motion
      anticipatePin: 1,
      invalidateOnRefresh: true,
      onUpdate: (self) => {
        const prog = self.progress;

        // Enable card interactivity once revealed into view
        if (prog > 0.55) {
          scrollTarget.style.pointerEvents = 'auto';
        } else {
          scrollTarget.style.pointerEvents = 'none';
        }

        // Studio drop shadow expansion as card blooms to full screen (clean natural shadow, no neon glow)
        const blur = Math.round(20 + prog * 45);
        const yOffset = Math.round(8 + prog * 24);
        scrollTarget.style.filter = `drop-shadow(0 ${yOffset}px ${blur}px rgba(0, 140, 216, 0.18))`;
      }
    }
  });

  // Step 1 (0 -> 0.35): Hero text dissolves & gently ascends out of view
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

  // Floating scroll prompt disappears early on scroll
  if (scrollPrompt) {
    heroTimeline.to(scrollPrompt, {
      opacity: 0,
      y: 12,
      ease: "power1.out",
      duration: 0.18
    }, 0);
  }

  // Step 2 (0.12 -> 1.0): Card rises up from the bottom & scales to Full Screen (1.04)
  heroTimeline.to(scrollTarget, {
    autoAlpha: 1,
    scale: 1.04,
    y: 0, // Ascends from bottom (y: 350 -> 0) into optical center
    ease: "power2.out",
    duration: 0.88
  }, 0.12);

  window.addEventListener('load', () => {
    ScrollTrigger.refresh();
  });
}

/**
 * Fallback scroll scaler if GSAP CDN is blocked or unavailable
 */
function initFallbackScrollScale() {
  const scrollTarget = document.getElementById('dashboard-scroll-target');
  const heroHeader = document.querySelector('.hero-header');
  const scrollPrompt = document.getElementById('hero-scroll-prompt');
  if (!scrollTarget) return;

  function onScroll() {
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
        Consultation Booked
      `;
      btn.style.background = 'linear-gradient(135deg, #10B981 0%, #059669 100%)';

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

/* ==========================================================================
   7. 3D Particle Silk-Dust Motion Wave (Hero Background)
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
  const PARTICLE_COUNT = 9000;
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
        // Tri-tone brand particles matching the owl logo: Azure Blue on the crest, Flame Orange highlights, and deep slate base
        if (Math.abs(v - 0.08) < 0.12 && i % 6 === 0) {
          ctx.fillStyle = `rgba(0, 140, 216, ${(alpha * 0.75).toFixed(3)})`;
        } else if (Math.abs(v - 0.18) < 0.14 && i % 7 === 0) {
          ctx.fillStyle = `rgba(248, 104, 0, ${(alpha * 0.75).toFixed(3)})`;
        } else {
          ctx.fillStyle = `rgba(30, 41, 59, ${(alpha * 0.55).toFixed(3)})`;
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
function initFullscreenNav() {
  const trigger = document.getElementById('synex-menu-trigger');
  const closeBtn = document.getElementById('fs-close-btn');
  const fsMenu = document.getElementById('synex-fs-menu');

  if (!trigger || !fsMenu) return;

  const navItems = fsMenu.querySelectorAll('.fs-nav-item');
  const menuFooter = fsMenu.querySelector('.fs-menu-footer');
  const gridCrosses = fsMenu.querySelectorAll('.fs-grid-cross');
  const navLinks = fsMenu.querySelectorAll('.fs-nav-link');

  let isOpen = false;

  function openMenu() {
    if (isOpen) return;
    isOpen = true;

    trigger.setAttribute('aria-expanded', 'true');
    fsMenu.setAttribute('aria-hidden', 'false');
    fsMenu.classList.add('is-open');
    document.body.style.overflow = 'hidden';

    // GSAP Staggered Reveal Animation
    if (typeof gsap !== 'undefined') {
      const activeTargets = [fsMenu, navItems, menuFooter, gridCrosses].filter(Boolean);
      gsap.killTweensOf(activeTargets);

      // Set initial states
      gsap.set(fsMenu, { opacity: 0 });
      gsap.set(navItems, { opacity: 0, y: 35 });
      if (menuFooter) gsap.set(menuFooter, { opacity: 0, y: 20 });
      if (gridCrosses.length) gsap.set(gridCrosses, { opacity: 0, scale: 0.6 });

      const tl = gsap.timeline();

      tl.to(fsMenu, {
        opacity: 1,
        duration: 0.35,
        ease: 'power2.out'
      })
        .to(gridCrosses, {
          opacity: 1,
          scale: 1,
          stagger: 0.05,
          duration: 0.4,
          ease: 'back.out(1.5)'
        }, '-=0.2')
        .to(navItems, {
          opacity: 1,
          y: 0,
          stagger: 0.06,
          duration: 0.5,
          ease: 'power3.out'
        }, '-=0.3')
        .to(menuFooter, {
          opacity: 1,
          y: 0,
          duration: 0.4,
          ease: 'power2.out'
        }, '-=0.35');
    }
  }

  function closeMenu() {
    if (!isOpen) return;
    isOpen = false;

    trigger.setAttribute('aria-expanded', 'false');
    fsMenu.setAttribute('aria-hidden', 'true');

    if (typeof gsap !== 'undefined') {
      const closeTargets = [navItems, menuFooter].filter(Boolean);
      gsap.killTweensOf([fsMenu, ...closeTargets]);

      const tl = gsap.timeline({
        onComplete: () => {
          fsMenu.classList.remove('is-open');
          document.body.style.overflow = '';
        }
      });

      tl.to(closeTargets, {
        opacity: 0,
        y: -15,
        stagger: 0.02,
        duration: 0.2,
        ease: 'power2.in'
      })
        .to(fsMenu, {
          opacity: 0,
          duration: 0.25,
          ease: 'power2.in'
        }, '-=0.1');
    } else {
      fsMenu.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  }

  // Event Listeners
  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    openMenu();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      closeMenu();
    });
  }

  // Keyboard accessibility: Escape key closes menu
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen) {
      closeMenu();
    }
  });

  // Smooth scroll and close menu on clicking any navigation anchor
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        closeMenu();

        const targetEl = document.querySelector(href);
        if (targetEl) {
          setTimeout(() => {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }, 250);
        }
      }
    });
  });
}

/* ==========================================================================
   9. Floating Navbar Smart Auto-Hide & Return on Scroll
   ========================================================================== */
function initFloatingNavScroll() {
  const nav = document.getElementById('synex-nav');
  const fsMenu = document.getElementById('synex-fs-menu');
  if (!nav) return;

  let lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
  let ticking = false;
  const threshold = 18; // Substantial scroll delta to prevent twitchy triggers

  function onScroll() {
    const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;

    // Do not hide when fullscreen menu overlay is open
    if (fsMenu && fsMenu.classList.contains('is-open')) {
      nav.classList.remove('nav-hidden');
      lastScrollY = currentScrollY;
      ticking = false;
      return;
    }

    // Always keep visible within the upper hero zone
    if (currentScrollY <= 80) {
      nav.classList.remove('nav-hidden');
    } else if (currentScrollY > lastScrollY + threshold) {
      // Intentional scroll DOWN -> smoothly glide capsules up
      nav.classList.add('nav-hidden');
    } else if (currentScrollY < lastScrollY - threshold) {
      // Intentional scroll UP (or pull down) -> smoothly return capsules
      nav.classList.remove('nav-hidden');
    }

    lastScrollY = Math.max(0, currentScrollY);
    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });
}

/* ==========================================================================
   10. Kinetic 3D Hero Tagline Rotator
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
      feedback.textContent = `Analyzing requirements for "${query}"... Redirecting to team consultation.`;
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
function initHeadingTypewriter() {
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  // Select all prominent headings across the website (excluding hero section)
  const headingSelectors = [
    '.subpage-title',
    '.showcase-title',
    '.section-title',
    '.footer-headline',
    '.service-block-header h3',
    '.process-step-title',
    '.case-card-title',
    'h2.section-heading',
    '[data-typewriter]'
  ];

  const candidateElements = document.querySelectorAll(headingSelectors.join(', '));
  if (!candidateElements.length) return;

  // Filter out any elements inside hero section, hidden overlays, menus, or dashboard windows
  const headings = Array.from(candidateElements).filter(el => {
    return !el.closest('.synex-hero') &&
           !el.closest('.hero-header') &&
           !el.closest('.fs-menu-overlay') &&
           !el.closest('.dash-sidebar') &&
           !el.closest('.synex-dashboard-window');
  });

  // Helper to extract text nodes that have meaningful content
  function getMeaningfulTextNodes(element) {
    const nodes = [];
    const walker = document.createTreeWalker(
      element,
      NodeFilter.SHOW_TEXT,
      {
        acceptNode: function(node) {
          if (!node.nodeValue || node.nodeValue.trim() === '') {
            return NodeFilter.FILTER_REJECT;
          }
          if (node.parentElement && (
            node.parentElement.classList.contains('typewriter-cursor') ||
            node.parentElement.closest('.hero-rotator-wrapper') ||
            node.parentElement.closest('.fs-menu-overlay')
          )) {
            return NodeFilter.FILTER_REJECT;
          }
          return NodeFilter.FILTER_ACCEPT;
        }
      },
      false
    );

    let n;
    while ((n = walker.nextNode())) {
      nodes.push(n);
    }
    return nodes;
  }

  // Prepare each heading: record original texts and clear them
  const preparedList = [];
  headings.forEach(heading => {
    const textNodes = getMeaningfulTextNodes(heading);
    if (!textNodes.length) return;

    const entries = textNodes.map(node => ({
      node: node,
      fullText: node.nodeValue
    }));

    heading._typewriterEntries = entries;
    heading._typewriterStarted = false;

    // Clear content of text nodes so they start blank before scrolling in
    entries.forEach(item => {
      item.node.nodeValue = '';
    });

    preparedList.push(heading);
  });

  function startTyping(heading) {
    if (heading._typewriterStarted) return;
    heading._typewriterStarted = true;

    const entries = heading._typewriterEntries;
    if (!entries || !entries.length) return;

    // Create the glowing brand-orange cursor
    const cursor = document.createElement('span');
    cursor.className = 'typewriter-cursor';
    cursor.setAttribute('aria-hidden', 'true');
    cursor.textContent = '|';

    let entryIndex = 0;
    let charIndex = 0;

    function typeStep() {
      if (entryIndex >= entries.length) {
        // Finished typing all nodes in this heading
        setTimeout(() => {
          cursor.classList.add('fade-out');
          setTimeout(() => {
            if (cursor.parentNode) cursor.parentNode.removeChild(cursor);
          }, 400);
        }, 1800);
        return;
      }

      const currentItem = entries[entryIndex];
      const targetStr = currentItem.fullText;

      // Position cursor right after current text node
      if (currentItem.node.parentNode) {
        if (currentItem.node.nextSibling !== cursor) {
          currentItem.node.parentNode.insertBefore(cursor, currentItem.node.nextSibling);
        }
      }

      if (charIndex < targetStr.length) {
        const char = targetStr.charAt(charIndex);
        charIndex++;
        currentItem.node.nodeValue = targetStr.substring(0, charIndex);

        // Natural typing timing calculation
        let delay = Math.floor(Math.random() * 10) + 20; // 20ms - 30ms
        if (['.', '!', '?', ':', ';'].includes(char)) {
          delay += 100;
        } else if ([',', '-'].includes(char)) {
          delay += 45;
        }

        setTimeout(typeStep, delay);
      } else {
        // Move to next line or span
        entryIndex++;
        charIndex = 0;
        setTimeout(typeStep, 70);
      }
    }

    // Initial slight delay before typing starts
    setTimeout(typeStep, 70);
  }

  // Set up IntersectionObserver with scroll trigger
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = entry.target;
          obs.unobserve(target);
          startTyping(target);
        }
      });
    }, {
      root: null,
      rootMargin: '0px 0px -6% 0px',
      threshold: 0.1
    });

    preparedList.forEach(heading => {
      observer.observe(heading);
    });
  } else {
    // Fallback if IntersectionObserver is not supported
    preparedList.forEach(h => startTyping(h));
  }
}

/* ==========================================================================
   HOMEPAGE INTERACTIVE FAQ ACCORDION
   ========================================================================== */
function initFaqAccordion() {
  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const trigger = item.querySelector('.faq-question-btn');
    if (!trigger) return;

    trigger.addEventListener('click', () => {
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
function initSmoothAnchorScroll() {
  const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
  anchorLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      const targetId = link.getAttribute('href').slice(1);
      const targetElement = document.getElementById(targetId);
      if (targetElement) {
        e.preventDefault();
        // If fullscreen menu is open, close it first
        const fsMenu = document.getElementById('synex-fs-menu');
        const trigger = document.getElementById('synex-menu-trigger');
        if (fsMenu && fsMenu.classList.contains('is-active')) {
          fsMenu.classList.remove('is-active');
          fsMenu.setAttribute('aria-hidden', 'true');
          if (trigger) trigger.setAttribute('aria-expanded', 'false');
          document.body.classList.remove('fs-menu-locked');
        }

        const navHeight = 90;
        const targetPos = targetElement.getBoundingClientRect().top + window.pageYOffset - navHeight;
        window.scrollTo({
          top: targetPos,
          behavior: 'smooth'
        });
      }
    });
  });
}

/* ==========================================================================
   DELIVERY LIFECYCLE: LASER SCANNER & ACTIVE CARD ROTATION
   ========================================================================== */
function initProcessLaser() {
  const processSection = document.getElementById('process');
  const cardsGrid = document.getElementById('processCardsGrid');
  const laserBeam = document.getElementById('processLaserBeam');
  const cards = document.querySelectorAll('.process-card');

  if (!cards.length) return;

  let currentIndex = 0;
  let laserTimer = null;
  let isHovered = false;

  function updateLaserPosition(index) {
    if (!laserBeam || !cardsGrid) return;
    const card = cards[index];
    if (!card) return;

    const gridRect = cardsGrid.getBoundingClientRect();
    const cardRect = card.getBoundingClientRect();
    const leftOffset = cardRect.left - gridRect.left;
    const width = cardRect.width;

    laserBeam.style.transform = `translateX(${leftOffset}px)`;
    laserBeam.style.width = `${width}px`;
  }

  function setActiveStage(index) {
    currentIndex = index;
    cards.forEach((card, idx) => {
      const isActive = idx === index;
      card.classList.toggle('is-laser-active', isActive);
      card.setAttribute('aria-expanded', isActive ? 'true' : 'false');
    });
    updateLaserPosition(index);
  }

  function startCycle() {
    stopCycle();
    laserTimer = setInterval(() => {
      if (!isHovered) {
        currentIndex = (currentIndex + 1) % cards.length;
        setActiveStage(currentIndex);
      }
    }, 2800);
  }

  function stopCycle() {
    if (laserTimer) {
      clearInterval(laserTimer);
      laserTimer = null;
    }
  }

  // Interactive mouse / keyboard events
  cards.forEach((card, idx) => {
    card.addEventListener('mouseenter', () => {
      isHovered = true;
      setActiveStage(idx);
    });

    card.addEventListener('click', () => {
      setActiveStage(idx);
    });

    card.addEventListener('focus', () => {
      isHovered = true;
      setActiveStage(idx);
    });

    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        setActiveStage(idx);
      }
    });
  });

  if (cardsGrid) {
    cardsGrid.addEventListener('mouseleave', () => {
      isHovered = false;
    });
  }

  // Handle window resizing to keep laser beam aligned
  window.addEventListener('resize', () => {
    updateLaserPosition(currentIndex);
  });

  // Start with Card 0 active
  setActiveStage(0);

  // IntersectionObserver to only animate when in viewport
  if ('IntersectionObserver' in window && processSection) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          startCycle();
          updateLaserPosition(currentIndex);
        } else {
          stopCycle();
        }
      });
    }, { threshold: 0.15 });

    observer.observe(processSection);
  } else {
    startCycle();
  }
}



