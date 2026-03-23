<?php
// auth.php — Session manager
// Include this in any file that needs to check login status

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Returns true if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Returns current user data or null
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    return [
        'id'           => $_SESSION['user_id'],
        'name'         => $_SESSION['user_name'],
        'username'     => $_SESSION['user_username'],
        'email'        => $_SESSION['user_email'],
        'role'         => $_SESSION['user_role'],
        'avatar_color' => $_SESSION['user_avatar_color'],
    ];
}

// Redirect if not logged in (use in protected pages)
function requireLogin($redirectTo = 'login.php') {
    if (!isLoggedIn()) {
        header('Location: ' . $redirectTo);
        exit;
    }
}

// Returns JSON response for API endpoints
function jsonResponse($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
