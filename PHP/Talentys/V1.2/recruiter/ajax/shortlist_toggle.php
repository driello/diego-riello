<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'recruiter') {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

header('Content-Type: application/json; charset=utf-8');

$recruiterId = (int) $_SESSION['user_id'];
$candidateId = (int) ($_POST['candidate_user_id'] ?? 0);
$action = (string) ($_POST['action'] ?? 'add'); // add | remove

if ($candidateId <= 0 || !in_array($action, ['add','remove'], true)) {
  http_response_code(400);
  echo json_encode(['error' => 'Bad request']);
  exit;
}

try {
  if ($action === 'add') {
    $stmt = $pdo->prepare("
      INSERT IGNORE INTO recruiter_shortlist (recruiter_user_id, candidate_user_id)
      VALUES (?, ?)
    ");
    $stmt->execute([$recruiterId, $candidateId]);
  } else {
    $stmt = $pdo->prepare("
      DELETE FROM recruiter_shortlist
      WHERE recruiter_user_id = ? AND candidate_user_id = ?
    ");
    $stmt->execute([$recruiterId, $candidateId]);
  }

  echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Server error']);
}
