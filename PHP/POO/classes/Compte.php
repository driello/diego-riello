<?php

abstract class Compte
{
    // Numéro unique du compte (IBAN simplifié par ex.)
    protected $numero;

    // Solde du compte, accessible aux classes filles
    protected $solde;

    // Constructeur : on impose un numéro, solde initial optionnel
    public function __construct($numero, $soldeInitial = 0)
    {
        $this->numero = $numero;
        $this->solde = $soldeInitial;
    }

    // Getter pour lire le numéro de compte
    public function getNumero()
    {
        return $this->numero;
    }

    // Getter pour lire le solde
    public function getSolde()
    {
        return $this->solde;
    }

    // Ajouter de l'argent sur le compte
    public function deposer($montant)
    {
        if ($montant > 0) {
            $this->solde += $montant;
        }
    }

    // Méthode abstraite : chaque type de compte gère le retrait à sa façon
    abstract public function retirer($montant);
}
