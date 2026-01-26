<?php
namespace Rpg\Model\Armes;

class DaguesJumelles extends Arme
{
    public function __construct(
        string $nom = "Dagues Jumelles",
        string $description = "Dagues jumelles des soeurs chiamoises",
    string $type = "Arme double",
        int $degatsMin = 2,
        int $degatsMax = 14,
        float $vitesse = 1.2
    ) {
        parent::__construct($nom, $description, $type, $degatsMin, $degatsMax, $vitesse);
    }
    public function attaquer(): string
    {
        $degats = random_int($this->getdegatsMin(), $this->getdegatsMax());

        return "Les Dagues jumelles attaque et inflige $degats points de dégâts.";
    }

}

?>