<?php
class Character
{
    public $force;
    public $pv;
    public $endurance;
    public $nom;

    public $race;

   public function attack(Character $cible): void
{
    if ($this->pv <= 0) {
        echo "{$this->nom} est K.O. et ne peut pas attaquer.<br>";
        return;
    }

    if ($cible->pv <= 0) {
        echo "{$cible->nom} est déjà K.O. !<br>";
        return;
    }
    // Dégâts de base aléatoires : entre 50% et 100% de la force
    $baseDegats = rand((int) floor($this->force / 2), $this->force);

    // On prend en compte l'endurance de la cible pour réduire un peu les dégâts
    $degats = $baseDegats - intdiv($cible->endurance, 3);

    // Minimum 1 point de dégât
    if ($degats < 1) {
        $degats = 1;
    }

    // On enlève les PV
    $cible->pv -= $degats;
    if ($cible->pv < 0) {
        $cible->pv = 0;
    }

    echo "{$this->nom} attaque {$cible->nom} et lui inflige {$degats} points de dégâts. "
       . "Il reste {$cible->pv} PV à {$cible->nom}.<br>";
}


}


?>