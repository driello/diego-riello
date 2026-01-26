<?php
// Langue par défaut
$lang = 'fr';

// Liste des langues autorisées
$allowedLangs = ['fr', 'en'];

// 1) L'utilisateur vient de choisir une langue ? (via ?lang=fr ou ?lang=en)
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowedLangs, true)) {
  $lang = $_GET['lang'];

  // On enregistre le choix dans un cookie pour 30 jours
  setcookie('lang', $lang, time() + 60 * 60 * 24 * 30, '/');
}
// 2) Sinon, on regarde si un cookie existe déjà
elseif (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $allowedLangs, true)) {
  $lang = $_COOKIE['lang'];
}
?>

<?php
// 1. On démarre la session (obligatoire AVANT tout HTML)
session_start();

$_SESSION['utilisateur'] = "Alice";
$_SESSION['email'] = "alice@example.com";
$_SESSION['role'] = "admin";
$_SESSION['connexion'] = time();  // horodatage de connexion (time() = nombre de secondes depuis 1970)

$nom = $_SESSION['utilisateur'] ?? 'Invité';
echo "Bonjour, $nom !";


// 2. Si le compteur n'existe pas (!isset = n'existe pas) encore dans la session, on l'initialise à 1
if (!isset($_SESSION['visit_count'])) {
  $_SESSION['visit_count'] = 1;
} else {
  // 3. Sinon, on l'incrémente à chaque chargement de la page
  $_SESSION['visit_count']++;
}
?>
<?php


// Exercice 3 : Panier

// 1) Liste simple de produits disponibles
$products = [
  1 => 'Pomme',
  2 => 'Banane',
  3 => 'Orange',
];

// 2) Initialisation du panier dans la session
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];   // clé = id produit, valeur = quantité
}
// 3) Gestion des actions du panier via l'URL : ?action=...&id=...
if (isset($_GET['action'])) {
  $action = $_GET['action'];

  // Ajouter un produit
  if ($action === 'add' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // on vérifie que le produit existe dans le tableau $products
    if (isset($products[$id])) {
      if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
      } else {
        $_SESSION['cart'][$id]++;
      }
    }
  }
  // Supprimer complètement un produit du panier
  if ($action === 'remove' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
      unset($_SESSION['cart'][$id]);
    }
  }
  // Vider complètement le panier
  if ($action === 'clear') {
    $_SESSION['cart'] = [];
  }
}


// Exercice 4 - Systeme de connexion
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Compteur de visites</title>
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

  /* Formulaire */
  form {
    max-width: 450px;
    margin: 1.5rem auto;
    background: #fff;
    padding: 1rem 1.5rem;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }


  /* Label + champ alignés */
  form label {
    display: inline-block;
    width: 150px;
    font-weight: 600;
  }

  form input {
    padding: 0.3rem 0.4rem;
    border: 1px solid #ccc;
    border-radius: 3px;
  }

  /* Bouton */
  form input[type="submit"],
  form button {
    margin-left: 110px;
    /* aligné avec les champs */
    margin-top: 0.5rem;
    padding: 0.4rem 0.9rem;
    background: #8e3adf;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  form input[type="submit"]:hover,
  form button:hover {
    background: #732fba;
  }


</style>

<body>
  <header>
    <h1>Sessions - Cookies</h1>
       <a href="./exos9.php" <?= $page ?>&cat=<?= $categorie ?>>
      ⬅️ SuperGlobaux
    </a><?= "-----PHP-----" ?>
    <a href="./exos11.php" <?= $page ?>&cat=<?= $categorie ?>>
      FIchiers IO ➡️
    </a><br>
    <br>
    <h2>Exo 1 - Compteur de visites</h2>
     <p>
    Tu as visité cette page
    <strong><?php echo $_SESSION['visit_count']; ?></strong>
    fois depuis le début de ta session 🔁
  </p>
 
  </header>

  <h2>Exo 2 - Choix de la langue</h2>

  <p>
    <a href="?lang=fr">🇫🇷 Français</a>
    <a href="?lang=en">🇬🇧 English</a>
  </p>

  <?php if ($lang === 'fr'): ?>
    <h2>Bonjour !</h2>
    <p>La langue actuelle est : <strong>Français</strong>.</p>
  <?php else: ?>
    <h2>Hello!</h2>
    <p>Current language is: <strong>English</strong>.</p>
  <?php endif; ?>

 
  <main>

    <h2>Exercice 3 – Mini-panier</h2>
    <section class="panier">
      <hr>
      <div class="produits">
        <h3>Produits disponibles</h3>
        <ul>
          <?php foreach ($products as $id => $name): ?>
            <li>
              <?= htmlspecialchars($name) ?>
              — <a href="?action=add&id=<?= $id ?>">Ajouter au panier</a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="cart">
        <h3>Votre panier</h3>

        <?php if (empty($_SESSION['cart'])): ?>
          <p>Votre panier est vide.</p>
        <?php else: ?>
          <table border="1" cellpadding="5" cellspacing="0">
            <thead>
              <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
                <tr>
                  <td><?= htmlspecialchars($products[$id]) ?></td>
                  <td><?= $qty ?></td>
                  <td>
                    <a href="?action=remove&id=<?= $id ?>">Supprimer ce produit</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <p>
            <a href="?action=clear">🗑️ Vider le panier</a>
          </p>
        <?php endif; ?>
      </div>

    </section>

<h2>Exo 4 - Système de connexion complet</h2>
<br>
<a href="./login/login.php">👉 LOGIN 👈</a>
  </main>
  <br>



  <button><a href="./index.php">INDEX</a></button>


  <br>
  <pre class="md-viewer"><?php
  // On lit le fichier Markdown
  $content = file_get_contents('./cours/10-sessions-cookies.md'); // adapte le chemin si besoin
  
  // On l'affiche en échappant les balises PHP/HTML
  echo htmlspecialchars($content, ENT_QUOTES);
  ?></pre>
</body>

</html>