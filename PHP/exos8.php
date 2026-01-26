<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    h2 {
        background: blueviolet;
        color: whitesmoke;
    }

    .md-viewer {
        background: #0f172a;
        /* fond sombre type "editor" */
        color: #e5e7eb;
        /* texte gris clair */
        padding: 1.5rem;
        border-radius: 0.75rem;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-size: 0.95rem;
        line-height: 1.5;
        white-space: pre-wrap;
        /* les lignes longues reviennent à la ligne */
        border: 1px solid #1f2937;
    }

    /* Pour faire ressortir les lignes qui commencent par # (titres Markdown) */
    .md-viewer {
        counter-reset: line;
    }

    .md-viewer::before {
        content: "Markdown";
        display: block;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #38bdf8;
        margin-bottom: 0.5rem;
    }
</style>

<body>
    <span></a>
        <a href="./exos7.php" <?= $id = "tableaux" ?>&cat=<?= $categorie ?>>
            ⬅️ Tableaux
        </a><?= "-----PHP-----" ?>
        <a href="./exos9.php" <?= $id = "superglobaux" ?>&cat=<?= $categorie ?>>
            SuperGlobaux & Formulaires ➡️</a></span>
    <br>
    <br>
    <!-- Exo 8.1 : Longueur afficher le nombre de caractères d'une phrase  -->
    <?php
    $phrase = "Créez une fonction qui affiche le nombre de caractères d'une phrase";
    echo "La phrase contient :" . mb_strlen($phrase) . " " . "caractères";
    ?><br>

    <!-- Exo 8.2 :Inverser une chaîne de caractères  -->




    <button><a href="./index.php">INDEX</a></button>
    <pre class="md-viewer"><?php
    // On lit le fichier Markdown
    $content = file_get_contents('./cours/08-chaines-caracteres.md'); // adapte le chemin si besoin
    
    // On l'affiche en échappant les balises PHP/HTML
    echo htmlspecialchars($content, ENT_QUOTES);
    ?></pre>
</body>

</html>