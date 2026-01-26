<?php

namespace Rpg\Service;

use Rpg\Model\Personnage;
use Rpg\Model\Races\Nain;
use Rpg\Model\Races\Orc;
use Rpg\Model\Armes\HacheDeGuerre;
use Rpg\Model\Armes\Epee;

/**
 * Classe responsable de la création des personnages.
 */
class CharacterFactory
{
    /**
     * Crée un héros et un ennemi "de base" pour nos tests.
     *
     * @return array{hero: Personnage, enemy: Personnage}
     */
    public static function createDefaultCharacters(): array
    {
        // 1. Créer les races
        $raceNain = new Nain(
            'Nain',
            'Guerrier robuste des montagnes',
            ['force' => +2, 'endurance' => +2],
            'Peau de pierre'
        );

        $raceOrc = new Orc(
            'Orc',
            'Brute sauvage',
            ['force' => +3],
            'Rage sanguinaire'
        );

        // 2. Créer les armes
        $hache = new HacheDeGuerre(
            'Hache de guerre',
            'Une lourde hache naine.',
            'hache',
            8,
            15,
            0.7
        );

        $epee = new Epee(
            'Épée orc',
            'Épée grossière mais meurtrière.',
            'épée',
            6,
            12,
            0.9
        );

        // 3. Créer les personnages avec arme obligatoire
        $hero  = new Personnage('Gimli',  $raceNain, $hache);
        $enemy = new Personnage('Grobash', $raceOrc,  $epee);

        // 4. Retourner les deux personnages dans un tableau associatif
        return [
            'hero'  => $hero,
            'enemy' => $enemy,
        ];
    }
}
