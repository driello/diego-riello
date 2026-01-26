<?php
/**
 * Classe Model : gère la connexion PDO commune à tous les modèles.
 * On initialise un seul PDO statique dans Model::$pdo,
 * qui sera utilisé dans ModelVoiture et les autres modèles.
 */

require_once __DIR__ . '/../config/Conf.php';

class Model
{
    // Propriété statique qui contiendra l'objet PDO une fois initialisé
    public static PDO $pdo;

    // Méthode d'initialisation de la connexion PDO
    public static function init(): void
    {
        // Récupération des paramètres de connexion via la classe Conf
        $hostname = Conf::getHostname();
        $database = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        try {
            // Construction de la chaîne de connexion (DSN)
            $dsn = "mysql:host=$hostname;dbname=$database;charset=utf8";

            // On instancie l'objet PDO
            self::$pdo = new PDO(
                $dsn,
                $login,
                $password,
            );

            // Activation du mode exception pour les erreurs PDO
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            // En cas d'erreur de connexion, on affiche un message et on arrête tout
            echo "Erreur de connexion à la base de données : " . $error->getMessage();
            die();
        }
    }
}

// On initialise la connexion dès que le fichier est chargé
Model::init();
