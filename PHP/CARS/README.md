# Projet CARS – Mini MVC Voitures (PHP)

Petit projet pédagogique réalisé en DWWM pour apprendre :

- la connexion à une base MySQL avec PDO,
- les requêtes préparées et la gestion des erreurs,
- l’architecture MVC (Model – View – Controller),
- un routeur simple basé sur une query string.

---

## 1. Prérequis

- PHP 8.x
- Serveur web (Apache via XAMPP, MAMP, etc.)
- MySQL / MariaDB

---

## 2. Installation

1. Cloner ou copier le dossier `CARS/` dans le répertoire web de votre serveur  
   par exemple :  
   `xampp/htdocs/phpcours/CARS`  

2. Créer la base de données `voiture` :

   ```sql
   CREATE DATABASE voiture CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

3. Créer la table voiture
```sql

USE voiture;

CREATE TABLE voiture (
    immatriculation VARCHAR(8) PRIMARY KEY,
    marque          VARCHAR(50),
    couleur         VARCHAR(20)
);


4. Structure du projet

CARS/
├── config/
│   └── Conf.php           # Configuration BDD (login, host, base...)
├── model/
│   ├── Model.php          # Connexion PDO (Model::$pdo)
│   └── ModelVoiture.php   # Modèle métier pour la table `voiture`
├── controller/
│   ├── ControllerVoiture.php  # Contrôleur (readAll, read, create, created, delete)
│   └── routeur.php            # Routeur simple basé sur ?action=...
├── view/
│   └── voiture/
│       ├── list.php        # Liste de toutes les voitures
│       ├── detail.php      # Détail d une voiture
│       ├── error.php       # Erreur si immatriculation inconnue
│       ├── create.php      # Formulaire de création
│       └── createError.php # Erreur si immatriculation déjà en base
└── testModel.php           # (optionnel) Test de connexion PDO

5. Notes pédagogiques

Le Modèle (ModelVoiture) ne connaît pas les vues ni les contrôleurs :
il ne fait que de la logique métier + accès BDD.
Le Contrôleur (ControllerVoiture) récupère les paramètres de la requête,
appelle le modèle, et choisit la vue à afficher.
Les Vues (view/voiture/*.php) ne contiennent pas de logique métier,
seulement de l’affichage (HTML + un peu de PHP).
