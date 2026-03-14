/* ============================================================
   comments.js — UrbanPulse  |  Comment System
   LocalStorage persistence · Reactions · Avatar initials
   Real timestamps · Delete own comments · Animated entries
   ============================================================ */

(() => {
  'use strict';

  const STORAGE_KEY = 'up_comments_home';
  const MAX_CHARS   = 500;

  /* ── Load / Save ── */
  function loadComments() {
    try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; }
    catch { return []; }
  }
  function saveComments(list) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(list));
  }

  /* ── Time formatting ── */
  function timeAgo(ts) {
    const diff = Date.now() - ts;
    const m = Math.floor(diff / 60000);
    const h = Math.floor(diff / 3600000);
    const d = Math.floor(diff / 86400000);
    if (m < 1)  return 'Just now';
    if (m < 60) return `${m}m ago`;
    if (h < 24) return `${h}h ago`;
    if (d < 7)  return `${d}d ago`;
    return new Date(ts).toLocaleDateString('en-PH', { month: 'short', day: 'numeric' });
  }

  /* ── Avatar initials + colour ── */
  const AVATAR_COLORS = [
    '#c8102e','#d4af37','#0066cc','#27ae60','#9b59b6','#e67e22','#16a085'
  ];
  function getAvatarColor(name) {
    let hash = 0;
    for (const ch of name) hash = ch.charCodeAt(0) + ((hash << 5) - hash);
    return AVATAR_COLORS[Math.abs(hash) % AVATAR_COLORS.length];
  }
  function getInitials(name) {
    return name.trim().split(/\s+/).map(w => w[0]).join('').slice(0, 2).toUpperCase();
  }

  /* ── Reactions ── */
  const REACTIONS = [
    { emoji: '👍', label: 'Like' },
    { emoji: '❤️', label: 'Love' },
    { emoji: '🔥', label: 'Fire' },
    { emoji: '😮', label: 'Wow'  },
  ];
  function toggleReaction(comments, id, emoji) {
    const c = comments.find(c => c.id === id);
    if (!c) return;
    c.reactions = c.reactions || {};
    c.reactions[emoji] = (c.reactions[emoji] || 0) + (c.reactions[emoji] ? -1 : 1);
    if (c.reactions[emoji] <= 0) delete c.reactions[emoji];
    saveComments(comments);
  }

  /* ── Build a single comment element ── */
  function buildComment(c, comments, isNew = false) {
    const li = document.createElement('li');
    li.className = 'up-comment' + (isNew ? ' up-comment--new' : '');
    li.dataset.id = c.id;

    const avatarColor = getAvatarColor(c.name);
    const initials    = getInitials(c.name);

    const reactionBtns = REACTIONS.map(r => {
      const count = (c.reactions || {})[r.emoji] || 0;
      return `<button class="uc-react-btn" data-emoji="${r.emoji}" title="${r.label}" aria-label="${r.label}">
        ${r.emoji}<span class="uc-react-count ${count ? 'has-count' : ''}">${count || ''}</span>
      </button>`;
    }).join('');

    li.innerHTML = `
      <div class="uc-avatar" style="background:${avatarColor}">${initials}</div>
      <div class="uc-body">
        <div class="uc-header">
          <span class="uc-name">${escapeHtml(c.name)}</span>
          <span class="uc-time" title="${new Date(c.ts).toLocaleString()}">${timeAgo(c.ts)}</span>
          <button class="uc-delete" aria-label="Delete comment" title="Delete your comment">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          </button>
        </div>
        <p class="uc-text">${escapeHtml(c.text).replace(/\n/g, '<br>')}</p>
        <div class="uc-reactions">${reactionBtns}</div>
      </div>
    `;

    /* Reaction events */
    li.querySelectorAll('.uc-react-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const emoji = btn.dataset.emoji;
        const fresh = loadComments();
        toggleReaction(fresh, c.id, emoji);
        const updated = fresh.find(x => x.id === c.id);
        const countEl = btn.querySelector('.uc-react-count');
        const newCount = updated ? ((updated.reactions || {})[emoji] || 0) : 0;
        countEl.textContent = newCount || '';
        countEl.classList.toggle('has-count', !!newCount);
        btn.classList.toggle('reacted', !!newCount);
        btn.animate([{transform:'scale(1)'},{transform:'scale(1.4)'},{transform:'scale(1)'}],
          { duration:300, easing:'cubic-bezier(0.16,1,0.3,1)' });
      });
    });

    /* Delete event */
    li.querySelector('.uc-delete').addEventListener('click', () => {
      if (!confirm('Delete your comment?')) return;
      li.classList.add('up-comment--removing');
      setTimeout(() => {
        const fresh = loadComments().filter(x => x.id !== c.id);
        saveComments(fresh);
        li.remove();
        updateCount();
      }, 300);
    });

    return li;
  }

  /* ── Escape HTML ── */
  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
              .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
  }

  /* ── Render all comments ── */
  function renderAll() {
    const container = document.getElementById('commentsContainer');
    if (!container) return;
    container.innerHTML = '';
    const list = loadComments();
    if (!list.length) {
      container.innerHTML = `<li class="uc-empty">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <span>No comments yet — be the first!</span>
      </li>`;
      return;
    }
    list.slice().reverse().forEach(c => container.appendChild(buildComment(c, list)));
    updateCount();
  }

  /* ── Count badge ── */
  function updateCount() {
    const badge = document.getElementById('commentCount');
    if (!badge) return;
    const n = loadComments().length;
    badge.textContent = n;
    badge.style.display = n ? '' : 'none';
  }

  /* ── Character counter ── */
  function updateCharCount(textarea, counter) {
    const left = MAX_CHARS - textarea.value.length;
    counter.textContent = `${left} characters remaining`;
    counter.classList.toggle('cc-warn', left < 50);
    counter.classList.toggle('cc-error', left < 0);
  }

  /* ── Upgrade the existing comment form ── */
  function upgradeForm() {
    const section = document.querySelector('.comment-section');
    const form    = document.getElementById('commentForm');
    if (!section || !form) return;

    /* Replace section heading */
    const h3 = section.querySelector('h3');
    if (h3) h3.innerHTML = `Leave a Comment <span id="commentCount" class="uc-count-badge" style="display:none">0</span>`;

    /* Upgrade username field */
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
      usernameInput.placeholder = 'Your name…';
      usernameInput.setAttribute('maxlength', '60');
      usernameInput.setAttribute('autocomplete', 'name');
    }

    /* Upgrade textarea */
    const textarea = document.getElementById('comment');
    if (textarea) {
      textarea.placeholder = 'Share your thoughts…';
      textarea.setAttribute('maxlength', MAX_CHARS);
      const counter = document.createElement('div');
      counter.className = 'uc-char-counter';
      counter.textContent = `${MAX_CHARS} characters remaining`;
      textarea.after(counter);
      textarea.addEventListener('input', () => updateCharCount(textarea, counter));
    }

    /* Upgrade submit button */
    const submitBtn = form.querySelector('[type="submit"]');
    if (submitBtn) {
      submitBtn.textContent = 'Post Comment';
      submitBtn.className   = 'uc-submit-btn';
    }

    /* Upgrade comment list */
    const listWrap = document.getElementById('commentList');
    if (listWrap) {
      const h4 = listWrap.querySelector('h4');
      if (h4) h4.remove();
    }

    const container = document.getElementById('commentsContainer');
    if (container) container.className = 'uc-list';

    /* Form submit handler */
    form.addEventListener('submit', e => {
      e.preventDefault();
      const name = usernameInput?.value.trim() || '';
      const text = textarea?.value.trim() || '';
      if (!name || !text || text.length > MAX_CHARS) return;

      const comment = {
        id:        'c_' + Date.now() + Math.random().toString(36).slice(2,6),
        name, text,
        ts:        Date.now(),
        reactions: {}
      };

      const list = loadComments();
      list.push(comment);
      saveComments(list);

      /* Prepend with animation */
      const li = buildComment(comment, list, true);
      const emptyEl = container?.querySelector('.uc-empty');
      if (emptyEl) emptyEl.remove();
      container?.prepend(li);
      requestAnimationFrame(() => li.classList.add('up-comment--entered'));

      form.reset();
      if (textarea) { textarea.dispatchEvent(new Event('input')); }
      updateCount();

      /* Scroll to new comment */
      li.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

      /* Flash submit button */
      if (submitBtn) {
        submitBtn.textContent = 'Posted! ✓';
        submitBtn.disabled = true;
        setTimeout(() => {
          submitBtn.textContent = 'Post Comment';
          submitBtn.disabled = false;
        }, 2000);
      }
    });
  }

  /* ── Inject CSS ── */
  const style = document.createElement('style');
  style.textContent = `
    /* Section */
    .comment-section { padding: 2.5rem 2rem; border-radius: 4px; }
    .comment-section h3 { display: flex; align-items: center; gap: 0.6rem; }

    /* Count badge */
    .uc-count-badge {
      display: inline-flex; align-items: center; justify-content: center;
      background: var(--color-secondary, #c8102e); color: #fff;
      font-size: 0.7rem; font-weight: 700; min-width: 20px; height: 20px;
      border-radius: 999px; padding: 0 5px;
    }

    /* Form */
    #commentForm { display: flex; flex-direction: column; gap: 0.85rem; }
    #commentForm .mb-3 { margin: 0 !important; }
    #commentForm .form-label {
      font-size: 0.72rem; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; color: var(--color-text-muted, #999);
      margin-bottom: 0.3rem; display: block;
    }
    #commentForm .form-control {
      border: 1.5px solid var(--color-border, #e0e0e0);
      border-radius: 8px; padding: 0.65rem 0.9rem;
      font-family: var(--font-body, sans-serif); font-size: 0.9rem;
      color: var(--color-text, #2d2d2d); transition: border-color 0.2s, box-shadow 0.2s;
    }
    #commentForm .form-control:focus {
      outline: none;
      border-color: var(--color-secondary, #c8102e);
      box-shadow: 0 0 0 3px rgba(200,16,46,0.1);
    }
    #commentForm textarea.form-control { resize: vertical; min-height: 100px; }

    /* Char counter */
    .uc-char-counter {
      font-size: 0.72rem; color: var(--color-text-muted, #999);
      text-align: right; margin-top: 0.3rem; transition: color 0.2s;
    }
    .uc-char-counter.cc-warn  { color: #d97706; }
    .uc-char-counter.cc-error { color: var(--color-secondary, #c8102e); font-weight: 700; }

    /* Submit button */
    .uc-submit-btn {
      align-self: flex-start;
      padding: 0.7rem 1.5rem;
      background: linear-gradient(90deg, var(--color-secondary, #c8102e), #a30c26);
      color: #fff; border: none; border-radius: 8px;
      font-family: var(--font-body, sans-serif); font-size: 0.875rem;
      font-weight: 700; letter-spacing: 0.5px; cursor: pointer;
      transition: transform 0.18s, filter 0.18s, box-shadow 0.18s;
    }
    .uc-submit-btn:hover { transform: translateY(-1px); filter: brightness(1.06); box-shadow: 0 6px 18px rgba(200,16,46,0.3); }
    .uc-submit-btn:active { transform: scale(0.98); }
    .uc-submit-btn:disabled { opacity: 0.75; cursor: default; transform: none; }

    /* Comment list */
    .uc-list { list-style: none; padding: 0; margin: 1.5rem 0 0; display: flex; flex-direction: column; gap: 0; }

    /* Empty state */
    .uc-empty {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 2rem 1rem; color: var(--color-text-muted, #999);
      font-size: 0.9rem; justify-content: center;
    }

    /* Single comment */
    .up-comment {
      display: grid; grid-template-columns: 38px 1fr; gap: 0.75rem;
      padding: 1.1rem 0; border-bottom: 1px solid var(--color-border, #e0e0e0);
      opacity: 0; transform: translateY(10px);
      transition: opacity 0.3s ease, transform 0.3s ease, background 0.2s;
    }
    .up-comment:first-child { padding-top: 0; }
    .up-comment:last-child  { border-bottom: none; }
    .up-comment--entered    { opacity: 1; transform: translateY(0); }
    .up-comment--new        { background: rgba(200,16,46,0.03); border-radius: 8px; padding: 1rem; }
    .up-comment--removing   { opacity: 0 !important; transform: scale(0.97) !important; }

    /* Avatar */
    .uc-avatar {
      width: 38px; height: 38px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 0.8rem; color: #fff;
      flex-shrink: 0; margin-top: 2px;
    }

    /* Comment body */
    .uc-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem; flex-wrap: wrap; }
    .uc-name   { font-weight: 700; font-size: 0.875rem; color: var(--color-primary, #1a1a1a); }
    .uc-time   { font-size: 0.75rem; color: var(--color-text-muted, #999); margin-left: auto; cursor: default; }
    .uc-text   { font-size: 0.9rem; line-height: 1.6; color: var(--color-text, #2d2d2d); margin: 0 0 0.5rem; }

    /* Delete button */
    .uc-delete {
      background: none; border: none; cursor: pointer; padding: 3px 5px;
      color: var(--color-text-muted, #ccc); border-radius: 5px;
      transition: color 0.18s, background 0.18s; margin-left: auto;
    }
    .uc-delete:hover { color: var(--color-secondary, #c8102e); background: rgba(200,16,46,0.08); }

    /* Reactions */
    .uc-reactions { display: flex; gap: 0.3rem; flex-wrap: wrap; }
    .uc-react-btn {
      display: inline-flex; align-items: center; gap: 0.25rem;
      padding: 0.2rem 0.5rem; border-radius: 999px;
      border: 1px solid var(--color-border, #e0e0e0);
      background: transparent; font-size: 0.78rem; cursor: pointer;
      color: var(--color-text-light, #666);
      transition: border-color 0.18s, background 0.18s, transform 0.18s;
    }
    .uc-react-btn:hover  { background: var(--color-surface, #f4f4f4); border-color: #ccc; }
    .uc-react-btn.reacted { border-color: var(--color-secondary, #c8102e); background: rgba(200,16,46,0.06); }
    .uc-react-count      { font-size: 0.72rem; font-weight: 700; color: var(--color-text-muted, #999); }
    .uc-react-count.has-count { color: var(--color-secondary, #c8102e); }

    /* Section divider between form and list */
    #commentList { border-top: 2px solid var(--color-border, #e0e0e0); margin-top: 2rem; padding-top: 1.5rem; }
  `;
  document.head.appendChild(style);

  /* ── Init ── */
  upgradeForm();
  renderAll();

  /* Animate existing comments in on load */
  setTimeout(() => {
    document.querySelectorAll('.up-comment').forEach((el, i) => {
      setTimeout(() => el.classList.add('up-comment--entered'), i * 60);
    });
    updateCount();
  }, 100);

})();
