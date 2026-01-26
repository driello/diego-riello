<?php
/**
 * Routeur très simple :
 * - lit le paramètre GET 'action'
 * - appelle la méthode statique correspondante dans ControllerVoiture
 * Exemple : ?action=readAll / ?action=read&immat=AB123CD
 */

// On inclut le contrôleur en utilisant __DIR__ pour être robuste
require_once __DIR__ . '/ControllerVoiture.php';

// Récupère l'action passée dans l'URL (ex : readAll, read, create, created, delete)
// Si aucun paramètre 'action' n'est fourni, on utilise 'readAll' par défaut
$action = $_GET['action'] ?? 'readAll';

// Appel dynamique de la méthode statique de ControllerVoiture
ControllerVoiture::$action();
