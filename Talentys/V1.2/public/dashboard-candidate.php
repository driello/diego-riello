<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'candidate') {
  header("Location: login.php");
  exit;
}

// Récupération données utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
  echo "Utilisateur introuvable.";
  exit;
}
// Vérifie si le candidat a déjà un bureau (profil existant)
$profileStmt = $pdo->prepare("SELECT id FROM candidate_profile WHERE user_id = ?");
$profileStmt->execute([$_SESSION['user_id']]);
$hasDesk = (bool) $profileStmt->fetchColumn();

?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">

      <?php if (!$hasDesk): ?>
        <!-- ÉTAT 1 : aucun bureau créé -->
        <h2>Bienvenue sur Talentys, <?= htmlspecialchars($user['first_name']) ?> 👋</h2>
        <p style="margin-top: 8px; margin-bottom: 24px;">
          On commence par créer ton bureau virtuel.
        </p>
        <a href="wizard-candidate.php?step=1" class="btn btn-primary">
          Créer mon bureau
        </a>
        <div class="candidate-progress">
          <p style="font-weight: 600; margin-bottom: 8px;">Progression : 0%</p>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li>➊ Créer mon bureau</li>
            <li style="opacity: 0.6;">➋ Compléter mon profil</li>
            <li style="opacity: 0.6;">➌ Ajouter mes médias &amp; projets</li>
          </ul>
        </div>

      <?php else: ?>
        <!-- ÉTAT 2 : bureau déjà créé -->
        <h2>Ton bureau Talentys est prêt, <?= htmlspecialchars($user['first_name']) ?> 🎯</h2>
        <p style="margin-top: 8px; margin-bottom: 24px;">
          Tu peux l’ouvrir ou le modifier à tout moment.
        </p>

        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 24px;">
          <a href="desk-candidate.php" class="btn btn-primary">
            Ouvrir mon bureau
          </a>
          <a href="wizard-candidate.php?step=1" class="btn btn-outline">
            Modifier mon bureau
          </a>
        </div>

        <div class="candidate-progress">
          <p style="font-weight: 600; margin-bottom: 8px;">Progression : 60%</p>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li>✅ Étape 1 : Créer mon bureau</li>
            <li>🟡 Étape 2 : Compléter mon profil</li>
            <li style="opacity: 0.8;">⚪ Étape 3 : Ajouter mes médias &amp; projets</li>
          </ul>
        </div>

      <?php endif; ?>

      <div style="margin-top: 30px;">
        <a href="logout.php" class="btn btn-outline">Déconnexion</a>
      </div>

    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>