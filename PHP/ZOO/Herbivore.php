<?php

class Herbivore extends Animal
{
    public function __construct($nom, $race)
    {
        parent::__construct($nom, $race, "herbivore");
    }

    public function donnerNaissance()
    {
        // Un zèbre fait naître un zèbre, etc.
        return new Herbivore(null, $this->race);
    }
}
