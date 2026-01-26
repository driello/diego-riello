<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'recruiter') {
  header('Location: ../login.php');
  exit;
}

$recruiterId = (int) $_SESSION['user_id'];

$stmt = $pdo->prepare("
  SELECT
    u.id AS user_id,
    u.first_name,
    u.last_name,
    p.headline,
    p.city,
    s.created_at
  FROM recruiter_shortlist s
  JOIN users u ON u.id = s.candidate_user_id
  JOIN candidate_profile p ON p.user_id = u.id
  WHERE s.recruiter_user_id = ?
  ORDER BY s.created_at DESC
");
$stmt->execute([$recruiterId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Talentys — Short-list</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin: 24px; }
    .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; margin-top: 16px; }
    .card { border: 1px solid #eee; border-radius: 14px; padding: 14px; }
    .muted { color:#666; font-size:14px; }
    .actions { display:flex; gap:10px; margin-top:12px; }
    a.btn, button.btn { padding: 8px 10px; border-radius: 10px; border: 1px solid #ddd; background:#fff; cursor:pointer; text-decoration:none; color:#111; }
  </style>
</head>
<body>

<h1>⭐ Ma short-list</h1>
<p class="muted"><?= count($items) ?> profil(s)</p>

<div class="grid">
<?php foreach ($items as $it): ?>
  <div class="card">
    <div style="font-weight:700;">
      <?= htmlspecialchars(($it['first_name'] ?? '') . ' ' . ($it['last_name'] ?? '')) ?>
    </div>
    <div class="muted">
      <?= htmlspecialchars($it['headline'] ?? 'Profil Talentys') ?>
      <?= !empty($it['city']) ? ' • ' . htmlspecialchars($it['city']) : '' ?>
    </div>

    <div class="actions">
      <a class="btn" href="../desk-candidate.php?user_id=<?= (int)$it['user_id'] ?>">Ouvrir le bureau</a>

      <form method="post" action="./ajax/shortlist_toggle.php" onsubmit="return removeShortlist(event, <?= (int)$it['user_id'] ?>)">
        <input type="hidden" name="candidate_user_id" value="<?= (int)$it['user_id'] ?>">
        <input type="hidden" name="action" value="remove">
        <button class="btn" type="submit">Retirer</button>
      </form>
    </div>
  </div>
<?php endforeach; ?>
</div>

<script>
async function removeShortlist(e, candidateId) {
  e.preventDefault();
  const form = e.target;
  const fd = new FormData(form);

  const res = await fetch(form.action, { method: "POST", body: fd });
  if (res.ok) location.reload();
  return false;
}
</script>

</body>
</html>
