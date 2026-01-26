<?php

require_once 'Character.php';

class GameEngine
{
    /**
     * @var Character[]  Liste des combattants dans l'arène
     */
    private array $combattants = [];

    public function __construct()
    {
        // Pour l'instant, rien de spécial au démarrage
    }

    /**
     * Ajoute un combattant dans l'arène.
     */
    public function addCombattant(Character $perso): void
    {
        $this->combattants[] = $perso;
    }

    /**
     * Lance le combat.
     * (On remplira la logique plus tard.)
     */
      public function start(): void
    {
        // S'il n'y a pas assez de combattants, on ne lance pas la partie
        if (count($this->combattants) < 2) {
            echo "Pas assez de combattants pour démarrer le combat.<br>";
            return;
        }

        echo "Le combat commence !<br>";

        $tour = 1;

        // Boucle principale : on joue des tours jusqu'à la fin
        while (!$this->fin()) {
            echo "<br><strong>=== Tour {$tour} ===</strong><br>";

            // Un tour de jeu : un attaquant frappe une cible
            $this->tourDeJeu();

            // On enlève les morts de l'arène
            $this->nettoyerMort();

            $tour++;
        }

        echo "<br><strong>=== Fin du combat ===</strong><br>";

        if (count($this->combattants) === 1) {
            $vainqueur = $this->combattants[0];
            echo "{$vainqueur->nom} remporte le combat avec {$vainqueur->pv} PV restants.<br>";
        } else {
            echo "Tous les combattants sont morts !<br>";
        }
    }


    /**
     * Retourne un index aléatoire d'un combattant dans le tableau.
     */
    private function getId(): int
    {
        return array_rand($this->combattants);
    }

    /**
     * Retourne un combattant aléatoire.
     */
    private function getJoueur(): ?Character
    {
        if (empty($this->combattants)) {
            return null;
        }

        $id = $this->getId();
        return $this->combattants[$id];
    }
        /**
     * Effectue les actions d'un tour de jeu :
     * - choisit un attaquant aléatoire
     * - choisit une cible différente
     * - lance l'attaque
     */
    public function tourDeJeu(): void
    {
        // S'il y a moins de 2 combattants, on ne fait rien
        if (count($this->combattants) < 2) {
            return;
        }

        // 1) Choisir l'attaquant
        $idAttaquant = $this->getId();
        $attaquant = $this->combattants[$idAttaquant];

        // 2) Choisir une cible différente
        $idsPossibles = array_keys($this->combattants);

        // On enlève l'attaquant de la liste des cibles possibles
        $idsPossibles = array_filter($idsPossibles, function ($id) use ($idAttaquant) {
            return $id !== $idAttaquant;
        });

        // On tire un id au hasard parmi les cibles restantes
        $randomKey = array_rand($idsPossibles);
        $idCible = $idsPossibles[$randomKey];
        $cible = $this->combattants[$idCible];

        echo '<strong>--- Nouveau tour ---</strong><br>';
        $attaquant->attack($cible);
    }

    /**
     * Enlève les combattants morts (pv <= 0) de l'arène.
     */
    private function nettoyerMort(): void
    {
        foreach ($this->combattants as $index => $combattant) {
            if ($combattant->pv <= 0) {
                echo "{$combattant->nom} est retiré de l'arène.<br>";
                unset($this->combattants[$index]);
            }
        }

        // On réindexe le tableau pour éviter les trous dans les clés
        $this->combattants = array_values($this->combattants);
    }

        /**
     * La partie est finie s'il reste 0 ou 1 combattant.
     */
    private function fin(): bool
    {
        return count($this->combattants) <= 1;
    }


}

?>