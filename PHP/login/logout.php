<?php
session_start();

// On supprime toutes les données de session
session_unset();
session_destroy();

// On renvoie vers la page de login avec un message
header('Location: login.php?logout=1');
exit;
