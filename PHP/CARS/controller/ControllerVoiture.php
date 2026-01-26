<?php
require_once __DIR__ . '/../model/ModelVoiture.php'; // chargement du modèle

class ControllerVoiture
{

    public static function readAll()
    {
        // appel au modèle pour gérer la BD
        $tab_v = ModelVoiture::getAllVoitures();

        // "redirige" vers la vue
        require __DIR__ . '/../view/voiture/list.php';
    }

    public static function read()
    {
        // 1. On récupère l'immatriculation dans l'URL
        $immat = $_GET['immat'];

        // 2. On demande au modèle la voiture correspondante
        $v = ModelVoiture::getVoitureByImmat($immat);

        // 3. Si aucune voiture trouvée -> vue d'erreur
        if ($v === false) {
            require __DIR__ . '/../view/voiture/error.php';
        } else {
            // 4. Sinon -> vue détail
            require __DIR__ . '/../view/voiture/detail.php';
        }
    }

    public static function create()
    {
        // Affiche le formulaire de création
        require __DIR__ . '/../view/voiture/create.php';
    }

    public static function created()
    {
        // 1. Récupérer les données de la query string
        $immat = $_GET['immatriculation'];
        $marque = $_GET['marque'];
        $couleur = $_GET['couleur'];

        // 2. Créer une instance de ModelVoiture
        $v = new ModelVoiture($immat, $marque, $couleur);

        // 3. Tenter la sauvegarde en BDD
        $saved = $v->save();

        if ($saved) {
            // 4.a Si succès : on réaffiche la liste complète
            echo "✅ Voiture $immat enregistrée en base de données.";

            self::readAll();
        } else {
            // 4.b Si échec (immat en doublon) : on affiche la vue d'erreur création
            // On passe $immat à la vue
            $immat = $v->getImmatriculation();
            require __DIR__ . '/../view/voiture/createError.php';
        }
    }

    public static function delete()
    {
        // 1. Récupérer l'immat depuis l'URL
        $immat = $_GET['immat'];

        // 2. Supprimer dans la BDD
        ModelVoiture::delete($immat);

        // 3. Préparer un petit message de confirmation
        $message = "La voiture $immat a bien été supprimée.";

        // 4. Réafficher la liste
        $tab_v = ModelVoiture::getAllVoitures();
        require __DIR__ . '/../view/voiture/list.php';
    }

}
