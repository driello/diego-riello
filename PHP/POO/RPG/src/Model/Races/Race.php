<?php
namespace Rpg\Model\Races;

use Rpg\Interfaces\RaceInterface;

abstract class Race implements RaceInterface
{
    protected string $nom;

    protected string $description;
    protected array $bonusStats;
    protected string $capaciteSpeciale;


    public function getNom(): string
    {
        return $this->nom;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getBonusStats(): array
    {
        return $this->bonusStats;
    }
    public function getCapaciteSpeciale(): string
    {
        return $this->capaciteSpeciale;
    }

    public function __construct(
        string $nom,
        string $description,
        array $bonusStats,
        string $capaciteSpeciale,


    ) {
        $this->nom = $nom;
        $this->description = $description;
        $this->bonusStats = $bonusStats;
        $this->capaciteSpeciale = $capaciteSpeciale;

    }
    abstract public function utiliserCapacite(): string;

}
?>