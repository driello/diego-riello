<?php

namespace Rpg\Controller;

use Rpg\Model\Personnage;
use Rpg\Service\CharacterFactory;
use Rpg\Service\BattleManager;



class GameController
{
   
    public function index(): void
    {
      require __DIR__ .'/../View/home.php';
    }

public function combat(): void
{
    // 1. Créer les personnages via la factory
    $characters = CharacterFactory::createDefaultCharacters();

    /** @var Personnage $hero */
    /** @var Personnage $enemy */
    $hero  = $characters['hero'];
    $enemy = $characters['enemy'];

    // 2. Lancer un combat complet jusqu'à la mort d'un des deux
    $battle = BattleManager::fightUntilDeath($hero, $enemy);

    // 3. Récupérer le log complet et le vainqueur
    $log    = $battle['log'];
    $winner = $battle['winner'];

    // 4. Envoyer les données à la vue
    require __DIR__ . '/../View/combat.php';
}




}
