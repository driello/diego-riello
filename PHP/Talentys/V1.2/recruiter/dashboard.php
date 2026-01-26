<?php
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'recruiter') {
  header('Location: ../login.php');
  exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Talentys — Espace recruteur</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin: 24px; }
    .grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-top: 18px; }
    .card { border:1px solid #eee; border-radius: 16px; padding: 16px; }
    .title { font-weight: 800; font-size: 20px; }
    .muted { color:#666; margin-top: 6px; }
    a.btn { display:inline-block; margin-top: 12px; padding: 10px 12px; border-radius: 12px; border:1px solid #ddd; text-decoration:none; color:#111; }
  </style>
</head>
<body>

<h1>Espace recruteur</h1>
<p class="muted">Objectif démo : trouver un talent → ouvrir son bureau → short-list.</p>

<div class="grid">
  <div class="card">
    <div class="title">🔎 Rechercher des talents</div>
    <div class="muted">Filtres + résultats (cards) branchés sur ta BDD.</div>
    <a class="btn" href="./search.php">Ouvrir la recherche</a>
  </div>

  <div class="card">
    <div class="title">⭐ Ma short-list</div>
    <div class="muted">V1 : page simple (à faire juste après).</div>
    <a class="btn" href="./shortlist.php">Voir la short-list</a>
  </div>

  <div class="card">
    <div class="title">🕒 Profils consultés</div>
    <div class="muted">V1 : optionnel (historique léger).</div>
    <a class="btn" href="./recent.php">Voir l’historique</a>
  </div>
</div>

</body>
</html>
