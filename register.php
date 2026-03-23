<?php
// register.php — User registration
require_once 'db.php';
require_once 'auth.php';

// If already logged in, go home
if (isLoggedIn()) {
    header('Location: home.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password =      $_POST['password'] ?? '';
    $confirm  =      $_POST['confirm']  ?? '';

    // Basic validation
    if (!$name || !$username || !$email || !$password) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'Username can only contain letters, numbers, and underscores.';
    } else {
        $db = getDB();

        // Check if username or email already exists
        $stmt = $db->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = 'Username or email is already taken.';
        } else {
            // Pick a random avatar color
            $colors = ['#c8102e','#d4af37','#0066cc','#27ae60','#9b59b6','#e67e22','#16a085'];
            $avatarColor = $colors[array_rand($colors)];

            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare(
                'INSERT INTO users (username, email, password, name, avatar_color) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$username, $email, $hashed, $name, $avatarColor]);

            $success = 'Account created! You can now <a href="login.php">log in</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="home.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    .auth-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--color-surface, #f4f4f4); padding: 2rem; }
    .auth-box { background: white; border: 1px solid var(--color-border, #e0e0e0); padding: 2.5rem; width: 100%; max-width: 440px; }
    .auth-logo { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 900; color: var(--color-primary, #1a1a1a); text-decoration: none; display: block; margin-bottom: 0.25rem; }
    .auth-tagline { font-size: 0.8rem; color: var(--color-text-muted, #999); margin-bottom: 2rem; }
    .auth-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--color-primary, #1a1a1a); }
    .auth-field { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1rem; }
    .auth-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-light, #666); }
    .auth-input { border: 1.5px solid var(--color-border, #e0e0e0); border-radius: 8px; padding: 0.75rem 1rem; font-size: 0.95rem; font-family: 'Source Sans 3', sans-serif; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
    .auth-input:focus { border-color: #c8102e; box-shadow: 0 0 0 3px rgba(200,16,46,.08); }
    .auth-btn { width: 100%; padding: 0.85rem; background: linear-gradient(90deg, #c8102e, #a30c26); color: white; border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 700; font-family: 'Source Sans 3', sans-serif; cursor: pointer; margin-top: 0.5rem; transition: filter 0.2s; }
    .auth-btn:hover { filter: brightness(1.08); }
    .auth-error { background: #fff0f0; border: 1px solid #ffcccc; color: #c8102e; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.875rem; margin-bottom: 1rem; }
    .auth-success { background: #f0fff4; border: 1px solid #bbf7d0; color: #16a34a; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.875rem; margin-bottom: 1rem; }
    .auth-footer { text-align: center; margin-top: 1.25rem; font-size: 0.875rem; color: var(--color-text-light, #666); }
    .auth-footer a { color: #c8102e; font-weight: 700; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }
    .auth-divider { height: 1px; background: var(--color-border, #e0e0e0); margin: 1.25rem 0; }
  </style>
</head>
<body>
  <main class="auth-page">
    <div class="auth-box">
      <a href="home.php" class="auth-logo">UrbanPulse</a>
      <p class="auth-tagline">Feel the Ripple!</p>
      <h1 class="auth-title">Create your account</h1>

      <?php if ($error): ?>
        <div class="auth-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="auth-success"><?= $success ?></div>
      <?php endif; ?>

      <?php if (!$success): ?>
      <form method="POST" action="register.php">
        <div class="auth-field">
          <label class="auth-label" for="name">Full Name</label>
          <input class="auth-input" type="text" id="name" name="name" placeholder="Juan dela Cruz" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        </div>
        <div class="auth-field">
          <label class="auth-label" for="username">Username</label>
          <input class="auth-input" type="text" id="username" name="username" placeholder="juandc" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        </div>
        <div class="auth-field">
          <label class="auth-label" for="email">Email</label>
          <input class="auth-input" type="email" id="email" name="email" placeholder="juan@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="auth-field">
          <label class="auth-label" for="password">Password</label>
          <input class="auth-input" type="password" id="password" name="password" placeholder="At least 8 characters" required>
        </div>
        <div class="auth-field">
          <label class="auth-label" for="confirm">Confirm Password</label>
          <input class="auth-input" type="password" id="confirm" name="confirm" placeholder="Repeat your password" required>
        </div>
        <button class="auth-btn" type="submit">Create Account</button>
      </form>
      <?php endif; ?>

      <div class="auth-divider"></div>
      <div class="auth-footer">
        Already have an account? <a href="login.php">Sign in</a>
      </div>
    </div>
  </main>
</body>
</html>
