/**
 * RITIVERSE — SERVICES PAGE DEDICATED LOGIC
 * Dribbble-style architectural service previews & active tab switching
 */

document.addEventListener('DOMContentLoaded', () => {
  initDribbbleServices();
});

function initDribbbleServices() {
  const serviceItems = document.querySelectorAll('.dribbble-service-item');
  const previewCards = document.querySelectorAll('.dribbble-preview-card');

  if (!serviceItems.length || !previewCards.length) return;

  const activeItem = document.querySelector('.dribbble-service-item.is-active');
  let currentServiceKey = activeItem ? activeItem.getAttribute('data-service') : 'web';

  function activateService(serviceKey) {
    if (!serviceKey || serviceKey === currentServiceKey) return;
    const prevKey = currentServiceKey;
    currentServiceKey = serviceKey;

    // 1. Update service list items state
    serviceItems.forEach(item => {
      const isMatch = item.getAttribute('data-service') === serviceKey;
      item.classList.toggle('is-active', isMatch);
      item.setAttribute('aria-selected', isMatch ? 'true' : 'false');
    });

    // 2. Animate preview cards smoothly
    const prevCard = document.querySelector(`.dribbble-preview-card[data-preview="${prevKey}"]`);
    const nextCard = document.querySelector(`.dribbble-preview-card[data-preview="${serviceKey}"]`);

    if (typeof gsap !== 'undefined') {
      if (prevCard) {
        gsap.killTweensOf(prevCard);
        prevCard.style.zIndex = '2';
        gsap.to(prevCard, {
          autoAlpha: 0,
          scale: 0.95,
          y: -10,
          duration: 0.22,
          ease: 'power2.in',
          onComplete: () => {
            if (prevCard.getAttribute('data-preview') !== currentServiceKey) {
              prevCard.classList.remove('is-visible');
              prevCard.style.zIndex = '';
              gsap.set(prevCard, { clearProps: 'transform,opacity,visibility' });
            }
          }
        });
      }

      if (nextCard) {
        gsap.killTweensOf(nextCard);
        previewCards.forEach(card => {
          if (card !== nextCard && card !== prevCard) {
            card.classList.remove('is-visible');
            card.style.zIndex = '';
            gsap.set(card, { clearProps: 'transform,opacity,visibility' });
          }
        });

        nextCard.classList.add('is-visible');
        nextCard.style.zIndex = '4';
        gsap.fromTo(nextCard,
          { autoAlpha: 0, scale: 0.94, y: 16 },
          { 
            autoAlpha: 1, 
            scale: 1, 
            y: 0, 
            duration: 0.38, 
            ease: 'power2.out',
            onComplete: () => {
              nextCard.style.zIndex = '';
            }
          }
        );
      }
    } else {
      previewCards.forEach(card => {
        const isMatch = card.getAttribute('data-preview') === serviceKey;
        card.classList.toggle('is-visible', isMatch);
      });
    }
  }

  serviceItems.forEach(item => {
    const serviceKey = item.getAttribute('data-service');

    // Activate on hover
    item.addEventListener('mouseenter', () => {
      activateService(serviceKey);
    });

    // Activate on click
    item.addEventListener('click', () => {
      activateService(serviceKey);
    });

    // Keyboard accessibility
    item.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        activateService(serviceKey);
      }
    });
  });
}
