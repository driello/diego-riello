<?php 
namespace Rpg\Interfaces;

interface CompetenceInterface{

    public function getNom():string;
    public function getDescription():string;
    public function getType():string;
    public function getCoutMana():int;
    public function getNiveauRequis():int;
    public function utiliser($cible): string; 
        

    
}

?>