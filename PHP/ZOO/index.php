<?php

require_once 'Zoo.php';
require_once 'Animal.php';
require_once 'Carnivore.php';
require_once 'Herbivore.php';
require_once 'Personne.php';

// --- Création des animaux livrés au zoo ---

$lion   = new Carnivore('Doudou', 'lion');
$tigre  = new Carnivore('Tigrou', 'tigre');
$loup   = new Carnivore('Loulou', 'loup');

$zebre1 = new Herbivore('Riri',  'zèbre');
$zebre2 = new Herbivore('Fifi',  'zèbre');
$zebre3 = new Herbivore('Loulou','zèbre');

// --- Création du zoo et livraison des animaux ---

$zoo = new Zoo();
$zoo->livraison($lion, $tigre, $loup, $zebre1, $zebre2, $zebre3);

// --- Vente des billets aux visiteurs ---

$nbVisiteurs = $zoo->vendreBillets(
    new Personne('Loïc',    'Visiteur'),
    new Personne('Yannick', 'Visiteur'),
    new Personne('Yassine', 'Visiteur'),
    new Personne('Enzo',    'Visiteur'),
    new Personne('Pierre',  'Visiteur')
);

// --- Ouverture des portes si assez de monde ---

if ($nbVisiteurs >= 5) {
    $zoo->ouvrirLesPortes();
} else {
    echo "Pas assez de visiteurs pour ouvrir le zoo aujourd'hui.<br>";
}
