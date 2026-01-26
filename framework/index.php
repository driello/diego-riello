<?php // Déclarer le debut du code PHP

// Définir une constante root qui va définir le chemin absolu du projet
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
// __DIR__ = dossier courant -> dossier racine
// DIRECTORY_SEPARATOR = \ ou / selon linux ou window

// Inclus le fichier du Router qui génèrera les urls
require ROOT . 'app/Router.php'; // on charge la classe ROUTEUR définit sur app/Router.php

// On récupère l'url de la requête (ex: index.php?url=home/index)
$url = $_GET['url'] ?? ''; // si l'url n'existe pas dans la requête, on met une chaine vide

// on crée une instance de routeur
$routeur = new Router();

// On demande au routeur d'executer la bonne page en fonction de l'url
$routeur->run( $url ); // On appelle la méthode run du routeur en lui passant l'url
