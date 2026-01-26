<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFOS BUENOS</title>
</head>

<body>
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


    <!--Exercice 06.1  Fonction simple -->
    <?php
    $carre = fn($n) => $n * $n;
    echo $carre(15);
    ?><br>

    <!--Exercice 06.2  Fonction avec valeur par défaut -->

    <?php
    function saluer($name, $langue = "fr")
    {
        if ($langue === "fr") {
            echo "Bonjour $name";
        } elseif ($langue === "en") {
            echo "Hello $name";
        } elseif ($langue === "es") {
            echo "Ola $name";
        }
    }
    saluer("Diego", "es"); ?>
    <br>


    <?php function salutation($name, $langue = "fr")
    {
        switch ($langue) {
            case "fr":
                echo "Bonjour $name";
                break;
            case "en":
                echo "Hello $name";
                break;
            case "es":
                echo "Ola $name";
                break;


        }
    }
    salutation("francis", "en");
    ?>
    <br>
    <!--Exercice 06.3  Calculer l'aire -->

    <?php
    $aireRectangle = fn($longueur, $largeur): float|int => $longueur * $largeur;
    echo "L'aire du rectangle est de :" . $aireRectangle(12, 56) . "cm2"; ?>
<br>
    <!--Exercice 06.4   Nombre pair ou impair -->
    <?php
    $estPair = fn(int $n): bool => $n % 2 === 0;
    $num = 81;
    echo $estPair($num) ? "Le chiffre $num est pair<br>" : "Le chiffre $num est impair<b>";
    ?>
    <br>
    <!--Exercice 06.5  Température  -->

    <?php
    $celsiusVersFahrenheit = fn($celsius) => $celsius * (9 / 5) + 32;
    $fahrenheitVersCelsius = fn($fahrenheit) => ($fahrenheit - 32) * (5 / 9);
    echo "126° farenheit correspond à : " . $fahrenheitVersCelsius(126) . " °C <br>";
    echo "35°C correspond à : " . $celsiusVersFahrenheit(32) . " °F";
    ?>
<br>
    <!--Exercice 06.6  Fonction variadique  -->
    <?php
   function moyennes(...$number){
    return array_sum($number) / count($number);  // array_sum additionne tous le nombres. count = le total des index
   }
echo "La moyenne est de : " . moyennes(8, 90, 78, 67, 12);
    ?>
</body>

</html>