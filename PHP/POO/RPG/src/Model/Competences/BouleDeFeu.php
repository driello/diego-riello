<?php
namespace Rpg\Model\Competences;
class BouleDeFeu extends Competence
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
return "La compétence {$this->nom} brûle {$cible->getNom()} pour 20 dégâts.";
}

}

?>