<?php
// src/Controller/ShowPersonnage.php

namespace Rpg\Controller;

use Rpg\Model\Personnage;

class ShowPersonnage
{
    public function show(): void
    {
        $fiche = null;

        if (isset($_SESSION['personnage']) && $_SESSION['personnage'] instanceof Personnage) {
            /** @var Personnage $personnage */
            $personnage = $_SESSION['personnage'];
            $fiche = $personnage->getFiche();
        }

        require __DIR__ . '/../View/show.php';
    }
}
