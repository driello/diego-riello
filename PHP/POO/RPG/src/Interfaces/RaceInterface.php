<?php
namespace Rpg\Interfaces;
// interface = un contrat : elle définit les méthodes que toutes les races devront avoir.
interface RaceInterface
{
    public function getNom():string;
    public function getDescription():string;
    public function getBonusStats():array;
    public function getCapaciteSpeciale():string;

    public function utiliserCapacite(): string;
}
?>


<!-- Auto load et nameSpace , plus facile pouyr faire des requires-->