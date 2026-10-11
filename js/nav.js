/**
 * RITIVERSE — SHARED NAVIGATION & CORE UX
 * Fullscreen menu, sticky navbar capsules, heading typewriter, smooth anchor scrolling
 */

document.addEventListener('DOMContentLoaded', () => {
  initFullscreenNav();
  initFloatingNavScroll();
  initHeadingTypewriter();
  initSmoothAnchorScroll();
  initGlobalFaqAccordion();
});

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
   9. Floating Sticky Navbar Capsules on Scroll
   ========================================================================== */

function initFloatingNavScroll() {
  const nav = document.getElementById('synex-nav');
  if (!nav) return;

  let ticking = false;

  function updateNavState() {
    const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;

    // Maintain sticky capsules at all times, elevating slightly on scroll
    if (currentScrollY > 20) {
      nav.classList.add('is-scrolled');
    } else {
      nav.classList.remove('is-scrolled');
    }

    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(updateNavState);
      ticking = true;
    }
  }, { passive: true });

  // Initial check
  updateNavState();
}

/* ==========================================================================
   10. Kinetic 3D Hero Tagline Rotator
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
        acceptNode: function (node) {
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
   GLOBAL INTERACTIVE FAQ ACCORDION (Works across all pages)
   ========================================================================== */

function initGlobalFaqAccordion() {
  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const trigger = item.querySelector('.faq-question-btn');
    if (!trigger) return;

    // Guard against duplicate event listener registration
    if (trigger._faqInitialized || trigger.dataset.faqBound === 'true') return;
    trigger._faqInitialized = true;
    trigger.dataset.faqBound = 'true';

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const isOpen = item.classList.contains('is-open');

      // Close siblings in the same container for clean accordion UX
      const parent = item.parentElement;
      const siblingFaqs = parent ? parent.querySelectorAll('.faq-item') : faqItems;
      siblingFaqs.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('is-open');
          const otherBtn = otherItem.querySelector('.faq-question-btn');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        }
      });

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

