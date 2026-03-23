<?php
// api-search.php — Returns approved submitted articles as JSON for search.js
require_once 'db.php';
header('Content-Type: application/json');
header('Cache-Control: max-age=30');

try {
    $db   = getDB();
    $stmt = $db->query("
        SELECT s.id, s.title, s.category, s.summary, u.name AS author_name
        FROM article_submissions s
        JOIN users u ON s.author_id = u.id
        WHERE s.status = 'approved'
        ORDER BY s.submitted_at DESC
        LIMIT 100
    ");
    $rows    = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    foreach ($rows as $r) {
        $results[] = [
            'title' => $r['title'],
            'url'   => 'view-article.php?id=' . $r['id'],
            'cat'   => $r['category'],
            'kw'    => $r['author_name'] . ' ' . $r['category'] . ' ' . $r['title'] . ' ' . $r['summary'],
            'desc'  => $r['summary'],
        ];
    }
    echo json_encode(['success' => true, 'articles' => $results]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'articles' => [], 'error' => $e->getMessage()]);
}