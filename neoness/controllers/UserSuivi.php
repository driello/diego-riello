<?php
class UserSuivi extends Controller
{
    /**
     * Page individuelle de suivi
     */
    public function __construct()
    {
        // on charge les modèles nécessaires
        $this->loadModel('User');
        $this->loadmodel('Activite');
        $this->loadmodel('Sport');
    }

    public function suivi()
    {
        // 1. Sécurité : user connecté ?
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }

        // 2. Récup de l'utilisateur
        $this->User->id = (int) $_SESSION['user_id'];
        $user = $this->User->getOne();

        if (!$user) {
            header('Location: index.php');
            exit;
        }

        // Récupère la liste des sports pour le select
        $sports = $this->Sport->getAll();

        // Traitement du form ajouter une activité
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formType = $_POST['form_type'];

            if ($formType === 'activite') {
                $sport_id = (int) ($_POST['sport_id'] ?? 0);
                $dureeMinutes = (int) $_POST['duree_minutes'] ?? 0;
                $dateJour = date('Y-m-d');
                $userId = (int) ($_SESSION['user_id']);

                // Validation du form
                if ($sport_id > 0 && $dureeMinutes > 0) {
                    // Récup du sport pour avoir calories_heure
                    $this->Sport->id = $sport_id;
                    $sport = $this->Sport->getOne();

                    $calories = 0;
                    if ($sport) {
                        $caloriesHeure = (int) $sport['calories_heure'];
                        $calories = (int) round($caloriesHeure * ($dureeMinutes / 60));
                    }

                    $this->Activite->addActivite([
                        'user_id' => $userId,
                        'sport_id' => $sport_id,
                        'date_activite' => $dateJour,
                        'duree_minutes' => $dureeMinutes,
                        'calories' => $calories,
                    ]);

                    header('Location: index.php?p=UserSuivi/suivi');
                    exit;
                }
            }
        }


        // 3. Calcul de l’IMC
        $imc = $this->User->calculImc(
            (float) $user['poids'],
            (float) $user['taille']
        );

        if ($imc < 18.5) {
            $imcCategorie = "Insuffisance pondérale";
        } elseif ($imc <= 25) {
            $imcCategorie = "Corpulence normale";
        } else {
            $imcCategorie = "Surpoids";
        }

        // 4. Activités du jour
        $userId = (int) $_SESSION['user_id'];
        $dateJour = date('Y-m-d'); // format YYYY-MM-DD
        $activitesJour = $this->Activite->getActiviteJour($userId, $dateJour);

        // 5. Envoi des données à la vue
        $this->render('suivi', [
            'user' => $user,
            'imc' => $imc,
            'imcCategorie' => $imcCategorie,
            'activitesJour' => $activitesJour,
            'sports' => $sports,
        ]);
    }
}