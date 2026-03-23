/* ============================================================
   search.js — UrbanPulse
   Philstar-style drop bar: measures header height dynamically
   No layout shift on the nav buttons
   search.html?q=query for full results page
============================================================ */
(() => {
  'use strict';

  /* ── Article data ── */
  const ARTICLES = [
    { title:'Home Page',         url:'home.html',          cat:'',              kw:'home landing overview breaking news',                         desc:'The UrbanPulse homepage with top stories and breaking news.' },
    { title:'Technology',        url:'technology.html',    cat:'technology',    kw:'tech AI robots gadgets innovation cybersecurity hardware',     desc:'Latest technology news and insights.' },
    { title:'Sports',            url:'sports.html',        cat:'sports',        kw:'sports football basketball tennis MLB NFL NBA olympics',       desc:'Catch up on the latest sports news and match results.' },
    { title:'Entertainment',     url:'entertainment.html', cat:'entertainment', kw:'movies music celebrities streaming vinyl cinema awards',       desc:'Entertainment news, reviews, and pop culture updates.' },
    { title:'World News',        url:'worldnews.html',     cat:'worldnews',     kw:'global politics international headlines climate mars',         desc:'Breaking news and stories from around the world.' },
    { title:'About Us',          url:'about.html',         cat:'',              kw:'company team mission UMak UrbanPulse journalism',             desc:'Learn more about the UrbanPulse team and mission.' },
    { title:'Contact',           url:'contact.html',       cat:'',              kw:'email phone support feedback',                                desc:'Get in touch with the UrbanPulse team.' },
    /* Technology */
    { title:'AI & Robotics: The Agentic Revolution',                url:'technology.html', cat:'technology',    kw:'AI agentic autonomous agents workflow enterprise Aris Thorne',           desc:'AI shifts from chatbots to autonomous agents capable of executing complex workflows.' },
    { title:'GPT-6 Beta: Near-Human Emotional Reasoning',           url:'technology.html', cat:'technology',    kw:'GPT-6 OpenAI emotional intelligence reasoning Julian Vane',               desc:'Early testers document sophisticated emotional intelligence from GPT-6.' },
    { title:'Humanoid Robots Join Global Manufacturing Lines',       url:'technology.html', cat:'technology',    kw:'humanoid robots automotive bipedal assembly Sarah Jenkins',               desc:'Bipedal robots outperform specialized machinery in adaptability and safety.' },
    { title:'Meta Shuts Down Messenger Desktop Website',             url:'technology.html', cat:'technology',    kw:'Meta Messenger.com desktop April 2026 Facebook Sharona Nicole Semilla',  desc:'Meta pulls the plug on Messenger.com, redirecting users to Facebook.' },
    { title:'SpaceX Starship 5: First Orbital Fuel Transfer',        url:'technology.html', cat:'technology',    kw:'SpaceX Starship orbital fuel cryogenic Artemis lunar David Sutherland',   desc:'Cryogenic fuel transfer between two Starship vehicles in low Earth orbit.' },
    { title:'Rise of 6G and Terahertz Communication',                url:'technology.html', cat:'technology',    kw:'6G terahertz standard telecom terabit Kenji Sato',                        desc:'Global telecoms finalized initial 6G standards targeting 1 terabit per second.' },
    { title:'Quantum Materials: True 1D Electron Behavior',          url:'technology.html', cat:'technology',    kw:'quantum materials electrons superconductors crystals Elena Costas',       desc:'Breakthrough expected to revolutionize zero-resistance superconductors.' },
    { title:'Australia Launches Secure Sovereign AI Factory',        url:'technology.html', cat:'technology',    kw:'Australia NVIDIA Cisco sovereign AI data center Sydney Marcus Thompson',   desc:'High-security AI data center processes sensitive government data locally.' },
    { title:'Infinix NOTE 60: Revolutionary Battery Tech',           url:'technology.html', cat:'technology',    kw:'Infinix NOTE 60 solid-state battery smartphone Sam Chen',                  desc:'Solid-state battery hybrid allows a week of usage on a single charge.' },
    /* Sports */
    { title:'Eagles Triumph in Super Bowl LIX',                      url:'sports.html',     cat:'sports',        kw:'Eagles Super Bowl Chiefs New Orleans Jalen Hurts three-peat Marcus Thompson', desc:'Eagles defeat the Chiefs 40-22, denying them a historic three-peat.' },
    { title:'OKC Thunder Win First NBA Title in 46 Years',           url:'sports.html',     cat:'sports',        kw:'Thunder NBA Finals Pacers Shai Gilgeous-Alexander MVP Sarah Jenkins',          desc:'Thunder defeat the Pacers 103-91 in Game 7 — first title since 1979.' },
    { title:'PSG Claims Maiden Champions League Trophy',             url:'sports.html',     cat:'sports',        kw:'PSG Champions League Inter Milan Munich Luis Enrique Desire Doue James Pratt',  desc:'PSG dismantled Inter Milan 5-0 in the UEFA Champions League Final.' },
    { title:'Sinner and Świątek Rule Wimbledon 2025',                url:'sports.html',     cat:'sports',        kw:'Wimbledon Sinner Swiatek Alcaraz tennis Centre Court Elena Costas',             desc:'Sinner defeats Alcaraz in four sets; Świątek delivers a double-bagel final.' },
    { title:'Dodgers Repeat as World Series Champions',              url:'sports.html',     cat:'sports',        kw:'Dodgers World Series Blue Jays Rojas Will Smith Yamamoto David Sutherland',    desc:'Dodgers win back-to-back titles in an 11-inning Game 7 thriller.' },
    /* Entertainment */
    { title:"Renaissance of Cinema: 2026's Boldest Directors",       url:'entertainment.html', cat:'entertainment', kw:'cinema 70mm AI narratives festival fourth wall Elena Thorne',                 desc:'From AI narratives to 70mm film, the big screen is more alive than ever.' },
    { title:"AI Rapper 'AERO' Hits No.1 on Global Charts",           url:'entertainment.html', cat:'entertainment', kw:'AI rapper AERO charts streaming music authenticity Binary B',                  desc:'AI-generated artist AERO tops global streaming charts for a second week.' },
    { title:'Vinyl Outsells Digital Downloads Third Year Running',    url:'entertainment.html', cat:'entertainment', kw:'vinyl records digital downloads music independent record stores Liam West',    desc:'Physical vinyl records have outsold digital downloads for three years.' },
    { title:'Interactive Theatre Reimagines Shakespeare',             url:'entertainment.html', cat:'entertainment', kw:'interactive theatre Shakespeare immersive stage W. Shake',                     desc:'New interactive productions reimagine Shakespeare for modern audiences.' },
    { title:'UrbanStream+ Announces 12 New Original Series',         url:'entertainment.html', cat:'entertainment', kw:'UrbanStream+ streaming original series exclusive D. Vane',                     desc:'The streaming platform announces 12 new originals for subscribers.' },
    /* World News */
    { title:'Global Summit: Plastic-Free Oceans by 2040',            url:'worldnews.html',  cat:'worldnews',     kw:'Blue Horizon Geneva plastic oceans G20 coral reefs Julian Vane',               desc:'World leaders ratified the Blue Horizon accord mandating 90% plastic reduction.' },
    { title:'Sub-Orbital Satellites Bring Internet to the World',    url:'worldnews.html',  cat:'worldnews',     kw:'satellite internet Sahara Amazon remote connectivity Elena Rodriguez',           desc:'High-speed connectivity reaches the world\'s most remote regions.' },
    { title:'ASEAN Digital Currency Framework Signed',               url:'worldnews.html',  cat:'worldnews',     kw:'ASEAN digital currency Southeast Asia trade pact Aris Thorne',                  desc:'Ten Southeast Asian nations introduce a unified digital currency framework.' },
    { title:'Mars Base Alpha: First Successful Greenhouse Harvest',  url:'worldnews.html',  cat:'worldnews',     kw:'Mars greenhouse microgreens Martian gravity colony Sarah Jenkins',               desc:'Scientists harvested the first self-sustaining microgreens on Mars.' },
    { title:"Brussels Proposes EU 'Right to Disconnect' Law",        url:'worldnews.html',  cat:'worldnews',     kw:'Brussels EU workers disconnect burnout emails Marcus Thompson',                  desc:'New legislation seeks to ban professional digital comms after 6PM.' },
    { title:'Amazon Reforestation at Five-Year High in Brazil',      url:'worldnews.html',  cat:'worldnews',     kw:'Amazon reforestation Brazil satellite carbon credits David Sutherland',          desc:'Reforestation in the Brazilian Amazon hits highest rate since 2021.' },
  ];

  const CAT_COLORS = { technology:'#0066cc', sports:'#ff6b35', entertainment:'#9b59b6', worldnews:'#27ae60' };
  const CAT_LABELS = { technology:'Tech', sports:'Sports', entertainment:'Ent.', worldnews:'World' };

  function hl(text, q) {
    if (!q) return text;
    const esc = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    return text.replace(new RegExp(`(${esc})`, 'gi'),
      '<mark style="background:rgba(200,16,46,0.13);color:#c8102e;font-weight:800;border-radius:2px;padding:0 1px">$1</mark>');
  }
  function catBadge(cat) {
    if (!cat || !CAT_COLORS[cat]) return '';
    return `<span style="background:${CAT_COLORS[cat]};color:#fff;font-size:0.62rem;font-weight:800;letter-spacing:.8px;text-transform:uppercase;padding:.18rem .5rem;border-radius:999px;flex-shrink:0">${CAT_LABELS[cat]}</span>`;
  }
  function searchURL(q) { return `search.html?q=${encodeURIComponent(q.trim())}`; }

  /* ── Fetch approved DB articles and merge into search index ── */
  (async () => {
    try {
      const res = await fetch('api-search.php');
      if (!res.ok) return;
      const data = await res.json();
      if (data.success && Array.isArray(data.articles) && data.articles.length) {
        ARTICLES.push(...data.articles);
      }
    } catch (e) { /* silently fail — static articles still work */ }
  })();

  /* ── DOM ── */
  const header   = document.querySelector('.header-main');
  const toggle   = document.getElementById('searchToggle');
  const drop     = document.getElementById('searchBarDrop');
  const box      = document.getElementById('searchBox');
  const closeBtn = document.getElementById('searchClose');
  const resultsEl= document.getElementById('results');

  if (!toggle || !drop || !box) return;

  /* ── Measure TOTAL sticky height (Breaking News + Header) dynamically ── */
  function setHeaderHeight() {
    const breakingNews = document.querySelector('.BreakingNews');
    const headerMain   = document.querySelector('.header-main');
    const bnH  = breakingNews ? breakingNews.getBoundingClientRect().height : 0;
    const navH = headerMain   ? headerMain.getBoundingClientRect().height   : 70;
    // Only count Breaking News height if it's still visible in viewport (not scrolled past)
    const bnRect = breakingNews ? breakingNews.getBoundingClientRect() : null;
    const bnVisible = bnRect && bnRect.bottom > 0 ? bnRect.bottom : 0;
    const totalH = bnVisible + navH;
    document.documentElement.style.setProperty('--header-h', totalH + 'px');
    drop.style.top = totalH + 'px';
  }
  setHeaderHeight();
  window.addEventListener('resize', setHeaderHeight);
  window.addEventListener('scroll', setHeaderHeight, { passive: true });

  /* ── Overlay ── */
  const overlay = document.createElement('div');
  overlay.className = 'search-overlay';
  document.body.appendChild(overlay);

  /* ── Open / Close ── */
  let isOpen = false;
  function openSearch() {
    setHeaderHeight();
    isOpen = true;
    drop.classList.add('is-open');
    overlay.classList.add('is-open');
    toggle.setAttribute('aria-expanded', 'true');
    drop.setAttribute('aria-hidden', 'false');
    /* Force styles via JS — guaranteed to override Bootstrap at runtime */

    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        box.focus();
        // select all text in contenteditable
        const range = document.createRange(); range.selectNodeContents(box); const sel = window.getSelection(); sel.removeAllRanges(); sel.addRange(range);

      });
    });
  }
  function closeSearch() {
    isOpen = false;
    drop.classList.remove('is-open');
    overlay.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
    drop.setAttribute('aria-hidden', 'true');
    box.textContent = '';
    if (resultsEl) resultsEl.innerHTML = '';
    focusIdx = -1;
  }

  toggle.addEventListener('click', e => {
    e.stopPropagation();
    isOpen ? closeSearch() : openSearch();
  });
  if (closeBtn) closeBtn.addEventListener('click', closeSearch);
  overlay.addEventListener('click', closeSearch);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearch(); });

  /* ── Keyboard nav ── */
  let focusIdx = -1;
  function getItems() { return [...(resultsEl?.querySelectorAll('.sbr-item') || [])]; }
  function moveFocus(d) {
    const its = getItems(); if (!its.length) return;
    focusIdx = Math.max(0, Math.min(its.length - 1, focusIdx + d));
    its.forEach((el, i) => el.classList.toggle('sbr-focused', i === focusIdx));
    its[focusIdx]?.scrollIntoView({ block: 'nearest' });
  }

  box.addEventListener('keydown', e => {
    if (e.key === 'ArrowDown') { e.preventDefault(); moveFocus(1); }
    if (e.key === 'ArrowUp')   { e.preventDefault(); moveFocus(-1); }
    if (e.key === 'Enter') {
      e.preventDefault();
      const focused = resultsEl?.querySelector('.sbr-focused');
      if (focused) { window.location.href = focused.href; return; }
      const q = (box.textContent || box.innerText || '').trim();
      if (q) window.location.href = searchURL(q);
    }
  });

  /* ── Live search ── */
  let timer;
  /* Force color on every keyup too — belt AND suspenders */
  box.addEventListener('keyup', function () {
    this.scrollLeft = this.scrollWidth;
  });

  box.addEventListener('input', function () {
    /* Scroll to end AFTER browser processes the keystroke */
    const el = this;
    setTimeout(() => { el.scrollLeft = el.scrollWidth; }, 0);

    focusIdx = -1; clearTimeout(timer);
    const q = (this.textContent || this.innerText || '').trim().toLowerCase();
    if (!q) { if (resultsEl) resultsEl.innerHTML = ''; return; }
    timer = setTimeout(() => {
      const hits = ARTICLES.filter(a =>
        a.title.toLowerCase().includes(q) ||
        a.kw.toLowerCase().includes(q) ||
        a.desc.toLowerCase().includes(q)
      ).slice(0, 6);

      if (!resultsEl) return;

      if (!hits.length) {
        resultsEl.innerHTML = `<div class="sbr-empty">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          No results for <strong>${q}</strong> — try different keywords.
        </div>`;
        return;
      }

      resultsEl.innerHTML =
        `<div class="sbr-header">Quick Results <a href="${searchURL(q)}">View all →</a></div>` +
        hits.map(r => `
          <a class="sbr-item" href="${r.url}">
            ${catBadge(r.cat)}
            <div class="sbr-text">
              <div class="sbr-title">${hl(r.title, q)}</div>
              <div class="sbr-desc">${hl(r.desc, q)}</div>
            </div>
            <svg class="sbr-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
          </a>`).join('') +
        `<a class="sbr-viewall" href="${searchURL(q)}">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          See all results for "<strong>${(this.textContent||this.innerText||'').trim()}</strong>"
        </a>`;
    }, 120);
  });

  /* ── Export for search.html ── */
  window.UP_SEARCH_DATA = ARTICLES;
  window.UP_SEARCH_HL   = hl;
  window.UP_CAT_COLORS  = CAT_COLORS;
  window.UP_CAT_LABELS  = { technology:'Technology', sports:'Sports', entertainment:'Entertainment', worldnews:'World News' };
})();