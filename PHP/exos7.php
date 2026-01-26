<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="./exos6.php"<?= $page ?>&cat=<?= $categorie ?>>
       ⬅️ Fonctions
    </a><?= "-----PHP-----"?>
    <a href="./exos8.php"<?= $page ?>&cat=<?= $categorie ?>>
         ➡️ Chaînes de caractères
    </a>
  <br>
<h1>TABLEAUX</h1>
    <!-- Exo 7.1 : Créer et Afficher un Tableau -->
    <h3>Tableau des couleurs</h3><br>
    <?php
    $colors = ["red", "blue", "green", "yellow", "grey"];
    foreach ($colors as $color) {
        echo "<table></table>";
        echo "<tr></tr";
        echo "<td>$color</td>";
    }
    ?><br>

    <!-- Exo 7.2 : Tableau associatif -->
    <h3>Tableau voiture</h3><br>
    <?php
    $voiture = ["marque" => "Ford", "modèle" => "Fiesta", "année" => "2008", "couleur" => "purple"];
    foreach ($voiture as $key => $value) {
        echo "$key : $value <br>";
    }
    ?><br>

    <!-- Exo 7.3 : Moyenne -->

    <?php $notes = [12, 14, 19, 11, 9, 17, 12];
    $somme = 0;
    foreach ($notes as $note) {
        $somme += $note;
    }
    $moyenne = $somme / count($notes);
    echo "La moyenne est de : $moyenne";
    ?><br><br>


    <!-- Exo 7.4 :  Recherche -->

    <?php $prenoms = ["Michel", "Yannick", "Alice", "Pedro", "Victor", "Sophie"];
    if (in_array("Alice", $prenoms)) {
        echo "Le prénom Alice est dans le tableau";
    } ?><br>

    <!-- Exo 7.5 :  Tri -->

    <?php $nombresAleatoires = [67, 98, 1, 45, 2, 23, 17, 54, 33];
    sort($nombresAleatoires);
    echo "<pre>";
    print_r($nombresAleatoires);
    echo "<pre>";
    ?><br>

    <!-- Exo 7.6 : Tableau multidimensionnel  -->

    <?php $produits = [
        ["nom" => "poulet", "prix" => 7, "stock" => 12],
        ["nom" => "boeuf", "prix" => 9, "stock" => 18],
        ["nom" => "saucisse", "prix" => 8, "stock" => 4],
    ];
    echo "<table border='1'>";
    echo "<tr>
                <th>Nom</th>
                <th>Prix €</th>
                <th>Stock</th>
             </tr>";

    foreach ($produits as $produit) {
        echo "<tr>";
        echo "<td>{$produit['nom']}</td>";
        echo "<td>{$produit['prix']}</td>";
        echo "<td>{$produit['stock']}</td>";
        echo "</tr>";
    } ?>

    <!-- Exo 7.7 : Tableau multidimensionnel  -->

    <?php $numbers = [1, 8, 90, 89, 56, 9, 11, 14, 6];
    $numbersFiltered = array_filter($numbers, function ($n) {
        return $n >= 10;
    });
    print_r($numbersFiltered);
    ?>
    <button><a href="./index.php">INDEX</a></button>
</body>

</html>

<!-- $arr1 = [1, 2, 3];
$arr2 = [4, 5, 6];
$resultat = [...$arr1, ...$arr2];
``` :contentReference[oaicite:21]{index=21}  

---

## 8. Mini-résumé à garder sous les yeux

- Créer :  
  - Indexé : `$arr = [1, 2, 3];`  
  - Associatif : `$arr = ["nom" => "Alice"];`  
- Parcourir : `foreach` en priorité  
- Compter : `count($arr)`  
- Ajouter / supprimer : `[]`, `array_push`, `array_pop`, `array_shift`, `array_unshift`  
- Chercher : `in_array`, `array_search`, `array_key_exists`  
- Clés / valeurs : `array_keys`, `array_values`  
- Fusionner : `array_merge`, `[...]`  
- Trier : `sort`, `rsort`, `asort`, `ksort`  
- Transformer / filtrer : `array_map`, `array_filter`, `array_reduce` :contentReference[oaicite:22]{index=22}  

---

Tu peux attaquer **Exercice 1** tranquille :  
> créer un tableau de 5 couleurs + `foreach` pour les afficher.  
Quand tu veux, tu me colles ton code et on le corrige ensemble si besoin 👌
-->