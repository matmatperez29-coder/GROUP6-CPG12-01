<?php
// transcript-feed.php — Returns a single transcript by key from DB
declare(strict_types=1);
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

$id = trim((string)($_GET['id'] ?? ''));

if ($id === '') {
    http_response_code(400);
    echo json_encode(['error' => 'id parameter required.']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT * FROM article_transcripts
        WHERE transcript_key = ? AND is_active = 1
        LIMIT 1
    ");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'Transcript not found.']);
        exit;
    }
    
    echo json_encode([
        'eyebrow'   => $row['eyebrow'],
        'headline'  => $row['headline'],
        'deck'      => $row['deck'],
        'author'    => $row['author'],
        'published' => $row['published_label'],
        'duration'  => $row['duration_label'],
        'summary'   => $row['summary'],
        'quote'     => $row['quote_text'],
        'signals'   => json_decode($row['signals_json'], true) ?? [],
        'transcript' => json_decode($row['transcript_json'], true) ?? [],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error.']);
}