<?php
// Exercice 4 : Lecture de fichier avec try/catch

function lireFichier(string $chemin): string
{
    if (!file_exists($chemin)) {
        throw new Exception("Le fichier '{$chemin}' n'existe pas.");
    }

    $contenu = file_get_contents($chemin);

    if ($contenu === false) {
        throw new Exception("Impossible de lire le fichier '{$chemin}'.");
    }

    return $contenu;
}

echo "<h2>Exercice 4 : Lecture de fichier avec try/catch</h2>";

// 1. Cas OK (si tu as créé un fichier demo.txt dans erreurs14/)
$cheminOk = __DIR__ . '/demo.txt';

// 2. Cas KO (fichier inexistant)
$cheminKo = __DIR__ . '/inexistant.txt';

echo "<h3>Lecture d'un fichier existant</h3>";
try {
    $contenu = lireFichier($cheminOk);
    echo "<pre>" . htmlspecialchars($contenu, ENT_QUOTES) . "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Erreur : {$e->getMessage()}</p>";
}

echo "<h3>Lecture d'un fichier inexistant</h3>";
try {
    $contenu = lireFichier($cheminKo);
    echo "<pre>" . htmlspecialchars($contenu, ENT_QUOTES) . "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Erreur : {$e->getMessage()}</p>";
}
