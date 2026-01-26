<?php

class CompteCourant extends Compte
{
    // Découvert autorisé pour ce compte
    private $decouvertAutorise;

    // Constructeur : on impose un numéro de compte,
    // un solde initial (0 par défaut) et un découvert autorisé (0 par défaut)
    public function __construct($numero, $soldeInitial = 0, $decouvertAutorise = 0)
    {
        // Appel du constructeur de la classe parente Compte
        // pour initialiser $numero et $solde
        parent::__construct($numero, $soldeInitial);

        // Propriété spécifique au compte courant
        $this->decouvertAutorise = $decouvertAutorise;
    }


    // Implémentation de la méthode abstraite retirer()
    // Retirer de l'argent en tenant compte du découvert autorisé
    public function retirer($montant)
    {
        if ($montant <= 0) {
            return; // montant invalide
        }

        // On calcule le solde si on fait le retrait
        $nouveauSolde = $this->solde - $montant;

        // On vérifie qu'on ne dépasse pas le découvert autorisé
        if ($nouveauSolde >= -$this->decouvertAutorise) {
            $this->solde = $nouveauSolde;
        } else {
            echo "Retrait impossible : découvert dépassé.<br>";
        }
    }

}
