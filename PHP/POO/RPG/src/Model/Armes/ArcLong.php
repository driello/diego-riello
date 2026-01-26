<?php
namespace Rpg\Model\Armes;

class ArcLong extends Arme
{
    public function __construct(
        string $nom,
        string $description,
        string $type,
        int $degatsMin = 1,
        int $degatsMax = 12,
        float $vitesse = 1.5
    ) {
        parent::__construct($nom, $description, $type, $degatsMin, $degatsMax, $vitesse);
    }
public function attaquer(): string
{
    $degats = random_int($this->getdegatsMin(), $this->getdegatsMax());

    return "L' Arc Long attaque et inflige $degats points de dégâts.";
}

}

?>