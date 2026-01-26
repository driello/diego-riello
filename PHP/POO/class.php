<?php
class livre{
    public string $titre;
    public string $auteur;
    public int $page;
}

$monlivre = new Livre();
$monlivre->titre = "Les aventures d'Enzo";
$monlivre->auteur = "Enzo";
$monlivre->page = 200;

$sonlivre = new Livre();
$sonlivre->titre = "'Le Ho Bite";
$sonlivre->auteur = "Tolchienne";
$sonlivre->pages = 450;

$sonlivre2 = new Livre();
$sonlivre2->titre = "La bite à Brigitte";
$sonlivre2->auteur = "E. Marcou";
$sonlivre2->page = 1000;
echo "<h1>LIBRAIRIE D'ENZO</h1>";
echo $monlivre->titre." ".$monlivre->auteur."<br>"."<br>";
;
echo $sonlivre2->titre." ".$sonlivre2->auteur;


?>