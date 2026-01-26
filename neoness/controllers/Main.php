<?php

class Main extends Controller
{
    public function __construct()
    {
        // Charge les modèles
        $this->loadModel('User');
        $this->loadModel('Activite');
    }

    /**
     * Page d'accueil :
     * - inscription nouvel utilisateur
     * - connexion utilisateur existant
     */
    public function index()
    {
        $erreurs = [];
        $message = '';


        // 🔁 Si l'utilisateur a déjà un cookie de session, on le reconnecte
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
            $_SESSION['user_id'] = (int) $_COOKIE['user_id'];
            $_SESSION['user_nom'] = $_COOKIE['user_nom'] ?? '';
            header('Location: index.php?p=UserSuivi/suivi');
            exit;
        }
        // variables pour stocker le calcul de l'IMC et le resultat
        $imcLibre = null;
        $imcLibreCategorie = null;

        // Traitement des formulaires
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formType = $_POST['form_type'] ?? '';

            // Calcul de l'IMC
            if ($formType === 'imc_calc') {
                $poids = (float) $_POST['imc_poids'] ?? 0;
                $taille = (float) $_POST['imc_taille'] ?? 0;

                if ($poids > 0 && $taille > 0) {
                    $imcLibre = $this->User->calculImc($poids, $taille);

                    if ($imcLibre < 18.5) {
                        $imcLibreCategorie = "Insuffisance pondérale";
                    } elseif ($imcLibre <= 25) {
                        $imcLibreCategorie = "Imc normal";
                    } else {
                        $imcLibreCategorie = "Surpoids";
                    }
                } else {
                    $erreur[] = "Saisir un poids et une taille valide";
                }
            }


            // 👉 INSCRIPTION
            if ($formType === 'register') {
                $data = [
                    'nom' => trim($_POST['nom'] ?? ''),
                    'prenom' => trim($_POST['prenom'] ?? ''),
                    'tel' => trim($_POST['tel'] ?? ''),
                    'age' => (int) ($_POST['age'] ?? 0),
                    'poids' => (float) ($_POST['poids'] ?? 0),
                    'taille' => (float) ($_POST['taille'] ?? 0),
                    'objectif_poids' => (float) ($_POST['objectif_poids'] ?? 0),
                    'password' => $_POST['password'] ?? '',
                ];

                // Vérifications minimales
                if (
                    $data['nom'] === '' ||
                    $data['prenom'] === '' ||
                    $data['tel'] === '' ||
                    $data['age'] <= 0 ||
                    $data['poids'] <= 0 ||
                    $data['taille'] <= 0 ||
                    $data['password'] === ''
                ) {
                    $erreurs[] = "Tous les champs marqués * sont obligatoires.";
                } else {
                    try {
                        $ok = $this->User->create($data);
                        if ($ok) {
                            $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                        } else {
                            $erreurs[] = "Erreur lors de l'inscription.";
                        }
                    } catch (Throwable $e) {
                        $erreurs[] = "Erreur technique lors de l'inscription.";
                    }
                }
            }

            // 👉 CONNEXION
            if ($formType === 'login') {
                $tel = trim($_POST['tel'] ?? '');
                $password = $_POST['password'] ?? '';

                if ($tel === '' || $password === '') {
                    $erreurs[] = "Téléphone et mot de passe obligatoires.";
                } else {
                    try {
                        $user = $this->User->verifyLogin($tel, $password);

                        if (!$user) {
                            $erreurs[] = "Identifiants invalides.";
                        } else {
                            // Connexion réussie
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_nom'] = $user['prenom'] . ' ' . $user['nom'];

                            // Cookies pour reconnexion ultérieure
                            setcookie('user_id', $user['id'], time() + 60 * 60 * 24 * 30, '/', '', false, true);
                            setcookie('user_nom', $_SESSION['user_nom'], time() + 60 * 60 * 24 * 30, '/', '', false, true);

                            header('Location: index.php?p=UserSuivi/suivi');
                            exit;
                        }
                    } catch (Throwable $e) {
                        $erreurs[] = "Erreur technique lors de l'inscription : " . $e->getMessage();
                    }

                }
            }
        }

        // Affiche la vue d'accueil
        $this->render('index', [
            'erreurs' => $erreurs,
            'message' => $message,
            'imcLibre' => $imcLibre,
            'imcLibreCategorie' => $imcLibreCategorie
        ]);
    }



}
