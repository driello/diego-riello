<?php
namespace Rpg\Model\Armes;

class Epee extends Arme
{
    public function __construct(
        string $nom,
        string $description,
        string $type,
        int $degatsMin = 1,
        int $degatsMax = 12,
        float $vitesse = 0.8
    ) {
        parent::__construct($nom, $description, $type, $degatsMin, $degatsMax, $vitesse);
    }
public function attaquer(): string{
 $degats = random_int($this->getdegatsMin(), $this->getdegatsMax());

    return "L' épée légendaire attaque et inflige $degats points de dégâts dans le cul de ta mère.";
    
}

}

?>