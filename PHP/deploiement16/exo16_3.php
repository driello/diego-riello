<?php
// deploiement16/ex16_3.php
// Exercice 3 : Déploiement sur hébergement mutualisé (structure simulée)

$tree = <<<TXT
monsite/
├── .env                  # Variables d'environnement (non versionné)
├── .env.example          # Modèle de config
├── .gitignore
├── composer.json
├── composer.lock
├── vendor/               # Dépendances Composer (non versionné)
├── public/               # Point d'entrée accessible par le web
│   ├── index.php
│   ├── .htaccess
│   ├── css/
│   ├── js/
│   └── uploads/
├── src/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── config/
│   └── bootstrap.php
└── storage/
    └── logs/
TXT;

$envExample = <<<ENV
# .env.example
APP_ENV=local
APP_DEBUG=true

DB_HOST=localhost
DB_NAME=
DB_USER=
DB_PASS=
ENV;

$gitignore = <<<GIT
/vendor/
/.env
/storage/logs/*
*.log
GIT;

$publicIndex = <<<PHP
<?php
// public/index.php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/bootstrap.php';

echo "Application déployée !";
PHP;
?>

<h2>Exercice 3 : Déploiement sur hébergement mutualisé (structure)</h2>

<p>Voici une structure de base à reproduire sur un hébergement mutualisé :</p>

<pre><?php echo htmlspecialchars($tree, ENT_QUOTES, 'UTF-8'); ?></pre>

<h3>Exemple de fichier <code>.env.example</code></h3>
<pre><?php echo htmlspecialchars($envExample, ENT_QUOTES, 'UTF-8'); ?></pre>

<h3>Exemple de <code>.gitignore</code></h3>
<pre><?php echo htmlspecialchars($gitignore, ENT_QUOTES, 'UTF-8'); ?></pre>

<h3>Exemple de <code>public/index.php</code></h3>
<pre><?php echo htmlspecialchars($publicIndex, ENT_QUOTES, 'UTF-8'); ?></pre>

<p>
L'idée de l'exercice : recréer cette structure dans un dossier à part
et imaginer que <code>public/</code> est le dossier pointé par ton hébergeur (DocumentRoot).
</p>
