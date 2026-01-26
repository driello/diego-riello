<?php

namespace Rpg\Model\Armes;

use Rpg\Interfaces\ArmeInterface;


abstract class Arme implements ArmeInterface
{
    protected string $nom;

    protected string $description;
    protected string $type;
    protected int $degatsMin;
    protected int $degatsMax;

    protected float $vitesse;
    public function __construct(
        string $nom,
        string $description,
        string $type,
        int $degatsMin,
        int $degatsMax,
        float $vitesse,

    ) {
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->degatsMin = $degatsMin;
        $this->degatsMax = $degatsMax;
        $this->vitesse = $vitesse;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getType(): string
    {
        return $this->type;
    }
    public function getdegatsMin(): int
    {
        return $this->degatsMin;
    }
    public function getdegatsMax(): int
    {
        return $this->degatsMax;
    }
    public function getVitesse(): float
    {
        return $this->vitesse;
    }

    abstract public function attaquer(): string;



}

?>