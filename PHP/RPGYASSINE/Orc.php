<?php
class Orc extends Character
{
    public function __construct($nom)
    {
        $this->force = 17;     // plus fort que les autres
        $this->pv = 68;        // bon gros sac à PV
        $this->endurance = 8;  // encaisse un peu moins
        $this->nom = $nom;
        $this->race = "Bloody Orc";
    }
}
?>
