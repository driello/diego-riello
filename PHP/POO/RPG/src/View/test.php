<?php
require __DIR__ . '/../vendor/autoload.php';

use Rpg\Model\Armes\Epee;
use Rpg\Model\Armes\BatonMagique;
use Rpg\Model\Armes\HacheDeGuerre;
use Rpg\Model\Races\Elfe;
use Rpg\Model\Races\Orc;
use Rpg\Model\Personnage;
use Rpg\Model\Competences\Soin;
use Rpg\Model\Competences\BouleDeFeu;

echo "=== TEST GLOBAL RPG ===" . PHP_EOL . PHP_EOL;

/*
 | 1. TEST ARMES
*/
echo "--- ARMES ---" . PHP_EOL;

$epee = new Epee(
    "Épée de Test",
    "Juste une épée pour vérifier le code.",
    "épée",
    1,
    5,
    1.2
);

$baton = new BatonMagique(
    "Bâton de Test",
    "Bâton magique de démo.",
    "bâton",
    3,
    8,
    0.8
);

$armes = [$epee, $baton];

foreach ($armes as $arme) {
    echo "Arme : " . $arme->getNom() . PHP_EOL;
    echo "Description : " . $arme->getDescription() . PHP_EOL;
    echo "Type : " . $arme->getType() . PHP_EOL;
    echo "Dégâts : " . $arme->getdegatsMin() . " - " . $arme->getdegatsMax() . PHP_EOL;
    echo "Vitesse : " . $arme->getVitesse() . PHP_EOL;
    echo "Attaque : " . $arme->attaquer() . PHP_EOL;
    echo "------------------------" . PHP_EOL;
}

/*
 | 2. TEST RACES
*/
echo PHP_EOL . "--- RACES ---" . PHP_EOL;

$raceElfe = new Elfe(
    "Elfe de Test",
    "Juste un elfe pour les tests.",
    ['dexterite' => +2],
    "Vision nocturne"
);

$raceOrc = new Orc(
    "Orc de Test",
    "Orc de test qui tape fort.",
    ['force' => +3],
    "Cri de guerre"
);

$races = [$raceElfe, $raceOrc];

foreach ($races as $race) {
    echo "Race : " . $race->getNom() . PHP_EOL;
    echo "Capacité raciale : " . $race->utiliserCapacite() . PHP_EOL;
    echo "------------------------" . PHP_EOL;
}

/*
 | 3. TEST COMPÉTENCES
*/
echo PHP_EOL . "--- COMPÉTENCES ---" . PHP_EOL;

// Mannequin pour tester les compétences
$dummy = new Personnage("Mannequin d'entraînement", $raceElfe, $HacheDeGuerre);

$soin = new Soin(
    "Soin de Test",
    "Rend quelques PV pour le test.",
    "soin",
    5,
    10
);

$boule = new BouleDeFeu(
    "Boule de Feu de Test",
    "Inflige des dégâts de feu pour le test.",
    "offensif",
    8,
    15
);

$competences = [$soin, $boule];

foreach ($competences as $comp) {
    echo "Compétence : " . $comp->getNom() . PHP_EOL;
    echo "Utilisation sur " . $dummy->getNom() . " : " . $comp->utiliser($dummy) . PHP_EOL;
    echo "------------------------" . PHP_EOL;
}

/*
 | 4. TEST PERSONNAGES + INTERACTIONS
*/
echo PHP_EOL . "--- PERSONNAGES + INTERACTIONS ---" . PHP_EOL;

$elfe = new Personnage("Légolax le Testeur", $raceElfe, $HacheDeGuerre);
$orc  = new Personnage("Gorgash le Cobaye", $raceOrc, $HacheDeGuerre);

// Équipement
$elfe->equiperArme($epee);
$orc->equiperArme($baton);

// Compétences
$elfe->apprendreCompetence($soin);
$orc->apprendreCompetence($boule);

// Expérience
$elfe->gagnerExperience(30);
$orc->gagnerExperience(45);

// Affichage fiches
$elfe->getFiche();
$orc->getFiche();

// Attaque + dégâts + tests de méthodes
echo PHP_EOL . "L'elfe attaque l'orc :" . PHP_EOL;
echo $elfe->attaquer($orc) . PHP_EOL;

echo "PV Orc après attaque : " . $orc->getPvActuels() . " / " . $orc->getPvMax() . PHP_EOL;

echo PHP_EOL . "L'orc utilise sa compétence sur l'elfe :" . PHP_EOL;
echo $orc->utiliserCompetence(0, $elfe) . PHP_EOL;

echo "PV Elfe après compétence : " . $elfe->getPvActuels() . " / " . $elfe->getPvMax() . PHP_EOL;

// Capacité raciale
echo PHP_EOL . "Capacité raciale de l'elfe : " . $elfe->utiliserCapaciteRaciale() . PHP_EOL;

// Check estVivant
echo "Elfe vivant ? " . ($elfe->estVivant() ? "oui" : "non") . PHP_EOL;
echo "Orc vivant ? " . ($orc->estVivant() ? "oui" : "non") . PHP_EOL;

echo PHP_EOL . "=== FIN TEST GLOBAL ===" . PHP_EOL;
