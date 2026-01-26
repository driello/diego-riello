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

  /* Formulaire */
form {
  max-width: 450px;
  margin: 1.5rem auto;
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: 4px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
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
  margin-left: 110px; /* aligné avec les champs */
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

  <!-- Exo 9.1 :  Lien avec paramètres -->
  <h2>Lien avec paramètre</h2>
  <a href="./exos8.php" <?= $page ?>&cat=<?= $categorie ?>>
    ⬅️ Chaînes de caractères
  </a><?= "-----PHP-----" ?>
  <a href="./exos10.php" <?= $page ?>&cat=<?= $categorie ?>>
    Sessions & Cookies ➡️
  </a><br>
  <br>
  <br>

  <!-- Exo 9.2 :  Formulaire d'inscription avec validation -->
  <h2>Formulaire d'Inscription </h2>
  <?php
  $erreurs = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validation
    if (empty($nom)) {
      $erreurs[] = "Le nom est obligatoire";
    }
    if (empty($prenom)) {
      $erreurs[] = "Le prénom est obligatoire";
    }

    if (empty($email)) {
      $erreurs[] = "L'email est obligatoire";
    }
    if (empty($password)) {
      $erreurs[] = "Le password est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $erreurs[] = "L'email n'est pas valide";
    }

    // Si pas d'erreurs, traiter les données
    if (empty($erreurs)) {
      echo "Formulaire valide !";
      // Enregistrer en base de données, envoyer un email, etc.
    }
  }
  ?>

  <?php if (!empty($erreurs)): ?>
    <div style="color: red;">
      <ul>
        <?php foreach ($erreurs as $erreur): ?>
          <li><?= htmlspecialchars($erreur) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST">
    <label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"></label><br>
    <label>Prénom : <input type="text" name="prenom"
        value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"></label><br>
    <label>Email : <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label><br>
    <label>Password : <input type="password" name="password"
        value="<?= htmlspecialchars($_POST['password'] ?? '') ?>"></label><br>
    <button type="submit">Envoyer</button>
  </form>
  <br>
  <br>
  <!-- Exo 9.3 : Calculatrice -->
  <h2>Calculatrice</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="num1">First number:</label>
    <input type="number" id="num1" name="num1" required><br>
    <label for="num2">Second number:</label>
    <input type="number" id="num2" name="num2" required><br>
    <label for="op">Operation:</label>
    <select id="op" name="op">
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">*</option>
      <option value="/">/</option>
    </select><br>
    <input type="submit" name="submit" value="Calculate">
  </form>

  <?php
  // check if the submit button is clicked
  if (isset($_POST['submit'])) {
    // get the user input from the form
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $op = $_POST['op'];
    // validate the input and display an error message if needed
    if (empty($num1) || empty($num2) || !is_numeric($num1) || !is_numeric($num2)) {
      echo "Please enter valid numbers.";
    } else {
      // continue to the next step
    }
  }
  ?>

  <?php
  // continue from the previous step
  switch ($op) {
    case "+":
      // add the numbers and store the result
      $result = $num1 + $num2;
      break;
    case "-":
      // subtract the numbers and store the result
      $result = $num1 - $num2;
      break;
    case "*":
      // multiply the numbers and store the result
      $result = $num1 * $num2;
      break;
    case "/":
      // check if the second number is zero and display an error message if it is
      if ($num2 == 0) {
        die("Cannot divide by zero.");
      } else {
        // divide the numbers and store the result
        $result = $num1 / $num2;
      }
      break;
    default:
      // display an error message if the operation is invalid
      echo "Invalid operation.";
  }
  ?>

  <?php
  // display the result
  echo "<p>The result of {$num1} {$op} {$num2} is {$result}.</p>";
  ?>
  <br>

  <!-- Exo 9.4 : Barre de recherche -->
  <!-- Créez une barre de recherche qui envoie le terme via GET.   -->
  <!-- Simulez une recherche en filtrant un tableau de produits. -->

  <h2>Créez une barre de recherche </h2>
  <form action="">
    <label for="site-search">Search the site:</label>
    <input type="search" id="site-search" name="search_term" />

    <button>Search</button>
  </form>

  <?php
  $product_array = array("Chaussure", "Veste", "Chaussette", "Pantalon", "Calecon", "Cravatte");

  // This method is used to filter the array of products with the search term named search_term in the $_GET
  $filtered_array = array_filter($product_array, function ($array_entry) {
    $search_term = $_GET['search_term'] ?? null;
    return $search_term !== null && $array_entry == $search_term;
  });

  if (!empty($filtered_array)) {
    echo reset($filtered_array);
  }
  ?>

  <button><a href="./index.php">INDEX</a></button>
  <pre class="md-viewer"><?php
  // On lit le fichier Markdown
  $content = file_get_contents('./cours/09-superglobaux-formulaires.md'); // adapte le chemin si besoin
  
  // On l'affiche en échappant les balises PHP/HTML
  echo htmlspecialchars($content, ENT_QUOTES);
  ?></pre>
</body>

</html>