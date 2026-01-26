<?php

class Utilisateur
{
    private $nom;
    private $email;

    // Un utilisateur peut avoir un compte courant et un compte épargne
    private $compteCourant;
    private $compteEpargne;

    public function __construct($nom, $email)
    {
        $this->nom = $nom;
        $this->email = $email;
    }

    // Associer un compte courant à l'utilisateur
    public function setCompteCourant($compteCourant)
    {
        $this->compteCourant = $compteCourant;
    }

    // Associer un compte épargne à l'utilisateur
    public function setCompteEpargne($compteEpargne)
    {
        $this->compteEpargne = $compteEpargne;
    }

    // Récupérer le compte courant
    public function getCompteCourant()
    {
        return $this->compteCourant;
    }

    // Récupérer le compte épargne
    public function getCompteEpargne()
    {
        return $this->compteEpargne;
    }

    // Retourne un résumé texte des infos de l'utilisateur et de ses comptes
    public function getResume()
    {
        // On commence par le nom et l'email de l'utilisateur
        $resume = "Utilisateur : " . $this->nom . " (" . $this->email . ")\n";

        // Si un compte courant est associé, on ajoute son solde au résumé
        if ($this->compteCourant !== null) {
            // On passe par getSolde() (encapsulation, pas d'accès direct à $solde)
            $resume .= "Solde compte courant : " . $this->compteCourant->getSolde() . " €\n";
        }

        // Si un compte épargne est associé, on ajoute aussi son solde
        if ($this->compteEpargne !== null) {
            $resume .= "Solde compte épargne : " . $this->compteEpargne->getSolde() . " €\n";
        }

        // On ne fait pas de echo ici : la classe se contente de retourner la chaîne
        return $resume;
    }

}
