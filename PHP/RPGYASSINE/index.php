<?php
// Chargement des classes
require_once 'Character.php';
require_once 'Elf.php';
require_once 'Orc.php';
require_once 'Human.php';
require_once 'GameEngine.php';

// Création du moteur de jeu
$game = new GameEngine();

// Ajout des combattants dans l'arène
$game->addCombattant(new Human("Florian"));
$game->addCombattant(new Orc("Yannick"));

// Lancement du combat
$game->start();
