<?php
session_start();

// DEBUG : afficher les erreurs PHP pendant le dev
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// On génère une constante contenant le chemin vers la racine publique du projet
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

// On appelle le modèle et le contrôleur principal
require_once ROOT.'app/Model.php';
require_once ROOT.'app/Controller.php';

// On sépare les paramètres et on les met dans le tableau $params
$params = isset($_GET['p']) ? explode('/', $_GET['p']) : [''];

// Si au moins 1 paramètre existe
if ($params[0] != "") {
    // On sauvegarde le 1er paramètre dans $controller en mettant sa 1ère lettre en majuscule
    $controller = ucfirst($params[0]);

    // On sauvegarde le 2ème paramètre dans $action s'il existe, sinon index
    $action = isset($params[1]) ? $params[1] : 'index';

    // On appelle le contrôleur
    require_once ROOT.'controllers/'.$controller.'.php';

    // On instancie le contrôleur
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        // On supprime les 2 premiers paramètres
        unset($params[0], $params[1]);

        // On appelle la méthode $action du contrôleur $controller
        call_user_func_array([$controller, $action], $params);
    } else {
        http_response_code(404);
        echo "La page recherchée n'existe pas";
    }
} else {
    // Ici aucun paramètre n'est défini
    // On appelle le contrôleur par défaut
    require_once ROOT.'controllers/Main.php';

    // On instancie le contrôleur
    $controller = new Main();

    // On appelle la méthode index
    $controller->index();
}
