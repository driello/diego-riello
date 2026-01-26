<?php
/**Exercice 3
Créez une classe représentant une personne. Elle doit avoir les propriétés nom, prénom et adresse, ainsi qu’un
constructeur et un destructeur. Une méthode getPersonne() doit retourner les coordonnées complètes de la
personne. Une méthode setAdresse() doit permettre de modifier l’adresse de la personne. Créez des objets
personne, et utilisez l’ensemble des méthodes. */



class Personne
{
    public string $nom;
    public string $prenom;
    public string $adresse;

    public function __construct(string $nom, string $prenom, string $adresse)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
    }

    public function afficher(): void
    {
        echo "Je m'appelle {$this->prenom} {$this->nom} et j'habite {$this->adresse} ans.", PHP_EOL;
    }

    public function __destruct()
    {
        // Simple message to show when the object is released
        echo "Destruction de {$this->prenom} {$this->nom} habitant {$this->adresse} .", PHP_EOL;
    }
}

$personne1 = new Personne('Jean', 'Dupont', 'rue du foutre' );
$personne2 = new Personne('Marie', 'Curie', 'rue des antivaxs');

$personne1->afficher();
$personne2->afficher();

?>