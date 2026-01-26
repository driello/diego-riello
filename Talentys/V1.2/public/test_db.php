<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=Talentys;charset=utf8mb4', 'root', '');
    echo "Connexion OK ✅";
} catch (PDOException $e) {
    echo $e->getMessage();
}
