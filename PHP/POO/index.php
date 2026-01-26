<?php

// Chargement des classes nécessaires
require_once __DIR__ . '/classes/Compte.php';
require_once __DIR__ . '/classes/CompteCourant.php';
require_once __DIR__ . '/classes/CompteEpargne.php';
require_once __DIR__ . '/classes/Utilisateur.php';

// On ajoutera le code de test (instanciation, opérations...) juste après
// Création d'un utilisateur
$utilisateur = new Utilisateur("Diego", "diego@example.com");

// Création d'un compte courant pour cet utilisateur
// Paramètres : numéro, solde initial, découvert autorisé
$compteCourant = new CompteCourant("CC-001", 500, 200);

// Création d'un compte épargne pour cet utilisateur
// Paramètres : numéro, solde initial, taux d'intérêt (ici 3%)
$compteEpargne = new CompteEpargne("CE-001", 1000, 0.03);

// On associe les comptes à l'utilisateur
$utilisateur->setCompteCourant($compteCourant);
$utilisateur->setCompteEpargne($compteEpargne);

// --- Scénario d'opérations bancaires ---

// Diego reçoit 200 € sur son compte courant
$compteCourant->deposer(200);

// Il paye une facture de 150 €
$compteCourant->retirer(150);

// Il place 300 € sur son compte épargne
$compteEpargne->deposer(300);

// La banque applique les intérêts sur le compte épargne
$compteEpargne->appliquerInterets();

// --- Affichage du résumé de l'utilisateur et de ses comptes ---

echo "<h1>Tableau de bord utilisateur</h1>";
echo "<pre>";
echo nl2br($utilisateur->getResume());
echo "</pre>";
