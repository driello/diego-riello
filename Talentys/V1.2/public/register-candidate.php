<?php
require_once '../config/db.php';

$errors = [];
$success = false;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name = trim($_POST['last_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';
  $city = trim($_POST['city'] ?? '');
  $status = $_POST['status'] ?? '';
  $cgu = isset($_POST['cgu']);

  // Validation
  if (empty($first_name))
    $errors['first_name'] = 'Prénom requis';
  if (empty($last_name))
    $errors['last_name'] = 'Nom requis';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors['email'] = 'Email invalide';

  if (!$cgu)
    $errors['cgu'] = 'Vous devez accepter les CGU';

  // Password strict option B
  $pwd_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%&*]).{10,}$/';
  if (!preg_match($pwd_regex, $password)) {
    $errors['password'] = 'Mot de passe non conforme';
  } elseif ($password !== $confirm_password) {
    $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
  }

  // Vérifie unicité email
  if (empty($errors)) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
      $errors['email'] = 'Email déjà utilisé';
    }
  }

  // Insertion si ok
  if (empty($errors)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users 
            (first_name, last_name, email, password_hash, role, city, status) 
            VALUES (?, ?, ?, ?, 'candidate', ?, ?)");
    $stmt->execute([$first_name, $last_name, $email, $hash, $city, $status]);

    header("Location: account-created.php");
    exit;
  }
}
?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">
      <h2>Créer mon profil candidat</h2>
      <form method="POST" novalidate>
        <label>Prénom</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($first_name ?? '') ?>">
        <p class="error"><?= $errors['first_name'] ?? '' ?></p>

        <label>Nom</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($last_name ?? '') ?>">
        <p class="error"><?= $errors['last_name'] ?? '' ?></p>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        <p class="error"><?= $errors['email'] ?? '' ?></p>

        <label>Mot de passe</label>
        <input type="password" name="password">
        <p class="error"><?= $errors['password'] ?? '' ?></p>

        <label>Confirmer le mot de passe</label>
        <input type="password" name="confirm_password">
        <p class="error"><?= $errors['confirm_password'] ?? '' ?></p>

        <label>Ville</label>
        <input type="text" name="city" value="<?= htmlspecialchars($city ?? '') ?>">

        <label>Status</label>
        <select name="status">
          <option value="">-- Sélectionner --</option>
          <option value="etudiant" <?= ($status ?? '') === 'etudiant' ? 'selected' : '' ?>>Étudiant</option>
          <option value="en_poste" <?= ($status ?? '') === 'en_poste' ? 'selected' : '' ?>>En poste</option>
          <option value="recherche" <?= ($status ?? '') === 'recherche' ? 'selected' : '' ?>>En recherche</option>
          <option value="freelance" <?= ($status ?? '') === 'freelance' ? 'selected' : '' ?>>Freelance</option>
        </select>

        <label class="checkbox">
          <input type="checkbox" name="cgu" <?= $cgu ?? false ? 'checked' : '' ?>>
          J'accepte les <a href="#">CGU</a>
        </label>
        <p class="error"><?= $errors['cgu'] ?? '' ?></p>

        <button type="submit" class="btn btn-primary">Créer mon profil</button>
      </form>
    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>