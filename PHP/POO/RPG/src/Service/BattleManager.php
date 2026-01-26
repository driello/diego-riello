<?php

namespace Rpg\Service;

use Rpg\Model\Personnage;

/**
 * Classe responsable de gérer les combats entre personnages.
 */
class BattleManager
{
    /**
     * Joue un tour de combat : $attacker attaque $defender.
     *
     * @return array{
     *   result: array,
     *   log: string[]
     * }
     */

    
    public static function fightOneTurn(Personnage $attacker, Personnage $defender): array
    {
        // 1. On demande au modèle d'appliquer l'attaque
        $result = $attacker->attaquer($defender);

        // 2. On construit le journal de combat (texte)
        $log = [];

        $log[] = "{$result['attaquant_nom']} attaque {$result['cible_nom']} "
            . "avec {$result['arme_nom']} et lui inflige {$result['degats']} dégâts.";

        if (!$result['cible_est_vivante']) {
            $log[] = "{$result['cible_nom']} est vaincu !";
        } else {
            $log[] = "{$result['cible_nom']} a encore {$result['pv_cible_restants']} PV.";
        }

        // 3. On renvoie à la fois les données brutes + le log
        return [
            'result' => $result,
            'log'    => $log,
        ];
    }
public static function fightUntilDeath(Personnage $p1, Personnage $p2): array
{
    $log = [];

    // Pour le moment : p1 attaque toujours en premier, puis p2, etc.
    $attacker = $p1;
    $defender = $p2;

    // Boucle de combat
    while ($p1->estVivant() && $p2->estVivant()) {
        // 1. Tour de l'attaquant
        $tour = self::fightOneTurn($attacker, $defender);

        // On fusionne les lignes de log de ce tour dans le log global
        foreach ($tour['log'] as $ligne) {
            $log[] = $ligne;
        }

        // 2. Si le défenseur est mort, on sort de la boucle
        if (!$defender->estVivant()) {
            break;
        }

        // 3. On inverse les rôles : celui qui attaquait devient défenseur, et inversement
        $tempAttacker = $attacker;
        $attacker = $defender;
        $defender = $tempAttacker;
    }

    // Déterminer le vainqueur
    $winner = $p1->estVivant() ? $p1 : $p2;

    return [
        'log'    => $log,
        'winner' => $winner,
    ];
}

    
}
