<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">
      <h2>Bienvenue, <?= htmlspecialchars($_SESSION['first_name']) ?> 👋</h2>
      <p>Ceci est votre futur espace bureau interactif.</p>
      <a href="logout.php" class="btn btn-outline" style="margin-top: 20px;">Se déconnecter</a>
    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>
