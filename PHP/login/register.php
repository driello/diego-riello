<?php
session_start();

// Fichier où on stocke les utilisateurs
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

$errors = [];

// 3) Traiter le formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Vérifs basiques
    if ($username === '') {
        $errors[] = "Nom d'utilisateur obligatoire.";
    }
    if ($password === '') {
        $errors[] = "Mot de passe obligatoire.";
    }
    if (isset($users[$username])) {
        $errors[] = "Ce nom d'utilisateur est déjà pris.";
    }

    // Si tout est OK : on enregistre
    if (empty($errors)) {
        // On stocke le mot de passe hashé (jamais en clair)
        $users[$username] = password_hash($password, PASSWORD_DEFAULT);

        // On réécrit le fichier JSON
        file_put_contents(
            $usersFile,
            json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Redirection vers login avec message "inscription OK"
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Créer un compte</h1>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label>
            Nom d'utilisateur :
            <input type="text" name="username" required>
        </label>
        <br><br>

        <label>
            Mot de passe :
            <input type="password" name="password" required>
        </label>
        <br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
</body>
</html>
