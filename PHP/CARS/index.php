<?php
// Optionnel : tu pourrais plus tard require des fichiers ici (config, etc.)
// Pour l'instant, cette page est juste une porte d'entrée vers le routeur.
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Projet CARS – MVC Voitures</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background: #1f2933;
            color: #fff;
            padding: 20px 30px;
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        header p {
            margin: 5px 0 0;
            opacity: 0.8;
        }

        main {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 24px 28px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-top: 0;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        footer {
            text-align: center;
            color: #6b7280;
            font-size: 0.8rem;
            margin: 30px 0 10px;
        }

        code {
            background: #f3f4f6;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <header>
        <h1>Projet CARS – Mini MVC en PHP</h1>
        <p>Gestion des voitures (liste, détail, ajout, suppression) avec PDO & architecture MVC.</p>
    </header>

    <main>
        <h2>Bienvenue 👋</h2>
        <p>
            Ce petit projet sert de base pour comprendre la structure MVC en PHP :
            un <strong>routeur</strong> central, un <strong>contrôleur</strong>, un <strong>modèle</strong>
            pour accéder à la base de données, et des <strong>vues</strong> pour l'affichage.
        </p>

        <div class="buttons">
            <a class="btn btn-primary" href="controller/routeur.php?action=readAll">
                📋 Voir la liste des voitures
            </a>
            <a class="btn btn-secondary" href="controller/routeur.php?action=create">
                ➕ Ajouter une voiture
            </a>
        </div>

        <h3>Raccourcis techniques</h3>
        <ul>
            <li><code>controller/routeur.php?action=readAll</code> – liste des voitures</li>
            <li><code>controller/routeur.php?action=create</code> – formulaire de création</li>
            <li><code>controller/routeur.php?action=read&amp;immat=AA111BB</code> – détail d'une voiture</li>
        </ul>

       

        <h3>Bloc technique</h3>
        <p>
            Ce projet illustre une architecture <strong>MVC</strong> minimale en PHP&nbsp;:
        </p>

        <ul>
            <li>
                <strong>Model</strong> :
                <code>Model.php</code> gère la connexion PDO,
                <code>ModelVoiture.php</code> contient la logique métier (CRUD sur la table <code>voiture</code>).
            </li>
            <li>
                <strong>View</strong> :
                fichiers dans <code>view/voiture/</code> (<code>list.php</code>, <code>detail.php</code>,
                <code>create.php</code>, <code>error.php</code>, <code>createError.php</code>) pour l'affichage HTML.
            </li>
            <li>
                <strong>Controller</strong> :
                <code>ControllerVoiture.php</code> reçoit les actions, appelle le modèle et choisit la vue.
            </li>
            <li>
                <strong>Routeur</strong> :
                <code>controller/routeur.php</code> lit <code>$_GET['action']</code> et appelle
                <code>ControllerVoiture::$action()</code>.
            </li>
            <li>
                <strong>Sécurité PDO</strong> :
                requêtes préparées + gestion des erreurs (doublon d'immatriculation) dans
                <code>ModelVoiture::save()</code>.
            </li>
        </ul>

        <p>Organisation des dossiers&nbsp;:</p>
        <pre><code>CARS/
├── config/
│   └── Conf.php
├── model/
│   ├── Model.php
│   └── ModelVoiture.php
├── controller/
│   ├── ControllerVoiture.php
│   └── routeur.php
└── view/
    └── voiture/
        ├── list.php
        ├── detail.php
        ├── create.php
        ├── error.php
        └── createError.php
</code></pre>

      

    </main>

    <footer>
        Projet pédagogique DWWM – CARS (MVC PHP + PDO)
    </footer>

</body>

</html>