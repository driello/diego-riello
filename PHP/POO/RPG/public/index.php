<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Autoload d'abord (pour que la classe Personnage soit connue)
require __DIR__ . '/../vendor/autoload.php';

// 2. Puis seulement la session
session_start();

use Rpg\Controller\PersonnageController;
use Rpg\Controller\ShowPersonnage;

$action = $_GET['action'] ?? 'create';

switch ($action) {
    case 'show':
        $controller = new ShowPersonnage();
        $controller->show();
        break;

    case 'create':
    default:
        $controller = new PersonnageController();
        $controller->create();
        break;
}
