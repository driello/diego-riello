<?php
namespace Rpg\Model\Armes;

class HacheDeGuerre extends Arme
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

    return "La Hache de Guerre attaque et inflige $degats points de dégâts.";
}

}

?>