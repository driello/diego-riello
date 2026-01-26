<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/db.php';

// ✅ Guard (à adapter à ton role exact)
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'recruiter') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$q = trim((string)($_GET['q'] ?? ''));
$city = trim((string)($_GET['city'] ?? ''));
$limit = 30;

// Base query : profil + dernières infos “résumé”
$sql = "
SELECT
  u.id AS user_id,
  u.first_name,
  u.last_name,
  p.headline,
  p.city,
  p.updated_at,
  GROUP_CONCAT(DISTINCT e.position ORDER BY e.position SEPARATOR ' • ') AS positions,
  GROUP_CONCAT(DISTINCT d.title ORDER BY d.title SEPARATOR ' • ') AS diplomas
FROM users u
JOIN candidate_profile p ON p.user_id = u.id
LEFT JOIN candidate_experiences e ON e.user_id = u.id
LEFT JOIN candidate_diplomas d ON d.user_id = u.id
WHERE 1=1
";

// ⚠️ si tu as une colonne role en BDD, tu peux filtrer ici (sinon on enlève)
// $sql .= " AND u.role = 'candidate' ";

$params = [];

if ($q !== '') {
    $sql .= " AND (
        p.headline LIKE :q
        OR p.summary LIKE :q
        OR e.position LIKE :q
        OR e.company LIKE :q
        OR d.title LIKE :q
      )";
    $params[':q'] = '%' . $q . '%';
}

if ($city !== '') {
    $sql .= " AND p.city LIKE :city";
    $params[':city'] = '%' . $city . '%';
}

$sql .= "
GROUP BY u.id
ORDER BY p.updated_at DESC
LIMIT {$limit}
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['items' => $rows], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
