/**
 * RITIVERSE — PROJECTS PAGE DEDICATED LOGIC
 * High-performance portfolio filtering, real-time search & interactive case study modal
 */

document.addEventListener('DOMContentLoaded', () => {
  const filterBtns = document.querySelectorAll('.project-filter-btn');
  const cards = document.querySelectorAll('.case-study-card');
  const searchInput = document.getElementById('projectSearch');
  const searchClearBtn = document.getElementById('projectSearchClear');
  const emptyState = document.getElementById('projectsEmptyState');
  const resetFiltersBtn = document.getElementById('resetFiltersBtn');

  // Modal elements
  const modalBackdrop = document.getElementById('projectModalBackdrop');
  const modalCloseBtn = document.getElementById('projectModalClose');
  const modalImg = document.getElementById('modalImg');
  const modalTag = document.getElementById('modalTag');
  const modalCategory = document.getElementById('modalCategory');
  const modalTitle = document.getElementById('modalTitle');
  const modalClient = document.getElementById('modalClient');
  const modalDesc = document.getElementById('modalDesc');
  const modalMetrics = document.getElementById('modalMetrics');
  const modalTechList = document.getElementById('modalTechList');
  const modalLiveBtn = document.getElementById('modalLiveBtn');
  const modalConsultBtn = document.getElementById('modalConsultBtn');

  if (!cards.length) return;

  // 1. Calculate and update badge counts on category buttons
  function updateCategoryCounts() {
    filterBtns.forEach(btn => {
      const filter = btn.dataset.filter || 'all';
      let count = 0;

      cards.forEach(card => {
        const categories = (card.dataset.category || '').toLowerCase();
        if (filter === 'all') {
          count++;
        } else if (filter === 'crm-erp') {
          if (categories.includes('crm') || categories.includes('erp')) count++;
        } else {
          if (categories.includes(filter)) count++;
        }
      });

      const countSpan = btn.querySelector('.filter-count');
      if (countSpan) {
        countSpan.textContent = count;
      }
    });
  }
  updateCategoryCounts();

  // 2. Main Filtering Engine (Combines Category Filter + Search Query)
  let activeFilter = 'all';
  let searchQuery = '';

  function applyFilters() {
    let visibleCount = 0;

    cards.forEach(card => {
      const categories = (card.dataset.category || '').toLowerCase();
      const searchableText = (card.dataset.search || '').toLowerCase();

      // Category match
      let matchesCategory = false;
      if (activeFilter === 'all') {
        matchesCategory = true;
      } else if (activeFilter === 'crm-erp') {
        matchesCategory = categories.includes('crm') || categories.includes('erp');
      } else {
        matchesCategory = categories.includes(activeFilter);
      }

      // Search match
      const matchesSearch = !searchQuery || searchableText.includes(searchQuery);

      if (matchesCategory && matchesSearch) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Handle Empty State
    if (emptyState) {
      if (visibleCount === 0) {
        emptyState.style.display = 'block';
      } else {
        emptyState.style.display = 'none';
      }
    }
  }

  // 3. Category Filter Click Handlers
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeFilter = btn.dataset.filter || 'all';
      applyFilters();
    });
  });

  // 4. Search Input Handler
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      searchQuery = e.target.value.toLowerCase().trim();
      if (searchClearBtn) {
        searchClearBtn.style.display = searchQuery ? 'block' : 'none';
      }
      applyFilters();
    });

    if (searchClearBtn) {
      searchClearBtn.addEventListener('click', () => {
        searchInput.value = '';
        searchQuery = '';
        searchClearBtn.style.display = 'none';
        searchInput.focus();
        applyFilters();
      });
    }
  }

  // 5. Reset Filters Button
  if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener('click', () => {
      activeFilter = 'all';
      searchQuery = '';
      if (searchInput) {
        searchInput.value = '';
        if (searchClearBtn) searchClearBtn.style.display = 'none';
      }
      filterBtns.forEach(b => {
        if (b.dataset.filter === 'all') b.classList.add('active');
        else b.classList.remove('active');
      });
      applyFilters();
    });
  }

  // 6. Interactive Quick View Modal
  function openProjectModal(card) {
    if (!modalBackdrop) return;

    const title = card.dataset.title || '';
    const client = card.dataset.client || '';
    const tag = card.dataset.tag || 'Production Architecture';
    const category = card.dataset.category || '';
    const imgUrl = card.dataset.image || '';
    const desc = card.dataset.desc || '';
    const liveUrl = card.dataset.live || '';
    const m1Val = card.dataset.m1Val || '';
    const m1Lbl = card.dataset.m1Lbl || '';
    const m2Val = card.dataset.m2Val || '';
    const m2Lbl = card.dataset.m2Lbl || '';
    const m3Val = card.dataset.m3Val || '';
    const m3Lbl = card.dataset.m3Lbl || '';
    const techTags = (card.dataset.tech || '').split(',').map(t => t.trim()).filter(Boolean);

    // Populate Fields
    if (modalTitle) modalTitle.textContent = title;
    if (modalClient) {
      modalClient.textContent = client ? `Client: ${client}` : '';
      modalClient.style.display = client ? 'block' : 'none';
    }
    if (modalTag) modalTag.textContent = tag;
    if (modalCategory) modalCategory.textContent = category.toUpperCase();
    if (modalDesc) modalDesc.textContent = desc;

    if (modalImg) {
      modalImg.src = imgUrl || 'assets/card_web_apps.jpg';
      modalImg.alt = title;
    }

    // Populate Metrics
    if (modalMetrics) {
      let metricsHtml = '';
      if (m1Val) {
        metricsHtml += `<div class="case-metric-box"><span class="case-metric-val" style="font-size:17px;">${escapeHtml(m1Val)}</span><span class="case-metric-lbl">${escapeHtml(m1Lbl)}</span></div>`;
      }
      if (m2Val) {
        metricsHtml += `<div class="case-metric-box"><span class="case-metric-val" style="font-size:17px;">${escapeHtml(m2Val)}</span><span class="case-metric-lbl">${escapeHtml(m2Lbl)}</span></div>`;
      }
      if (m3Val) {
        metricsHtml += `<div class="case-metric-box"><span class="case-metric-val" style="font-size:17px;">${escapeHtml(m3Val)}</span><span class="case-metric-lbl">${escapeHtml(m3Lbl)}</span></div>`;
      }
      modalMetrics.innerHTML = metricsHtml;
      modalMetrics.style.display = metricsHtml ? 'grid' : 'none';
    }

    // Populate Tech Stack
    if (modalTechList) {
      modalTechList.innerHTML = techTags.map(t => `<span class="case-tech-pill">${escapeHtml(t)}</span>`).join('');
    }

    // Live URL Button
    if (modalLiveBtn) {
      if (liveUrl && liveUrl !== '#' && liveUrl !== '') {
        modalLiveBtn.href = liveUrl;
        modalLiveBtn.style.display = 'inline-flex';
      } else {
        modalLiveBtn.style.display = 'none';
      }
    }

    // Consultation Pre-fill CTA
    if (modalConsultBtn) {
      modalConsultBtn.href = `contact.php?scope=${encodeURIComponent(category.split(' ')[0])}&project=${encodeURIComponent(title)}`;
    }

    // Open Modal
    modalBackdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeProjectModal() {
    if (!modalBackdrop) return;
    modalBackdrop.classList.remove('active');
    document.body.style.overflow = '';
  }

  // Attach modal trigger to buttons inside cards
  document.querySelectorAll('.open-case-modal-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const card = btn.closest('.case-study-card');
      if (card) openProjectModal(card);
    });
  });

  if (modalCloseBtn) {
    modalCloseBtn.addEventListener('click', closeProjectModal);
  }

  if (modalBackdrop) {
    modalBackdrop.addEventListener('click', (e) => {
      if (e.target === modalBackdrop) {
        closeProjectModal();
      }
    });
  }

  // Close on Escape Key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modalBackdrop && modalBackdrop.classList.contains('active')) {
      closeProjectModal();
    }
  });

  function escapeHtml(str) {
    return (str || '').replace(/[&<>"']/g, function(m) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
    });
  }
});
