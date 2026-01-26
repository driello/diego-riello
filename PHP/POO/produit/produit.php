<?php
class Produit{
    public string $nom;
    public string $prix;
}
$product = new Produit();
$product->nom = "balai";
$product->prix = 10;
$product->prix = $product->prix * 1.2;

echo $product->prix;
?>