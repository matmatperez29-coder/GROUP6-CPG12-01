/* ============================================================
   article-interactions.js — UrbanPulse (DATABASE VERSION)
   Handles: Reactions, Comments, Share buttons via API
============================================================ */
(() => {
  'use strict';

  // Get the article ID based on the current page filename (e.g., 'article-eagles')
  const ARTICLE_ID = location.pathname.split('/').pop().replace('.php', '').replace('.php', '');

  /* ── Helpers ── */
  function initials(name) {
    if (!name) return '??';
    return name.trim().split(/\s+/).map(w => w[0]).join('').slice(0,2).toUpperCase();
  }
  
  function timeAgo(dateString) {
    const ts = new Date(dateString).getTime();
    const m = Math.floor((Date.now()-ts)/60000);
    if (m < 1) return 'Just now';
    if (m < 60) return `${m}m ago`;
    const h = Math.floor(m/60);
    if (h < 24) return `${h}h ago`;
    const d = Math.floor(h/24);
    if (d < 7) return `${d}d ago`;
    return new Date(ts).toLocaleDateString('en-PH',{month:'short',day:'numeric'});
  }
  
  function esc(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
              .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
  }

  /* ── API Fetcher ── */
  let serverData = { reactions: {}, comments: [], myReaction: null, myLikes: [], isLoggedIn: false };

  async function fetchInteractions() {
    try {
      const res = await fetch(`api.php?action=get_data&article_id=${ARTICLE_ID}`);
      serverData = await res.json();
      renderReactions();
      renderComments();
    } catch (err) {
      console.error("Failed to load interactions:", err);
    }
  }

  /* ════════════════════════════════════
     REACTIONS
  ════════════════════════════════════ */
  function renderReactions() {
    const container = document.querySelector('.reaction-buttons');
    if (!container) return;

    const REACTIONS = [
      { key:'happy',     emoji:'😊', label:'Happy'     },
      { key:'sad',       emoji:'😢', label:'Sad'       },
      { key:'surprised', emoji:'😮', label:'Surprised' },
      { key:'angry',     emoji:'😠', label:'Angry'     },
    ];

    // Build the buttons
    container.innerHTML = REACTIONS.map(r => {
      const count = serverData.reactions[r.key] || 0;
      const active = serverData.myReaction === r.key ? 'active' : '';
      return `<button class="reaction-btn ${active}" data-key="${r.key}">
        <span class="emoji">${r.emoji}</span>
        <span class="label">${r.label}</span>
        <span class="count">${count > 0 ? count : ''}</span>
      </button>`;
    }).join('');

    // Attach click events
    container.querySelectorAll('.reaction-btn').forEach(btn => {
      btn.addEventListener('click', async () => {
        
        // SECURITY CHECK: Are they logged in?
        if ((typeof UP_IS_LOGGED_IN !== 'undefined' && !UP_IS_LOGGED_IN) || !serverData.isLoggedIn) {
          alert("Please log in to leave a reaction!");
          window.location.href = 'login.php';
          return;
        }

        const key = btn.dataset.key;
        
        // Optimistic UI update (makes it feel instant)
        if (serverData.myReaction === key) {
          serverData.reactions[key]--;
          serverData.myReaction = null;
        } else {
          if (serverData.myReaction) serverData.reactions[serverData.myReaction]--;
          serverData.reactions[key] = (serverData.reactions[key] || 0) + 1;
          serverData.myReaction = key;
        }
        renderReactions();

        // Send to server
        await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'toggle_reaction', article_id: ARTICLE_ID, reaction: key })
        });
      });
    });
  }

  /* ════════════════════════════════════
     COMMENTS
  ════════════════════════════════════ */
  function renderComments() {
    const list = document.getElementById('commentList');
    const badge = document.querySelector('.comment-count-badge');
    if (!list) return;

    // Update count badge
    if (badge) {
      badge.textContent = serverData.comments.length;
      badge.style.display = serverData.comments.length ? '' : 'none';
    }

    if (!serverData.comments.length) {
      list.innerHTML = '<div class="comment-empty" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">No comments yet — be the first!</div>';
      return;
    }

    // Build comment list
    list.innerHTML = serverData.comments.map(c => {
      const isLiked   = serverData.myLikes.includes(c.id);
      const isAdmin   = typeof UP_IS_ADMIN !== 'undefined' && UP_IS_ADMIN;
      return `
      <div class="comment-item" data-id="${c.id}" style="display: flex; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-border);">
        <div class="comment-avatar" style="background:${c.avatar_color}; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; flex-shrink: 0;">
            ${initials(c.name)}
        </div>
        <div class="comment-body" style="flex: 1;">
          <div class="comment-header" style="margin-bottom: 0.25rem; display:flex; align-items:center; justify-content:space-between;">
            <div>
              <span class="comment-name" style="font-weight: 700; color: var(--color-primary);">${esc(c.name)}</span>
              <span class="comment-time" style="font-size: 0.8rem; color: var(--color-text-muted); margin-left: 0.5rem;">${timeAgo(c.created_at)}</span>
            </div>
            ${isAdmin ? `
            <button class="comment-delete-btn" data-id="${c.id}" title="Delete comment" style="
              background: none; border: 1px solid #fca5a5; color: #c8102e;
              border-radius: 6px; cursor: pointer; font-size: 0.72rem; font-weight: 700;
              padding: 0.2rem 0.55rem; transition: all 0.18s; white-space: nowrap;
              font-family: inherit;
            " onmouseover="this.style.background='#c8102e';this.style.color='white'"
               onmouseout="this.style.background='none';this.style.color='#c8102e'">
              🗑 Delete
            </button>` : ''}
          </div>
          <div class="comment-text" style="font-size: 0.95rem; line-height: 1.5; margin-bottom: 0.5rem;">${esc(c.text).replace(/\n/g,'<br>')}</div>
          <div class="comment-actions">
            <button class="comment-like-btn ${isLiked ? 'liked' : ''}" data-id="${c.id}" style="background: none; border: none; cursor: pointer; font-size: 0.85rem; color: ${isLiked ? 'var(--color-secondary)' : 'var(--color-text-muted)'}; font-weight: ${isLiked ? '700' : '400'}; transition: 0.2s;">
              👍 ${c.likes > 0 ? c.likes : ''} Like
            </button>
          </div>
        </div>
      </div>`;
    }).join('');

    // Attach Like Events
    list.querySelectorAll('.comment-like-btn').forEach(btn => {
        btn.addEventListener('click', async function(e) {
          
          // SECURITY CHECK: Are they logged in?
          if ((typeof UP_IS_LOGGED_IN !== 'undefined' && !UP_IS_LOGGED_IN) || !serverData.isLoggedIn) {
            alert("Please log in to like a comment!");
            window.location.href = 'login.php';
            return;
          }
          
          const commentId = parseInt(btn.dataset.id);
          
          // Update UI instantly
          btn.classList.toggle('liked');
          if (btn.classList.contains('liked')) {
              btn.style.color = 'var(--color-secondary)';
              btn.style.fontWeight = '700';
          } else {
              btn.style.color = 'var(--color-text-muted)';
              btn.style.fontWeight = '400';
          }
          
          // Send to server
          await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'toggle_like', article_id: ARTICLE_ID, comment_id: commentId })
          });
          
          // Refresh to get accurate like counts
          fetchInteractions();
        });
    });

    // ── Delete buttons (admin only) ──
    list.querySelectorAll('.comment-delete-btn').forEach(btn => {
      btn.addEventListener('click', async function () {
        const commentId = parseInt(btn.dataset.id);
        if (!confirm('Delete this comment permanently? This cannot be undone.')) return;

        // Instantly remove from DOM for snappy UX
        const card = list.querySelector(`.comment-item[data-id="${commentId}"]`);
        if (card) {
          card.style.opacity = '0.4';
          card.style.pointerEvents = 'none';
        }

        try {
          const res  = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'delete_comment', article_id: ARTICLE_ID, comment_id: commentId })
          });
          const data = await res.json();
          if (data.success) {
            if (card) card.remove();
            // Update count badge
            const badge = document.querySelector('.comment-count-badge');
            if (badge) {
              const n = Math.max(0, (parseInt(badge.textContent) || 0) - 1);
              badge.textContent = n;
              badge.style.display = n ? '' : 'none';
            }
          } else {
            alert(data.error || 'Failed to delete comment.');
            if (card) { card.style.opacity = ''; card.style.pointerEvents = ''; }
          }
        } catch (err) {
          console.error('Delete error:', err);
          if (card) { card.style.opacity = ''; card.style.pointerEvents = ''; }
        }
      });
    });
  }

  function initCommentsForm() {
    const form = document.getElementById('commentForm');
    const textarea = document.getElementById('commentText');
    const submitBtn = form?.querySelector('.comment-submit');
    const charEl = document.getElementById('charCount');
    const MAX = 500;
    
    // If the form doesn't exist (because the PHP hid it from logged-out users), stop here.
    if (!form || !textarea) return;

    // Character counter
    if (charEl) {
      textarea.addEventListener('input', () => {
        const left = MAX - textarea.value.length;
        charEl.textContent = `${left} characters remaining`;
        charEl.style.color = left < 0 ? 'var(--color-secondary)' : (left < 50 ? '#d97706' : 'var(--color-text-muted)');
      });
    }

    form.addEventListener('submit', async e => {
      e.preventDefault();
      
      if ((typeof UP_IS_LOGGED_IN !== 'undefined' && !UP_IS_LOGGED_IN) || !serverData.isLoggedIn) return;

      const text = textarea.value.trim();
      if (!text || text.length > MAX) return;

      submitBtn.disabled = true;
      submitBtn.textContent = 'Posting...';

      const res = await fetch('api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'add_comment', article_id: ARTICLE_ID, body: text })
      });

      const result = await res.json();
      
      if (result.success) {
        form.reset();
        if (charEl) charEl.textContent = `${MAX} characters remaining`;
        submitBtn.textContent = 'Posted! ✓';
        await fetchInteractions(); // Reload comments to show the new one
      } else {
        alert(result.error || "Failed to post comment");
        submitBtn.textContent = 'Post Comment';
      }

      setTimeout(() => { submitBtn.textContent = 'Post Comment'; submitBtn.disabled = false; }, 2000);
    });
  }

  /* ════════════════════════════════════
     SHARE
  ════════════════════════════════════ */
  function initShare() {
    const url   = encodeURIComponent(location.href);
    const title = encodeURIComponent(document.title);

    document.querySelectorAll('.share-btn').forEach(btn => {
      if (btn.classList.contains('fb')) {
        btn.href = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        btn.target = '_blank'; btn.rel = 'noopener';
      }
      if (btn.classList.contains('tw')) {
        btn.href = `https://twitter.com/intent/tweet?text=${title}&url=${url}`;
        btn.target = '_blank'; btn.rel = 'noopener';
      }
      if (btn.classList.contains('copy')) {
        btn.addEventListener('click', async () => {
          try {
            await navigator.clipboard.writeText(location.href);
          } catch {
            const t = document.createElement('textarea');
            t.value = location.href;
            document.body.appendChild(t); t.select();
            document.execCommand('copy'); t.remove();
          }
          btn.classList.add('copied');
          btn.textContent = '✓ Copied!';
          const toast = document.querySelector('.share-toast');
          if (toast) { toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000); }
          setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = '🔗 Copy Link';
          }, 2000);
        });
      }
    });

    // Sidebar share/tweet buttons
    document.querySelectorAll('.sidebar-share').forEach(btn => {
      btn.addEventListener('click', () => {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
      });
    });
    document.querySelectorAll('.sidebar-tweet').forEach(btn => {
      btn.addEventListener('click', () => {
        window.open(`https://twitter.com/intent/tweet?text=${title}&url=${url}`, '_blank');
      });
    });
  }

  /* ── Init all ── */
  document.addEventListener('DOMContentLoaded', () => {
    fetchInteractions(); // Load data from the database!
    initCommentsForm();
    initShare();
  });

})();