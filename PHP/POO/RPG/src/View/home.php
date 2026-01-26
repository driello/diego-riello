<?php
// 1. Autoload Composer
require __DIR__ . '/../../vendor/autoload.php';

// 2. Import des classes (adapte les namespaces si besoin)
use Rpg\Model\Personnage;
use Rpg\Model\Armes\Epee;
use Rpg\Model\Races\Elfe;

// 3. Création de l'arme
$epee = new Epee(
    "Épée légendaire",
    "Une épée ancienne qui brille dans le noir.",
    "épée",
    3,   // dégâts min
    8,   // dégâts max
    0.2  // chance de critique
);

// 4. Création de la race
$raceElfe = new Elfe(
    "Elfe",
    "Créature agile et précise,",
    ['dexterite' => +2],
    "sait voler"
    
);

// 5. Création du personnage
$hero = new Personnage(
    "Legolax le jobard",
    $raceElfe,
    $epee,

);

// À partir d'ici, on passe à l'affichage HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche personnage</title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #111827;
            color: #e5e7eb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            background: #1f2937;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
            width: 380px;
            display: block;
        }
        .card h1 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-size: 1.5rem;
        }
        .card h2 {
            margin: 0;
            font-size: 1rem;
            color: #9ca3af;
        }
        .stats {
            margin-top: 1rem;
            padding: 0;
            list-style: none;
        }
        .stats li {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #374151;
            padding: .25rem 0;
        }
        .label { color: #9ca3af; }
        .value { font-weight: 600; }
    </style>
</head>
<body>

<div class="card">
    <h1><?= htmlspecialchars($hero->getNom(), ENT_QUOTES, 'UTF-8') ?></h1>
    <h2>
        Race :
        <?= htmlspecialchars($hero->getRace()->getNom(), ENT_QUOTES, 'UTF-8') ?>
    </h2>
    <p>
        Arme :
        <strong><?= htmlspecialchars($epee->getNom(), ENT_QUOTES, 'UTF-8') ?> . <?= htmlspecialchars($epee->getDescription())?></strong>
    </p>
    <p>
        Compétence :<?= htmlspecialchars($raceElfe->getDescription())?> qui  <?= htmlspecialchars($raceElfe->getCapaciteSpeciale())?>
    </p>

</div>

<h2>VA SE FIGHTER CONTRE</h2>

<div class="card">
    <h1><?= htmlspecialchars($hero->getNom(), ENT_QUOTES, 'UTF-8') ?></h1>
    <h2>
        Race :
        <?= htmlspecialchars($hero->getRace()->getNom(), ENT_QUOTES, 'UTF-8') ?>
    </h2>
    <p>
        Arme :
        <strong><?= htmlspecialchars($epee->getNom(), ENT_QUOTES, 'UTF-8') ?> . <?= htmlspecialchars($epee->getDescription())?></strong>
    </p>
    <p>
        Compétence :<?= htmlspecialchars($raceElfe->getDescription())?> qui  <?= htmlspecialchars($raceElfe->getCapaciteSpeciale())?>
    </p>

</div>

</body>
</html>
