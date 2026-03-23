<?php
require_once 'db.php';
require_once 'auth.php';

// Must be logged in
if (!isLoggedIn()) {
    header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$user = getCurrentUser();

// Only authors and admins can submit
if (!in_array($user['role'], ['author', 'admin'])) {
    die('
    <!DOCTYPE html><html><head><title>Access Denied</title>
    <link rel="stylesheet" href="home.css">
    </head><body style="display:flex;align-items:center;justify-content:center;min-height:100vh;background:#f4f4f4;">
    <div style="text-align:center;background:white;padding:2.5rem;border-radius:12px;max-width:400px;">
        <div style="font-size:3rem;margin-bottom:1rem;">🚫</div>
        <h2 style="font-family:serif;margin-bottom:0.5rem;">Authors Only</h2>
        <p style="color:#666;margin-bottom:1.5rem;">Only authors can submit articles. Contact an admin to upgrade your account.</p>
        <a href="home.php" style="background:#c8102e;color:white;padding:0.75rem 1.5rem;border-radius:8px;text-decoration:none;font-weight:700;">Go Home</a>
    </div></body></html>
    ');
}

$db = getDB();
$error   = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = trim($_POST['title']     ?? '');
    $category  = trim($_POST['category']  ?? '');
    $summary   = trim($_POST['summary']   ?? '');
    $body      = trim($_POST['body']      ?? '');
    $image_url = trim($_POST['image_url'] ?? '');

    $validCats = ['technology','sports','entertainment','worldnews'];

    if (!$title || !$category || !$summary || !$body) {
        $error = 'Please fill in all required fields.';
    } elseif (!in_array($category, $validCats)) {
        $error = 'Invalid category selected.';
    } elseif (strlen($title) > 255) {
        $error = 'Title is too long (max 255 characters).';
    } elseif (strlen($summary) > 500) {
        $error = 'Summary is too long (max 500 characters).';
    } else {
        $stmt = $db->prepare('
            INSERT INTO article_submissions 
            (author_id, title, category, summary, body, image_url)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute([$user['id'], $title, $category, $summary, $body, $image_url]);
        $success = 'Your article has been submitted! An admin will review it shortly.';
    }
}

// Get this author's previous submissions
$stmt = $db->prepare('
    SELECT * FROM article_submissions 
    WHERE author_id = ? 
    ORDER BY submitted_at DESC 
    LIMIT 10
');
$stmt->execute([$user['id']]);
$mySubmissions = $stmt->fetchAll();

$catColors = [
    'technology'    => '#0066cc',
    'sports'        => '#ff6b35',
    'entertainment' => '#9b59b6',
    'worldnews'     => '#27ae60',
];
$statusColors = [
    'pending'  => '#d97706',
    'approved' => '#16a34a',
    'declined' => '#c8102e',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Submit Article — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="home.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    body { background: #f4f4f4; }
    .submit-page { max-width: 860px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
    .submit-header { margin-bottom: 2rem; }
    .submit-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 0.25rem; }
    .submit-header p { color: #666; font-size: 0.95rem; }
    .submit-box { background: white; border: 1px solid #e0e0e0; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; }
    .form-field { display: flex; flex-direction: column; gap: 0.45rem; margin-bottom: 1.25rem; }
    .form-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #666; }
    .form-label span { color: #c8102e; } /* required star */
    .form-input, .form-select, .form-textarea { border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 0.75rem 1rem; font-size: 0.95rem; font-family: 'Source Sans 3', sans-serif; color: #1a1a1a; background: white; outline: none; transition: border-color 0.2s, box-shadow 0.2s; width: 100%; box-sizing: border-box; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #c8102e; box-shadow: 0 0 0 3px rgba(200,16,46,.08); }
    .form-textarea { resize: vertical; min-height: 300px; line-height: 1.7; }
    .form-textarea.summary { min-height: 90px; }
    .form-hint { font-size: 0.78rem; color: #999; margin-top: -0.25rem; }
    .char-count { font-size: 0.72rem; color: #999; text-align: right; }
    .char-count.warn { color: #d97706; }
    .char-count.over { color: #c8102e; font-weight: 700; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .submit-btn { width: 100%; padding: 0.9rem; background: linear-gradient(90deg, #c8102e, #a30c26); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; font-family: 'Source Sans 3', sans-serif; cursor: pointer; transition: filter 0.2s, transform 0.15s; margin-top: 0.5rem; }
    .submit-btn:hover { filter: brightness(1.07); transform: translateY(-1px); }
    .alert { padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; }
    .alert-error { background: #fff0f0; border: 1px solid #ffcccc; color: #c8102e; }
    .alert-success { background: #f0fff4; border: 1px solid #bbf7d0; color: #16a34a; }
    /* My Submissions */
    .submissions-box { background: white; border: 1px solid #e0e0e0; border-radius: 12px; padding: 1.5rem; }
    .submissions-box h2 { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 2px solid #c8102e; }
    .sub-item { padding: 1rem 0; border-bottom: 1px solid #f0f0f0; display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start; }
    .sub-item:last-child { border-bottom: none; padding-bottom: 0; }
    .sub-title { font-weight: 700; font-size: 0.95rem; color: #1a1a1a; margin-bottom: 0.25rem; }
    .sub-meta { font-size: 0.78rem; color: #999; }
    .sub-cat { display: inline-block; font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: white; padding: 0.15rem 0.5rem; border-radius: 4px; margin-right: 0.4rem; }
    .status-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; padding: 0.35rem 0.75rem; border-radius: 999px; white-space: nowrap; }
    .status-pending  { background: #fef3c7; color: #d97706; }
    .status-approved { background: #dcfce7; color: #16a34a; }
    .status-declined { background: #fff0f0; color: #c8102e; }
    .decline-reason { font-size: 0.8rem; color: #666; background: #f9f9f9; border-left: 3px solid #c8102e; padding: 0.5rem 0.75rem; margin-top: 0.5rem; border-radius: 0 4px 4px 0; }
    .empty-state { text-align: center; padding: 2rem; color: #999; font-size: 0.9rem; }
    @media(max-width:600px) { .form-row { grid-template-columns: 1fr; } }
  </style>
</head>
<body>

  <!-- NAV -->
  <header class="header-main">
    <div class="header-container">
      <div class="header-left">
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
        <span style="font-size:.85rem;font-weight:600;color:#666;">Hi, <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>!</span>
        <span class="header-right-divider"></span>
        <?php if ($user['role'] === 'admin'): ?>
          <a href="admin.php" style="font-size:.85rem;font-weight:700;color:#c8102e;text-decoration:none;">Admin Panel</a>
          <span class="header-right-divider"></span>
        <?php endif; ?>
        <a href="logout.php" style="font-size:.85rem;font-weight:700;color:#666;text-decoration:none;">Log Out</a>
      </div>
    </div>
  </header>

  <div class="submit-page">
    <div class="submit-header">
      <h1>✍️ Submit an Article</h1>
      <p>Write your story and submit it for editorial review. An admin will approve or decline it.</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success">✅ <?= $success ?></div>
    <?php endif; ?>

    <!-- SUBMISSION FORM -->
    <div class="submit-box">
      <form method="POST" action="submit-article.php">

        <div class="form-row">
          <div class="form-field">
            <label class="form-label" for="category">Category <span>*</span></label>
            <select class="form-select" id="category" name="category" required>
              <option value="">— Select a category —</option>
              <option value="technology"    <?= ($_POST['category']??'')==='technology'    ? 'selected':'' ?>>🔬 Technology</option>
              <option value="sports"        <?= ($_POST['category']??'')==='sports'        ? 'selected':'' ?>>⚽ Sports</option>
              <option value="entertainment" <?= ($_POST['category']??'')==='entertainment' ? 'selected':'' ?>>🎬 Entertainment</option>
              <option value="worldnews"     <?= ($_POST['category']??'')==='worldnews'     ? 'selected':'' ?>>🌍 World News</option>
            </select>
          </div>
          <div class="form-field">
            <label class="form-label" for="image_url">Hero Image URL <span style="color:#999;font-weight:400;">(optional)</span></label>
            <input class="form-input" type="url" id="image_url" name="image_url" placeholder="https://images.unsplash.com/..." value="<?= htmlspecialchars($_POST['image_url'] ?? '') ?>">
            <span class="form-hint">Paste an Unsplash or direct image link</span>
          </div>
        </div>

        <div class="form-field">
          <label class="form-label" for="title">Headline <span>*</span></label>
          <input class="form-input" type="text" id="title" name="title" placeholder="Write a clear, compelling headline..." maxlength="255" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
          <div class="char-count" id="titleCount">255 characters remaining</div>
        </div>

        <div class="form-field">
          <label class="form-label" for="summary">Summary / Lede <span>*</span></label>
          <textarea class="form-textarea summary" id="summary" name="summary" placeholder="Write a 1–2 sentence summary of the article. This appears on the home page cards." maxlength="500" required><?= htmlspecialchars($_POST['summary'] ?? '') ?></textarea>
          <div class="char-count" id="summaryCount">500 characters remaining</div>
        </div>

        <div class="form-field">
          <label class="form-label" for="body">Full Article Body <span>*</span></label>
          <textarea class="form-textarea" id="body" name="body" placeholder="Write your full article here. Use blank lines to separate paragraphs." required><?= htmlspecialchars($_POST['body'] ?? '') ?></textarea>
          <span class="form-hint">Minimum 100 words recommended. Separate paragraphs with blank lines.</span>
        </div>

        <button class="submit-btn" type="submit">Submit for Review →</button>
      </form>
    </div>

    <!-- MY PREVIOUS SUBMISSIONS -->
    <div class="submissions-box">
      <h2>My Submissions</h2>
      <?php if (empty($mySubmissions)): ?>
        <div class="empty-state">You haven't submitted any articles yet.</div>
      <?php else: ?>
        <?php foreach ($mySubmissions as $sub): ?>
          <div class="sub-item">
            <div>
              <div class="sub-title"><?= htmlspecialchars($sub['title']) ?></div>
              <div class="sub-meta">
                <span class="sub-cat" style="background:<?= $catColors[$sub['category']] ?>"><?= ucfirst($sub['category']) ?></span>
                Submitted <?= date('M j, Y', strtotime($sub['submitted_at'])) ?>
                <?php if ($sub['reviewed_at']): ?>
                  · Reviewed <?= date('M j, Y', strtotime($sub['reviewed_at'])) ?>
                <?php endif; ?>
              </div>
              <?php if ($sub['status'] === 'declined' && $sub['decline_reason']): ?>
                <div class="decline-reason">💬 Admin note: <?= htmlspecialchars($sub['decline_reason']) ?></div>
              <?php endif; ?>
            </div>
            <span class="status-badge status-<?= $sub['status'] ?>">
              <?php
                echo match($sub['status']) {
                    'pending'  => '⏳ Pending',
                    'approved' => '✅ Approved',
                    'declined' => '❌ Declined',
                };
              ?>
            </span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <script>
    // Character counters
    function charCounter(inputId, countId, max) {
      const el = document.getElementById(inputId);
      const counter = document.getElementById(countId);
      if (!el || !counter) return;
      function update() {
        const left = max - el.value.length;
        counter.textContent = `${left} characters remaining`;
        counter.className = 'char-count' + (left < 0 ? ' over' : left < 50 ? ' warn' : '');
      }
      el.addEventListener('input', update);
      update();
    }
    charCounter('title',   'titleCount',   255);
    charCounter('summary', 'summaryCount', 500);
  </script>
</body>
</html>
