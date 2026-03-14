/* ============================================================
   filter.js — UrbanPulse  |  Category & Date Filter
   Pill-style UI with animated card transitions
   ============================================================ */

(() => {
  'use strict';

  /* ── State ── */
  let activeCategory = 'all';
  let activeDate     = 'all';

  /* ── DOM refs ── */
  const categorySelect = document.getElementById('categoryFilter');
  const dateSelect     = document.getElementById('dateFilter');

  if (!categorySelect || !dateSelect) return;

  /* ── Date helpers ── */
  function getDateBounds() {
    const now          = new Date();
    const startOfToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const startOfWeek  = new Date(startOfToday);
    startOfWeek.setDate(startOfToday.getDate() - startOfToday.getDay());
    const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
    return { startOfToday, startOfWeek, startOfMonth };
  }

  /* ── Core filter ── */
  function runFilter() {
    const bounds   = getDateBounds();
    const articles = document.querySelectorAll(
      '.story-card, .category-card, .compact-story, .more-card, .hero-story'
    );

    let visibleCount = 0;

    articles.forEach(article => {
      const cat      = article.dataset.category || '';
      const dateStr  = article.dataset.date || '';
      const artDate  = dateStr ? new Date(dateStr) : null;
      let   show     = true;

      /* Category gate */
      if (activeCategory !== 'all' && cat !== activeCategory) show = false;

      /* Date gate */
      if (show && activeDate !== 'all' && artDate) {
        if (activeDate === 'today' &&
            artDate < bounds.startOfToday) show = false;
        if (activeDate === 'this-week' &&
            artDate < bounds.startOfWeek) show = false;
        if (activeDate === 'this-month' &&
            artDate < bounds.startOfMonth) show = false;
      }

      /* Animate in / out */
      if (show) {
        article.style.display = '';
        article.classList.remove('filter-hidden');
        article.classList.add('filter-visible');
        visibleCount++;
      } else {
        article.classList.add('filter-hidden');
        article.classList.remove('filter-visible');
        /* Remove from flow after fade */
        setTimeout(() => {
          if (article.classList.contains('filter-hidden'))
            article.style.display = 'none';
        }, 250);
      }
    });

    /* Hide empty parent sections */
    document.querySelectorAll('.category-section, .more-stories, .latest-section').forEach(sec => {
      const hasVisible = Array.from(
        sec.querySelectorAll('.category-card, .more-card, .compact-story')
      ).some(el => el.style.display !== 'none' && !el.classList.contains('filter-hidden'));

      sec.style.opacity  = hasVisible ? '' : '0';
      sec.style.display  = hasVisible ? '' : 'none';
    });

    /* Toast if nothing matches */
    showFilterToast(visibleCount);
  }

  /* ── Toast feedback ── */
  let toastTimer;
  function showFilterToast(count) {
    let toast = document.getElementById('filterToast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'filterToast';
      document.body.appendChild(toast);
    }

    clearTimeout(toastTimer);

    if (activeCategory === 'all' && activeDate === 'all') {
      toast.classList.remove('ft-show');
      return;
    }

    const catLabel  = categorySelect.options[categorySelect.selectedIndex].text;
    const dateLabel = dateSelect.options[dateSelect.selectedIndex].text;
    const parts     = [];
    if (activeCategory !== 'all') parts.push(`<strong>${catLabel}</strong>`);
    if (activeDate !== 'all')     parts.push(`<strong>${dateLabel}</strong>`);

    toast.innerHTML = count > 0
      ? `${count} article${count !== 1 ? 's' : ''} — ${parts.join(' · ')}`
      : `No articles match ${parts.join(' + ')}`;

    toast.classList.toggle('ft-empty', count === 0);
    toast.classList.add('ft-show');

    toastTimer = setTimeout(() => toast.classList.remove('ft-show'), 3500);
  }

  /* ── Active indicator on selects ── */
  function updateSelectState(el, value) {
    el.classList.toggle('filter-active', value !== 'all');
  }

  /* ── Events ── */
  categorySelect.addEventListener('change', function () {
    activeCategory = this.value;
    updateSelectState(this, activeCategory);
    runFilter();
  });

  dateSelect.addEventListener('change', function () {
    activeDate = this.value;
    updateSelectState(this, activeDate);
    runFilter();
  });

  /* ── CSS injected by JS for filter animations ── */
  const style = document.createElement('style');
  style.textContent = `
    /* Card transition */
    .story-card, .category-card, .compact-story, .more-card {
      transition: opacity 0.25s ease, transform 0.25s ease;
    }
    .filter-hidden  { opacity: 0 !important; transform: scale(0.97) !important; pointer-events: none; }
    .filter-visible { opacity: 1; transform: scale(1); }

    /* Active select highlight */
    .filter-inner select.filter-active {
      border-color: var(--color-secondary) !important;
      background: #fff5f6 !important;
      color: var(--color-secondary) !important;
      font-weight: 700 !important;
    }

    /* Filter Toast */
    #filterToast {
      position: fixed;
      bottom: 1.5rem;
      left: 50%;
      transform: translateX(-50%) translateY(80px);
      background: var(--color-primary);
      color: #fff;
      padding: 0.65rem 1.25rem;
      border-radius: 999px;
      font-size: 0.82rem;
      font-family: var(--font-body, sans-serif);
      letter-spacing: 0.3px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.22);
      z-index: 9000;
      opacity: 0;
      transition: transform 0.35s cubic-bezier(0.16,1,0.3,1), opacity 0.3s ease;
      pointer-events: none;
      white-space: nowrap;
      border-left: 3px solid var(--color-secondary);
    }
    #filterToast.ft-show    { opacity: 1; transform: translateX(-50%) translateY(0); }
    #filterToast.ft-empty   { background: #7f1d1d; border-color: #fca5a5; }
    #filterToast strong     { color: var(--color-accent, #d4af37); }

    /* Filter bar upgrade */
    .filter-bar {
      position: sticky;
      top: var(--header-h, 70px);
      z-index: 90;
      background: rgba(255,255,255,0.96) !important;
      backdrop-filter: blur(8px);
      box-shadow: 0 1px 0 var(--color-border);
      transition: box-shadow 0.2s;
    }
    .filter-inner label {
      font-size: 0.75rem;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      font-weight: 700;
      color: var(--color-text-muted, #999);
    }
    .filter-inner select {
      transition: border-color 0.2s, color 0.2s, background 0.2s;
      font-weight: 600;
    }
  `;
  document.head.appendChild(style);

})();