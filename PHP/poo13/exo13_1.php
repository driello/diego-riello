<?php
// poo13/exo13_1_personne.php

class Personne {
    public string $nom;
    public string $prenom;
    public int $age;

    public function __construct(string $nom, string $prenom, int $age)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
    }

    public function afficher(): void
    {
        echo "Je m'appelle {$this->prenom} {$this->nom} et j'ai {$this->age} ans.<br>";
    }
}

// Petit test d'affichage
$personne = new Personne("Riello", "Diego", 42);
$personne->afficher();
