<?php
session_start();

// Fichier des utilisateurs (même que dans register.php)
$usersFile = __DIR__ . '/users.json';

// 1) S'assurer que le fichier existe
if (!file_exists($usersFile)) {
  file_put_contents($usersFile, json_encode([]));
}

// 2) Charger les utilisateurs existants
$json = file_get_contents($usersFile);
$users = json_decode($json, true);
if (!is_array($users)) {
  $users = [];
}

// Variables de messages
$erreur = '';
$message = '';


if (isset($_GET['expired']) && $_GET['expired'] == '1') {
  $message = "Votre session a expiré. Merci de vous reconnecter.";
}

if (isset($_GET['logout']) && $_GET['logout'] == '1') {
  $message = "Vous avez été déconnecté.";
}



// on traite le formulaire.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $erreur = 'Nom d’utilisateur et mot de passe obligatoires.';
  } elseif (!isset($users[$username])) {
    $erreur = 'Identifiants invalides';
  } elseif (!password_verify($password, $users[$username])) {
    $erreur = 'Identifiants invalides';
  } else {
    // Connexion réussie
    $_SESSION['utilisateur'] = $username;
    $_SESSION['connexion'] = time();
    header('Location: dashboard.php');
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
</head>

<body>
  <h1>Page de connexion</h1>

  <?php if ($erreur): ?>
    <p style="color: red;">
      <?= htmlspecialchars($erreur) ?>
    </p>
  <?php endif; ?>

  <?php if ($message): ?>
    <p style="color: green;">
      <?= htmlspecialchars($message) ?>
    </p>
  <?php endif; ?>


  <form method="post" action="">
    <label>
      Nom d'utilisateur :
      <input type="text" name="username" required>
    </label>
    <br>

    <label>
      Mot de passe :
      <input type="password" name="password" required>
    </label>
    <br>

    <button type="submit">Se connecter</button>
  </form>
</body>

</html>