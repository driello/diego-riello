       <a href="./exos4.php"<?= $page ?>&cat=<?= $categorie ?>>
       ⬅️ Opérateurs Expressions
    </a><?= "-----PHP-----"?>
    <a href="./exos6.php"<?= $page ?>&cat=<?= $categorie ?>>
         ➡️ Fonctions
    </a>
  <br>
<h1>Structures Contrôles</h1>
   
   <!--Exercice 05.1  Nombre pair ou impair -->
    <?php
    $nombre = 11;
    if ($nombre % 2 == 0) {
        echo "Nombre pair";
    } else {
        echo "Nombre impair";
    }
    ?>

    <!--Exercice 05.2  Note et mention -->
    <?php
    $note = 16;
    if ($note >= 16) {
        echo "Très bien";
    } elseif ($note >= 14) {
        echo "Bien";
    } elseif ($note >= 12) {
        echo "Assez bien";
    } elseif ($note >= 10) {
        echo "Passable";
    } else {
        echo "Insuffisant";
    } ?><br>

    <!--Exercice 05.3  Afficher les nombres de 1 à 20 -->
    <?php
    for ($i = 1; $i <= 20; $i++) {
        echo $i;
    } ?><br>

    <!--Exercice 05.4  Somme des nombres de 1 à 100 -->
    <?php
    $somme = 0;
    for ($i = 1; $i <= 100; $i++) {
        $somme += $i;
    }
    echo $somme;
    ?><br>

    <!--Exercice 05.5  FizzBuzz -->
    <?php

    for ($i = 1; $i < 101; $i++) {
        if ($i % 3 === 0 && $i % 5 === 0) {
            echo "FizzBuzz ";
        } elseif ($i % 5 === 0) {
            echo "Buzz ";
        } elseif ($i % 3 === 0) {
            echo "Fizz ";
        } else {
            echo $i . " ";
        }
    }
    ?><br>

    <!--Exercice 05.6  Table de multiplication -->
    <table style="border=1">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <tr>
                <td>7 x <?= $i ?></td>
                <td><?= 7 * $i ?></td>
            </tr>
        <?php endfor; ?>
    </table>


    <!--Exercice 05.7  Tableau de fruits -->
    <?php
    $fruits = ["pomme", "banane", "melon", "poire"];
    foreach ($fruits as $fruit) {
        echo "$fruit <br>";
        ;
    } ?>
    <button><a href="./index.php">INDEX</a></button>