<?php
class Human extends Character
{
    public function __construct($nom)
    {
        $this->force = 14;     // entre l'elfe et l'orc
        $this->pv = 60;        // bon compromis
        $this->endurance = 10; // équilibré
        $this->nom = $nom;
        $this->race = "Human";
    }
}
?>
