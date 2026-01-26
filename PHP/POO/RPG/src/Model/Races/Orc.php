<?php
namespace Rpg\Model\Races;

class Orc extends Race
{
    public function __construct(
        string $nom,
        string $description,
        array $bonusStats,
        string $capaciteSpeciale,
    ) {
        parent::__construct($nom, $description, $bonusStats, $capaciteSpeciale);
    }
public function utiliserCapacite(): string{
    return $this->capaciteSpeciale;
}

}

?>