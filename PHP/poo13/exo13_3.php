<?php
// Exercice 3 : Héritage d'animaux
// - Classe abstraite Animal avec méthode abstraite crier()
// - Classes Chien, Chat, Vache qui héritent et implémentent crier()

abstract class Animal
{
    protected string $nom;

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    // Méthode abstraite : chaque animal doit définir sa façon de "crier"
    abstract public function crier(): void;

    // Méthode concrète commune à tous les animaux
    public function sePresenter(): void
    {
        echo "Je suis un " . static::class . " et je m'appelle {$this->nom}.<br>";
    }
}

class Chien extends Animal
{
    public function crier(): void
    {
        echo "{$this->nom} : Ouaf ouaf !<br>";
    }
}

class Chat extends Animal
{
    public function crier(): void
    {
        echo "{$this->nom} : Miaouuu...<br>";
    }
}

class Vache extends Animal
{
    public function crier(): void
    {
        echo "{$this->nom} : Meeeeuuuh !<br>";
    }
}


// --- Petit scénario de test ---

$chien = new Chien("Rex");
$chat  = new Chat("Minou");
$vache = new Vache("Marguerite");

$chien->sePresenter();
$chien->crier();

$chat->sePresenter();
$chat->crier();

$vache->sePresenter();
$vache->crier();
