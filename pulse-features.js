(() => {
  'use strict';

  const pageId = document.body?.dataset.page || 'home';
  const bellButton = document.getElementById('pulseAlertToggle');
  const bellBadge = document.getElementById('pulseAlertBadge');
  const drawer = document.getElementById('pulseDrawer');
  const overlay = document.getElementById('pulseOverlay');
  const alertList = document.getElementById('pulseAlertList');
  const enableButton = document.getElementById('pulseEnableNotifications');
  const permissionState = document.getElementById('pulsePermissionState');
  const transcriptModal = document.getElementById('pulseTranscriptModal');
  const transcriptContent = document.getElementById('pulseTranscriptContent');
  const transcriptSpotlightButton = document.querySelector('[data-open-transcript-spotlight]');
  const alertOpenButtons = document.querySelectorAll('[data-open-pulse-alerts]');
  const STORAGE_LAST_OPEN = `up_pulse_last_open_${pageId}`;
  const STORAGE_LAST_ALERT = `up_pulse_last_alert_${pageId}`;
  const STORAGE_ALLOW_BROWSER = 'up_pulse_browser_allowed';
  let pollTimer = null;

  function formatTime(value) {
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return 'Just now';
    return date.toLocaleString('en-PH', {
      month: 'short',
      day: 'numeric',
      hour: 'numeric',
      minute: '2-digit'
    });
  }

  function setPermissionText() {
    if (!permissionState) return;
    if (!('Notification' in window)) {
      permissionState.textContent = 'Status: browser notifications are not supported here';
      if (enableButton) enableButton.disabled = true;
      return;
    }
    permissionState.textContent = `Status: ${Notification.permission}`;
  }

  function unreadCount(alerts) {
    const lastOpen = Number(localStorage.getItem(STORAGE_LAST_OPEN) || 0);
    return alerts.filter((item) => new Date(item.time).getTime() > lastOpen).length;
  }

  function updateBadge(count) {
    if (!bellBadge) return;
    if (count > 0) {
      bellBadge.hidden = false;
      bellBadge.textContent = count > 9 ? '9+' : String(count);
    } else {
      bellBadge.hidden = true;
      bellBadge.textContent = '0';
    }
  }

  async function fetchAlerts() {
    if (!alertList) return [];
    try {
      const response = await fetch(`alerts-feed.php?page=${encodeURIComponent(pageId)}`, { cache: 'no-store' });
      if (!response.ok) throw new Error('Unable to load alerts.');
      const data = await response.json();
      renderAlerts(data.alerts || []);
      maybeNotify(data.alerts || []);
      return data.alerts || [];
    } catch (error) {
      alertList.innerHTML = '<div class="pulse-empty-state">Pulse Alerts could not load right now. Refresh the page and try again.</div>';
      return [];
    }
  }

  function renderAlerts(alerts) {
    if (!alertList) return;
    if (!alerts.length) {
      alertList.innerHTML = '<div class="pulse-empty-state">No live alerts yet. Your newsroom feed is ready for the next update.</div>';
      updateBadge(0);
      return;
    }

    const unread = unreadCount(alerts);
    updateBadge(unread);

    alertList.innerHTML = alerts.map((alert) => `
      <article class="pulse-alert-card" data-alert-id="${escapeHtml(alert.id)}">
        <div class="pulse-alert-top">
          <span class="pulse-alert-label">${escapeHtml(alert.label || alert.category || 'Update')}</span>
          <span class="pulse-alert-time">${escapeHtml(formatTime(alert.time))}</span>
        </div>
        <h4 class="pulse-alert-headline">${escapeHtml(alert.headline || '')}</h4>
        <p class="pulse-alert-summary">${escapeHtml(alert.summary || '')}</p>
        <div class="pulse-alert-actions">
          ${alert.transcript_id ? `<button class="pulse-alert-open" type="button" data-transcript-id="${escapeHtml(alert.transcript_id)}">${escapeHtml(alert.action_text || 'Open transcript')}</button>` : ''}
          <button class="pulse-alert-mark" type="button" data-mark-read>Mark as read</button>
        </div>
      </article>
    `).join('');

    alertList.querySelectorAll('[data-transcript-id]').forEach((button) => {
      button.addEventListener('click', () => openTranscript(button.getAttribute('data-transcript-id')));
    });

    alertList.querySelectorAll('[data-mark-read]').forEach((button) => {
      button.addEventListener('click', () => {
        localStorage.setItem(STORAGE_LAST_OPEN, String(Date.now()));
        fetchAlerts();
      });
    });
  }

  function maybeNotify(alerts) {
    if (!('Notification' in window)) return;
    if (Notification.permission !== 'granted') return;
    if (localStorage.getItem(STORAGE_ALLOW_BROWSER) !== 'true') return;
    const latest = alerts[0];
    if (!latest) return;
    const latestTime = new Date(latest.time).getTime();
    const notifiedAt = Number(localStorage.getItem(STORAGE_LAST_ALERT) || 0);
    if (latestTime <= notifiedAt) return;

    const notification = new Notification('UrbanPulse Alert', {
      body: latest.headline || 'New UrbanPulse alert available.',
      icon: 'IMAGES/UrbanPulse.png',
      badge: 'IMAGES/UrbanPulse.png'
    });

    notification.onclick = () => {
      window.focus();
      if (latest.transcript_id) openTranscript(latest.transcript_id);
      else openDrawer();
    };

    localStorage.setItem(STORAGE_LAST_ALERT, String(latestTime));
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function openDrawer() {
    if (!drawer || !overlay) return;
    drawer.hidden = false;
    overlay.hidden = false;
    requestAnimationFrame(() => drawer.classList.add('is-open'));
    drawer.setAttribute('aria-hidden', 'false');
    document.body.classList.add('pulse-open');
    localStorage.setItem(STORAGE_LAST_OPEN, String(Date.now()));
    fetchAlerts();
  }

  function closeDrawer() {
    if (!drawer || !overlay) return;
    drawer.classList.remove('is-open');
    drawer.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('pulse-open');
    setTimeout(() => {
      if (!drawer.classList.contains('is-open')) drawer.hidden = true;
      if (!transcriptModal || transcriptModal.hidden) overlay.hidden = true;
    }, 280);
  }

  function openTranscript(id) {
    if (!id || !transcriptModal || !transcriptContent || !overlay) return;
    transcriptModal.hidden = false;
    overlay.hidden = false;
    transcriptModal.setAttribute('aria-hidden', 'false');
    transcriptContent.innerHTML = '<div class="pulse-transcript-loading">Loading transcript lens...</div>';
    fetch(`transcript-feed.php?id=${encodeURIComponent(id)}`, { cache: 'no-store' })
      .then((response) => {
        if (!response.ok) throw new Error('Transcript not found');
        return response.json();
      })
      .then((data) => {
        transcriptContent.innerHTML = renderTranscript(data);
        localStorage.setItem(STORAGE_LAST_OPEN, String(Date.now()));
        fetchAlerts();
      })
      .catch(() => {
        transcriptContent.innerHTML = '<div class="pulse-empty-state">That transcript lens is not available right now.</div>';
      });
  }

  function closeTranscript() {
    if (!transcriptModal || !overlay) return;
    transcriptModal.hidden = true;
    transcriptModal.setAttribute('aria-hidden', 'true');
    if (!drawer || drawer.hidden) overlay.hidden = true;
  }

  function renderTranscript(data) {
    const blocks = Array.isArray(data.transcript) ? data.transcript : [];
    const signals = Array.isArray(data.signals) ? data.signals : [];
    return `
      <div class="pulse-transcript-eyebrow">${escapeHtml(data.eyebrow || 'Transcript Lens')}</div>
      <h3 class="pulse-transcript-title">${escapeHtml(data.headline || 'UrbanPulse Transcript')}</h3>
      <p class="pulse-transcript-deck">${escapeHtml(data.deck || '')}</p>
      <div class="pulse-transcript-meta">
        <span>${escapeHtml(data.author || 'UrbanPulse Desk')}</span>
        <span>${escapeHtml(data.published || '')}</span>
        <span>${escapeHtml(data.duration || '')}</span>
      </div>
      <div class="pulse-transcript-grid">
        <div class="pulse-transcript-main">
          <div class="pulse-transcript-summary">
            <div class="pulse-transcript-section-title">Scene setter</div>
            <p>${escapeHtml(data.summary || '')}</p>
          </div>
          <div class="pulse-transcript-blocks" style="margin-top: 1rem;">
            <div class="pulse-transcript-section-title">Live transcript</div>
            <div class="pulse-block-list">
              ${blocks.map((block) => `
                <article class="pulse-block">
                  <div class="pulse-block-top">
                    <span class="pulse-block-speaker">${escapeHtml(block.speaker || 'Desk')}</span>
                    <span class="pulse-block-time">${escapeHtml(block.time || '')}</span>
                  </div>
                  <p class="pulse-block-text">${escapeHtml(block.text || '')}</p>
                </article>
              `).join('')}
            </div>
          </div>
        </div>
        <aside class="pulse-transcript-side">
          <div class="pulse-transcript-quote">
            <div class="pulse-transcript-section-title">Quote pull</div>
            <p>${escapeHtml(data.quote || '')}</p>
          </div>
          <div class="pulse-transcript-signals" style="margin-top: 1rem;">
            <div class="pulse-transcript-section-title">Signal map</div>
            <div class="pulse-signals">
              ${signals.map((signal) => `<span class="pulse-signal-chip">${escapeHtml(signal)}</span>`).join('')}
            </div>
          </div>
          <div class="pulse-inline-actions">
            <button class="pulse-action-link" type="button" data-open-pulse-alerts>Back to alerts</button>
          </div>
        </aside>
      </div>
    `;
  }

  function bindStaticButtons() {
    alertOpenButtons.forEach((button) => button.addEventListener('click', openDrawer));
    if (bellButton) bellButton.addEventListener('click', openDrawer);
    document.querySelectorAll('[data-close-pulse]').forEach((button) => button.addEventListener('click', closeDrawer));
    document.querySelectorAll('[data-close-transcript]').forEach((button) => button.addEventListener('click', closeTranscript));
    if (overlay) {
      overlay.addEventListener('click', () => {
        closeDrawer();
        closeTranscript();
      });
    }

    document.querySelectorAll('.pulse-transcript-trigger').forEach((button) => {
      button.addEventListener('click', () => openTranscript(button.getAttribute('data-transcript-id')));
    });

    if (transcriptSpotlightButton && transcriptModal) {
      transcriptSpotlightButton.addEventListener('click', () => {
        const spotlight = transcriptModal.getAttribute('data-spotlight-id');
        openTranscript(spotlight);
      });
    }

    document.addEventListener('click', (event) => {
      const trigger = event.target.closest('[data-open-pulse-alerts]');
      if (trigger) openDrawer();
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeDrawer();
        closeTranscript();
      }
    });
  }

  function bindEnableNotifications() {
    if (!enableButton) return;
    enableButton.addEventListener('click', async () => {
      if (!('Notification' in window)) return;
      const permission = await Notification.requestPermission();
      if (permission === 'granted') {
        localStorage.setItem(STORAGE_ALLOW_BROWSER, 'true');
        new Notification('UrbanPulse alerts enabled', {
          body: 'Breaking prompts will appear while this page is open.',
          icon: 'IMAGES/UrbanPulse.png'
        });
      }
      setPermissionText();
    });
  }

  function startPolling() {
    fetchAlerts();
    pollTimer = window.setInterval(fetchAlerts, 30000);
  }

  bindStaticButtons();
  bindEnableNotifications();
  setPermissionText();
  startPolling();
})();