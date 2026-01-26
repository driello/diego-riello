<?php

class CompteEpargne extends Compte
{
    // Taux d'intérêt (ex : 0.02 = 2%)
    private $tauxInteret;

    // Constructeur : on impose un numéro de compte,
    // un solde initial (0 par défaut) et un taux d'intérêt
    public function __construct($numero, $soldeInitial = 0, $tauxInteret = 0.02)
    {
        // Appel du constructeur de Compte
        // pour initialiser $numero et $solde
        parent::__construct($numero, $soldeInitial);

        // Propriété spécifique au compte épargne
        $this->tauxInteret = $tauxInteret;
    }


    // On définira la logique de retrait juste après
    // Retirer de l'argent : PAS de découvert autorisé sur le compte épargne
    public function retirer($montant)
    {
        if ($montant <= 0) {
            return; // montant invalide
        }

        // On vérifie qu'il y a assez d'argent
        if ($montant <= $this->solde) {
            $this->solde -= $montant;
        } else {
            echo "Retrait impossible : solde insuffisant sur le compte épargne.<br>";
        }
    }
    // Appliquer les intérêts au solde actuel
    public function appliquerInterets()
    {
        if ($this->solde > 0) {
            $interets = $this->solde * $this->tauxInteret;
            $this->solde += $interets;
        }
    }
}




