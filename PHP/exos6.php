  
     <a href="./exos5.php"<?= $page ?>&cat=<?= $categorie ?>>
       ⬅️ Structure & Contrôles
    </a><?= "-----PHP-----"?>
    <a href="./exos7.php"<?= $page ?>&cat=<?= $categorie ?>>
         ➡️ Tableaux
    </a>
  <br>
<h1>FONCTIONS</h1>
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

        <button><a href="./index.php">INDEX</a></button>