<?php
class Elf extends Character
{
    public function __construct($nom)
    {
        $this->force = 13;     // dégâts corrects
        $this->pv = 55;        // un peu moins tanky qu'un orc
        $this->endurance = 11; // bonne résistance
        $this->nom = $nom;
        $this->race = "Elf";
    }
}
?>