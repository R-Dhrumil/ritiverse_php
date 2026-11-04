/**
 * RITIVERSE — PROJECTS PAGE DEDICATED LOGIC
 * High-performance portfolio filtering, real-time search, interactive view switcher & case study modal
 */

document.addEventListener('DOMContentLoaded', () => {
  const filterBtns = document.querySelectorAll('.project-filter-btn');
  const techChips = document.querySelectorAll('.tech-filter-chip');
  const gridCards = document.querySelectorAll('.case-study-card');
  const listRows = document.querySelectorAll('.project-list-row');
  const searchInput = document.getElementById('projectSearch');
  const searchClearBtn = document.getElementById('projectSearchClear');
  const emptyState = document.getElementById('projectsEmptyState');
  const resetFiltersBtn = document.getElementById('resetFiltersBtn');

  // View toggle buttons & views
  const viewGridBtn = document.getElementById('viewGridBtn');
  const viewListBtn = document.getElementById('viewListBtn');
  const projectsGrid = document.getElementById('projectsGrid');
  const projectsListView = document.getElementById('projectsListView');

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
  const modalCaseStudyBtn = document.getElementById('modalCaseStudyBtn');

  if (!gridCards.length && !listRows.length) return;

  // 1. View Switcher Logic (Grid View vs List View)
  let currentView = localStorage.getItem('ritiverse_projects_view') || 'grid';

  function setViewMode(mode) {
    currentView = mode;
    localStorage.setItem('ritiverse_projects_view', mode);

    if (mode === 'list') {
      if (projectsGrid) projectsGrid.style.display = 'none';
      if (projectsListView) projectsListView.style.display = 'block';
      if (viewGridBtn) {
        viewGridBtn.classList.remove('active');
        viewGridBtn.setAttribute('aria-pressed', 'false');
      }
      if (viewListBtn) {
        viewListBtn.classList.add('active');
        viewListBtn.setAttribute('aria-pressed', 'true');
      }
    } else {
      if (projectsGrid) projectsGrid.style.display = 'grid';
      if (projectsListView) projectsListView.style.display = 'none';
      if (viewGridBtn) {
        viewGridBtn.classList.add('active');
        viewGridBtn.setAttribute('aria-pressed', 'true');
      }
      if (viewListBtn) {
        viewListBtn.classList.remove('active');
        viewListBtn.setAttribute('aria-pressed', 'false');
      }
    }
  }

  if (viewGridBtn) {
    viewGridBtn.addEventListener('click', () => setViewMode('grid'));
  }
  if (viewListBtn) {
    viewListBtn.addEventListener('click', () => setViewMode('list'));
  }

  // Initialize view mode
  setViewMode(currentView);

  // 2. Calculate and update badge counts on category buttons
  function updateCategoryCounts() {
    filterBtns.forEach(btn => {
      const filter = btn.dataset.filter || 'all';
      let count = 0;

      gridCards.forEach(card => {
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

  // 3. Multi-Dimensional Filtering Engine (Category + Tech Chip + Live Search)
  let activeCategory = 'all';
  let activeTech = 'all';
  let searchQuery = '';

  function matchesItem(element) {
    const categories = (element.dataset.category || '').toLowerCase();
    const techTags = (element.dataset.tech || '').toLowerCase();
    const searchableText = (element.dataset.search || '').toLowerCase();

    // Category match
    let matchesCategory = false;
    if (activeCategory === 'all') {
      matchesCategory = true;
    } else if (activeCategory === 'crm-erp') {
      matchesCategory = categories.includes('crm') || categories.includes('erp');
    } else {
      matchesCategory = categories.includes(activeCategory);
    }

    // Tech match
    let matchesTech = false;
    if (activeTech === 'all') {
      matchesTech = true;
    } else {
      matchesTech = techTags.includes(activeTech);
    }

    // Search match
    const matchesSearch = !searchQuery || searchableText.includes(searchQuery);

    return matchesCategory && matchesTech && matchesSearch;
  }

  function applyFilters() {
    let visibleCount = 0;

    // Filter Grid Cards
    gridCards.forEach(card => {
      if (matchesItem(card)) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Filter List Rows
    listRows.forEach(row => {
      if (matchesItem(row)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });

    // Handle Empty State
    if (emptyState) {
      if (visibleCount === 0) {
        emptyState.style.display = 'block';
        if (projectsListView) projectsListView.style.display = 'none';
      } else {
        emptyState.style.display = 'none';
        if (currentView === 'list' && projectsListView) {
          projectsListView.style.display = 'block';
        }
      }
    }
  }

  // 4. Category Filter Buttons
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeCategory = btn.dataset.filter || 'all';
      applyFilters();
    });
  });

  // 5. Tech Filter Chips
  techChips.forEach(chip => {
    chip.addEventListener('click', () => {
      techChips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      activeTech = (chip.dataset.tech || 'all').toLowerCase();
      applyFilters();
    });
  });

  // 6. Search Input Handler
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

  // 7. Reset Filters Button
  if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener('click', () => {
      activeCategory = 'all';
      activeTech = 'all';
      searchQuery = '';
      if (searchInput) {
        searchInput.value = '';
        if (searchClearBtn) searchClearBtn.style.display = 'none';
      }
      filterBtns.forEach(b => {
        if (b.dataset.filter === 'all') b.classList.add('active');
        else b.classList.remove('active');
      });
      techChips.forEach(c => {
        if (c.dataset.tech === 'all') c.classList.add('active');
        else c.classList.remove('active');
      });
      applyFilters();
    });
  }

  // 8. Interactive Quick View Modal
  function openProjectModal(item) {
    if (!modalBackdrop) return;

    const title = item.dataset.title || '';
    const client = item.dataset.client || '';
    const industry = item.dataset.industry || '';
    const tag = item.dataset.tag || 'Production Architecture';
    const category = item.dataset.category || '';
    const imgUrl = item.dataset.image || '';
    const desc = item.dataset.desc || '';
    const liveUrl = item.dataset.live || '';
    const caseUrl = item.dataset.caseUrl || '#';
    const m1Val = item.dataset.m1Val || '';
    const m1Lbl = item.dataset.m1Lbl || '';
    const m2Val = item.dataset.m2Val || '';
    const m2Lbl = item.dataset.m2Lbl || '';
    const m3Val = item.dataset.m3Val || '';
    const m3Lbl = item.dataset.m3Lbl || '';
    const techTags = (item.dataset.tech || '').split(',').map(t => t.trim()).filter(Boolean);

    // Populate Fields
    if (modalTitle) modalTitle.textContent = title;
    if (modalClient) {
      const clientText = client ? `Client: ${client}${industry ? ' (' + industry + ')' : ''}` : '';
      modalClient.textContent = clientText;
      modalClient.style.display = clientText ? 'block' : 'none';
    }
    if (modalTag) modalTag.textContent = tag;
    if (modalCategory) modalCategory.textContent = category.toUpperCase();
    if (modalDesc) modalDesc.textContent = desc;

    if (modalImg) {
      modalImg.src = imgUrl || 'assets/card_web_apps.webp';
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

    // Dedicated Case Study Deep-Dive Button in Modal
    if (modalCaseStudyBtn) {
      modalCaseStudyBtn.href = caseUrl;
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

  // Attach modal trigger to buttons in cards or table rows
  document.querySelectorAll('.open-case-modal-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      e.preventDefault();
      const parentItem = btn.closest('.case-study-card') || btn.closest('.project-list-row');
      if (parentItem) {
        openProjectModal(parentItem);
      } else {
        const modalId = btn.dataset.modalId;
        if (modalId) {
          const card = document.querySelector(`.case-study-card[data-id="${modalId}"]`);
          if (card) openProjectModal(card);
        }
      }
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