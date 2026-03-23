<?php
require_once 'db.php';
require_once 'auth.php';

// Must be logged in
if (!isLoggedIn()) {
    header('Location: login.php?redirect=admin.php');
    exit;
}

$user = getCurrentUser();

// Role check — show helpful debug if wrong role
if ($user['role'] !== 'admin') {
    // Check what's actually in DB
    $db = getDB();
    $dbUser = $db->prepare('SELECT role FROM users WHERE id = ?');
    $dbUser->execute([$user['id']]);
    $dbRole = $dbUser->fetchColumn();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <title>Access Denied — UrbanPulse</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
      <style>
        body { font-family: 'Source Sans 3', sans-serif; background: #f4f4f4; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem; }
        .box { background: white; border-radius: 16px; padding: 2.5rem; max-width: 480px; width: 100%; text-align: center; box-shadow: 0 8px 30px rgba(0,0,0,0.08); }
        h2 { font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 0.5rem; color: #1a1a1a; }
        p { color: #666; font-size: 0.9rem; line-height: 1.6; }
        .info { background: #fff7ed; border: 1px solid #fde68a; border-radius: 8px; padding: 1rem; margin: 1.25rem 0; font-size: 0.875rem; text-align: left; }
        .info strong { color: #c8102e; }
        .btn { display: inline-block; padding: 0.75rem 1.5rem; background: #c8102e; color: white; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.9rem; margin: 0.35rem; }
        .btn-gray { background: #e0e0e0; color: #333; }
        form { display: inline; }
        .fix-btn { padding: 0.65rem 1.25rem; background: #16a34a; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 0.875rem; cursor: pointer; font-family: inherit; }
      </style>
    </head>
    <body>
      <div class="box">
        <div style="font-size:3rem;margin-bottom:1rem;">🔒</div>
        <h2>Admin Access Required</h2>
        <p>Your account doesn't have admin privileges yet.</p>
        <div class="info">
          <strong>Session role:</strong> <?= htmlspecialchars($user['role']) ?><br>
          <strong>Database role:</strong> <?= htmlspecialchars($dbRole ?: 'unknown') ?><br>
          <strong>Your username:</strong> <?= htmlspecialchars($user['username']) ?>
          <?php if ($dbRole === 'admin' && $user['role'] !== 'admin'): ?>
          <br><br>
          ⚠️ Your DB role is <strong>admin</strong> but session shows <strong><?= htmlspecialchars($user['role']) ?></strong>.
          You just need to <strong>log out and log back in!</strong>
          <?php endif; ?>
        </div>
        <?php if ($dbRole !== 'admin'): ?>
          <!-- Auto-fix: make this user admin right now -->
          <form method="POST" action="admin.php">
            <input type="hidden" name="self_promote" value="1">
            <button type="submit" class="fix-btn"
              onclick="return confirm('Make your account (<?= htmlspecialchars($user['username']) ?>) an admin?')">
              ⚡ Make My Account Admin
            </button>
          </form>
          <p style="font-size:.78rem;color:#999;margin-top:.75rem;">This will set your role to admin in the database.</p>
        <?php endif; ?>
        <br>
        <a href="logout.php" class="btn" style="margin-top:.5rem;">Log Out & Back In</a>
        <a href="home.php" class="btn btn-gray">Go Home</a>
      </div>
    </body>
    </html>
    <?php
    exit;
}

$db = getDB();
$message = '';
$msgType = '';

// ── Handle self-promote (fallback fix) ──────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['self_promote'])) {
    $db->prepare('UPDATE users SET role = ? WHERE id = ?')->execute(['admin', $user['id']]);
    header('Location: logout.php');
    exit;
}

// ── Handle approve / decline ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $subId  = (int)($_POST['submission_id'] ?? 0);
    $reason = trim($_POST['decline_reason'] ?? '');

    if ($subId && in_array($action, ['approve','decline'])) {
        $status        = $action === 'approve' ? 'approved' : 'declined';
        $declineReason = $action === 'decline' ? ($reason ?: null) : null;
        $db->prepare('
            UPDATE article_submissions
            SET status = ?, decline_reason = ?, reviewed_at = NOW(), reviewed_by = ?
            WHERE id = ?
        ')->execute([$status, $declineReason, $user['id'], $subId]);

        $message = $action === 'approve'
            ? '✅ Article approved!'
            : '❌ Article declined.';
        $msgType = $action === 'approve' ? 'success' : 'error';
    }
}

// ── Filters & fetch ─────────────────────────────────────
$filter       = $_GET['filter'] ?? 'pending';
$validFilters = ['all','pending','approved','declined'];
if (!in_array($filter, $validFilters)) $filter = 'pending';

$where  = $filter !== 'all' ? 'WHERE s.status = ?' : '';
$params = $filter !== 'all' ? [$filter] : [];

$stmt = $db->prepare("
    SELECT s.*, 
           u.name AS author_name, u.username AS author_username, u.avatar_color,
           r.name AS reviewer_name
    FROM article_submissions s
    JOIN users u ON s.author_id = u.id
    LEFT JOIN users r ON s.reviewed_by = r.id
    $where
    ORDER BY
      CASE s.status WHEN 'pending' THEN 0 WHEN 'approved' THEN 1 ELSE 2 END,
      s.submitted_at DESC
");
$stmt->execute($params);
$submissions = $stmt->fetchAll();

// ── Stats ────────────────────────────────────────────────
$stats = $db->query("
    SELECT
        COUNT(*) as total,
        SUM(status='pending')  as pending,
        SUM(status='approved') as approved,
        SUM(status='declined') as declined
    FROM article_submissions
")->fetch();

$catColors = [
    'technology'    => '#0066cc',
    'sports'        => '#ff6b35',
    'entertainment' => '#9b59b6',
    'worldnews'     => '#27ae60',
];
$catLabels = [
    'technology'    => '🔬 Technology',
    'sports'        => '⚽ Sports',
    'entertainment' => '🎬 Entertainment',
    'worldnews'     => '🌍 World News',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    * { box-sizing: border-box; }
    body { background: #f0f2f5; font-family: 'Source Sans 3', sans-serif; margin: 0; color: #1a1a1a; }

    /* TOP ADMIN BAR */
    .admin-topnav {
      background: #1a1a1a;
      color: white;
      padding: 0.75rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .admin-topnav-left { display: flex; align-items: center; gap: 1.5rem; }
    .admin-brand { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: white; text-decoration: none; }
    .admin-brand span { color: #c8102e; }
    .admin-nav-link { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s; }
    .admin-nav-link:hover, .admin-nav-link.active { color: white; }
    .admin-topnav-right { display: flex; align-items: center; gap: 1rem; font-size: 0.82rem; }
    .admin-user { color: rgba(255,255,255,0.8); }
    .admin-badge-pill { background: #c8102e; color: white; font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; padding: 0.2rem 0.5rem; border-radius: 4px; }

    /* PAGE */
    .admin-page { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

    /* STATS */
    .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 2rem; }
    .stat-box { background: white; border-radius: 12px; padding: 1.25rem 1.5rem; border: 1px solid #e0e0e0; }
    .stat-box .num { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 900; line-height: 1; }
    .stat-box .lbl { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-top: 0.25rem; }
    .stat-box.s-pending  .num { color: #d97706; }
    .stat-box.s-approved .num { color: #16a34a; }
    .stat-box.s-declined .num { color: #c8102e; }

    /* ALERTS */
    .alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #16a34a; }
    .alert-error   { background: #fff0f0; border: 1px solid #fca5a5; color: #c8102e; }

    /* FILTER TABS */
    .filter-row { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; }
    .filter-tab { padding: 0.5rem 1.1rem; border-radius: 999px; font-size: 0.82rem; font-weight: 700; text-decoration: none; border: 2px solid #e0e0e0; color: #666; background: white; transition: all 0.18s; }
    .filter-tab:hover { border-color: #c8102e; color: #c8102e; }
    .filter-tab.on { background: #c8102e; border-color: #c8102e; color: white; }
    .pending-dot { display: inline-block; width: 8px; height: 8px; background: #d97706; border-radius: 50%; margin-right: 4px; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

    /* SECTION HEADER */
    .section-hdr { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #999; margin-bottom: 0.75rem; }

    /* SUBMISSION CARD */
    .sub-card {
      background: white;
      border: 1px solid #e0e0e0;
      border-radius: 14px;
      margin-bottom: 1.25rem;
      overflow: hidden;
      transition: box-shadow 0.2s;
    }
    .sub-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .sub-card.is-pending { border-left: 4px solid #d97706; }
    .sub-card.is-approved { border-left: 4px solid #16a34a; }
    .sub-card.is-declined { border-left: 4px solid #c8102e; }

    /* CARD HEADER */
    .card-hdr { padding: 1.25rem 1.5rem; display: flex; align-items: flex-start; gap: 1rem; }
    .c-avatar { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; color: white; flex-shrink: 0; }
    .c-info { flex: 1; min-width: 0; }
    .c-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; line-height: 1.25; margin-bottom: 0.4rem; color: #1a1a1a; }
    .c-meta { display: flex; flex-wrap: wrap; gap: 0.4rem 0.75rem; align-items: center; font-size: 0.78rem; color: #999; }
    .c-cat { display: inline-block; font-size: 0.62rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: white; padding: 0.18rem 0.55rem; border-radius: 4px; }
    .c-status { font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; padding: 0.25rem 0.65rem; border-radius: 999px; }
    .cs-pending  { background: #fef3c7; color: #d97706; }
    .cs-approved { background: #dcfce7; color: #16a34a; }
    .cs-declined { background: #fff0f0; color: #c8102e; }

    /* CARD BODY */
    .card-body { padding: 0 1.5rem 0; border-top: 1px solid #f5f5f5; }
    .c-hero-img { width: 100%; max-height: 220px; object-fit: cover; border-radius: 8px; margin: 1rem 0 0.75rem; }
    .c-summary { font-style: italic; font-size: 0.9rem; color: #555; line-height: 1.65; margin-bottom: 0.75rem; background: #fafafa; padding: 0.75rem 1rem; border-radius: 6px; border-left: 3px solid #e0e0e0; }
    .c-body-preview { font-size: 0.875rem; color: #777; line-height: 1.65; margin-bottom: 1rem; }
    .c-body-full { display: none; font-size: 0.95rem; color: #2d2d2d; line-height: 1.85; }
    .c-body-full p { margin-bottom: 1rem; }
    .c-body-full p:last-child { margin-bottom: 0; }
    .c-decline-note { background: #fff0f0; border-left: 3px solid #c8102e; padding: 0.65rem 1rem; border-radius: 0 6px 6px 0; font-size: 0.82rem; color: #c8102e; margin-bottom: 1rem; }
    .c-reviewed-note { font-size: 0.78rem; color: #aaa; margin-bottom: 0.75rem; }

    /* ACTION BAR */
    .card-actions {
      padding: 1rem 1.5rem;
      border-top: 1px solid #f0f0f0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex-wrap: wrap;
      background: #fafafa;
    }
    .btn { padding: 0.6rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; font-family: 'Source Sans 3', sans-serif; cursor: pointer; border: 2px solid transparent; transition: all 0.18s; display: inline-flex; align-items: center; gap: 0.35rem; }
    .btn:hover { transform: translateY(-1px); filter: brightness(1.05); }
    .btn-approve { background: #16a34a; color: white; border-color: #16a34a; }
    .btn-approve:hover { background: #15803d; }
    .btn-decline { background: white; color: #c8102e; border-color: #c8102e; }
    .btn-decline:hover { background: #c8102e; color: white; }
    .btn-toggle  { background: white; color: #666; border-color: #e0e0e0; font-size: 0.78rem; }
    .btn-toggle:hover { border-color: #aaa; color: #333; }
    .btn-revoke  { background: white; color: #999; border-color: #e0e0e0; font-size: 0.78rem; }

    /* DECLINE REASON FORM */
    .decline-panel {
      display: none;
      flex-direction: column;
      gap: 0.5rem;
      width: 100%;
      margin-top: 0.25rem;
      padding: 1rem;
      background: #fff5f5;
      border: 1px solid #fca5a5;
      border-radius: 8px;
    }
    .decline-panel label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #c8102e; }
    .decline-panel textarea { border: 1.5px solid #fca5a5; border-radius: 6px; padding: 0.65rem; font-family: 'Source Sans 3', sans-serif; font-size: 0.875rem; resize: vertical; min-height: 70px; outline: none; background: white; }
    .decline-panel textarea:focus { border-color: #c8102e; }
    .decline-panel .row { display: flex; gap: 0.5rem; }
    .btn-confirm-decline { background: #c8102e; color: white; border-color: #c8102e; }
    .btn-confirm-decline:hover { background: #a30c26; }

    /* EMPTY STATE */
    .empty-box { background: white; border-radius: 14px; border: 1px dashed #e0e0e0; padding: 3rem; text-align: center; color: #aaa; }

    @media(max-width:700px) {
      .stats-row { grid-template-columns: 1fr 1fr; }
      .admin-topnav-left { gap: 0.75rem; }
    }
    @media(max-width:480px) {
      .stats-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- ADMIN TOP NAV -->
<nav class="admin-topnav">
  <div class="admin-topnav-left">
    <a href="home.php" class="admin-brand">Urban<span>Pulse</span></a>
    <a href="admin.php" class="admin-nav-link active">📋 Submissions</a>
    <a href="home.php" class="admin-nav-link">🏠 View Site</a>
    <a href="submit-article.php" class="admin-nav-link">✍️ Submit Article</a>
  </div>
  <div class="admin-topnav-right">
    <div style="width:32px;height:32px;border-radius:50%;background:<?= htmlspecialchars($user['avatar_color']) ?>;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.85rem;color:white;">
      <?= strtoupper(substr($user['name'],0,1)) ?>
    </div>
    <span class="admin-user"><?= htmlspecialchars($user['name']) ?></span>
    <span class="admin-badge-pill">Admin</span>
    <a href="logout.php" style="color:rgba(255,255,255,.5);font-size:.78rem;font-weight:600;text-decoration:none;">Log Out</a>
  </div>
</nav>

<div class="admin-page">

  <!-- PAGE TITLE -->
  <div style="margin-bottom:1.75rem;">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:900;margin:0 0 0.25rem;">
      Article Submissions
    </h1>
    <p style="color:#888;font-size:.875rem;margin:0;">Review, approve, or decline articles submitted by authors.</p>
  </div>

  <!-- STATS -->
  <div class="stats-row">
    <div class="stat-box">
      <div class="num"><?= (int)$stats['total'] ?></div>
      <div class="lbl">Total</div>
    </div>
    <div class="stat-box s-pending">
      <div class="num"><?= (int)$stats['pending'] ?></div>
      <div class="lbl">⏳ Pending</div>
    </div>
    <div class="stat-box s-approved">
      <div class="num"><?= (int)$stats['approved'] ?></div>
      <div class="lbl">✅ Approved</div>
    </div>
    <div class="stat-box s-declined">
      <div class="num"><?= (int)$stats['declined'] ?></div>
      <div class="lbl">❌ Declined</div>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-<?= $msgType ?>"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <!-- FILTER TABS -->
  <div class="filter-row">
    <a href="admin.php?filter=all"      class="filter-tab <?= $filter==='all'      ?'on':'' ?>">All (<?= (int)$stats['total'] ?>)</a>
    <a href="admin.php?filter=pending"  class="filter-tab <?= $filter==='pending'  ?'on':'' ?>">
      <?php if($stats['pending']>0): ?><span class="pending-dot"></span><?php endif; ?>
      Pending (<?= (int)$stats['pending'] ?>)
    </a>
    <a href="admin.php?filter=approved" class="filter-tab <?= $filter==='approved' ?'on':'' ?>">✅ Approved (<?= (int)$stats['approved'] ?>)</a>
    <a href="admin.php?filter=declined" class="filter-tab <?= $filter==='declined' ?'on':'' ?>">❌ Declined (<?= (int)$stats['declined'] ?>)</a>
  </div>

  <!-- SUBMISSIONS -->
  <?php if (empty($submissions)): ?>
    <div class="empty-box">
      <div style="font-size:2.5rem;margin-bottom:.75rem;">📭</div>
      <p style="font-size:.95rem;margin:0;">
        <?= $filter === 'pending' ? 'No pending articles — all caught up!' : "No $filter submissions." ?>
      </p>
    </div>
  <?php else: ?>

    <div class="section-hdr"><?= count($submissions) ?> submission<?= count($submissions)!==1?'s':'' ?> — <?= $filter ?></div>

    <?php foreach ($submissions as $sub):
      $ini   = strtoupper(substr($sub['author_name'],0,1));
      $paras = array_values(array_filter(explode("\n\n", trim($sub['body']))));
      $preview = implode(' ', array_slice($paras, 0, 2));
      if (strlen($preview) > 350) $preview = substr($preview, 0, 350) . '…';
    ?>

    <div class="sub-card is-<?= $sub['status'] ?>" id="card-<?= $sub['id'] ?>">

      <!-- HEADER -->
      <div class="card-hdr">
        <div class="c-avatar" style="background:<?= htmlspecialchars($sub['avatar_color']) ?>"><?= $ini ?></div>
        <div class="c-info">
          <div class="c-title"><?= htmlspecialchars($sub['title']) ?></div>
          <div class="c-meta">
            <span class="c-cat" style="background:<?= $catColors[$sub['category']] ?>">
              <?= $catLabels[$sub['category']] ?>
            </span>
            <span>by <strong><?= htmlspecialchars($sub['author_name']) ?></strong></span>
            <span>@<?= htmlspecialchars($sub['author_username']) ?></span>
            <span>·</span>
            <span><?= date('M j, Y · g:i A', strtotime($sub['submitted_at'])) ?></span>
          </div>
        </div>
        <span class="c-status cs-<?= $sub['status'] ?>">
          <?= match($sub['status']) { 'pending'=>'⏳ Pending Review', 'approved'=>'✅ Approved', 'declined'=>'❌ Declined' } ?>
        </span>
      </div>

      <!-- PREVIEW BODY -->
      <div class="card-body">

        <?php if ($sub['image_url']): ?>
          <img class="c-hero-img"
               src="<?= htmlspecialchars($sub['image_url']) ?>"
               alt="Hero image"
               onerror="this.style.display='none'">
        <?php endif; ?>

        <p class="c-summary"><?= htmlspecialchars($sub['summary']) ?></p>

        <div class="c-body-preview" id="preview-<?= $sub['id'] ?>">
          <?= nl2br(htmlspecialchars($preview)) ?>
          <?php if (count($paras) > 2): ?>
            <span style="color:#c8102e;font-weight:700;cursor:pointer;" onclick="toggleBody(<?= $sub['id'] ?>)"> Read more…</span>
          <?php endif; ?>
        </div>

        <div class="c-body-full" id="body-<?= $sub['id'] ?>">
          <?php foreach ($paras as $p): ?>
            <p><?= nl2br(htmlspecialchars(trim($p))) ?></p>
          <?php endforeach; ?>
        </div>

        <?php if ($sub['status'] === 'declined' && $sub['decline_reason']): ?>
          <div class="c-decline-note">💬 Decline reason: <?= htmlspecialchars($sub['decline_reason']) ?></div>
        <?php endif; ?>

        <?php if ($sub['status'] !== 'pending'): ?>
          <div class="c-reviewed-note">
            Reviewed by <strong><?= htmlspecialchars($sub['reviewer_name'] ?? 'Admin') ?></strong>
            on <?= date('M j, Y', strtotime($sub['reviewed_at'])) ?>
          </div>
        <?php endif; ?>

      </div>

      <!-- ACTION BAR -->
      <div class="card-actions">

        <button class="btn btn-toggle" onclick="toggleBody(<?= $sub['id'] ?>)" id="toggle-<?= $sub['id'] ?>">
          📄 Read Full Article
        </button>

        <?php if ($sub['status'] === 'pending'): ?>

          <!-- APPROVE -->
          <form method="POST" style="display:inline-flex">
            <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
            <input type="hidden" name="action" value="approve">
            <button type="submit" class="btn btn-approve"
              onclick="return confirm('Approve "<?= addslashes(htmlspecialchars($sub['title'])) ?>"?')">
              ✅ Approve
            </button>
          </form>

          <!-- DECLINE TRIGGER -->
          <button class="btn btn-decline" onclick="toggleDecline(<?= $sub['id'] ?>)">
            ❌ Decline
          </button>

          <!-- DECLINE PANEL -->
          <div class="decline-panel" id="decline-<?= $sub['id'] ?>">
            <label for="reason-<?= $sub['id'] ?>">Reason for declining (optional — sent to author)</label>
            <textarea id="reason-<?= $sub['id'] ?>" placeholder="e.g. Needs more sources, too short, off-topic…"></textarea>
            <div class="row">
              <form method="POST" style="display:contents">
                <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                <input type="hidden" name="action" value="decline">
                <input type="hidden" name="decline_reason" id="hidden-reason-<?= $sub['id'] ?>">
                <button type="submit" class="btn btn-confirm-decline"
                  onclick="document.getElementById('hidden-reason-<?= $sub['id'] ?>').value = document.getElementById('reason-<?= $sub['id'] ?>').value; return confirm('Decline this article?')">
                  Confirm Decline
                </button>
              </form>
              <button class="btn btn-toggle" onclick="toggleDecline(<?= $sub['id'] ?>)">Cancel</button>
            </div>
          </div>

        <?php else: ?>

          <!-- RE-REVIEW: revoke or re-approve -->
          <form method="POST" style="display:inline-flex">
            <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
            <input type="hidden" name="action" value="<?= $sub['status']==='approved' ? 'decline' : 'approve' ?>">
            <button type="submit" class="btn btn-revoke"
              onclick="return confirm('Change the status of this article?')">
              <?= $sub['status']==='approved' ? '↩ Revoke Approval' : '↩ Re-Approve' ?>
            </button>
          </form>

        <?php endif; ?>

      </div>
    </div><!-- /sub-card -->
    <?php endforeach; ?>

  <?php endif; ?>
</div><!-- /admin-page -->

<script>
  function toggleBody(id) {
    const preview = document.getElementById('preview-' + id);
    const full    = document.getElementById('body-'    + id);
    const btn     = document.getElementById('toggle-'  + id);
    const isOpen  = full.style.display === 'block';
    preview.style.display = isOpen ? '' : 'none';
    full.style.display    = isOpen ? 'none' : 'block';
    btn.textContent = isOpen ? '📄 Read Full Article' : '🔼 Collapse Article';
  }

  function toggleDecline(id) {
    const panel = document.getElementById('decline-' + id);
    const open  = panel.style.display === 'flex';
    panel.style.display = open ? 'none' : 'flex';
    panel.style.flexDirection = 'column';
    if (!open) panel.querySelector('textarea').focus();
  }
</script>
</body>
</html>