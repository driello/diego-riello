<?php
namespace Rpg\Model\Armes;

class BatonMagique extends Arme
{
    public function __construct(
        string $nom,
        string $description,
        string $type,
        int $degatsMin = 3,
        int $degatsMax = 18,
        float $vitesse = 0.2
    ) {
        parent::__construct($nom, $description, $type, $degatsMin, $degatsMax, $vitesse);
    }
public function attaquer(): string
{
    $degats = random_int($this->getdegatsMin(), $this->getdegatsMax());

    return "Le bâton magique attaque et inflige $degats points de dégâts.";
}

}

?>