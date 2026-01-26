<?php

class Animal
{
    public $nom;
    public $race;
    public $type; // "carnivore" ou "herbivore"

    public function __construct($nom, $race, $type)
    {
        $this->nom  = $nom;   // peut être null pour un animal né dans le zoo
        $this->race = $race;
        $this->type = $type;
    }

    // La version générique, redéfinie dans les classes filles
    public function donnerNaissance()
    {
        // Sera redéfini dans Carnivore / Herbivore
    }

    public function faireLeShow()
    {
        // Exemple attendu : "cet animal carnivore qui est un lion et qui s’appelle concon"
        $message = "cet animal {$this->type} qui est un {$this->race}";

        if ($this->nom !== null) {
            $message .= " et qui s'appelle {$this->nom}";
        } else {
            $message .= " né dans le zoo et qui n'a pas encore de nom";
        }

        echo $message . "<br>";
    }
}
