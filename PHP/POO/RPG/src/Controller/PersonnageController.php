<?php


// src/Controller/PersonnageController.php

namespace Rpg\Controller;

use Rpg\Model\Personnage;
use Rpg\Model\Races\Elfe;
use Rpg\Model\Races\Orc;
use Rpg\Model\Armes\Epee;
use Rpg\Model\Armes\HacheDeGuerre;
use Rpg\Model\Armes\DaguesJumelles;

class PersonnageController
{
    public function create(): void
    {
        // Variables pour la vue
        $errors = [];
        $personnageCree = null;

        // Listes pour les <select> et checkboxes
        $racesDisponibles = [
            'elfe' => 'Elfe',
            'orc'  => 'Orc',
        ];

        $armesDisponibles = [
            'epee'   => 'Épée',
            'hache'  => 'Hache de guerre',
            'dagues' => 'Dagues jumelles',
        ];

        // Prévu pour plus tard si tu veux gérer des objets de compétence
        $competencesDisponibles = [
            'attaque_puissante' => 'Attaque puissante',
            'esquive_rapide'    => 'Esquive rapide',
            'cri_de_guerre'     => 'Cri de guerre',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récup des données du formulaire
            $nom      = trim($_POST['nom'] ?? '');
            $raceKey  = $_POST['race'] ?? '';
            $armeKey  = $_POST['arme'] ?? '';
            $compKeys = $_POST['competences'] ?? [];

            // Validation simple
            if ($nom === '') {
                $errors[] = "Le nom du personnage est obligatoire.";
            }
            if (!isset($racesDisponibles[$raceKey])) {
                $errors[] = "La race choisie est invalide.";
            }
            if (!isset($armesDisponibles[$armeKey])) {
                $errors[] = "L'arme choisie est invalide.";
            }

            if (empty($errors)) {
                // --- RACE ---
                $raceObj = null;
                switch ($raceKey) {
                    case 'elfe':
                        $raceObj = new Elfe(
                            "Elfe",
                            "Elfe agile",
                            ['dexterite' => +2],
                            "Race elfe de base"
                        );
                        break;

                    case 'orc':
                        $raceObj = new Orc(
                            "Orc",
                            "Orc brutal",
                            ['force' => +2],
                            "Race orc de base"
                        );
                        break;
                }

                // --- ARME ---
                $armeObj = null;
                switch ($armeKey) {
                    case 'epee':
                        $armeObj = new Epee(
                            "Épée simple",
                            "Une épée équilibrée.",
                            "épée",
                            3,
                            6,
                            0.9
                        );
                        break;

                    case 'hache':
                        $armeObj = new HacheDeGuerre(
                            "Hache de Guerre",
                            "Une grosse hache orc.",
                            "hache de guerre",
                            4,
                            8,
                            0.8
                        );
                        break;

                    case 'dagues':
                        $armeObj = new DaguesJumelles(
                            "Dagues jumelles",
                            "Deux dagues rapides."
                        );
                        break;
                }

                if ($raceObj === null || $armeObj === null) {
                    $errors[] = "Erreur interne : race ou arme non trouvée.";
                } else {
                    // Pour l'instant, on ignore les compétences (à brancher plus tard en objets)
                    $competences = [];

                    // Création du personnage avec le constructeur correct
                    $perso = new Personnage(
                        $nom,
                        $raceObj,
                        $armeObj,
                        $competences
                    );

                    $personnageCree = $perso;

                    // Stockage en session (assure-toi que session_start() est fait dans index.php)
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        $_SESSION['personnage'] = $perso;
                    }
                }
            }
        }
        // Charge la vue (adapter le chemin si besoin)
        require __DIR__ . '/../View/create.php';
    }
}
