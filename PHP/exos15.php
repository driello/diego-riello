<?php
// exos15.php : HUB Leçon 15 - Sécurité essentielle

$exo = isset($_GET['exo']) ? (int) $_GET['exo'] : 1;

$allowedExos = [1, 2, 3];
if (!in_array($exo, $allowedExos, true)) {
    $exo = 1;
}

$exoFile = __DIR__ . '/securite15/exO15_' . $exo . '.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 15 - Sécurité essentielle</title>
</head>
<body>
    <h1>Leçon 15 : Sécurité essentielle</h1>

    <nav>
        <ul>
            <li><a href="exos15.php?exo=1">Exercice 1 : Page de connexion sécurisée</a></li>
            <li><a href="exos15.php?exo=2">Exercice 2 : Validation de formulaire</a></li>
            <li><a href="exos15.php?exo=3">Exercice 3 : Upload d'images sécurisé</a></li>
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
