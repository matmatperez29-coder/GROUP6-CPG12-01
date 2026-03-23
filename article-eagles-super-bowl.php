<?php
require_once 'db.php';
require_once 'auth.php'; // This also starts the session and connects to the DB
$currentUser = getCurrentUser(); // Returns user data if logged in, or null if not
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Philadelphia Eagles Triumph in Super Bowl LIX — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="Philadelphia Eagles Triumph in Super Bowl LIX">
  <meta property="og:description" content="The Philadelphia Eagles claimed their second franchise championship, defeating the Kansas City Chiefs 40–22 at the Caesars Superdome in New Orleans.">
  <meta property="og:image" content="https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=900&auto=format&fit=crop">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="burgermenu.css">
  <link rel="stylesheet" href="article.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
</head>
<body>

  <div class="BreakingNews">
    <span class="BreakingNewsLabel">Breaking News</span>
    <div class="BreakingNewsContent"><span class="BreakingNewsItem">UMak HSU Filipino Radio Broadcasting Won Championship in DSPC</span><span class="BreakingNewsItem">UMak HSU English Radio Broadcasting placed 2nd in DSPC</span><span class="BreakingNewsItem">Eagles defeat Chiefs 40-22 in Super Bowl LIX</span><span class="BreakingNewsItem">Mars Base Alpha reports first successful greenhouse harvest</span><span class="BreakingNewsItem">UMak HSU Filipino Radio Broadcasting Won Championship in DSPC</span><span class="BreakingNewsItem">UMak HSU English Radio Broadcasting placed 2nd in DSPC</span><span class="BreakingNewsItem">Eagles defeat Chiefs 40-22 in Super Bowl LIX</span><span class="BreakingNewsItem">Mars Base Alpha reports first successful greenhouse harvest</span></div>
  </div>

  <header class="header-main">
    <div class="header-container">
      <div class="header-left">
        <button type="button" class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-controls="burgerMenu" aria-expanded="false">
          <span class="burger-icon" aria-hidden="true"><span></span><span></span><span></span></span>
        </button>
        <a href="home.php" class="header-logo">
          <h1>UrbanPulse</h1>
          <p class="header-logo-tagline">Feel the Ripple!</p>
        </a>
      </div>
      <nav class="main-nav">
        <a href="home.php">Home</a>
        <a href="technology.php">Technology</a>
        <a href="sports.php">Sports</a>
        <a href="entertainment.php">Entertainment</a>
        <a href="worldnews.php">World News</a>
      </nav>
      <div class="header-right">
    <?php if ($currentUser): ?>
        <div class="header-user-profile" style="display: flex; align-items: center; gap: 0.5rem;">
            <div class="user-avatar" style="
                width: 32px; 
                height: 32px; 
                border-radius: 50%; 
                background-color: <?= htmlspecialchars($currentUser['avatar_color']) ?>; 
                color: white; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                font-weight: 800; 
                font-size: 0.9rem;">
                <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
            </div>
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-primary);">
                Hi, <?= htmlspecialchars(explode(' ', $currentUser['name'])[0]) ?>!
            </span>
        </div>

        <div class="header-right-divider"></div>

        <div class="header-subscription">
            <a href="logout.php" style="color: var(--color-secondary);">Log Out</a>
        </div>

    <?php else: ?>
        <a href="login.php" class="header-login">
            <img src="assets/user-icon.svg" alt="Sign In" style="width: 24px; height: 24px;"> 
        </a>
        
        <div class="header-right-divider"></div>
        
        <div class="header-subscription">
            <a href="subscription.php">Subscribe</a>
        </div>
    <?php endif; ?>
</div>
    </div>
  </header>

  <div class="search-bar-drop" id="searchBarDrop" aria-hidden="true">
    <div class="search-bar-inner">
      <div id="searchBox" role="searchbox" contenteditable="true" aria-label="Search UrbanPulse" data-placeholder="Enter search item" spellcheck="false"></div>
      <button class="search-bar-close" id="searchClose" aria-label="Close search">&#10005;</button>
    </div>
    <div id="results" class="search-bar-results"></div>
  </div>

  <main class="article-page">
    <div class="article-container">

      <div class="hero-news">
        <article>
          <p class="hero-subheadlines" style="color:#ff6b35">SPORTS</p>
          <h1 class="hero-title">Philadelphia Eagles Triumph in Super Bowl LIX</h1>
          <div class="hero-meta">
            <strong>Marcus Thompson</strong>
            <span>UrbanPulse.com</span>
            <span>February 9, 2025 · 6:30 PM EST</span>
          </div>

          <!-- SHARE BAR -->
          <div class="share-bar" style="margin-bottom:1.5rem">
            <span class="share-label">Share:</span>
            <a class="share-btn fb" href="#" title="Share on Facebook">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> Facebook
            </a>
            <a class="share-btn tw" href="#" title="Share on Twitter">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg> Tweet
            </a>
            <button class="share-btn copy">🔗 Copy Link</button>
            <span class="share-toast">Link copied!</span>
          </div>

          <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=900&auto=format&fit=crop" alt="Philadelphia Eagles Triumph in Super Bowl LIX" loading="lazy">
          </div>
          <p class="hero-summary">The Philadelphia Eagles claimed their second franchise championship, defeating the Kansas City Chiefs 40–22 at the Caesars Superdome in New Orleans.</p>
          <div class="hero-description">The Philadelphia Eagles delivered a masterclass in defensive dominance at Super Bowl LIX, defeating the Kansas City Chiefs 40–22 at the Caesars Superdome in New Orleans. The victory denied the Chiefs a historic "three-peat" and served as a deeply redemptive moment for Philadelphia.<br><br>The Eagles' retooled defensive line was the story of the night. They sacked Patrick Mahomes six times, forcing him into uncharacteristic mistakes and intercepting him twice. Mahomes completed just 58% of his passes for 257 yards — well below his playoff average.<br><br>On offense, quarterback Jalen Hurts was clinical and composed, throwing for 221 yards and two touchdowns while adding 51 rushing yards. Saquon Barkley was explosive in his first Super Bowl appearance, racking up 142 total yards and a touchdown. A.J. Brown added two catches for 67 yards, including a spectacular 43-yard gain in the third quarter that broke the game open.<br><br>"This team never doubted itself," Eagles head coach Nick Sirianni said in the post-game press conference. "We knew what we were capable of, and tonight we showed the world."<br><br>Philadelphia's streets erupted in celebration immediately following the final whistle, with fans flooding Broad Street in scenes reminiscent of their 2018 championship victory.</div>

          <div class="section-divider"></div>

          <!-- REACTIONS -->
          <div class="reactions">
            <div class="reactions-title">How do you feel about this article?</div>
            <div class="reaction-buttons">
              <!-- populated by JS -->
            </div>
          </div>

          <div class="section-divider"></div>

          <!-- RELATED STORIES -->
          <div class="news-related">
            <h5 class="news-related-title">RELATED STORIES</h5>
            <a class="news-related-container" href="article-okc-thunder.php">
          <div class="news-related-image"><img src="https://images.unsplash.com/photo-1546519638405-a4d4e8df12b5?w=100&auto=format&fit=crop" alt="OKC Thunder Win First NBA Title in 46 Years"></div>
          <span class="news-related-headline">OKC Thunder Win First NBA Title in 46 Years</span>
        </a><a class="news-related-container" href="article-dodgers.php">
          <div class="news-related-image"><img src="https://images.unsplash.com/photo-1508344928928-7165b67de128?w=100&auto=format&fit=crop" alt="Dodgers Repeat as World Series Champions"></div>
          <span class="news-related-headline">Dodgers Repeat as World Series Champions</span>
        </a>
          </div>

          <div class="section-divider"></div>

          <!-- COMMENTS -->
          <div class="comments-section">
    <h3 class="comments-heading">
        Leave a Comment <span class="comment-count-badge" style="display:none">0</span>
    </h3>

    <?php if ($currentUser): ?>
        <form id="commentForm" class="comment-form">
            <div class="form-group" style="margin-bottom: 0;">
                <textarea id="commentText" placeholder="Share your thoughts, <?= htmlspecialchars(explode(' ', $currentUser['name'])[0]) ?>..." required></textarea>
                <div id="charCount" class="comment-char-count">500 characters remaining</div>
            </div>
            <button type="submit" class="comment-submit" style="margin-top: 0.75rem;">Post Comment</button>
        </form>
    <?php else: ?>
        <div class="comment-form" style="text-align: center; padding: 2.5rem 1rem; background: var(--color-surface); border: 1px dashed var(--color-border);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-text-muted)" stroke-width="1.5" style="margin-bottom: 1rem;">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <h4 style="font-family: var(--font-display); color: var(--color-primary); margin-bottom: 0.5rem;">Join the Conversation</h4>
            <p style="font-size: 0.9rem; color: var(--color-text-light); margin-bottom: 1.5rem;">You must be logged in to leave a comment or react to this article.</p>
            <a href="login.php" class="comment-submit" style="text-decoration: none; display: inline-block;">Log In or Register</a>
        </div>
    <?php endif; ?>

    <div id="commentList" class="comment-list">
        </div>
</div>

        </article>
      </div>

      <!-- SIDEBAR -->
      <aside class="sidebar">
        <h3 class="sidebar-heading">Recommended</h3>
        <div class="sidebar-stories">
          <div class="sidebar-story">
            <div class="sidebar-image"><img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=300&auto=format&fit=crop" alt="PSG Claims Maiden Champions League Trophy" loading="lazy"></div>
            <div class="sidebar-story1">
              <a href="article-psg.php"><h3 class="sidebar-headline">PSG Claims Maiden Champions League Trophy</h3></a>
              <span class="sidebar-category">Sports</span>
              <div class="sidebar-meta">
                <button class="sidebar-share">FB SHARE</button>
                <button class="sidebar-tweet">TWEET</button>
              </div>
            </div>
          </div><div class="sidebar-story">
            <div class="sidebar-image"><img src="https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?w=300&auto=format&fit=crop" alt="Jannik Sinner and Iga Świątek Rule Wimbledon" loading="lazy"></div>
            <div class="sidebar-story1">
              <a href="article-wimbledon.php"><h3 class="sidebar-headline">Jannik Sinner and Iga Świątek Rule Wimbledon</h3></a>
              <span class="sidebar-category">Sports</span>
              <div class="sidebar-meta">
                <button class="sidebar-share">FB SHARE</button>
                <button class="sidebar-tweet">TWEET</button>
              </div>
            </div>
          </div><div class="sidebar-story">
            <div class="sidebar-image"><img src="https://images.unsplash.com/photo-1546519638405-a4d4e8df12b5?w=300&auto=format&fit=crop" alt="OKC Thunder Win First NBA Title in 46 Years" loading="lazy"></div>
            <div class="sidebar-story1">
              <a href="article-okc-thunder.php"><h3 class="sidebar-headline">OKC Thunder Win First NBA Title in 46 Years</h3></a>
              <span class="sidebar-category">Sports</span>
              <div class="sidebar-meta">
                <button class="sidebar-share">FB SHARE</button>
                <button class="sidebar-tweet">TWEET</button>
              </div>
            </div>
          </div>
        </div>

        <div class="roundup-section">
          <h2>Independent News</h2>
          <p>Independent journalism you can trust.</p>
          <form class="roundup-form" onsubmit="return false">
            <input type="email" placeholder="Your Email Address">
            <button type="submit">SIGN-UP</button>
          </form>
          <div class="roundup-help">Please enter a valid email address.</div>
          <div class="roundup-social">
            <p>or sign in with</p>
            <div class="social-row">
              <span class="soc-box">f</span>
              <span class="soc-box">G</span>
              <span class="soc-box">A</span>
              <span class="soc-box">M</span>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </main>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>UrbanPulse</h3>
          <p>Independent journalism you can trust. Delivering truth in every story since 2026.</p>
          <div class="footer-social">
            <a href="#" aria-label="Facebook">FB</a>
            <a href="#" aria-label="Twitter">TW</a>
            <a href="#" aria-label="Instagram">IG</a>
            <a href="#" aria-label="Github">GH</a>
          </div>
        </div>
        <div class="footer-section"><h4>Categories</h4><ul><li><a href="technology.php">Technology</a></li><li><a href="sports.php">Sports</a></li><li><a href="entertainment.php">Entertainment</a></li><li><a href="worldnews.php">World News</a></li></ul></div>
        <div class="footer-section"><h4>Company</h4><ul><li><a href="about.php">About Us</a></li><li><a href="contact.php">Contact</a></li><li><a href="#">Careers</a></li><li><a href="#">Advertise</a></li></ul></div>
        <div class="footer-section"><h4>Pledge</h4><p>We, the UrbanPulse team, pledge to deliver news that keeps people informed, aware, and always updated.</p></div>
      </div>
      <div class="footer-bottom"><p>&copy; 2026 UrbanPulse News. All rights reserved.</p></div>
    </div>
  </footer>

  <div class="menu-overlay" id="menuOverlay" hidden></div>
  <aside class="burger-menu" id="burgerMenu" aria-hidden="true" aria-label="Site menu" inert>
    <div class="burger-top">
      <button type="button" class="menu-close" id="menuClose" aria-label="Close menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="M6 6l12 12"></path></svg>
      </button>
      <div class="burger-brand"><div class="burger-logo">UrbanPulse</div><div class="burger-tagline">Feel the Ripple!</div></div>
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
    </div>
  </aside>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="burger.js"></script>
  <script src="search.js"></script>
<script>
    // Pass PHP login status to JavaScript
    const UP_IS_LOGGED_IN = <?php echo $currentUser ? 'true' : 'false'; ?>;
</script>
<script src="article-interactions.js"></script>
</body>
</html>