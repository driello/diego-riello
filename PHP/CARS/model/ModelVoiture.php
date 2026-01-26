<?php
// On inclut le fichier Model pour accéder à Model::$pdo

require_once __DIR__ . '/Model.php';

class ModelVoiture
{
    private $immatriculation;
    private $marque;
    private $couleur;

    // Constructeur avec arguments optionnels (pour FETCH_CLASS)
    public function __construct($immatriculation = NULL, $marque = NULL, $couleur = NULL)
    {
        if (!is_null($immatriculation) && !is_null($marque) && !is_null($couleur)) {
            $this->setImmatriculation($immatriculation);
            $this->setMarque($marque);
            $this->setCouleur($couleur);
        }
    }

    // --- Getters ---
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    public function getMarque()
    {
        return $this->marque;
    }

    public function getCouleur()
    {
        return $this->couleur;
    }

    // --- Setters (privés) ---
    private function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;
    }

    private function setMarque($marque)
    {
        $this->marque = $marque;
    }

    private function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    // --- Méthode d'affichage d'une voiture ---
    public function getAfficher()
    {
        echo "Voiture d'immatriculation " . htmlspecialchars($this->immatriculation) .
            " de marque " . htmlspecialchars($this->marque) .
            " et de couleur " . htmlspecialchars($this->couleur) . "<br>";
    }


    // --- Méthode statique : récupérer toutes les voitures ---
    public static function getAllVoitures()
    {
        $sql = "SELECT * FROM Voiture";
        $rep = Model::$pdo->query($sql);

        // On crée des objets de classe ModelVoiture (et plus Voiture)
        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelVoiture');
        $tab_voit = $rep->fetchAll();

        return $tab_voit;
    }

    // --- Méthode statique sécurisée : une voiture par immat ---
    public static function getVoitureByImmat($immat)
    {
        $sql = "SELECT * FROM Voiture WHERE immatriculation = :nom_tag";

        $req_prep = Model::$pdo->prepare($sql);

        $values = array(
            "nom_tag" => $immat,
        );

        $req_prep->execute($values);

        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelVoiture');
        $tab_voit = $req_prep->fetchAll();

        if (empty($tab_voit)) {
            return false;
        }

        return $tab_voit[0];
    }
    public static function delete($immat)
    {
        $sql = "DELETE FROM voiture WHERE immatriculation = :immat";

        $req_prep = Model::$pdo->prepare($sql);
        $values = [
            "immat" => $immat,
        ];

        $req_prep->execute($values);
    }

    // --- Sauvegarde en BDD ---
    public function save()
    {
        try {
            $sql = "INSERT INTO Voiture (immatriculation, marque, couleur)
                VALUES (:immat, :marque, :couleur)";
            // requête préparée => passe par un tableau pour "cleaner" et évite les injections sql
            $req_prep = Model::$pdo->prepare($sql); 

            $values = [
                "immat" => $this->immatriculation,
                "marque" => $this->marque,
                "couleur" => $this->couleur,
            ];

            $req_prep->execute($values);

            // Tout s'est bien passé
            return true;

        } catch (PDOException $e) {

            // 23000 = violation de contrainte d’intégrité (clé primaire / unique en double)
            if ($e->getCode() === '23000') {
                // On ne plante pas : on signale juste l’échec
                return false;
            }

            // Autre type d’erreur => on laisse remonter (pour ne pas masquer un vrai bug)
            throw $e;
        }
    }

}
?>