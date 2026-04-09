<?php
session_start();
require_once 'db.php';
require_once 'auth.php';
$currentUser = getCurrentUser();
$pageId = 'contact';

$success = false;
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if (!$name)                          $errors[] = 'Your name is required.';
  if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
  if (!$subject)                       $errors[] = 'Please enter a subject.';
  if (strlen($message) < 10)          $errors[] = 'Message must be at least 10 characters.';

  if (empty($errors)) {
    // In production: mail() or a mailer library would go here.
    // For now we just mark success.
    $success = true;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contact Us — UrbanPulse</title>
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
    .contact-hero {
      position: relative;
      background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 50%, #0d0d0d 100%);
      overflow: hidden; padding: 4.5rem 1.5rem 3.5rem; text-align: center;
    }
    .contact-hero::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 55% 60% at 15% 50%, rgba(200,16,46,0.16), transparent 70%),
        radial-gradient(ellipse 45% 55% at 85% 50%, rgba(212,175,55,0.09), transparent 70%);
      pointer-events: none;
    }
    .contact-hero::after {
      content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
      background: linear-gradient(90deg, transparent, rgba(200,16,46,0.5), rgba(212,175,55,0.35), transparent);
    }
    .contact-hero-eyebrow {
      display: inline-block; font-size: .72rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--color-secondary);
      background: rgba(200,16,46,0.12); border: 1px solid rgba(200,16,46,0.25);
      padding: .35rem .9rem; border-radius: 999px; margin-bottom: 1.25rem; position: relative;
    }
    .contact-hero-title {
      font-family: var(--font-display); font-size: clamp(2.4rem, 5vw, 4.2rem);
      font-weight: 900; line-height: 1.08; color: #fff;
      margin: 0 auto 1rem; max-width: 640px; position: relative;
    }
    .contact-hero-title em { font-style: italic; color: var(--color-accent); }
    .contact-hero-sub {
      font-size: clamp(.95rem, 2vw, 1.1rem);
      color: rgba(255,255,255,.6); max-width: 500px;
      margin: 0 auto; line-height: 1.7; position: relative;
    }

    /* ── MAIN LAYOUT ── */
    .contact-body {
      max-width: 1100px; margin: 0 auto;
      padding: 4rem 1.5rem;
      display: grid; grid-template-columns: 1fr 380px; gap: 4rem;
      align-items: flex-start;
    }

    /* ── FORM ── */
    .form-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border); border-radius: 24px; padding: 2.5rem;
    }
    html[data-theme='dark'] .form-card { background: #151a22; border-color: #2a313c; }

    .form-title {
      font-family: var(--font-display); font-size: 1.6rem; font-weight: 900;
      color: var(--color-primary); margin: 0 0 .4rem;
    }
    html[data-theme='dark'] .form-title { color: #f4f7fb; }
    .form-subtitle { font-size: .95rem; color: var(--color-text-light); margin: 0 0 2rem; }
    html[data-theme='dark'] .form-subtitle { color: #8f98a7; }

    /* Success */
    .form-success {
      text-align: center; padding: 3rem 1.5rem;
    }
    .success-icon { font-size: 3.5rem; margin-bottom: 1rem; display: block; }
    .success-title {
      font-family: var(--font-display); font-size: 1.6rem; font-weight: 900;
      color: var(--color-primary); margin: 0 0 .65rem;
    }
    html[data-theme='dark'] .success-title { color: #f4f7fb; }
    .success-text { font-size: .95rem; color: var(--color-text-light); line-height: 1.7; }
    html[data-theme='dark'] .success-text { color: #8f98a7; }

    /* Errors */
    .form-errors {
      background: #fff0f2; border: 1px solid #ffc2cc;
      border-left: 4px solid #c8102e; border-radius: 10px;
      padding: .85rem 1rem; margin-bottom: 1.5rem;
    }
    html[data-theme='dark'] .form-errors {
      background: rgba(200,16,46,.1); border-color: rgba(200,16,46,.3);
    }
    .form-errors ul { margin: 0; padding-left: 1.25rem; }
    .form-errors li { font-size: .88rem; color: #c8102e; }
    html[data-theme='dark'] .form-errors li { color: #ff7a8a; }

    /* Fields */
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .field { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1rem; }
    .field-label {
      font-size: .72rem; font-weight: 800; text-transform: uppercase;
      letter-spacing: 1px; color: var(--color-text-light);
    }
    html[data-theme='dark'] .field-label { color: #8f98a7; }
    .field-input,
    .field-select,
    .field-textarea {
      border: 1.5px solid var(--color-border); border-radius: 12px;
      padding: .8rem 1rem; font-size: .95rem; font-family: var(--font-body);
      color: var(--color-text); background: #fff;
      outline: none; transition: border-color .2s, box-shadow .2s; width: 100%;
    }
    html[data-theme='dark'] .field-input,
    html[data-theme='dark'] .field-select,
    html[data-theme='dark'] .field-textarea {
      background: #0f1420; color: #e7ecf4; border-color: #2a313c;
    }
    .field-input:focus,
    .field-select:focus,
    .field-textarea:focus {
      border-color: var(--color-secondary);
      box-shadow: 0 0 0 3px rgba(200,16,46,.1);
    }
    .field-textarea { min-height: 140px; resize: vertical; }

    .form-submit {
      width: 100%; padding: .95rem; border: none; border-radius: 12px;
      background: linear-gradient(90deg, #c8102e, #a30c26); color: #fff;
      font-size: 1rem; font-weight: 800; font-family: var(--font-body);
      cursor: pointer; transition: filter .2s, transform .15s; letter-spacing: .3px;
      margin-top: .5rem;
    }
    .form-submit:hover { filter: brightness(1.08); transform: translateY(-1px); }
    .form-submit:active { transform: translateY(0); }

    /* ── SIDEBAR ── */
    .contact-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }

    .info-card {
      background: var(--color-surface);
      border: 1px solid var(--color-border); border-radius: 20px; padding: 1.75rem;
      position: relative; overflow: hidden;
    }
    html[data-theme='dark'] .info-card { background: #151a22; border-color: #2a313c; }
    .info-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--color-secondary), var(--color-accent));
    }
    .info-card-title {
      font-family: var(--font-display); font-size: 1.15rem; font-weight: 700;
      color: var(--color-primary); margin: 0 0 1.25rem;
    }
    html[data-theme='dark'] .info-card-title { color: #f4f7fb; }

    .info-item {
      display: flex; align-items: flex-start; gap: .85rem;
      padding: .75rem 0; border-bottom: 1px solid var(--color-border);
    }
    html[data-theme='dark'] .info-item { border-bottom-color: #2a313c; }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    .info-icon {
      width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
      background: rgba(200,16,46,0.09); display: flex;
      align-items: center; justify-content: center; font-size: 1.1rem;
    }
    html[data-theme='dark'] .info-icon { background: rgba(200,16,46,0.15); }
    .info-label {
      font-size: .72rem; font-weight: 800; letter-spacing: 1px;
      text-transform: uppercase; color: var(--color-text-light); margin-bottom: .2rem;
    }
    html[data-theme='dark'] .info-label { color: #8f98a7; }
    .info-value { font-size: .92rem; font-weight: 600; color: var(--color-primary); }
    html[data-theme='dark'] .info-value { color: #c9d1dc; }

    /* Desks card */
    .desk-item {
      display: flex; align-items: center; justify-content: space-between;
      padding: .65rem 0; border-bottom: 1px solid var(--color-border);
      font-size: .9rem;
    }
    html[data-theme='dark'] .desk-item { border-bottom-color: #2a313c; }
    .desk-item:last-child { border-bottom: none; }
    .desk-name { font-weight: 700; color: var(--color-primary); }
    html[data-theme='dark'] .desk-name { color: #f4f7fb; }
    .desk-email { font-size: .82rem; color: var(--color-secondary); }

    /* Pledge card */
    .pledge-card {
      background: linear-gradient(135deg, #0f0f0f, #1c1c1c);
      border-radius: 20px; padding: 1.75rem; position: relative; overflow: hidden;
    }
    .pledge-card::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(ellipse at 80% 20%, rgba(200,16,46,0.15), transparent 60%);
      pointer-events: none;
    }
    .pledge-card::after {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, #c8102e, #d4af37);
    }
    .pledge-label {
      font-size: .72rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--color-accent);
      margin-bottom: .75rem; position: relative;
    }
    .pledge-text {
      font-family: var(--font-display); font-style: italic;
      font-size: 1.05rem; line-height: 1.65; color: rgba(255,255,255,.82);
      margin: 0; position: relative;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .contact-body { grid-template-columns: 1fr; gap: 2.5rem; }
      .contact-sidebar { order: -1; }
    }
    @media (max-width: 560px) {
      .field-row { grid-template-columns: 1fr; }
      .form-card { padding: 1.5rem; }
    }
  </style>
</head>
<body data-page="<?= htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8') ?>">

  <?php require_once 'nav.php'; ?>

  <!-- HERO -->
  <section class="contact-hero">
    <div class="contact-hero-eyebrow">Get in Touch</div>
    <h1 class="contact-hero-title">We'd Love to<br><em>Hear From You</em></h1>
    <p class="contact-hero-sub">Tips, corrections, partnerships, or just a kind note — our team reads every message and responds within 48 hours.</p>
  </section>

  <div class="contact-body">

    <!-- FORM -->
    <div class="form-card">
      <?php if ($success): ?>
        <div class="form-success">
          <span class="success-icon">✅</span>
          <h2 class="success-title">Message Sent!</h2>
          <p class="success-text">Thanks for reaching out. A member of the UrbanPulse team will get back to you within 48 hours.</p>
          <a href="home.php" style="display:inline-block;margin-top:1.5rem;padding:.8rem 2rem;background:#c8102e;color:#fff;border-radius:999px;font-weight:800;font-size:.9rem;transition:filter .2s;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">← Back to Home</a>
        </div>
      <?php else: ?>
        <h2 class="form-title">Send Us a Message</h2>
        <p class="form-subtitle">Use the form below or reach out directly to one of our desks.</p>

        <?php if (!empty($errors)): ?>
          <div class="form-errors">
            <ul>
              <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST" action="contact.php" novalidate>
          <div class="field-row">
            <div class="field">
              <label class="field-label" for="cf_name">Your Name</label>
              <input class="field-input" type="text" id="cf_name" name="name"
                placeholder="e.g. Maria Santos"
                value="<?= htmlspecialchars($_POST['name'] ?? ($currentUser ? $currentUser['name'] : '')) ?>"
                required>
            </div>
            <div class="field">
              <label class="field-label" for="cf_email">Email Address</label>
              <input class="field-input" type="email" id="cf_email" name="email"
                placeholder="you@example.com"
                value="<?= htmlspecialchars($_POST['email'] ?? ($currentUser ? $currentUser['email'] : '')) ?>"
                required>
            </div>
          </div>

          <div class="field">
            <label class="field-label" for="cf_subject">Subject / Desk</label>
            <select class="field-select" id="cf_subject" name="subject">
              <option value="" disabled <?= empty($_POST['subject']) ? 'selected' : '' ?>>Select a topic…</option>
              <option value="General Inquiry"     <?= ($_POST['subject'] ?? '') === 'General Inquiry'     ? 'selected' : '' ?>>General Inquiry</option>
              <option value="News Tip"            <?= ($_POST['subject'] ?? '') === 'News Tip'            ? 'selected' : '' ?>>📰 News Tip</option>
              <option value="Correction Request"  <?= ($_POST['subject'] ?? '') === 'Correction Request'  ? 'selected' : '' ?>>🔧 Correction Request</option>
              <option value="Partnership"         <?= ($_POST['subject'] ?? '') === 'Partnership'         ? 'selected' : '' ?>>🤝 Partnership / Advertising</option>
              <option value="Technical Issue"     <?= ($_POST['subject'] ?? '') === 'Technical Issue'     ? 'selected' : '' ?>>⚙️ Technical Issue</option>
              <option value="Other"               <?= ($_POST['subject'] ?? '') === 'Other'               ? 'selected' : '' ?>>Other</option>
            </select>
          </div>

          <div class="field">
            <label class="field-label" for="cf_message">Your Message</label>
            <textarea class="field-textarea" id="cf_message" name="message"
              placeholder="Tell us what's on your mind…" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
          </div>

          <button type="submit" class="form-submit">Send Message →</button>
        </form>
      <?php endif; ?>
    </div>

    <!-- SIDEBAR -->
    <div class="contact-sidebar">

      <div class="info-card">
        <h3 class="info-card-title">Contact Information</h3>
        <div class="info-item">
          <div class="info-icon">📍</div>
          <div>
            <div class="info-label">Address</div>
            <div class="info-value">J.P. Rizal Extension, West Rembo<br>Makati City, Metro Manila 1215</div>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon">📧</div>
          <div>
            <div class="info-label">General Inquiries</div>
            <div class="info-value">hello@urbanpulse.ph</div>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon">🕐</div>
          <div>
            <div class="info-label">Response Time</div>
            <div class="info-value">Within 48 hours on business days</div>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3 class="info-card-title">Editorial Desks</h3>
        <div class="desk-item">
          <span class="desk-name">Technology</span>
          <span class="desk-email">tech@urbanpulse.ph</span>
        </div>
        <div class="desk-item">
          <span class="desk-name">Sports</span>
          <span class="desk-email">sports@urbanpulse.ph</span>
        </div>
        <div class="desk-item">
          <span class="desk-name">Entertainment</span>
          <span class="desk-email">ent@urbanpulse.ph</span>
        </div>
        <div class="desk-item">
          <span class="desk-name">World News</span>
          <span class="desk-email">world@urbanpulse.ph</span>
        </div>
        <div class="desk-item">
          <span class="desk-name">Tips &amp; Corrections</span>
          <span class="desk-email">tips@urbanpulse.ph</span>
        </div>
      </div>

      <div class="pledge-card">
        <div class="pledge-label">Our Pledge</div>
        <p class="pledge-text">"We, the UrbanPulse team, pledge to deliver news that keeps people informed, aware, and always updated."</p>
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