(() => {
  'use strict';

  const LIMIT = 3;
  const METER_KEY = 'urbanpulse_ripple_meter_v1';
  const DETAIL_MAP = [
    { terms: ['agentic ai'], premium: true, meterLabel: 'premium', paragraphs: [
      'Beyond the product language, the real shift is operational. Companies are no longer testing AI only as a writing assistant. They are placing it inside supply chains, ticket routing, procurement checks, and workflow approvals where one weak decision can echo across an entire system.',
      'That is why the debate around agentic AI is now centered on logs, escalation paths, and responsibility. The strongest teams are not only asking whether the model can act faster. They are asking who can interrupt it, audit it, and explain it when the decision path becomes messy.'
    ]},
    { terms: ['philadelphia eagles', 'super bowl'], premium: true, meterLabel: 'premium', paragraphs: [
      'The Eagles made the game feel different before the final score fully explained it. Their pressure never felt random. It was coordinated enough to shrink Mahomes’ comfort without opening the escape lanes that usually let Kansas City survive chaotic stretches.',
      'On offense, the key was rhythm. Philadelphia kept building short pieces of control, then used Hurts as the stabilizer whenever the moment threatened to swing back. That made the game less about one highlight and more about a team steadily locking the door.'
    ]},
    { terms: ['eagles dethrone chiefs'], premium: true, meterLabel: 'premium', paragraphs: [
      'The defensive script mattered as much as the touchdown count. Philadelphia forced Kansas City to play from uncomfortable spacing, and that removed the calm sequencing that usually lets the Chiefs build their biggest answers.',
      'Hurts then turned the margin into authority. His passing production, rushing threat, and command at the line made the offense feel like part of the pressure system instead of a separate story.'
    ]},
    { terms: ['gpt-6', 'emotional reasoning'], premium: true, meterLabel: 'premium', paragraphs: [
      'What made the beta feel different to early testers was not only tone. It was continuity. The model seemed better at holding emotional context across longer exchanges, which made the conversation feel less like a chain of prompts and more like a relationship with memory.',
      'That same improvement raises a harder product question. Once users feel understood, they also start expecting consent, deletion, and boundaries that match human trust. The technical gain quickly becomes a design and ethics problem.'
    ]},
    { terms: ['plastic-free oceans'], premium: false, paragraphs: [
      'The 2040 promise sounds bold because it pulls several hard sectors into the same conversation: packaging, shipping, consumer goods, and waste infrastructure. A treaty like this becomes real only when those separate systems move at roughly the same speed.',
      'Environmental groups welcomed the target, but they also stressed that enforcement matters more than applause. The next phase is not the signing photo. It is the sequence of laws, penalties, and budget decisions that follow it.'
    ]},
    { terms: ['humanoid robots'], premium: true, meterLabel: 'premium', paragraphs: [
      'The deeper business angle is not that robots can move like people. It is that companies are finally deciding the flexibility is worth the cost. A machine that can shift between stations, avoid hazards, and adapt to a redesigned floor changes the economics of the line.',
      'That also changes the human role. Plants that adopt humanoids at scale will need fewer workers doing repetitive lifting and more workers supervising fleets, troubleshooting edge cases, and translating production goals into robot-safe instructions.'
    ]},
    { terms: ['messenger desktop website'], premium: false, paragraphs: [
      'The shutdown says a lot about platform consolidation. Messenger as a standalone desktop habit made sense when Meta wanted separate product identities. Folding it back into the larger Facebook experience points to a strategy built on ecosystem retention instead.',
      'For users, the change is small on paper but noticeable in routine. A focused messaging tool creates a different kind of attention than a platform designed to pull people across feeds, alerts, and social activity.'
    ]},
    { terms: ['note 60'], premium: false, paragraphs: [
      'Battery headlines matter because they solve a daily problem users still feel. A phone that stretches to multiple days of confident use does more than win a spec battle. It changes charging habits, travel choices, and what people expect from mid-range devices.',
      'Competitors will now have to answer with either better endurance or a stronger reason not to. That is why this launch feels bigger than one model line. It resets the reference point for value.'
    ]},
    { terms: ['thunder', 'first title'], premium: true, meterLabel: 'premium', paragraphs: [
      'The championship story was built on possession quality. Oklahoma City did not only score enough. It kept winning the quiet parts of the game by contesting at the rim, rotating early, and making Indiana work harder for every clean read late in the series.',
      'Shai Gilgeous-Alexander’s season now reads like an identity piece for the franchise. The scoring, the MVP case, and the finals finish all lined up because OKC stayed loyal to its pace and defensive discipline when the pressure got loud.'
    ]},
    { terms: ['psg', 'maiden champions league'], premium: true, meterLabel: 'premium', paragraphs: [
      'This breakthrough felt different because PSG finally looked structured instead of merely talented. Their spacing, decision-making, and confidence against pressure made the result feel earned long before the scoreline became historic.',
      'Luis Enrique’s biggest achievement may be psychological. He turned a club often defined by expectations into a side that seemed free enough to impose its own terms on the final.'
    ]},
    { terms: ['dodgers', 'world series'], premium: false, paragraphs: [
      'Back-to-back titles require more than star power. They demand roster depth that can survive long stretches, postseason volatility, and the pressure of playing as the team everyone is aiming at. The Dodgers cleared that standard again.',
      'Game 7 captured the larger truth of the series. Even when Toronto forced chaos, Los Angeles still looked like the group with more ways to solve the moment.'
    ]},
    { terms: ['renaissance of cinema'], premium: false, paragraphs: [
      'What makes this wave interesting is the mix of old and new confidence. Directors are using immersive tools, interactive structures, and AI-assisted workflows without pretending traditional craft no longer matters. The best films are blending experimentation with discipline.',
      'For audiences, the result is a reset of what theatrical storytelling can feel like. The discussion is no longer whether cinema is dying. It is which creators are bold enough to change its grammar on purpose.'
    ]},
    { terms: ['ai rapper'], premium: false, paragraphs: [
      'The bigger question is not whether an AI artist can top charts. It is how labels, fans, and platforms decide what counts as authorship once performance, voice, and production can all be partly synthetic.',
      'AERO’s rise shows that novelty can hold mainstream attention longer than skeptics expected. That forces the industry to think about branding, disclosure, royalties, and what listeners still mean when they say an artist feels real.'
    ]},
    { terms: ['vinyl sales'], premium: false, paragraphs: [
      'Vinyl’s strength is emotional and physical at the same time. Listeners are not only buying sound. They are buying ritual, artwork, shelf presence, and the feeling that music can still be owned as an object instead of accessed as a stream.',
      'That is why the trend keeps outlasting predictions. It fills a gap left by convenience culture, especially for younger audiences who grew up with endless access but still want something tactile and memorable.'
    ]},
    { terms: ['mars base alpha'], premium: false, paragraphs: [
      'The greenhouse harvest matters because life-support milestones are usually more important than dramatic launch headlines. A colony becomes believable only when food, water, and waste systems start proving they can loop without constant rescue from Earth.',
      'Scientists will now study yield stability, nutritional consistency, and energy cost. The exciting image is the first harvest. The real test is whether the system can keep producing month after month.'
    ]},
    { terms: ['asean trade pact'], premium: false, paragraphs: [
      'Regional digital currency frameworks are ultimately about trust and friction. If member states can reduce payment delays and stabilize transaction rules, the agreement becomes more than a tech experiment. It becomes infrastructure for trade confidence.',
      'The rollout will still depend on coordination between central banks, cybersecurity standards, and political patience. Shared frameworks are easy to announce and difficult to standardize.'
    ]},
    { terms: ['quantum materials'], premium: true, meterLabel: 'premium', paragraphs: [
      'The significance of true 1D electron behavior is that it gives researchers a cleaner laboratory for understanding how matter behaves when movement is tightly constrained. Strange electronic phases become easier to study when the noise of more complex pathways is reduced.',
      'That does not mean consumer devices arrive tomorrow. It means the foundational science guiding future hardware just became a little less abstract and a little more testable.'
    ]},
    { terms: ['secure sovereign ai factory'], premium: false, paragraphs: [
      'Sovereign AI projects are about control as much as computing power. Governments and domestic firms want the ability to train, store, and deploy sensitive systems without relying entirely on foreign infrastructure or policy environments.',
      'Australia’s move reflects a bigger geopolitical pattern. Chips, cloud capacity, and model training are turning into strategic assets, not only business tools.'
    ]},
    { terms: ['orbital fuel transfer'], premium: true, meterLabel: 'premium', paragraphs: [
      'Refueling in orbit changes mission planning because it breaks the one-launch mindset. Vehicles can be assembled, topped up, and sent farther without forcing every kilogram to leave Earth in its final mission state.',
      'That makes lunar logistics more realistic and Mars architecture less speculative. The public sees a test. Engineers see the early shape of a transport system.'
    ]},
    { terms: ['sub-orbital satellite webs'], premium: false, paragraphs: [
      'This race is really about latency, coverage, and control of the next access layer of the internet. Whoever owns the most dependable hybrid network can shape everything from remote education to emergency response and maritime tracking.',
      'The challenge is that infrastructure stories look invisible until they fail. That makes reliability and regulation just as important as launch speed.'
    ]},
    { terms: ['right to disconnect'], premium: false, paragraphs: [
      'A legal right to disconnect sounds cultural, but it has operational consequences. Once after-hours communication becomes a labor issue, companies need clearer expectations about response windows, scheduling, and what counts as urgent.',
      'That is why the proposal resonates outside Europe too. It names a problem many workers already feel even when their employer has never put it into policy language.'
    ]},
    { terms: ['amazon reforestation'], premium: false, paragraphs: [
      'Five-year highs matter because ecological recovery is slow enough that one good season proves very little on its own. What observers want to see is continuity, enforcement, and evidence that restored land is staying protected.',
      'The best outcome would be a shift from symbolic tree counts toward measurable ecosystem health, including canopy survival, water quality, and indigenous stewardship.'
    ]},
    { terms: ['sinner and swiatek'], premium: false, paragraphs: [
      'The finals told two different versions of dominance. Sinner’s win looked like control built through composure, while Świątek’s result felt like pressure so complete that the scoreboard almost stopped describing the gap accurately.',
      'Wimbledon tends to magnify identity. This year it showed which players could impose their game in the most exposed moments instead of simply surviving them.'
    ]},
    { terms: ['sinner and swiatek own the wimbledon spotlight'], premium: false, paragraphs: [
      'Both champions arrived with different kinds of momentum, but the common theme was clarity. Each looked like a player whose patterns and choices held up even when the occasion tried to distort them.',
      'That made the day memorable for opposite reasons: one match rewarded resilience, while the other became a reminder that total command can itself be shocking.'
    ]}
  ];

  function normalize(value) {
    return String(value || '').toLowerCase().replace(/[^a-z0-9\s]+/g, ' ').replace(/\s+/g, ' ').trim();
  }

  function getState() {
    try {
      const raw = localStorage.getItem(METER_KEY);
      const parsed = raw ? JSON.parse(raw) : null;
      if (parsed && typeof parsed === 'object') {
        return { count: parsed.count || 0, seen: parsed.seen || {}, passUntil: parsed.passUntil || 0 };
      }
    } catch (error) {}
    return { count: 0, seen: {}, passUntil: 0 };
  }

  function setState(next) {
    try { localStorage.setItem(METER_KEY, JSON.stringify(next)); } catch (error) {}
  }

  function hasPass(state) {
    return Number(state.passUntil || 0) > Date.now();
  }

  function formatPassUntil(timestamp) {
    if (!timestamp) return '';
    try {
      return new Date(timestamp).toLocaleString([], {
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit'
      });
    } catch (error) {
      return '';
    }
  }

  function updateMeterUi() {
    const state = getState();
    const passActive = hasPass(state);
    const used = passActive ? LIMIT : Math.min(state.count, LIMIT);
    const remaining = passActive ? '∞' : Math.max(LIMIT - state.count, 0);
    const remainingEl = document.getElementById('rippleMeterRemaining');
    const statusEl = document.getElementById('rippleMeterStatus');
    const progressEl = document.getElementById('rippleMeterProgress');
    const modalRemainingEl = document.getElementById('rippleModalRemaining');
    const modalUsedEl = document.getElementById('rippleModalUsed');
    const modalModeEl = document.getElementById('rippleModalMode');
    const passStateEl = document.getElementById('ripplePassState');
    const campusPassBtn = document.getElementById('rippleCampusPass');
    const pips = document.querySelectorAll('#rippleMeterPips .editorial-meter-pip');
    const passUntilLabel = passActive ? formatPassUntil(state.passUntil) : '';

    if (remainingEl) remainingEl.textContent = String(remaining);
    if (modalRemainingEl) modalRemainingEl.textContent = String(remaining);
    if (modalUsedEl) modalUsedEl.textContent = passActive ? 'pass active' : `${used} / ${LIMIT}`;
    if (modalModeEl) modalModeEl.textContent = passActive ? (passUntilLabel ? `Campus pass until ${passUntilLabel}` : 'Campus pass active') : 'Meter active';
    if (passStateEl) passStateEl.textContent = passActive ? 'Campus pass active' : state.count >= LIMIT ? 'Meter reached' : 'Meter active';

    if (statusEl) {
      statusEl.textContent = passActive
        ? (passUntilLabel ? `24-hour campus pass active until ${passUntilLabel}` : 'Campus pass active for 24 hours')
        : state.count >= LIMIT
          ? 'Meter reached for premium story depth'
          : state.count === 0
            ? 'Fresh meter ready'
            : `You used ${state.count} of ${LIMIT} premium reads`;
    }
    if (progressEl) {
      const progress = passActive ? 100 : Math.min((state.count / LIMIT) * 100, 100);
      progressEl.style.width = `${progress}%`;
    }

    pips.forEach((pip, index) => {
      pip.classList.toggle('is-filled', passActive || index < state.count);
    });

    if (campusPassBtn) {
      campusPassBtn.disabled = passActive;
      campusPassBtn.innerHTML = passActive
        ? '<span>Campus pass is active</span><small>Premium detail is unlocked in this browser</small>'
        : '<span>Use 24-hour campus pass</span><small>Fast demo unlock in this browser</small>';
    }
  }

  function openPaywall() {
    const modal = document.getElementById('ripplePaywallModal');
    const backdrop = document.getElementById('ripplePaywallBackdrop');
    if (!modal || !backdrop) return;
    modal.hidden = false;
    backdrop.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('ripple-paywall-open');
  }

  function closePaywall() {
    const modal = document.getElementById('ripplePaywallModal');
    const backdrop = document.getElementById('ripplePaywallBackdrop');
    if (!modal || !backdrop) return;
    modal.hidden = true;
    backdrop.hidden = true;
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('ripple-paywall-open');
  }

  function matchDetailData(headline) {
    const normalized = normalize(headline);
    return DETAIL_MAP.find((entry) => entry.terms.every((term) => normalized.includes(normalize(term)))) || null;
  }

  function inferAuthor(card) {
    const selectors = ['.time-tag', '.hero-meta', '.story-meta', '.sidebar-meta', '.compact-meta', '.news-card-meta', '.review-meta', '.trending-meta'];
    for (const selector of selectors) {
      const el = card.querySelector(selector);
      if (el) {
        const text = el.textContent.replace(/\s+/g, ' ').trim();
        if (text) return text;
      }
    }
    return '';
  }

  function createParagraphs(container, paragraphs) {
    const frag = document.createDocumentFragment();
    if (!container.querySelector('.story-detail-label')) {
      const label = document.createElement('div');
      label.className = 'story-detail-label';
      label.textContent = 'UrbanPulse depth mode';
      frag.appendChild(label);
    }
    paragraphs.forEach((paragraph) => {
      const p = document.createElement('p');
      p.textContent = paragraph;
      frag.appendChild(p);
    });
    container.appendChild(frag);
  }

  function attachDetailData(card) {
    if (card.dataset.detailReady === 'true') return;
    const heading = card.querySelector('h1, h2, h3, h4');
    if (!heading) return;
    const detailData = matchDetailData(heading.textContent) || {
      premium: false,
      paragraphs: [
        'UrbanPulse adds this extended detail layer so the story does not stop at the first summary line. The extra section is meant to show consequence, context, and what the headline means once the first reaction fades.',
        'That makes the Read more button useful for class demos because it behaves like a genuine second layer of reporting instead of a decorative toggle.'
      ]
    };

    const legacyButton = card.querySelector('.toggle-btn');
    if (legacyButton) {
      let moreText = legacyButton.closest('p')?.querySelector('.more-text');
      if (moreText) {
        let panel;
        if (moreText.parentElement && moreText.parentElement.classList.contains('story-detail-panel')) {
          panel = moreText.parentElement;
        } else {
          panel = document.createElement('div');
          panel.className = 'story-detail-panel';
          panel.hidden = true;
          moreText.parentNode.insertBefore(panel, moreText);
          const existing = moreText.textContent.trim();
          if (existing) {
            createParagraphs(panel, [existing]);
          }
          moreText.remove();
        }
        createParagraphs(panel, detailData.paragraphs);
        const panelId = `detail-${Math.random().toString(36).slice(2, 10)}`;
        panel.id = panelId;
        legacyButton.dataset.detailTarget = panelId;
      }
      legacyButton.type = 'button';
      legacyButton.setAttribute('aria-expanded', 'false');
      if (detailData.premium) legacyButton.dataset.meterLabel = detailData.meterLabel || 'premium';
      card.dataset.premiumDetail = detailData.premium ? 'true' : 'false';
      card.dataset.detailReady = 'true';
      return;
    }

    const dataButton = card.querySelector('[data-read-more]');
    if (dataButton) {
      const target = document.getElementById(dataButton.getAttribute('data-read-more'));
      if (target) {
        target.classList.add('story-detail-panel');
        createParagraphs(target, detailData.paragraphs);
      }
      if (detailData.premium) dataButton.dataset.meterLabel = detailData.meterLabel || 'premium';
      dataButton.type = 'button';
      card.dataset.premiumDetail = detailData.premium ? 'true' : 'false';
      card.dataset.detailReady = 'true';
      return;
    }

    const anchor = card.querySelector('.story-meta, .hero-meta, .sidebar-meta, .compact-meta, .news-card-meta, .review-meta, .trending-meta, .time-tag');
    const panel = document.createElement('div');
    panel.className = 'story-detail-panel';
    panel.hidden = true;
    panel.id = `detail-${Math.random().toString(36).slice(2, 10)}`;
    createParagraphs(panel, detailData.paragraphs);
    const button = document.createElement('button');
    button.className = 'read-more-btn';
    button.type = 'button';
    button.textContent = 'Read more';
    button.setAttribute('aria-expanded', 'false');
    button.dataset.detailTarget = panel.id;
    if (detailData.premium) button.dataset.meterLabel = detailData.meterLabel || 'premium';
    if (anchor && anchor.parentNode) {
      anchor.parentNode.insertBefore(panel, anchor);
      anchor.parentNode.insertBefore(button, anchor);
    } else {
      card.appendChild(panel);
      card.appendChild(button);
    }
    card.dataset.premiumDetail = detailData.premium ? 'true' : 'false';
    card.dataset.detailReady = 'true';
  }

  function registerPremiumAccess(card, targetId) {
    const state = getState();
    if (hasPass(state)) return true;
    const premium = card?.dataset.premiumDetail === 'true';
    if (!premium) return true;
    if (state.seen[targetId]) return true;
    if (state.count >= LIMIT) {
      openPaywall();
      return false;
    }
    state.count += 1;
    state.seen[targetId] = true;
    setState(state);
    updateMeterUi();
    return true;
  }

  function toggleTarget(button, target) {
    const expanded = button.getAttribute('aria-expanded') === 'true';
    if (!expanded) {
      const accessKey = target?.id || button.dataset.detailTarget || button.getAttribute('data-read-more') || normalize(button.closest('.filter-item')?.querySelector('h1,h2,h3,h4')?.textContent || 'story');
      if (!registerPremiumAccess(button.closest('.filter-item'), accessKey)) return;
    }
    if (target) target.hidden = expanded;
    button.setAttribute('aria-expanded', String(!expanded));
    button.textContent = expanded ? 'Read more' : 'Read less';
  }

  function handleLegacyToggle(button) {
    const targetId = button.dataset.detailTarget;
    const target = targetId ? document.getElementById(targetId) : null;
    if (!target) return;
    toggleTarget(button, target);
  }

  function enhanceStories() {
    const selectors = ['.filter-item', '.hero-story', '.story-card', '.category-card', '.compact-story', '.more-card', '.hero-main', '.list-story', '.news-card', '.review-card', '.sidebar-story', '.trending-item'];
    const unique = new Set();
    document.querySelectorAll(selectors.join(',')).forEach((card) => {
      if (!card.querySelector('h1, h2, h3, h4')) return;
      if (unique.has(card)) return;
      unique.add(card);
      attachDetailData(card);
      const author = inferAuthor(card);
      if (author && !card.dataset.search?.includes(author)) {
        card.dataset.search = `${card.dataset.search || ''} ${author}`.trim();
      }
    });
  }

  function bindButtons() {
    document.addEventListener('click', (event) => {
      const readButton = event.target.closest('.read-more-btn');
      if (readButton) {
        const targetId = readButton.dataset.detailTarget || readButton.getAttribute('data-read-more');
        const target = targetId ? document.getElementById(targetId) : null;
        if (target) {
          event.preventDefault();
          event.stopImmediatePropagation();
          toggleTarget(readButton, target);
        }
        return;
      }

      const legacyButton = event.target.closest('.toggle-btn');
      if (legacyButton) {
        event.preventDefault();
        event.stopImmediatePropagation();
        handleLegacyToggle(legacyButton);
        return;
      }

      if (event.target.closest('[data-open-paywall]')) {
        event.preventDefault();
        openPaywall();
        return;
      }

      if (event.target.closest('[data-close-paywall]') || event.target.id === 'ripplePaywallBackdrop') {
        event.preventDefault();
        closePaywall();
        return;
      }

      const authorCard = event.target.closest('[data-author-column]');
      if (authorCard) {
        event.preventDefault();
        const author = authorCard.getAttribute('data-author-name') || '';
        document.querySelectorAll('[data-author-column]').forEach((item) => item.classList.toggle('is-active', item === authorCard));
        const input = document.getElementById('articleSearch');
        if (input) {
          input.value = author;
          input.dispatchEvent(new Event('input', { bubbles: true }));
          input.focus();
          input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
    }, true);

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') closePaywall();
    });

    const campusPass = document.getElementById('rippleCampusPass');
    if (campusPass) {
      campusPass.addEventListener('click', () => {
        const state = getState();
        state.passUntil = Date.now() + 24 * 60 * 60 * 1000;
        setState(state);
        updateMeterUi();
        closePaywall();
      });
    }
  }

  function init() {
    enhanceStories();
    bindButtons();
    updateMeterUi();
  }

  window.UrbanPulseEditorial = {
    handleLegacyToggle,
    toggleTarget,
    openPaywall,
    updateMeterUi,
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();