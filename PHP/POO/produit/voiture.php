<?php
class Voiture
{
    public string $marque;
    public string $modele;
    public int $annee;

    public function age(): int
    {
        return date('Y') - $this->annee;
    }
}
$voiture = new Voiture();
$voiture->marque = 'baslesc';
$voiture->modele = 'sd';
$voiture->annee = '2008';

echo $voiture->age();
?>