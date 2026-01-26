<?php
// exos13.php : HUB POO

// On lit le numéro d'exercice dans l'URL, par défaut 1
$exo = isset($_GET['exo']) ? (int) $_GET['exo'] : 1;

// On limite aux exos 1 à 4
$allowedExos = [1, 2, 3, 4];
if (!in_array($exo, $allowedExos, true)) {
    $exo = 1;
}

// On construit le chemin du fichier à inclure
$exoFile = __DIR__ . '/poo13/exo13_' . $exo . '.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercice 13 - POO</title>
</head>
<body>
    <h1>Leçon 13 : Programmation Orientée Objet (POO)</h1>

    <nav>
        <ul>
            <li><a href="exos13.php?exo=1">Exercice 1 : Personne</a></li>
            <li><a href="exos13.php?exo=2">Exercice 2 : Compte bancaire</a></li>
            <li><a href="exos13.php?exo=3">Exercice 3 : Animaux</a></li>
            <li><a href="exos13.php?exo=4">Exercice 4 : Formes géométriques</a></li>
        </ul>
    </nav>

    <hr>

    <section>
        <?php
        // On inclut le fichier correspondant, si il existe
        if (file_exists($exoFile)) {
            require $exoFile;
        } else {
            echo "<p>Exercice non encore disponible.</p>";
        }
        ?>
    </section>
</body>
</html>
