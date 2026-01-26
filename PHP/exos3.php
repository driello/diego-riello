     <a href="./exos2.php"<?= $page ?>&cat=<?= $categorie ?>>
       ⬅️ Syntaxes Bases. 
    </a><?= "-----PHP-----"?>
    <a href="./exos4.php"<?= $page ?>&cat=<?= $categorie ?>>
         ➡️ Opérateurs Expressions
    </a>
  <br>
<h1>Variables & Types</h1>
 
 
 <!-- Exo 2.1 :  -->
    <?php $prenom = "Diego";
    $age = 41;
    $taille = 1.80;
    $lovephp = true;
    echo "Prénom : $prenom <br>";
    echo "Âge : $age ans<br>";
    echo "Taille :" . number_format($taille, 2, ',') . "m" . "<br>";
    echo "J'aime PHP : " . ($lovephp ? "Oui" : "Non") . "<br>";
    var_dump($prenom, $age, $taille, $lovephp);
    ?>
    <br>
    <?php $nombre = "42";
    $entier = (int) $nombre;
    $result = $entier + 8;
    echo "Le nombre  $entier + 8 est égal à = $result" . "<br>";
    echo "Type de \$entier : " . gettype($entier) . "<br>";
    echo "Type de \$result : " . gettype($result) . "<br>"; ?>
    <br>


    <?php const TVA = 0.20;
    const PRIX_HT = 100;
    $PRIX_TTC = PRIX_HT * (1 + TVA);
    echo "Le prix TTC est de : $PRIX_TTC €
    <br>"; ?>


    <br>
    <?php
    $testValue = "0";
    var_dump((bool) $testValue);
    echo "<br>";

    $testValue = "false";
    var_dump((bool) $testValue);
    echo "<br>";

    $testValue = [];
    var_dump((bool) $testValue);
    echo "<br>";

    $testValue = [0];
    var_dump((bool) $testValue);
    echo "<br>";

    $testValue = null;
    var_dump((bool) $testValue);
    echo "<br>";

    $testValue = NULL;
    var_dump((bool) $testValue);
    echo "<br>";
    ?>

        <button><a href="./index.php">INDEX</a></button>