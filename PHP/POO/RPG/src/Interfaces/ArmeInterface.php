<?php
namespace Rpg\Interfaces;

interface ArmeInterface
{
    public function getNom(): string;
    public function getDescription(): string;
    public function getType(): string;
    public function getDegatsMin(): int;
    public function getDegatsMax(): int;
    public function getVitesse(): float;
    public function attaquer(): string;
}
