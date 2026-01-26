<?php
class Conf
{
    static public $instanceNumber = 0;
    public function _construct()
    {
        if (self::$instanceNumber > 0) {
            echo "Le nombre d'instances de l'objet est dépassé !!!";
            self::$instanceNumber++;
        }
    }

    static private $database = array(
        // serveur
        'hostname' => 'phpcours.bwb',

        // nom BDD
        'database' => 'POO_voitures',

        //Utilisateur root par défault
        'login' => 'root',

        // Mot de passe
        'password' => '',
    );
    // On fait tous les getters pour envoyé les informations de connexions
    static public function getLogin(): mixed
    {
        return self::$database['login'];
    }
    static public function getHostname(): mixed
    {
        return self::$database['hostname'];
    }
    static public function getDatabase(): mixed
    {
        return self::$database['database'];
    }
    static public function getPassword(): mixed
    {
        return self::$database['password'];
    }
    // on a configuré la base de données avec les getters 
// self:: attribut static => n'ai appelé qu'à l'intérieur de la class
}

?>