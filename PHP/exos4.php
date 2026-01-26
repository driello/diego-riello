    <a href="./exos3.php"<?= $page ?>&cat=<?= $categorie ?>>
       ⬅️ Variables & types
    </a><?= "-----PHP-----"?>
    <a href="./exos5.php"<?= $page ?>&cat=<?= $categorie ?>>
         ➡️ Structures Contrôles
    </a>
  <br>
<h1>Opérateurs & Expressions</h1>  
  
  <!--Exercice 04.1 Calculatrice-->
    <?php $a = 18;
    $b = 3;
    echo $a + $b . "<br>";
    echo $a - $b . "<br>";
    echo $a * $b . "<br>";
    echo $a / $b . "<br>";
    echo $a % $b . "<br>";
    ?>

    <!--Exercice 04.2 Comparaisons-->
    <?php
    var_dump(10 == "10");
    var_dump(10 === "10");
    var_dump(0 == false);
    var_dump(0 === false);
    ?>
    <br>
    <!--Exercice 04.3  Conditions logiques -->
    <?php
    $age = 31;
    $billet = false;
    $accompagne = true;

    if (($age >= 18 || $accompagne) && ($billet)) {
        echo "Tu peux rentrer jeune loup!";
    } else {
        echo "Tu rentres pas jeune loup!";
    } ?><br>
    <!--Exercice 04.4  Opérateur ternaire -->
    <?php
    $note = 12;
    $resultat = ($note >= 10) ? "Examen validé" : "Essaie encore...";
    echo $resultat;
    ?><br>

        <button><a href="./index.php">INDEX</a></button>

        