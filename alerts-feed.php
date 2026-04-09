<?php
// alerts-feed.php — Returns active alerts for the current page from DB
declare(strict_types=1);
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$page = strtolower((string)($_GET['page'] ?? 'home'));
$page = preg_replace('/[^a-z]/', '', $page) ?: 'home';

try {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT alert_key as id, label, headline, summary, 
               event_time as time, transcript_id, action_text
        FROM pulse_alerts
        WHERE is_active = 1
          AND (page_scope = ? OR page_scope LIKE ? OR page_scope LIKE ? OR page_scope LIKE ?)
        ORDER BY event_time DESC
        LIMIT 10
    ");
    $stmt->execute([$page, $page.',%', '%,'.$page, '%,'.$page.',%']);
    $alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format time to ISO
    foreach ($alerts as &$a) {
        $a['time'] = (new DateTime($a['time']))->format(DATE_ATOM);
    }
    
    echo json_encode([
        'page' => $page,
        'generated_at' => (new DateTime())->format(DATE_ATOM),
        'alerts' => $alerts,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode(['page' => $page, 'generated_at' => date(DATE_ATOM), 'alerts' => []]);
}