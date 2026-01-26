<?php

require_once __DIR__ . '/model/ModelVoiture.php';

// Récupération de toutes les voitures
$tab_Voiture = ModelVoiture::getAllVoitures();

// Affichage
foreach ($tab_Voiture as $v) {
    $v->getAfficher();
}
