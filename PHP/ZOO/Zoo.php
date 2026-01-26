<?php

class Zoo
{
    public $animaux;
    public $visiteurs;

    public function __construct()
    {
        $this->animaux = [];
        $this->visiteurs = [];
    }

    /**
     * Vendre des billets à une ou plusieurs personnes.
     * Retourne le nombre total de visiteurs.
     */
    public function vendreBillets(Personne ...$newVisiteurs)
    {
        foreach ($newVisiteurs as $visiteur) {
            if ($visiteur->type === 'Visiteur') {
                $this->visiteurs[] = $visiteur;
            }
        }

        $nbVisiteurs = count($this->visiteurs);
        echo "Le zoo a vendu {$nbVisiteurs} billets.<br>";

        return $nbVisiteurs;
    }

    /**
     * Livraison de plusieurs animaux.
     * Affiche : "une livraison de XX animaux a été effectuée."
     */
    public function livraison(Animal ...$newAnimals)
    {
        foreach ($newAnimals as $animal) {
            $this->animaux[] = $animal;
        }

        $nbLivres = count($newAnimals);
        echo "Une livraison de {$nbLivres} animaux a été effectuée.<br>";
    }

    /**
     * Naissance d'un nouvel animal à partir d'un parent de la liste.
     * $indexParent = position dans le tableau $animaux (0 = premier animal).
     */
    public function naissance($indexParent)
    {
        if (!isset($this->animaux[$indexParent])) {
            return;
        }

        $parent = $this->animaux[$indexParent];
        $bebe = $parent->donnerNaissance();
        $this->animaux[] = $bebe;

        echo "Un nouvel animal est né dans le Zoo.<br>";
    }

    /**
     * Chaque visiteur voit chaque animal faire son show.
     * Naissance 1 : après le passage de la moitié des visiteurs (2e animal de la liste).
     * Naissance 2 : après le passage de tous les visiteurs (1er animal de la liste).
     */
    public function ouvrirLesPortes()
    {
        $nbVisiteurs = count($this->visiteurs);

        if ($nbVisiteurs === 0) {
            echo "Le zoo est ouvert, mais il n'y a aucun visiteur...<br>";
            return;
        }

        echo "<br>Le zoo ouvre ses portes !<br>";

        // On calcule la moitié (arrondie vers le haut)
        $moitie = ceil($nbVisiteurs / 2);

        foreach ($this->visiteurs as $index => $visiteur) {
            echo "<br><strong>--- Visite de {$visiteur->nom} ---</strong><br>";

            foreach ($this->animaux as $animal) {
                $animal->faireLeShow();
            }

            // Naissance après que la moitié des visiteurs soit passée (2e animal)
            if ($index + 1 === $moitie && isset($this->animaux[1])) {
                $this->naissance(1);
            }
        }

        // Naissance après la visite de tous les visiteurs (1er animal)
        if (isset($this->animaux[0])) {
            $this->naissance(0);
        }
    }
}
