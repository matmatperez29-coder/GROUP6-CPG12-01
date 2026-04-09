<?php
session_start();
require_once 'db.php';
require_once 'auth.php';
$currentUser = getCurrentUser();
$pageId = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>About Us — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>(function(){try{if(localStorage.getItem('up_theme')==='dark')document.documentElement.setAttribute('data-theme','dark')}catch(e){}})()</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="burgermenu.css">
  <link rel="stylesheet" href="theme.css">
  <link rel="stylesheet" href="pulse-features.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    :root {
      --color-primary: #1a1a1a;
      --color-secondary: #c8102e;
      --color-accent: #d4af37;
      --color-background: #ffffff;
      --color-surface: #f4f4f4;
      --color-border: #e0e0e0;
      --color-text: #2d2d2d;
      --color-text-light: #666666;
      --font-display: 'Playfair Display', serif;
      --font-body: 'Source Sans 3', sans-serif;
    }
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: var(--font-body); color: var(--color-text); background: var(--color-background); margin: 0; overflow-x: hidden; }
    a { text-decoration: none; color: inherit; transition: color .2s; }

    /* ── HERO ── */
    .about-hero {
      position: relative;
      background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 50%, #0d0d0d 100%);
      overflow: hidden;
      padding: 5rem 1.5rem 4rem;
      text-align: center;
    }
    .about-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200,16,46,0.18) 0%, transparent 70%),
        radial-gradient(ellipse 50% 60% at 80% 50%, rgba(212,175,55,0.10) 0%, transparent 70%);
      pointer-events: none;
    }
    .about-hero::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(200,16,46,0.6), rgba(212,175,55,0.4), transparent);
    }
    .about-hero-eyebrow {
      display: inline-block;
      font-size: .72rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--color-secondary);
      background: rgba(200,16,46,0.12); border: 1px solid rgba(200,16,46,0.25);
      padding: .35rem .9rem; border-radius: 999px;
      margin-bottom: 1.5rem; position: relative;
    }
    .about-hero-title {
      font-family: var(--font-display);
      font-size: clamp(2.8rem, 6vw, 5rem);
      font-weight: 900; line-height: 1.05;
      color: #fff; margin: 0 auto 1.25rem;
      max-width: 760px; position: relative;
    }
    .about-hero-title em { font-style: italic; color: var(--color-accent); }
    .about-hero-sub {
      font-size: clamp(1rem, 2vw, 1.2rem);
      color: rgba(255,255,255,.65); max-width: 560px;
      margin: 0 auto; line-height: 1.7; position: relative;
    }
    .about-hero-accent {
      display: flex; align-items: center; justify-content: center; gap: 1rem;
      margin-top: 2.5rem; position: relative;
    }
    .about-hero-accent span {
      display: inline-block; height: 2px; width: 60px;
      background: linear-gradient(90deg, transparent, var(--color-secondary));
    }
    .about-hero-accent span:last-child {
      background: linear-gradient(90deg, var(--color-secondary), transparent);
    }
    .about-hero-accent strong {
      font-family: var(--font-display); font-size: .95rem;
      color: var(--color-accent); letter-spacing: 1.5px; font-weight: 700;
    }

    /* ── MAIN CONTENT ── */
    .about-body { max-width: 1100px; margin: 0 auto; padding: 4rem 1.5rem; }

    /* Mission */
    .mission-block {
      display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;
      align-items: center; margin-bottom: 5rem;
    }
    .mission-kicker {
      font-size: .72rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--color-secondary);
      margin-bottom: .75rem; display: block;
    }
    .mission-title {
      font-family: var(--font-display);
      font-size: clamp(1.8rem, 3vw, 2.8rem); font-weight: 900;
      line-height: 1.1; color: var(--color-primary); margin: 0 0 1.25rem;
    }
    html[data-theme='dark'] .mission-title { color: #f4f7fb; }
    .mission-body { font-size: 1.05rem; line-height: 1.85; color: var(--color-text-light); }
    html[data-theme='dark'] .mission-body { color: #8f98a7; }

    .mission-visual {
      position: relative; border-radius: 24px; overflow: hidden;
      aspect-ratio: 4/3;
      background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
      display: flex; align-items: center; justify-content: center;
    }
    .mission-visual-inner {
      text-align: center; padding: 2rem;
    }
    .mission-visual-logo {
      font-family: var(--font-display); font-size: 3.5rem; font-weight: 900;
      color: #fff; line-height: 1; margin-bottom: .5rem;
    }
    .mission-visual-tag {
      font-size: .75rem; letter-spacing: 2px; text-transform: uppercase;
      color: var(--color-accent); font-weight: 700;
    }
    .mission-visual::before {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse at 30% 40%, rgba(200,16,46,0.25), transparent 65%),
                  radial-gradient(ellipse at 70% 70%, rgba(212,175,55,0.12), transparent 65%);
    }
    .mission-visual-bar {
      position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, #c8102e, #d4af37);
    }

    /* Values */
    .values-section { margin-bottom: 5rem; }
    .section-header-row {
      display: flex; align-items: flex-end; justify-content: space-between;
      margin-bottom: 2.5rem; padding-bottom: 1rem;
      border-bottom: 2px solid var(--color-border);
    }
    html[data-theme='dark'] .section-header-row { border-bottom-color: #2a313c; }
    .section-kicker {
      font-size: .72rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--color-secondary); margin-bottom: .4rem;
    }
    .section-title {
      font-family: var(--font-display);
      font-size: clamp(1.5rem, 2.5vw, 2.2rem); font-weight: 900;
      color: var(--color-primary); margin: 0;
    }
    html[data-theme='dark'] .section-title { color: #f4f7fb; }

    .values-grid {
      display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;
    }
    .value-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border);
      border-radius: 20px; padding: 2rem 1.75rem;
      position: relative; overflow: hidden;
      transition: transform .2s, box-shadow .2s;
    }
    html[data-theme='dark'] .value-card {
      background: #151a22; border-color: #2a313c;
    }
    .value-card:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,0,0,.08); }
    html[data-theme='dark'] .value-card:hover { box-shadow: 0 20px 50px rgba(0,0,0,.35); }
    .value-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--color-secondary), var(--color-accent));
      opacity: 0; transition: opacity .2s;
    }
    .value-card:hover::before { opacity: 1; }
    .value-icon {
      font-size: 2rem; margin-bottom: 1rem; display: block;
    }
    .value-title {
      font-family: var(--font-display); font-size: 1.2rem; font-weight: 700;
      color: var(--color-primary); margin: 0 0 .65rem;
    }
    html[data-theme='dark'] .value-title { color: #f4f7fb; }
    .value-text { font-size: .95rem; line-height: 1.75; color: var(--color-text-light); margin: 0; }
    html[data-theme='dark'] .value-text { color: #8f98a7; }

    /* Team */
    .team-section { margin-bottom: 5rem; }
    .team-grid {
      display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;
    }
    .team-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border);
      border-radius: 20px; padding: 1.75rem 1.25rem;
      text-align: center;
      transition: transform .2s, box-shadow .2s;
    }
    html[data-theme='dark'] .team-card {
      background: #151a22; border-color: #2a313c;
    }
    .team-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.07); }
    .team-avatar {
      width: 72px; height: 72px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-family: var(--font-display); font-size: 1.75rem; font-weight: 900;
      color: #fff; margin: 0 auto 1rem;
      box-shadow: 0 8px 24px rgba(0,0,0,.2);
    }
    .team-name {
      font-family: var(--font-display); font-size: 1.05rem; font-weight: 700;
      color: var(--color-primary); margin: 0 0 .25rem;
    }
    html[data-theme='dark'] .team-name { color: #f4f7fb; }
    .team-role {
      font-size: .78rem; font-weight: 700; letter-spacing: .8px;
      text-transform: uppercase; color: var(--color-secondary); margin: 0 0 .65rem;
    }
    .team-bio { font-size: .88rem; line-height: 1.65; color: var(--color-text-light); margin: 0; }
    html[data-theme='dark'] .team-bio { color: #8f98a7; }

    /* Stats */
    .stats-bar {
      background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
      border-radius: 24px; padding: 3rem 2.5rem;
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 2rem; margin-bottom: 5rem;
      position: relative; overflow: hidden;
    }
    .stats-bar::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(ellipse at 50% 0%, rgba(200,16,46,0.15), transparent 60%);
      pointer-events: none;
    }
    .stats-bar::after {
      content: ''; position: absolute;
      top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, #c8102e, #d4af37, #c8102e);
    }
    .stat-item { text-align: center; position: relative; }
    .stat-number {
      font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 900; color: #fff; line-height: 1; margin-bottom: .4rem;
    }
    .stat-number em { font-style: normal; color: var(--color-accent); }
    .stat-label {
      font-size: .8rem; font-weight: 600; letter-spacing: 1px;
      text-transform: uppercase; color: rgba(255,255,255,.5);
    }

    /* CTA */
    .about-cta {
      text-align: center; padding: 3.5rem 2rem;
      background: var(--color-surface);
      border: 1px solid var(--color-border); border-radius: 24px;
    }
    html[data-theme='dark'] .about-cta { background: #151a22; border-color: #2a313c; }
    .about-cta-title {
      font-family: var(--font-display); font-size: clamp(1.6rem, 3vw, 2.4rem);
      font-weight: 900; color: var(--color-primary); margin: 0 0 .75rem;
    }
    html[data-theme='dark'] .about-cta-title { color: #f4f7fb; }
    .about-cta-sub { font-size: 1rem; color: var(--color-text-light); margin: 0 0 2rem; }
    html[data-theme='dark'] .about-cta-sub { color: #8f98a7; }
    .about-cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary {
      display: inline-flex; align-items: center; gap: .5rem;
      background: linear-gradient(90deg, #c8102e, #a30c26);
      color: #fff; font-weight: 800; font-size: .95rem;
      padding: .85rem 2rem; border-radius: 999px;
      text-decoration: none; transition: filter .2s, transform .15s;
    }
    .btn-primary:hover { filter: brightness(1.1); transform: translateY(-2px); color: #fff; }
    .btn-outline {
      display: inline-flex; align-items: center; gap: .5rem;
      border: 2px solid var(--color-border);
      color: var(--color-primary); font-weight: 800; font-size: .95rem;
      padding: .85rem 2rem; border-radius: 999px;
      text-decoration: none; transition: border-color .2s, background .2s, color .2s, transform .15s;
    }
    .btn-outline:hover {
      border-color: var(--color-primary); background: var(--color-primary);
      color: #fff; transform: translateY(-2px);
    }
    html[data-theme='dark'] .btn-outline {
      border-color: #2a313c; color: #f4f7fb;
    }
    html[data-theme='dark'] .btn-outline:hover {
      border-color: #f4f7fb; background: rgba(255,255,255,.08); color: #f4f7fb;
    }

    /* Responsive */
    @media (max-width: 960px) {
      .mission-block { grid-template-columns: 1fr; gap: 2.5rem; }
      .mission-visual { aspect-ratio: 16/7; }
      .values-grid { grid-template-columns: repeat(2, 1fr); }
      .team-grid { grid-template-columns: repeat(2, 1fr); }
      .stats-bar { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
      .values-grid { grid-template-columns: 1fr; }
      .team-grid { grid-template-columns: repeat(2, 1fr); }
      .stats-bar { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; padding: 2rem 1.25rem; }
      .about-cta-btns { flex-direction: column; align-items: center; }
    }
  </style>
</head>
<body data-page="<?= htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8') ?>">

  <?php require_once 'nav.php'; ?>

  <!-- HERO -->
  <section class="about-hero">
    <div class="about-hero-eyebrow">Our Story</div>
    <h1 class="about-hero-title">Independent Journalism<br><em>You Can Trust</em></h1>
    <p class="about-hero-sub">UrbanPulse was founded in 2026 with a single conviction — that truthful, fearless reporting should be accessible to everyone, everywhere.</p>
    <div class="about-hero-accent">
      <span></span>
      <strong>FEEL THE RIPPLE!</strong>
      <span></span>
    </div>
  </section>

  <div class="about-body">

    <!-- MISSION -->
    <div class="mission-block">
      <div>
        <span class="mission-kicker">Our Mission</span>
        <h2 class="mission-title">Delivering Truth in Every Story Since 2026</h2>
        <p class="mission-body">
          UrbanPulse is an independent digital newsroom committed to factual, balanced, and timely journalism. We cover technology, sports, entertainment, and world affairs with the same rigor — because every beat matters, and every reader deserves the full picture.
        </p>
        <p class="mission-body" style="margin-top:1rem;">
          We believe the pulse of a city — and a nation — lives in its stories. Our reporters dig deeper, verify harder, and write with clarity so that you never have to wonder if what you're reading is real.
        </p>
      </div>
      <div class="mission-visual">
        <div class="mission-visual-bar"></div>
        <div class="mission-visual-inner">
          <div class="mission-visual-logo">UrbanPulse</div>
          <div class="mission-visual-tag">Feel the Ripple!</div>
        </div>
      </div>
    </div>

    <!-- STATS -->
    <div class="stats-bar">
      <div class="stat-item">
        <div class="stat-number">250<em>K+</em></div>
        <div class="stat-label">Monthly Readers</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">5</div>
        <div class="stat-label">Coverage Verticals</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">100<em>%</em></div>
        <div class="stat-label">Independent</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">2026</div>
        <div class="stat-label">Founded</div>
      </div>
    </div>

    <!-- VALUES -->
    <div class="values-section">
      <div class="section-header-row">
        <div>
          <div class="section-kicker">What We Stand For</div>
          <h2 class="section-title">Our Core Values</h2>
        </div>
      </div>
      <div class="values-grid">
        <div class="value-card">
          <span class="value-icon">🎯</span>
          <h3 class="value-title">Accuracy First</h3>
          <p class="value-text">Every claim we publish is verified through multiple independent sources. If we're not certain, we say so — and we correct the record when we're wrong.</p>
        </div>
        <div class="value-card">
          <span class="value-icon">⚖️</span>
          <h3 class="value-title">Editorial Independence</h3>
          <p class="value-text">No advertiser, sponsor, or political interest dictates our coverage. UrbanPulse is editorially autonomous — always has been, always will be.</p>
        </div>
        <div class="value-card">
          <span class="value-icon">🌐</span>
          <h3 class="value-title">Open Access</h3>
          <p class="value-text">Quality journalism should not be gated. Our core reporting is free for all readers because an informed public is a healthier society.</p>
        </div>
        <div class="value-card">
          <span class="value-icon">🔍</span>
          <h3 class="value-title">Accountability</h3>
          <p class="value-text">We hold institutions and leaders to account — and we hold ourselves to the same standard. Our corrections policy is public and our sourcing is transparent.</p>
        </div>
        <div class="value-card">
          <span class="value-icon">🤝</span>
          <h3 class="value-title">Community Focus</h3>
          <p class="value-text">The ripple effect starts locally. We prioritize stories that matter to the communities we serve, not just the headlines that trend online.</p>
        </div>
        <div class="value-card">
          <span class="value-icon">🚀</span>
          <h3 class="value-title">Forward Thinking</h3>
          <p class="value-text">We embrace new storytelling formats, data journalism, and reader interactivity — evolving how news is told without compromising on what makes it trustworthy.</p>
        </div>
      </div>
    </div>

    <!-- TEAM -->
    <div class="team-section">
      <div class="section-header-row">
        <div>
          <div class="section-kicker">The People Behind the Pulse</div>
          <h2 class="section-title">Meet the Team</h2>
        </div>
      </div>
      <div class="team-grid">
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#c8102e,#a30c26);">M</div>
          <div class="team-name">Matthew Reyes</div>
          <div class="team-role">Editor-in-Chief</div>
          <p class="team-bio">Leads editorial strategy and oversees all coverage verticals. Former broadcast journalist with 8 years in digital media.</p>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#0066cc,#004fa3);">S</div>
          <div class="team-name">Sofia Cruz</div>
          <div class="team-role">Tech Editor</div>
          <p class="team-bio">Covers AI, hardware, and the intersection of technology and society. Graduate of UMak School of Communications.</p>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#ff6b35,#d4520f);">J</div>
          <div class="team-name">James Pratt</div>
          <div class="team-role">Sports Desk</div>
          <p class="team-bio">Beat reporter covering local and international sports leagues. Known for sharp game analysis and player profiles.</p>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#9b59b6,#7d3c98);">A</div>
          <div class="team-name">Anika Vargas</div>
          <div class="team-role">Entertainment</div>
          <p class="team-bio">From box office trends to celebrity culture, Anika brings context and critique to the stories behind the glamour.</p>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <div class="about-cta">
      <h2 class="about-cta-title">Stay Connected to the Pulse</h2>
      <p class="about-cta-sub">Create a free account to comment, react, and get personalized alerts on the stories that matter to you.</p>
      <div class="about-cta-btns">
        <a href="register.php" class="btn-primary">📰 Register Free</a>
        <a href="contact.php" class="btn-outline">✉️ Contact Us</a>
      </div>
    </div>

  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-container" style="max-width:1280px;margin:0 auto;">
      <div class="footer-content">
        <div class="footer-section"><h4>UrbanPulse</h4><p>Independent journalism you can trust. Delivering truth in every story since 2026.</p></div>
        <div class="footer-section"><h4>Navigate</h4><ul><li><a href="home.php">Home</a></li><li><a href="technology.php">Technology</a></li><li><a href="sports.php">Sports</a></li><li><a href="entertainment.php">Entertainment</a></li><li><a href="worldnews.php">World News</a></li></ul></div>
        <div class="footer-section"><h4>Company</h4><ul><li><a href="about.php">About Us</a></li><li><a href="contact.php">Contact</a></li></ul></div>
        <div class="footer-section" id="pledge"><h4>Pledge</h4><p>We, the UrbanPulse team, pledge to deliver news that keeps people informed, aware, and always updated.</p></div>
      </div>
      <div class="footer-bottom"><p>&copy; 2026 UrbanPulse News. All rights reserved.</p></div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="burger.js"></script>
  <script src="theme.js"></script>
  <script src="search.js"></script>
  <script src="pulse-features.js"></script>
</body>
</html>