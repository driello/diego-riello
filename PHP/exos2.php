<?php define("SITE_NAME", "Apprendre PHP dans la douleur");
echo SITE_NAME;

ini_set('display_errors', '1');  // activer l'affichage des erreurs pour faciliter le débogage :
error_reporting(E_ALL); ?>
<?php $prenom = "Diego";
$age = 41;
// $entier = (integer)$age; // force le type de la variable (nombre entier dans ce cas)
echo gettype($age); // integer
var_dump($age);
?>
<!-- Exo 1.1 : phrase avec concaténation -->
<h1 style="text-align:center; margin-top: 50px;"><?php echo "Bienvenue en enfer 👺" . " " . "Don Diego"; ?></h1>
<!-- Exo 2 : date + heure + âge -->
<h2>Aujourd'hui nous sommes le <?= date('d/m/Y H:i:s'); ?> et j'ai <?= $age ?> ans</h2>
<!-- Exo 3 : ville / pays / population avec interpolation -->
<?php $pays = "France";
$ville = "Paris";
$population = 2000000;
echo gettype($population); ?>
<p style="background:red; color:whitesmoke; text-align:center">
    <?php echo "$ville est une ville de $pays, qui compte $population d'habitants" ?>
</p>

<a href="./exos3.php"<?= $id="variables" ?>&cat<?= $categorie="php" ?>>
         ➡️ Variables Types
    </a>
<button><a href="./index.php">INDEX</a></button>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Exercice 2 – Préférence de langue</title>
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
</style>
<body>

  <h1>Exercice 2 – Préférence de langue</h1>

  <pre class="md-viewer">
<?php
  // On lit le fichier Markdown
  $content = file_get_contents('./cours/02-syntaxe-base.md'); // adapte le chemin si besoin

  // On l'affiche en échappant les balises PHP/HTML
  echo htmlspecialchars($content, ENT_QUOTES);
?>
  </pre>

</body>
</html>
