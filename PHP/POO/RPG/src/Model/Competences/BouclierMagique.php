<?php
namespace Rpg\Model\Competences;

class BouclierMagique extends Competence
{
    public function __construct(
        string $nom,
        string $description,
        string $type,
        int $coutMana,
        int $niveauRequis

    ) {
        parent::__construct($nom, $description, $type, $coutMana, $niveauRequis);
    }
public function utiliser($cible): string{
    return $this->$cible;
}

}

?>