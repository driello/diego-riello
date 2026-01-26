<?php

class Pouvoir
{
    // Propriétés privées : accessibles seulement dans la classe
    private string $nom;
    private int $degats;

    // Constructeur : on impose un nom et des dégâts à la création
    public function __construct(string $nom, int $degats)
    {
        $this->nom = $nom;
        $this->setPointsDegat($degats); // on passe par le setter pour vérifier la valeur
    }

    // Setter avec contrôle : on ne peut pas mettre de dégâts négatifs
    public function setPointsDegat(int $degats): void
    {
        if ($degats < 0) {
            throw new Exception("Les points ne peuvent pas être négatifs");
        }

        $this->degats = $degats;
    }

    // (optionnel mais utile) : getter pour lire les dégâts
    public function getPointsDegat(): int
    {
        return $this->degats;
    }
    public function getPouvoir() : string {
        return $this->nom;
        
    }
}

// Test : création d'une arme
$legendSword = new Pouvoir("Kameamea", 200);

// Exemple d'utilisation
 echo  $legendSword->getPointsDegat().$legendSword->getPouvoir(); // affichera 20

