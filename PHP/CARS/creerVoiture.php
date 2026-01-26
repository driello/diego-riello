<?php
require_once './model/Model.php';
require_once './model/ModelVoiture.php';

// On attend les données en POST
if (isset($_POST['immatriculation'])) {

    $immat = $_POST['immatriculation'];

    // Si le formulaire envoie aussi marque / couleur, on les récupère,
    // sinon on met une valeur par défaut
    $marque  = isset($_POST['marque'])  ? $_POST['marque']  : 'inconnue';
    $couleur = isset($_POST['couleur']) ? $_POST['couleur'] : 'inconnue';

    // Création de l'objet Voiture
    $voiture = new modelVoiture($immat, $marque, $couleur);

    // Sauvegarde dans la BDD
    $voiture->save();

    echo "✅ Voiture $immat enregistrée en base de données.";
} else {
    echo "❌ Aucune immatriculation reçue.";
}
?>
