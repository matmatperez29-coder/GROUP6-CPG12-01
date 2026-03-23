<?php
// login.php — User login
require_once 'db.php';
require_once 'auth.php';

// If already logged in, go home
if (isLoggedIn()) {
    header('Location: home.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['login']    ?? '');  // username OR email
    $password =      $_POST['password'] ?? '';

    if (!$login || !$password) {
        $error = 'Please enter your username/email and password.';
    } else {
        $db = getDB();
        // Allow login with either username or email
        $stmt = $db->prepare(
            'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1'
        );
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id']           = $user['id'];
            $_SESSION['user_name']         = $user['name'];
            $_SESSION['user_username']     = $user['username'];
            $_SESSION['user_email']        = $user['email'];
            $_SESSION['user_role']         = $user['role'];
            $_SESSION['user_avatar_color'] = $user['avatar_color'];

            // Redirect to where they came from, or home
            $redirect = $_GET['redirect'] ?? 'home.php';
            header('Location: ' . $redirect);
            exit;
        } else {
            $error = 'Incorrect username/email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign In — UrbanPulse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="home.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    .auth-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--color-surface, #f4f4f4); padding: 2rem; }
    .auth-box { background: white; border: 1px solid var(--color-border, #e0e0e0); padding: 2.5rem; width: 100%; max-width: 420px; }
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
    .auth-footer { text-align: center; margin-top: 1.25rem; font-size: 0.875rem; color: var(--color-text-light, #666); }
    .auth-footer a { color: #c8102e; font-weight: 700; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }
    .auth-divider { height: 1px; background: var(--color-border, #e0e0e0); margin: 1.25rem 0; }
    .auth-forgot { text-align: right; font-size: 0.8rem; margin-top: -0.5rem; margin-bottom: 0.75rem; }
    .auth-forgot a { color: #c8102e; text-decoration: none; font-weight: 600; }
  </style>
</head>
<body>
  <main class="auth-page">
    <div class="auth-box">
      <a href="home.php" class="auth-logo">UrbanPulse</a>
      <p class="auth-tagline">Feel the Ripple!</p>
      <h1 class="auth-title">Sign in to your account</h1>

      <?php if ($error): ?>
        <div class="auth-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="login.php<?= isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>">
        <div class="auth-field">
          <label class="auth-label" for="login">Username or Email</label>
          <input class="auth-input" type="text" id="login" name="login" placeholder="username or email@address.com" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required autofocus>
        </div>
        <div class="auth-field">
          <label class="auth-label" for="password">Password</label>
          <input class="auth-input" type="password" id="password" name="password" placeholder="Your password" required>
        </div>
        <button class="auth-btn" type="submit">Sign In</button>
      </form>

      <div class="auth-divider"></div>
      <div class="auth-footer">
        Don't have an account? <a href="register.php">Create one</a>
      </div>
    </div>
  </main>
</body>
</html>
