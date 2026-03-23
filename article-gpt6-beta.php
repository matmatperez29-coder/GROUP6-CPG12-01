<?php
require_once 'db.php';
require_once 'auth.php'; // This also starts the session and connects to the DB
$currentUser = getCurrentUser(); // Returns user data if logged in, or null if not
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>GPT-6 Early Beta: Users Report "Near-Human" Emotional Reasoning — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="GPT-6 Early Beta: Users Report "Near-Human" Emotional Reasoning">
  <meta property="og:description" content="Early testers of the GPT-6 model have documented instances of the AI exhibiting sophisticated emotional intelligence and nuanced ethical reasoning.">
  <meta property="og:image" content="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=900&auto=format&fit=crop">
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

  <?php require_once 'nav.php'; ?>



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
          <p class="hero-subheadlines" style="color:#0066cc">TECHNOLOGY</p>
          <h1 class="hero-title">GPT-6 Early Beta: Users Report "Near-Human" Emotional Reasoning</h1>
          <div class="hero-meta">
            <strong>Julian Vane</strong>
            <span>UrbanPulse.com</span>
            <span>February 18, 2026 · 2:15 PM EST</span>
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
            <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=900&auto=format&fit=crop" alt="GPT-6 Early Beta: Users Report "Near-Human" Emotional Reasoning" loading="lazy">
          </div>
          <p class="hero-summary">Early testers of the GPT-6 model have documented instances of the AI exhibiting sophisticated emotional intelligence and nuanced ethical reasoning.</p>
          <div class="hero-description">Early testers of OpenAI's GPT-6 model have documented unprecedented instances of the AI exhibiting sophisticated emotional intelligence that, in some cases, testers describe as indistinguishable from human empathy. The reports have sent shockwaves through the AI research community and reignited fundamental questions about the nature of machine consciousness.<br><br>In one widely-shared transcript, a user described being talked through a difficult personal decision by the model. "It didn't just give me advice — it acknowledged my fear, reframed my perspective, and challenged my assumptions in a way that felt genuinely caring," the tester wrote. "I cried. I'm not sure what that means."<br><br>OpenAI maintains a cautious position. In an official statement, the company emphasized that these behaviors represent "highly sophisticated pattern-matching and probabilistic language generation, not evidence of consciousness or genuine emotional experience."<br><br>Ethicists and AI researchers are not so easily reassured. Dr. Elena Costas of MIT's AI Ethics Lab argues that the distinction between "simulating" and "having" emotional intelligence may be philosophically meaningless from a practical standpoint. "If a system consistently produces outcomes that require emotional intelligence to generate, the question of whether it truly 'feels' becomes secondary to the question of how we treat it," she said.<br><br>The European Union's AI Oversight Board has already requested a briefing from OpenAI, citing concerns about the model's potential impact on mental health services and therapeutic contexts.</div>

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
            <a class="news-related-container" href="article-ai-agentic-revolution.php">
          <div class="news-related-image"><img src="https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=100&auto=format&fit=crop" alt="The Transition to Agentic AI and Autonomous Systems"></div>
          <span class="news-related-headline">The Transition to Agentic AI and Autonomous Systems</span>
        </a><a class="news-related-container" href="article-australia-ai.php">
          <div class="news-related-image"><img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=100&auto=format&fit=crop" alt="Australia Launches Secure Sovereign AI Factory"></div>
          <span class="news-related-headline">Australia Launches Secure Sovereign AI Factory</span>
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
            <div class="sidebar-image"><img src="https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=300&auto=format&fit=crop" alt="Quantum Materials: True 1D Electron Behavior" loading="lazy"></div>
            <div class="sidebar-story1">
              <a href="article-quantum.php"><h3 class="sidebar-headline">Quantum Materials: True 1D Electron Behavior</h3></a>
              <span class="sidebar-category">Technology</span>
              <div class="sidebar-meta">
                <button class="sidebar-share">FB SHARE</button>
                <button class="sidebar-tweet">TWEET</button>
              </div>
            </div>
          </div><div class="sidebar-story">
            <div class="sidebar-image"><img src="https://images.unsplash.com/photo-1512054502232-10a0a035d672?w=300&auto=format&fit=crop" alt="Infinix NOTE 60: Revolutionary Battery Tech" loading="lazy"></div>
            <div class="sidebar-story1">
              <a href="article-infinix.php"><h3 class="sidebar-headline">Infinix NOTE 60: Revolutionary Battery Tech</h3></a>
              <span class="sidebar-category">Technology</span>
              <div class="sidebar-meta">
                <button class="sidebar-share">FB SHARE</button>
                <button class="sidebar-tweet">TWEET</button>
              </div>
            </div>
          </div><div class="sidebar-story">
            <div class="sidebar-image"><img src="https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=300&auto=format&fit=crop" alt="Eagles Triumph in Super Bowl LIX" loading="lazy"></div>
            <div class="sidebar-story1">
              <a href="article-eagles-super-bowl.php"><h3 class="sidebar-headline">Eagles Triumph in Super Bowl LIX</h3></a>
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
    const UP_IS_ADMIN     = <?php echo ($currentUser && $currentUser['role'] === 'admin') ? 'true' : 'false'; ?>;
</script>
<script src="article-interactions.js"></script>
</body>
</html>