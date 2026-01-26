<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'recruiter') {
    header("Location: login.php");
    exit;
}

// Récupération données recruteur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}
?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">
      <h2>Bonjour, <?= htmlspecialchars($user['first_name']) ?> 👋</h2>

      <p><strong>Entreprise :</strong> <?= htmlspecialchars($user['company_name'] ?? '-') ?></p>
      <p><strong>Rôle :</strong> <?= htmlspecialchars($user['company_role'] ?? '-') ?></p>
      <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>

      <div style="margin-top: 30px;">
        <a href="#" class="btn btn-outline">Publier une offre</a>
        <a href="#" class="btn btn-outline">Voir les candidats</a>
        <a href="#" class="btn btn-outline">Modifier mon profil</a>
        <a href="logout.php" class="btn btn-primary" style="margin-top: 10px;">Déconnexion</a>
      </div>
    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>
