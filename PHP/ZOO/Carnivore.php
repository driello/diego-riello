<?php

class Carnivore extends Animal
{
    public function __construct($nom, $race)
    {
        // Tous les carnivores ont type = "carnivore"
        parent::__construct($nom, $race, "carnivore");
    }

    public function donnerNaissance()
    {
        // Un lion fait naître un lion, un tigre un tigre, etc.
        // L’animal né dans le zoo n’a PAS de nom (null)
        return new Carnivore(null, $this->race);
    }
}
