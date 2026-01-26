
<?php
session_start();

// ✅ Guard (à adapter)
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
  <title>Talentys — Recherche de talents</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin: 24px; }
    .row { display: flex; gap: 12px; flex-wrap: wrap; }
    input { padding: 10px 12px; border: 1px solid #ddd; border-radius: 10px; }
    button { padding: 10px 14px; border: 0; border-radius: 10px; cursor: pointer; }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; margin-top: 16px; }
    .card { border: 1px solid #eee; border-radius: 14px; padding: 14px; }
    .muted { color: #666; font-size: 14px; }
    .actions { display: flex; gap: 10px; margin-top: 12px; }
    a.btn { display:inline-block; padding: 8px 10px; border-radius: 10px; border: 1px solid #ddd; text-decoration:none; color: #111; }
  </style>
</head>
<body>

<h1>Recherche de talents</h1>

<form id="searchForm" class="row">
  <input id="q" name="q" placeholder="Mots-clés (poste, stack, compétences…)" />
  <input id="city" name="city" placeholder="Ville (optionnel)" />
  <button type="submit">Rechercher</button>
</form>

<p class="muted" id="status"></p>
<div class="grid" id="results"></div>

<script>
const form = document.getElementById('searchForm');
const results = document.getElementById('results');
const statusEl = document.getElementById('status');

function escapeHtml(s="") {
  return s.replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;").replaceAll("'","&#039;");
}

async function runSearch() {
  statusEl.textContent = "Recherche…";
  results.innerHTML = "";

  const params = new URLSearchParams(new FormData(form));
  const res = await fetch(`./ajax/search_candidates.php?${params.toString()}`, { headers: { "Accept": "application/json" } });

  if (!res.ok) {
    statusEl.textContent = "Erreur (non autorisé ou serveur).";
    return;
  }

  const data = await res.json();
  const items = data.items || [];

  statusEl.textContent = `${items.length} résultat(s).`;

  results.innerHTML = items.map(it => {
    const name = `${escapeHtml(it.first_name || "")} ${escapeHtml(it.last_name || "")}`.trim();
    const headline = escapeHtml(it.headline || "Profil Talentys");
    const city = escapeHtml(it.city || "");
    const positions = escapeHtml(it.positions || "");
    const diplomas = escapeHtml(it.diplomas || "");

    return `
      <div class="card">
        <div style="font-weight:700">${name || "Candidat"}</div>
        <div class="muted">${headline}${city ? " • " + city : ""}</div>
        ${positions ? `<div style="margin-top:10px"><b>Exp. :</b> <span class="muted">${positions}</span></div>` : ""}
        ${diplomas ? `<div style="margin-top:6px"><b>Diplômes :</b> <span class="muted">${diplomas}</span></div>` : ""}
        <div class="actions">
          <a class="btn" href="../recruiter/talent.php?user_id=${encodeURIComponent(it.user_id)}">Voir profil</a>
<a class="btn" href="../desk-candidate.php?user_id=${encodeURIComponent(it.user_id)}">Ouvrir le bureau</a>      </div>
    `;
  }).join("");
}

form.addEventListener('submit', (e) => {
  e.preventDefault();
  runSearch();
});

runSearch();
</script>

</body>
</html>
