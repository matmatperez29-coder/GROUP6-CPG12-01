<?php
// Safety: ensure $currentUser is always available
if (!isset($currentUser)) {
    if (!function_exists('getCurrentUser')) {
        require_once __DIR__ . '/db.php';
        require_once __DIR__ . '/auth.php';
    }
    $currentUser = getCurrentUser();
}
?>
<?php
// nav.php — Shared header include
// Usage: require_once 'nav.php'; at top of every page (after auth.php)
// Requires $currentUser to already be set
?>
  <!-- BREAKING NEWS -->
  <div class="BreakingNews">
    <span class="BreakingNewsLabel">Breaking News</span>
    <div class="BreakingNewsContent">
      <span class="BreakingNewsItem">UMak HSU Filipino Radio Broadcasting Won Championship in DSPC</span>
      <span class="BreakingNewsItem">UMak HSU English Radio Broadcasting placed 2nd in DSPC</span>
      <span class="BreakingNewsItem">UMak HSU Filipibo RB will be fighting in RSPC NCR</span>
      <span class="BreakingNewsItem">Eagles defeat Chiefs 40-22 in Super Bowl LIX</span>
      <span class="BreakingNewsItem">Mars Base Alpha reports first successful greenhouse harvest</span>
      <span class="BreakingNewsItem">UMak HSU Filipino Radio Broadcasting Won Championship in DSPC</span>
      <span class="BreakingNewsItem">UMak HSU English Radio Broadcasting placed 2nd in DSPC</span>
      <span class="BreakingNewsItem">UMak HSU Filipibo RB will be fighting in RSPC NCR</span>
      <span class="BreakingNewsItem">Eagles defeat Chiefs 40-22 in Super Bowl LIX</span>
      <span class="BreakingNewsItem">Mars Base Alpha reports first successful greenhouse harvest</span>
    </div>
  </div>

  <!-- HEADER -->
  <header class="header-main">
    <div class="header-container">

      <!-- LEFT: Burger + Logo -->
      <div class="header-left">
        <button type="button" class="menu-toggle" id="menuToggle"
          aria-label="Open menu" aria-controls="burgerMenu" aria-expanded="false">
          <span class="burger-icon" aria-hidden="true"><span></span><span></span><span></span></span>
        </button>
        <a href="home.php" class="header-logo">
          <h1>UrbanPulse</h1>
          <p class="header-logo-tagline">Feel the Ripple!</p>
        </a>
      </div>

      <!-- CENTER: Nav links -->
      <nav class="main-nav">
        <a href="home.php"          <?= (basename($_SERVER['PHP_SELF'])==='home.php')          ? 'class="active"':'' ?>>Home</a>
        <a href="technology.php"    <?= (basename($_SERVER['PHP_SELF'])==='technology.php')    ? 'class="active"':'' ?>>Technology</a>
        <a href="sports.php"        <?= (basename($_SERVER['PHP_SELF'])==='sports.php')        ? 'class="active"':'' ?>>Sports</a>
        <a href="entertainment.php" <?= (basename($_SERVER['PHP_SELF'])==='entertainment.php') ? 'class="active"':'' ?>>Entertainment</a>
        <a href="worldnews.php"     <?= (basename($_SERVER['PHP_SELF'])==='worldnews.php')     ? 'class="active"':'' ?>>World News</a>
      </nav>

      <!-- RIGHT: Search + User area -->
      <!-- RIGHT: all inline styles to defeat Bootstrap -->
      <div style="display:flex;align-items:center;gap:0.5rem;flex-shrink:0;">

        <!-- Pulse Alert Bell -->
        <button class="pulse-alert-trigger" id="pulseAlertToggle" type="button" aria-label="Open UrbanPulse alerts">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path>
            <path d="M10 21a2 2 0 0 0 4 0"></path>
          </svg>
          <span class="pulse-alert-badge" id="pulseAlertBadge" hidden>0</span>
        </button>

        <!-- Dark Mode Toggle -->
        <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch to dark mode" aria-pressed="false" title="Toggle dark mode">
          <span class="theme-toggle-track" aria-hidden="true">
            <span class="theme-toggle-icon theme-toggle-sun">☀</span>
            <span class="theme-toggle-thumb"></span>
            <span class="theme-toggle-icon theme-toggle-moon">☾</span>
          </span>
        </button>

        <!-- Search icon -->
        <button class="search-toggle" id="searchToggle" aria-label="Open search" aria-expanded="false"
          style="background:none;border:none;cursor:pointer;color:#666;padding:0.25rem;display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
        </button>

        <?php if ($currentUser): ?>

          <!-- Divider -->
          <span class="nav-divider"></span>

          <!-- Avatar circle -->
          <span class="nav-avatar" style="background-color:<?= htmlspecialchars($currentUser['avatar_color']) ?>">
            <?= strtoupper(substr($currentUser['name'],0,1)) ?>
          </span>

          <!-- Hi name -->
          <span class="nav-username">
            Hi, <?= htmlspecialchars(explode(' ',$currentUser['name'])[0]) ?>!
          </span>

          <?php if (in_array($currentUser['role'], ['author','admin'])): ?>
            <span class="nav-divider"></span>
            <a href="submit-article.php" class="nav-submit-btn <?= basename($_SERVER['PHP_SELF'])==='submit-article.php' ? 'nav-active-link' : '' ?>">
              ✍️ Submit
            </a>
          <?php endif; ?>

          <?php if ($currentUser['role'] === 'admin'): ?>
            <span class="nav-divider"></span>
            <a href="admin.php" class="nav-admin-btn <?= basename($_SERVER['PHP_SELF'])==='admin.php' ? 'nav-admin-btn--active' : '' ?>">
              👑 Admin
            </a>
          <?php endif; ?>

          <span class="nav-divider"></span>
          <a href="logout.php" class="nav-logout-btn">Log Out</a>

        <?php else: ?>

          <span class="nav-divider"></span>
          <span class="nav-username nav-guest">👤 Guest</span>
          <span class="nav-divider"></span>
          <a href="login.php" class="nav-signin-btn">Sign In</a>
          <span class="nav-divider"></span>
          <a href="register.php" class="nav-subscribe-btn">Subscribe</a>

        <?php endif; ?>
      </div>

    </div>
  </header>

  <!-- SEARCH DROP BAR -->
  <div class="search-bar-drop" id="searchBarDrop" aria-hidden="true">
    <div class="search-bar-inner">
      <div id="searchBox"
        role="searchbox"
        contenteditable="true"
        aria-label="Search UrbanPulse"
        data-placeholder="Enter search item"
        spellcheck="false"></div>
      <button class="search-bar-close" id="searchClose" aria-label="Close search">&#10005;</button>
    </div>
    <div id="results" class="search-bar-results"></div>
  </div>

  <!-- BURGER MENU -->
  <div class="menu-overlay" id="menuOverlay" hidden></div>
  <aside class="burger-menu" id="burgerMenu" aria-hidden="true" aria-label="Site menu" inert>
    <div class="burger-top">
      <button type="button" class="menu-close" id="menuClose" aria-label="Close menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path><path d="M6 6l12 12"></path>
        </svg>
      </button>
      <div class="burger-brand">
        <div class="burger-logo">UrbanPulse</div>
        <div class="burger-tagline">Feel the Ripple!</div>
      </div>
    </div>
    <div class="burger-body">
      <div class="burger-section">
        <div class="burger-section-title">Browse</div>
        <nav class="burger-links">
          <a class="burger-link" data-nav href="home.php">Home</a>
          <a class="burger-link" data-nav href="technology.php">Technology</a>
          <a class="burger-link" data-nav href="sports.php">Sports</a>
          <a class="burger-link" data-nav href="entertainment.php">Entertainment</a>
          <a class="burger-link" data-nav href="worldnews.php">World News</a>
        </nav>
      </div>
      <div class="burger-divider"></div>
      <?php if ($currentUser && in_array($currentUser['role'], ['author','admin'])): ?>
      <div class="burger-section">
        <div class="burger-section-title">Author</div>
        <nav class="burger-links">
          <a class="burger-link" data-nav href="submit-article.php">✍️ Submit Article</a>
          <?php if ($currentUser['role'] === 'admin'): ?>
            <a class="burger-link" data-nav href="admin.php">👑 Admin Dashboard</a>
          <?php endif; ?>
        </nav>
      </div>
      <div class="burger-divider"></div>
      <?php endif; ?>
      <div class="burger-section">
        <div class="burger-section-title">Company</div>
        <nav class="burger-links">
          <a class="burger-link" data-nav href="about.php">About</a>
          <a class="burger-link" data-nav href="contact.php">Contact</a>
        </nav>
      </div>
      <div class="burger-divider"></div>
      <div class="burger-section burger-account">
        <?php if ($currentUser): ?>
          <div class="account-row">
            <div class="account-left">
              <span class="account-dot" style="background:<?= htmlspecialchars($currentUser['avatar_color']) ?>"></span>
              <span class="account-name"><?= htmlspecialchars($currentUser['name']) ?></span>
            </div>
            <span style="font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.5);">
              <?= htmlspecialchars($currentUser['role']) ?>
            </span>
          </div>
          <a class="burger-cta" href="logout.php" style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);">LOG OUT</a>
        <?php else: ?>
          <div class="account-row">
            <div class="account-left">
              <span class="account-dot"></span>
              <span class="account-name">Guest</span>
            </div>
            <a class="account-register" href="register.php">Register</a>
          </div>
          <a class="burger-cta" href="login.php">SIGN IN</a>
        <?php endif; ?>
      </div>
    </div>
  </aside>
  <!-- PULSE ALERT DRAWER -->
  <div class="pulse-overlay" id="pulseOverlay" hidden></div>
  <div class="pulse-drawer" id="pulseDrawer" hidden aria-hidden="true">
    <div class="pulse-drawer-header">
      <div>
        <div class="pulse-drawer-eyebrow">UrbanPulse Alerts</div>
        <h2 class="pulse-drawer-title">Live Feed</h2>
      </div>
      <button class="pulse-close-btn" type="button" data-close-pulse aria-label="Close alerts">✕</button>
    </div>
    <div class="pulse-drawer-controls">
      <button class="pulse-enable-btn" id="pulseEnableNotifications" type="button">Enable browser notifications</button>
      <p class="pulse-permission-state" id="pulsePermissionState"></p>
    </div>
    <div class="pulse-alert-list" id="pulseAlertList"></div>
  </div>

  <!-- TRANSCRIPT MODAL -->
  <div class="pulse-transcript-modal" id="pulseTranscriptModal" hidden aria-hidden="true">
    <div class="pulse-transcript-shell">
      <button class="pulse-close-transcript pulse-close-btn" type="button" data-close-transcript aria-label="Close transcript">✕</button>
      <div id="pulseTranscriptContent"></div>
    </div>
  </div>