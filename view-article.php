<?php
require_once 'db.php';
require_once 'auth.php';

$db  = getDB();
$id  = (int)($_GET['id'] ?? 0);
$currentUser = getCurrentUser();

if (!$id) { header('Location: home.php'); exit; }

$isAdmin = ($currentUser && $currentUser['role'] === 'admin') ? 'admin' : 'reader';
$stmt = $db->prepare("
    SELECT s.*, u.name as author_name, u.avatar_color, u.username as author_username
    FROM article_submissions s
    JOIN users u ON s.author_id = u.id
    WHERE s.id = ? AND (s.status = 'approved' OR ? = 'admin')
");
$stmt->execute([$id, $isAdmin]);
$article = $stmt->fetch();

if (!$article) {
    http_response_code(404);
    require_once 'db.php'; require_once 'auth.php';
    ?><!DOCTYPE html><html lang="en"><head><title>Not Found — UrbanPulse</title>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="navfooter.css"><link rel="stylesheet" href="home.css">
    </head><body><?php require_once 'nav.php'; ?>
    <div style="text-align:center;padding:5rem 1rem;">
      <div style="font-size:4rem;margin-bottom:1rem;">📭</div>
      <h1 style="font-family:serif;margin-bottom:.5rem;">Article Not Found</h1>
      <p style="color:#666;margin-bottom:1.5rem;">This article doesn't exist or hasn't been approved yet.</p>
      <a href="home.php" style="background:#c8102e;color:white;padding:.75rem 1.5rem;border-radius:8px;text-decoration:none;font-weight:700;">Go Home</a>
    </div></body></html><?php exit;
}

$catColors = ['technology'=>'#0066cc','sports'=>'#ff6b35','entertainment'=>'#9b59b6','worldnews'=>'#27ae60'];
$ARTICLE_ID = 'submission-' . $article['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= htmlspecialchars($article['title']) ?> — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="<?= htmlspecialchars($article['title']) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($article['summary']) ?>">
  <?php if ($article['image_url']): ?><meta property="og:image" content="<?= htmlspecialchars($article['image_url']) ?>"><?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="burgermenu.css">
  <link rel="stylesheet" href="article.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    #searchBox:empty::before{content:attr(data-placeholder);color:#aaa;font-style:italic;pointer-events:none;}
    #searchBox:focus{outline:none;}
    #searchBox::-webkit-scrollbar{display:none;}
    .search-bar-inner{display:flex!important;align-items:center!important;gap:1rem!important;padding:.85rem 2rem!important;width:100%!important;background:#fff!important;}
  </style>
</head>
<body>

<?php require_once 'nav.php'; ?>

<?php if ($article['status'] !== 'approved' && $isAdmin === 'admin'): ?>
<div style="background:#d97706;color:white;text-align:center;padding:.65rem;font-size:.85rem;font-weight:700;">
  ⚠️ Admin Preview — Status: <strong><?= strtoupper($article['status']) ?></strong> — not visible to public.
  <a href="admin.php" style="color:white;text-decoration:underline;margin-left:.75rem;">Back to Admin Panel →</a>
</div>
<?php endif; ?>

<main class="article-page">
  <div class="article-container">

    <div class="hero-news">
      <article>

        <p class="hero-subheadlines" style="color:<?= $catColors[$article['category']] ?>">
          <?= htmlspecialchars(ucfirst($article['category'])) ?>
        </p>

        <h1 class="hero-title"><?= htmlspecialchars($article['title']) ?></h1>

        <div class="hero-meta">
          <span style="width:28px;height:28px;border-radius:50%;background:<?= htmlspecialchars($article['avatar_color']) ?>;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:.75rem;flex-shrink:0;">
            <?= strtoupper(substr($article['author_name'],0,1)) ?>
          </span>
          <strong><?= htmlspecialchars($article['author_name']) ?></strong>
          <span>· UrbanPulse.com ·</span>
          <span><?= date('F j, Y', strtotime($article['submitted_at'])) ?></span>
        </div>

        <!-- SHARE BAR -->
        <div class="share-bar" style="margin-bottom:1.5rem;">
          <span class="share-label">Share:</span>
          <a class="share-btn fb" href="#" title="Share on Facebook">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> Facebook
          </a>
          <a class="share-btn tw" href="#" title="Tweet">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg> Tweet
          </a>
          <button class="share-btn copy">🔗 Copy Link</button>
          <span class="share-toast">Link copied!</span>
        </div>

        <?php if ($article['image_url']): ?>
        <div class="hero-image">
          <img src="<?= htmlspecialchars($article['image_url']) ?>"
               alt="<?= htmlspecialchars($article['title']) ?>" loading="lazy">
        </div>
        <?php endif; ?>

        <p class="hero-summary"><?= htmlspecialchars($article['summary']) ?></p>

        <div class="hero-description">
          <?php foreach (array_filter(explode("\n\n", trim($article['body']))) as $para): ?>
            <p style="margin-bottom:1.25rem;"><?= nl2br(htmlspecialchars(trim($para))) ?></p>
          <?php endforeach; ?>
        </div>

        <div class="section-divider"></div>

        <!-- REACTIONS -->
        <div class="reactions">
          <div class="reactions-title">How do you feel about this article?</div>
          <div class="reaction-buttons"></div>
        </div>

        <div class="section-divider"></div>

        <!-- COMMENTS -->
        <div class="comments-section">
          <div class="comments-heading">
            COMMENTS <span class="comment-count-badge" style="display:none">0</span>
          </div>

          <?php if ($currentUser): ?>
          <form class="comment-form" id="commentForm">
            <textarea id="commentText"
              placeholder="Share your thoughts, <?= htmlspecialchars(explode(' ',$currentUser['name'])[0]) ?>…"
              required></textarea>
            <div id="charCount" class="comment-char-count">500 characters remaining</div>
            <button type="submit" class="comment-submit" style="margin-top:.75rem;">Post Comment</button>
          </form>
          <?php else: ?>
          <div id="commentLoginNotice" style="background:#fff8f0;border:1px solid #ffe0b2;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;text-align:center;">
            <p style="margin:0 0 1rem;font-size:.9rem;color:#666;">
              <strong style="color:#1a1a1a;">Want to join the conversation?</strong><br>
              Sign in or create a free account to comment and react.
            </p>
            <div style="display:flex;gap:.75rem;justify-content:center;">
              <a href="login.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>" style="padding:.6rem 1.25rem;background:#c8102e;color:#fff;border-radius:6px;font-weight:700;font-size:.875rem;text-decoration:none;">Sign In</a>
              <a href="register.php" style="padding:.6rem 1.25rem;border:2px solid #e0e0e0;color:#1a1a1a;border-radius:6px;font-weight:700;font-size:.875rem;text-decoration:none;">Register Free</a>
            </div>
          </div>
          <?php endif; ?>

          <div class="comment-list" id="commentList"></div>
        </div>

      </article>
    </div>

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <?php
      $moreSub = $db->prepare("
          SELECT id, title, category, submitted_at FROM article_submissions
          WHERE author_id = ? AND status = 'approved' AND id != ?
          ORDER BY submitted_at DESC LIMIT 3
      ");
      $moreSub->execute([$article['author_id'], $article['id']]);
      $moreArticles = $moreSub->fetchAll();
      ?>
      <?php if (!empty($moreArticles)): ?>
      <div>
        <h3 class="sidebar-heading">More from <?= htmlspecialchars(explode(' ',$article['author_name'])[0]) ?></h3>
        <div class="sidebar-stories">
          <?php foreach ($moreArticles as $m): ?>
          <div class="sidebar-story">
            <div class="sidebar-story1">
              <a href="view-article.php?id=<?= $m['id'] ?>">
                <h3 class="sidebar-headline"><?= htmlspecialchars($m['title']) ?></h3>
              </a>
              <span class="sidebar-category" style="background:<?= $catColors[$m['category']] ?>">
                <?= ucfirst($m['category']) ?>
              </span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

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
            <span class="soc-box">f</span><span class="soc-box">G</span>
            <span class="soc-box">A</span><span class="soc-box">M</span>
          </div>
        </div>
      </div>
    </aside>

  </div>
</main>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-content">
      <div class="footer-section"><h3>UrbanPulse</h3><p>Independent journalism you can trust. Delivering truth in every story since 2026.</p>
        <div class="footer-social"><a href="#">FB</a><a href="#">TW</a><a href="#">IG</a></div>
      </div>
      <div class="footer-section"><h4>Categories</h4><ul>
        <li><a href="technology.php">Technology</a></li><li><a href="sports.php">Sports</a></li>
        <li><a href="entertainment.php">Entertainment</a></li><li><a href="worldnews.php">World News</a></li>
      </ul></div>
      <div class="footer-section"><h4>Company</h4><ul>
        <li><a href="about.php">About Us</a></li><li><a href="contact.php">Contact</a></li>
      </ul></div>
      <div class="footer-section"><h4>Pledge</h4><p>We deliver news that keeps people informed, aware, and always updated.</p></div>
    </div>
    <div class="footer-bottom"><p>&copy; 2026 UrbanPulse News. All rights reserved.</p></div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="burger.js"></script>
<script src="search.js"></script>
<script>const UP_IS_LOGGED_IN = <?= $currentUser ? 'true' : 'false' ?>;
    const UP_IS_ADMIN     = <?= ($currentUser && $currentUser['role'] === 'admin') ? 'true' : 'false' ?>;</script>
<script src="article-interactions.js"></script>
</body>
</html>