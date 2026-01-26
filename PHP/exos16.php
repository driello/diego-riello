<?php
// exos16.php : HUB Leçon 16 - Déploiement minimal

$exo = isset($_GET['exo']) ? (int) $_GET['exo'] : 1;

$allowedExos = [1, 2, 3];
if (!in_array($exo, $allowedExos, true)) {
    $exo = 1;
}

$exoFile = __DIR__ . '/deploiement16/exo16_' . $exo . '.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 16 - Déploiement minimal</title>
</head>
<body>
    <h1>Leçon 16 : Déploiement minimal</h1>

    <nav>
        <ul>
            <li><a href="exos16.php?exo=1">Exercice 1 : Fichier .htaccess complet</a></li>
            <li><a href="exos16.php?exo=2">Exercice 2 : Composer & autoload</a></li>
            <li><a href="exos16.php?exo=3">Exercice 3 : Structure projet en production</a></li>
        </ul>
    </nav>

    <hr>

    <section>
        <?php
        if (file_exists($exoFile)) {
            require $exoFile;
        } else {
            echo "<p>Cet exercice n'est pas encore codé.</p>";
        }
        ?>
    </section>
</body>
</html>
