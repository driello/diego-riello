<?php
session_start();
require_once '../config/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email invalide';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['first_name'] = $user['first_name'];

            header("Location: dashboard-candidate.php");
            exit;
        } else {
            $errors['login'] = 'Email ou mot de passe incorrect';
        }
    }
}
?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">
      <h2>Connexion</h2>

      <?php if (!empty($errors['login'])): ?>
        <p class="error"><?= $errors['login'] ?></p>
      <?php endif; ?>

      <form method="POST" novalidate>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        <p class="error"><?= $errors['email'] ?? '' ?></p>

        <label>Mot de passe</label>
        <input type="password" name="password">
        <p class="error"><?= $errors['password'] ?? '' ?></p>

        <button type="submit" class="btn btn-primary">Se connecter</button>
      </form>
    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>
