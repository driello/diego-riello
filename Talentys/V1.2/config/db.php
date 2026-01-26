<?php
// config/db.php

$host = 'phpcours.bwb';
$db   = 'talentys';
$user = 'root';
$pass = ''; // à adapter selon ton environnement
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Erreur connexion BDD : ' . $e->getMessage());
}

// URL de base de ton projet (à adapter à TON chemin local)
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://phpcours.bwb/Talentys/V1.2/');
}
