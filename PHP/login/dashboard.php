<?php
session_start();

// Durée de vie de la session (en secondes)
$sessionLifetime = 300; // 5 minutes

// 1. Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

// 2. Vérifier l'expiration de la session
if (!isset($_SESSION['connexion'])) {
    $_SESSION['connexion'] = time();
}

if (time() - $_SESSION['connexion'] > $sessionLifetime) {
    // Si on arrive ici, la session est encore valide → on rafraîchit le timestamp
    $_SESSION['connexion'] = time();

    // Session expirée : on supprime tout
    session_unset();
    session_destroy();

    // On renvoie vers login avec un indicateur d'expiration
    header('Location: login.php?expired=1');
    exit;
}
// 2. Si le compteur n'existe pas encore dans la session, on l'initialise à 1
if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
} else {
    // 3. Sinon, on l'incrémente à chaque chargement de la page
    $_SESSION['visit_count']++;
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h1>Dashboard</h1>

    <p>
        Bonjour
        <strong><?= htmlspecialchars($_SESSION['utilisateur']) ?></strong> 👋
    </p>

    <p>
        Ceci est une page protégée, accessible seulement si vous êtes connecté.
    </p>
    <?php
    $visites = $_SESSION['visit_count'] ?? 0;
    ?>

    <p>Vous avez visité la page des exercices <?= $visites ?> fois.</p>


    <p>
        <a href="logout.php">Se déconnecter</a>
    </p>
</body>

</html>