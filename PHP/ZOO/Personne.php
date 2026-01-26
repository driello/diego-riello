<?php
class Personne
{
    public $nom;
    public $type;  // visiteur ou non


    public function __construct($nom, $type)
    {
        $this->nom = $nom;
        $this->type = $type;
    }
}
?>