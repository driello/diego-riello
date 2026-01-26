<?php
class Ville{
    public $nom;
    public $departement;
 
    public function __construct($nom, $departement) {
        $this->nom = $nom;
        $this->departement = $departement;}
    public function afficherVille(){
        echo "La ville de $this->nom  est dans le département de  $this->departement ", PHP_EOL;
    }
}
$ville1 = new Ville("Béziers", "Hérault");

$ville2 = new Ville("Perpignan", "Pyrénées Orientales");


$ville1->afficherVille();
$ville2->afficherVille();

?>