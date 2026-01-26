<?php
// exos14.php : HUB Leçon 14 - Gestion des erreurs & debugging

$exo = isset($_GET['exo']) ? (int) $_GET['exo'] : 1;

$allowedExos = [1, 2, 3, 4];
if (!in_array($exo, $allowedExos, true)) {
    $exo = 1;
}

$exoFile = __DIR__ . '/erreurs14/exo14_' . $exo . '.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 14 - Gestion des erreurs & debugging</title>
</head>
<body>
    <h1>Leçon 14 : Gestion des erreurs & debugging</h1>

    <nav>
        <ul>
            <li><a href="exos14.php?exo=1">Exercice 1 : Gestionnaire d'erreurs simple</a></li>
            <li><a href="exos14.php?exo=2">Exercice 2 : Validation avec exceptions</a></li>
            <li><a href="exos14.php?exo=3">Exercice 3 : Logger</a></li>
            <li><a href="exos14.php?exo=4">Exercice 4 : Lecture de fichier avec try/catch</a></li>
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
