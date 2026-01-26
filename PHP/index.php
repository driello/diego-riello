<?php
// 1. On démarre la session (obligatoire AVANT tout HTML)
session_start();

// 2. Si le compteur n'existe pas encore dans la session, on l'initialise à 1
if (!isset($_SESSION['visit_count'])) {
  $_SESSION['visit_count'] = 1;
} else {
  // 3. Sinon, on l'incrémente à chaque chargement de la page
  $_SESSION['visit_count']++;
} ?>
<?php
// ---------------------------
// 1. Message d'accueil
// ---------------------------

// On récupère l'heure au format "00" à "23"
$hour = date('H');

// On choisit un message en fonction de l'heure
if ($hour < 12) {
  $sayHello = "Good Morning";
} elseif ($hour < 18) {
  $sayHello = "Good Afternoon";
} else {
  $sayHello = "Good Evening";
}

// ---------------------------
// 2. Variables pour la recherche
// ---------------------------

// Message d'erreur à afficher sous le formulaire (vide par défaut)
$errorMessage = '';

// Terme tapé dans la barre de recherche (GET)
// Si 'search_term' n'existe pas dans l'URL, on met une chaîne vide pour éviter les erreurs
$searchTerm = $_GET['search_term'] ?? '';

// ---------------------------
// 3. Tableau des exercices + mots-clés associés
//    Ici on commence avec l'exercice 2 uniquement
// ---------------------------

$exerciseKeywords = [
  // Exercice 2 : syntaxe de base
  2 => [
    'file' => 'exos2.php',
    'keywords' => [
      'syntaxe',
      'syntaxe de base',
      'php de base',
      'balises php',
      'balises',
      'ouverture php',
      'fermeture php',
      'echo',
      'instruction',
      'instructions',
      'point virgule',
      'commentaires',
      'commentaire',
      'phpinfo',
    ],
  ],

  // Exercice 3 : variables
  3 => [
    'file' => 'exos3.php',
    'keywords' => [
      'variable',
      'variables',
      'declaration variable',
      'declarer une variable',
      'affectation',
      'assignation',
      'operateur d affectation',
      'types',
      'type de donnees',
      'string',
      'chaine',
      'texte',
      'int',
      'integer',
      'entier',
      'float',
      'nombre decimal',
      'bool',
      'boolean',
      'booleen',
      'null',
      'var_dump',
      'gettype',
    ],
  ],

  // Exercice 4 : operateurs
  4 => [
    'file' => 'exos4.php',
    'keywords' => [
      // vocabulaire général
      'operateur',
      'operateurs',
      'opérateur',
      'opérateurs',

      // opérateurs arithmétiques
      'addition',
      'soustraction',
      'multiplication',
      'division',
      'modulo',
      'reste',
      '+',
      '-',
      '*',
      '/',
      '%',

      // opérateurs de comparaison
      'comparaison',
      'comparer',
      'egal',
      'egalite',
      'different',
      'superieur',
      'inferieur',
      '>=',
      '<=',
      '==',
      '===',
      '!=',
      '!==',

      // opérateurs logiques
      'logique',
      'et',
      'ou',
      'non',
      'and',
      'or',
      'xor',
      '&&',
      '||',

      // opérateurs d’affectation composés
      'operateur d affectation',
      '+=',
      '-=',
      '*=',
      '/=',
      '%=',
    ],
  ],

  // Exercice 5 : structures de controle
  5 => [
    'file' => 'exos5.php',
    'keywords' => [
      'structure de controle',
      'structures de controle',
      'controle de flux',
      'conditions',
      'condition',

      // if / else / elseif / switch
      'if',
      'else',
      'elseif',
      'switch',
      'case',
      'default',
      'operateur ternaire',

      // boucles
      'boucle',
      'boucles',
      'while',
      'boucle while',
      'do while',
      'for',
      'boucle for',
      'foreach',

      // autres
      'break',
      'continue',
    ],
  ],

  // Exercice 6 : fonctions
  6 => [
    'file' => 'exos6.php',
    'keywords' => [
      'fonction',
      'fonctions',
      'function',
      'declaration de fonction',
      'declarer une fonction',
      'appel de fonction',
      'appel de fonctions',

      'parametre',
      'parametres',
      'argument',
      'arguments',
      'valeur de retour',
      'return',

      'valeur par defaut',
      'type hinting',
      'typage',
      'portee',
      'scope',
      'variable locale',
      'variable globale',
    ],
  ],

  // Exercice 7 : tableaux
  7 => [
    'file' => 'exos7.php',
    'keywords' => [
      'tableau',
      'tableaux',
      'array',

      'tableau indexe',
      'tableaux indexes',
      'tableau associatif',
      'tableau multidimensionnel',

      'index',
      'cle',
      'clef',
      'valeur',

      'parcourir un tableau',
      'boucle sur un tableau',
      'foreach sur un tableau',

      'count',
      'in_array',
      'array_push',
      'array_pop',
      'array_shift',
      'array_unshift',
      'array_merge',
    ],
  ],

  // Exercice 8 : chaines de caracteres
  8 => [
    'file' => 'exos8.php',
    'keywords' => [
      'chaine',
      'chaine de caracteres',
      'chaines',
      'string',
      'texte',

      'concatenation',
      'concatener',
      'concatenation de chaines',
      'operateur point',

      'manipulation de chaine',
      'strlen',
      'substr',
      'str_replace',
      'strpos',
      'strtolower',
      'strtoupper',
      'trim',
      'nl2br',
    ],
  ],

  // Exercice 9 : superglobales et formulaires (lecon 9)
  9 => [
    'file' => 'exos9.php',
    'keywords' => [
      'superglobales',
      'superglobale',
      'variable superglobale',

      '$_GET',
      'get',
      'requete get',
      'parametres url',
      'query string',

      '$_POST',
      'post',
      'requete post',
      'donnees formulaire',

      '$_REQUEST',
      '$_SERVER',
      '$_SESSION',
      '$_COOKIE',
      '$_FILES',
      '$_ENV',
      '$GLOBALS',

      'formulaire',
      'formulaires',
      'form html',
      'balise form',
      'input',
      'champ de formulaire',
      'textarea',
      'select',
      'bouton submit',
      'button submit',

      'method post',
      'method get',
      'attribut action',
      'traitement formulaire',
      'traitement.php',
      'traitement des donnees',
    ],
  ],
  10 => [
    'file' => 'exos10.php',
    [
      'login',
      'logout',
    ],
  ],
];


// ---------------------------
// 4. Logique de recherche
// ---------------------------

// On ne lance la recherche que si l'utilisateur a tapé quelque chose
if ($searchTerm !== '') {

  // On supprime les espaces avant/après
  $normalized = trim($searchTerm);

  // 4.1. CAS N°1 : l'utilisateur a tapé uniquement des chiffres → numéro d'exercice
  if (ctype_digit($normalized)) {

    // On convertit en entier (ex: "3" → 3)
    $exoNumber = (int) $normalized;

    // On fabrique le nom du fichier : exos3.php, exos8.php, etc.
    $target = "exos{$exoNumber}.php";

    // On vérifie si le fichier existe réellement avant de rediriger
    if (file_exists($target)) {
      // Redirection vers la page de l'exercice
      header("Location: " . $target);
      exit; // On stoppe le script après la redirection
    } else {
      // Le fichier n'existe pas → on prépare un message d'erreur
      $errorMessage = "Aucun exercice ne correspond au numéro " . htmlspecialchars($normalized, ENT_QUOTES) . ".";
    }
  }

  // 4.2. CAS N°2 : ce n'est PAS un numéro → on cherche dans les mots-clés
  else {

    // On passe la recherche en minuscules pour faire une comparaison insensible à la casse
    $normalizedLower = strtolower($normalized);

    // Flag pour savoir si on a trouvé un exercice ou non
    $matched = false;

    // On parcourt tous les exercices décrits dans $exerciseKeywords
    foreach ($exerciseKeywords as $exoNumber => $data) {

      // On parcourt chaque mot-clé associé à cet exercice
      foreach ($data['keywords'] as $keyword) {

        // stripos() cherche la position du mot-clé dans la chaîne
        // !== false → le mot-clé est trouvé quelque part dans la recherche
        if (stripos($normalizedLower, strtolower($keyword)) !== false) {

          // On récupère le fichier cible de cet exercice
          $target = $data['file'];

          // On vérifie que le fichier existe
          if (file_exists($target)) {
            // Redirection vers l'exercice lié au mot-clé
            header("Location: " . $target);
            exit;
          } else {
            // Le fichier indiqué dans le tableau n'existe pas (cas rare)
            $errorMessage = "L'exercice lié à ce mot-clé n'est pas encore disponible.";
          }

          // On signale qu'on a trouvé un match
          $matched = true;

          // break 2; → on sort des deux boucles foreach (mots-clés + exercices)
          break 2;
        }
      }
    }

    // Si on n'a trouvé aucun exercice ET qu'aucun autre message d'erreur n'a été défini
    if (!$matched && $errorMessage === '') {
      $errorMessage = "Aucun exercice ne correspond à ta recherche : " . htmlspecialchars($normalized, ENT_QUOTES) . ".";
    }
  }
}
?>





<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Index des exercices PHP</title>

  <style>
    /* Style global */
    body {
      margin: 0;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
      color: #222;
      background: whitesmoke;

    }

    .page-header {
      text-align: center;
      padding: 2rem 1rem 1rem;

    }

    .page-header h1 {
      margin: 0 0 0.5rem;
      font-size: 1.8rem;
    }

    .page-header p {
      margin: 0;
      font-size: 0.95rem;
      color: #555;
    }

    .wrapper {
      max-width: 900px;
      margin: 0 auto 3rem;
      padding: 0 1rem;
      background-image: url("/img/dev.webp");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;


    }

    .exo-section-title {
      text-align: center;
      margin: 2rem 0 1.5rem;
      font-size: 1.5rem;
      color: whitesmoke;
    }

    /* Liste des exercices sous forme de cartes */
    .exo-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1rem;
    }

    .exo-list li a {
      display: block;
      padding: 1rem 1.2rem;
      background: #ffffff;
      border-radius: 0.6rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
      text-decoration: none;
      color: #222;
      font-weight: 500;
      transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    }

    .exo-list li a span {
      display: block;
    }

    .exo-list li a .exo-name {
      font-size: 1rem;
    }

    .exo-list li a .exo-info {
      font-size: 0.85rem;
      color: #777;
      margin-top: 0.25rem;
    }

    .exo-list li a:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
      background: #f8f9ff;
    }
  </style>
</head>

<body>



  <header class="page-header">
    <h1><?php echo $sayHello; ?> Don Diego</h1>
    <p>
      We are <?php echo date('l d/m/y'); ?>
      and it's <?php echo date('H:i'); ?> — PHP done 🚀 ✅
    </p>
    <p>
      You visit this page
      <strong><?php echo $_SESSION['visit_count']; ?></strong>
      times since your session start 🔁
    </p>
  </header>
  <!--Formulaire de recherche par thème dans les exercices php  -->
  <form method="get" action="">
    <label for="item-search">Rechercher un exercice :</label>
    <input type="search" id="item-search" name="search_term" />

    <button type="submit">Search</button>
  </form>

  <?php if ($errorMessage !== ''): ?>
    <p style="color:red;">
      <?php echo $errorMessage; ?>
    </p>
  <?php endif; ?>

  <?php
  $searchTerm = $_GET['search_term'] ?? ''; // Si search_term existe, on le prend. Sinon, on met une chaîne vide ('') pour éviter les erreurs.
  ?>
  <main class="wrapper">
    <h2 class="exo-section-title">Index des exercices PHP</h2>

    <ul class="exo-list">
      <li>
        <a href="./exos1.php">
          <span class="exo-name">Exercice 1</span>
          <span class="exo-info">Introduction</span>
        </a>
      </li>
      <li>
        <a href="./exos2.php">
          <span class="exo-name">Exercice 2</span>
          <span class="exo-info">Syntaxe</span>
        </a>
      </li>
      <li>
        <a href="./exos3.php">
          <span class="exo-name">Exercice 3</span>
          <span class="exo-info">Variables</span>
        </a>
      </li>
      <li>
        <a href="./exos4.php">
          <span class="exo-name">Exercice 4</span>
          <span class="exo-info">Opérateurs</span>
        </a>
      </li>
      <li>
        <a href="./exos5.php">
          <span class="exo-name">Exercice 5</span>
          <span class="exo-info">Structures de contrôle</span>
        </a>
      </li>
      <li>
        <a href="./exos6.php">
          <span class="exo-name">Exercice 6</span>
          <span class="exo-info">Fonctions</span>
        </a>
      </li>
      <li>
        <a href="./exos7.php">
          <span class="exo-name">Exercice 7</span>
          <span class="exo-info">Tableaux</span>
        </a>
      </li>
      <li>
        <a href="./exos8.php">
          <span class="exo-name">Exercice 8</span>
          <span class="exo-info">Chaînes de caractères</span>
        </a>
      </li>
      <li>
        <a href="./exos9.php">
          <span class="exo-name">Exercice 9</span>
          <span class="exo-info">SuperGlobaux</span>
        </a>
      </li>
      <li>
        <a href="./exos10.php">
          <span class="exo-name">Exercice 10</span>
          <span class="exo-info">Sessions - Cookies</span>
        </a>
      </li>
      <li>
        <a href="./exos11.php">
          <span class="exo-name">Exercice 11</span>
          <span class="exo-info">Fichiers et entrée/sortie</span>
        </a>
      </li>
      <li>
        <a href="./exos12.php">
          <span class="exo-name">Exercice 12</span>
          <span class="exo-info">PHP Data Object</span>
        </a>
      </li>
      <li>
        <a href="./exos13.php">
          <span class="exo-name">Exercice 13</span>
          <span class="exo-info">Programmation Orientée Objet (POO)</span>
        </a>
      </li>
      <li>
        <a href="./exos14.php">
          <span class="exo-name">Exercice 14</span>
          <span class="exo-info">Gestion des erreurs & debugging</span>
        </a>
      </li>
      <li>
        <a href="./exos15.php">
          <span class="exo-name">Exercice 15</span>
          <span class="exo-info">Sécurité essentielle</span>
        </a>
      </li>
      <li>
        <a href="./exos16.php">
          <span class="exo-name">Exercice 16</span>
          <span class="exo-info">Déploiement minimal</span>
        </a>
      </li>
      <li>
        <a href="./exos17.php">
          <span class="exo-name">Exercice 17</span>
          <span class="exo-info">Exercices et corrigés</span>
        </a>
      </li>
      <li>
        <a href="./exos18.php">
          <span class="exo-name">Exercice 18</span>
          <span class="exo-info">À compléter</span>
        </a>
      </li>
    </ul>
  </main>
</body>

</html>