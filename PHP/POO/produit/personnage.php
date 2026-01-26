<?php


// Classe abstraite : on ne peut PAS créer directement un Personnage.
// Elle sert de "modèle" commun pour tous les types de personnages.
abstract class Personnage{

    // Nom du personnage (public = accessible de partout)
    private $nom;



    // Points d'attaque. Typé en int = doit toujours être un entier.
    public int $attack;

    // Points de défense.
    public int $defense;

    // Points d'expérience.

    public int $live;

      public function __construct(string $nom,  int $attack, int $defense, int $live) {
        $this->nom = $nom;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->live = $live;
    }
    // Méthode abstraite = OBLIGE chaque classe fille à définir sa façon d'attaquer.
    // Pas de corps ici, juste la "signature".
     abstract function attack();
     

    // Pareil pour la défense : chaque type de perso défendra à sa manière.
     abstract function defense();
}



?>
