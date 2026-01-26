<?php

namespace Rpg\Model\Competences;

use Rpg\Interfaces\CompetenceInterface;


abstract class Competence implements CompetenceInterface
{
    protected string $nom;

    protected string $description;
    protected string $type;
    protected int $coutMana;
    protected int $niveauRequis;



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
    public function getCoutMana(): int
    {
        return $this->coutMana;
    }
    public function getNiveauRequis(): int
    {
        return $this->niveauRequis;
    }
  
    public function __construct(
        string $nom,
        string $description,
        string $type,
        int $coutMana,
        int $niveauRequis

    ) {
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->coutMana = $coutMana;
        $this->niveauRequis = $niveauRequis;
    }
abstract public function utiliser($cible):string;
}
?>