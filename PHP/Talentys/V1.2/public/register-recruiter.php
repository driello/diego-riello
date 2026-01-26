<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $company_name = trim($_POST['company_name'] ?? '');
    $company_role = $_POST['company_role'] ?? '';
    $cgu = isset($_POST['cgu']);

    if (empty($first_name)) $errors['first_name'] = 'Prénom requis';
    if (empty($last_name)) $errors['last_name'] = 'Nom requis';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email invalide';
    if (empty($company_name)) $errors['company_name'] = 'Nom de l’entreprise requis';
    if (empty($company_role)) $errors['company_role'] = 'Rôle requis';
    if (!$cgu) $errors['cgu'] = 'Vous devez accepter les CGU';

    $pwd_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%&*]).{10,}$/';
    if (!preg_match($pwd_regex, $password)) {
        $errors['password'] = 'Mot de passe non conforme';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'Email déjà utilisé';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users 
            (first_name, last_name, email, password_hash, role, company_name, company_role) 
            VALUES (?, ?, ?, ?, 'recruiter', ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $hash, $company_name, $company_role]);

        header("Location: account-created.php");
        exit;
    }
}
?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">
      <h2>Créer un espace recruteur</h2>
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

        <label>Nom de l’entreprise</label>
        <input type="text" name="company_name" value="<?= htmlspecialchars($company_name ?? '') ?>">
        <p class="error"><?= $errors['company_name'] ?? '' ?></p>

        <label>Votre rôle</label>
        <select name="company_role">
          <option value="">-- Sélectionner --</option>
          <option value="RH" <?= ($company_role ?? '') === 'RH' ? 'selected' : '' ?>>RH</option>
          <option value="manager" <?= ($company_role ?? '') === 'manager' ? 'selected' : '' ?>>Manager</option>
          <option value="dirigeant" <?= ($company_role ?? '') === 'dirigeant' ? 'selected' : '' ?>>Dirigeant</option>
          <option value="autre" <?= ($company_role ?? '') === 'autre' ? 'selected' : '' ?>>Autre</option>
        </select>
        <p class="error"><?= $errors['company_role'] ?? '' ?></p>

        <label class="checkbox">
          <input type="checkbox" name="cgu" <?= $cgu ?? false ? 'checked' : '' ?>>
          J'accepte les <a href="#">CGU</a>
        </label>
        <p class="error"><?= $errors['cgu'] ?? '' ?></p>

        <button type="submit" class="btn btn-primary">Créer mon compte recruteur</button>
      </form>
    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>
