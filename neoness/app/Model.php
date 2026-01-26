<?php
abstract class Model{
    // Informations de la base de données
    private $host = "neoness.bwb";
    private $db_name = "neoness";
    private $username = "root";
    private $password = "";
     
    // Propriété qui contiendra l'instance de la connexion
    protected $_connexion;

    // Propriétés permettant de personnaliser les requêtes
    public $table;
    public $id;

    // Fonction d'initialisation de la base de données
    public function getConnection(){
        $this->_connexion = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->_connexion = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
         
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }
    }

    public function getOne(){
        $sql = "SELECT * FROM ".$this->table." WHERE id = :id";
        $query = $this->_connexion->prepare($sql);
        $query->execute([':id' => $this->id]);
        return $query->fetch();    
    }

    public function getAll(){
        $sql = "SELECT * FROM ".$this->table;
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll();    
    }
}
