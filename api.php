<?php
// api.php - Final Robust Version
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    require_once 'db.php';
    require_once 'auth.php';

    // Connect to database using your specific db.php setup
    $db = getDB();

    $raw_input = file_get_contents('php://input');
    $data = json_decode($raw_input, true) ?? [];

    $action = $_GET['action'] ?? ($data['action'] ?? '');
    $article_id = $_GET['article_id'] ?? ($data['article_id'] ?? '');

    if (!$article_id) throw new Exception("Article ID is required");

    // ---------------------------------------------------------
    // GET DATA (Loads comments when you open the page)
    // ---------------------------------------------------------
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'get_data') {
        
        $stmt = $db->prepare("SELECT reaction, COUNT(*) as count FROM reactions WHERE article_id = ? GROUP BY reaction");
        $stmt->execute([$article_id]);
        $reaction_counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $my_reaction = null;
        if (isLoggedIn()) {
            $stmt = $db->prepare("SELECT reaction FROM reactions WHERE article_id = ? AND user_id = ?");
            $stmt->execute([$article_id, $_SESSION['user_id']]);
            $my_reaction = $stmt->fetchColumn();
        }

        $stmt = $db->prepare("
            SELECT c.id, c.body as text, c.likes, c.created_at, u.name, u.avatar_color 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.article_id = ? 
            ORDER BY c.created_at DESC
        ");
        $stmt->execute([$article_id]);
        $comments = $stmt->fetchAll();

        $my_likes = [];
        if (isLoggedIn()) {
            $stmt = $db->prepare("SELECT comment_id FROM comment_likes WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $my_likes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        echo json_encode([
            'reactions' => $reaction_counts,
            'myReaction' => $my_reaction,
            'comments' => $comments,
            'myLikes' => $my_likes,
            'isLoggedIn' => isLoggedIn()
        ]);
        exit();
    }

    // ---------------------------------------------------------
    // SECURITY CHECK
    // ---------------------------------------------------------
    if (!isLoggedIn()) {
        echo json_encode(['error' => 'You must be logged in.', 'notLoggedIn' => true]);
        exit();
    }
    
    $user_id = $_SESSION['user_id'];

    // CRITICAL FIX: Ensure the user actually exists in the database!
    $stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    if (!$stmt->fetch()) {
        session_destroy(); // Destroy the ghost session
        throw new Exception("Your session expired or user doesn't exist. Please log out and log back in.");
    }

    // ---------------------------------------------------------
    // TOGGLE REACTION
    // ---------------------------------------------------------
    if ($action === 'toggle_reaction') {
        $reaction = $data['reaction'];
        $db->prepare("DELETE FROM reactions WHERE article_id = ? AND user_id = ?")->execute([$article_id, $user_id]);
        $db->prepare("INSERT INTO reactions (user_id, article_id, reaction) VALUES (?, ?, ?)")->execute([$user_id, $article_id, $reaction]);
        
        echo json_encode(['success' => true]);
        exit();
    }

    // ---------------------------------------------------------
    // ADD COMMENT
    // ---------------------------------------------------------
    if ($action === 'add_comment') {
        $body = htmlspecialchars(trim($data['body'] ?? ''));
        if (empty($body)) throw new Exception("Comment cannot be empty");

        $db->prepare("INSERT INTO comments (user_id, article_id, body) VALUES (?, ?, ?)")
           ->execute([$user_id, $article_id, $body]);
        echo json_encode(['success' => true]);
        exit();
    }

    // ---------------------------------------------------------
    // TOGGLE COMMENT LIKE
    // ---------------------------------------------------------
    if ($action === 'toggle_like') {
        $comment_id = $data['comment_id'];
        $stmt = $db->prepare("SELECT 1 FROM comment_likes WHERE user_id = ? AND comment_id = ?");
        $stmt->execute([$user_id, $comment_id]);
        
        if ($stmt->fetchColumn()) {
            $db->prepare("DELETE FROM comment_likes WHERE user_id = ? AND comment_id = ?")->execute([$user_id, $comment_id]);
            $db->prepare("UPDATE comments SET likes = GREATEST(likes - 1, 0) WHERE id = ?")->execute([$comment_id]);
        } else {
            $db->prepare("INSERT INTO comment_likes (user_id, comment_id) VALUES (?, ?)")->execute([$user_id, $comment_id]);
            $db->prepare("UPDATE comments SET likes = likes + 1 WHERE id = ?")->execute([$comment_id]);
        }
        echo json_encode(['success' => true]);
        exit();
    }

    // ---------------------------------------------------------
    // DELETE COMMENT (admin only)
    // ---------------------------------------------------------
    if ($action === 'delete_comment') {
        // Only admins can delete comments
        $stmt = $db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $role = $stmt->fetchColumn();

        if ($role !== 'admin') {
            echo json_encode(['error' => 'Only admins can delete comments.']);
            exit();
        }

        $comment_id = (int)($data['comment_id'] ?? 0);
        if (!$comment_id) {
            echo json_encode(['error' => 'comment_id required.']);
            exit();
        }

        // Delete likes first (foreign key), then the comment
        $db->prepare("DELETE FROM comment_likes WHERE comment_id = ?")->execute([$comment_id]);
        $db->prepare("DELETE FROM comments WHERE id = ?")->execute([$comment_id]);

        echo json_encode(['success' => true, 'deleted_id' => $comment_id]);
        exit();
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => "Error: " . $e->getMessage()
    ]);
    exit();
}
?>