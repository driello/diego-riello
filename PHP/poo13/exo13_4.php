<?php
// Exercice 4 : Formes géométriques
// - Interface Forme avec calculerAire() et calculerPerimetre()
// - Classes Carre, Rectangle, Triangle qui implémentent l'interface

interface Forme
{
    public function calculerAire(): float;

    public function calculerPerimetre(): float;
}

class Carre implements Forme
{
    private float $cote;

    public function __construct(float $cote)
    {
        $this->cote = $cote;
    }

    public function calculerAire(): float
    {
        return $this->cote * $this->cote;
    }

    public function calculerPerimetre(): float
    {
        return 4 * $this->cote;
    }
}

class Rectangle implements Forme
{
    private float $largeur;
    private float $hauteur;

    public function __construct(float $largeur, float $hauteur)
    {
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
    }

    public function calculerAire(): float
    {
        return $this->largeur * $this->hauteur;
    }

    public function calculerPerimetre(): float
    {
        return 2 * ($this->largeur + $this->hauteur);
    }
}

class Triangle implements Forme
{
    private float $base;
    private float $hauteur;
    private float $coteA;
    private float $coteB;
    private float $coteC;

    /**
     * @param float $base    Base du triangle (pour l'aire)
     * @param float $hauteur Hauteur correspondante à la base
     * @param float $coteA   Longueur du côté A (pour le périmètre)
     * @param float $coteB   Longueur du côté B
     * @param float $coteC   Longueur du côté C
     */
    public function __construct(
        float $base,
        float $hauteur,
        float $coteA,
        float $coteB,
        float $coteC
    ) {
        $this->base = $base;
        $this->hauteur = $hauteur;
        $this->coteA = $coteA;
        $this->coteB = $coteB;
        $this->coteC = $coteC;
    }

    public function calculerAire(): float
    {
        return ($this->base * $this->hauteur) / 2;
    }

    public function calculerPerimetre(): float
    {
        return $this->coteA + $this->coteB + $this->coteC;
    }
}

// --- Petit scénario de test ---

echo "<h2>Formes géométriques</h2>";

$carre = new Carre(4);
echo "<p>Carré (côté 4) : aire = "
    . $carre->calculerAire()
    . " — périmètre = "
    . $carre->calculerPerimetre()
    . "</p>";

$rectangle = new Rectangle(5, 3);
echo "<p>Rectangle (5 x 3) : aire = "
    . $rectangle->calculerAire()
    . " — périmètre = "
    . $rectangle->calculerPerimetre()
    . "</p>";

$triangle = new Triangle(6, 4, 5, 6, 7);
echo "<p>Triangle (base 6, hauteur 4, côtés 5/6/7) : aire = "
    . $triangle->calculerAire()
    . " — périmètre = "
    . $triangle->calculerPerimetre()
    . "</p>";
