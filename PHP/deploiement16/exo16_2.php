<?php
// deploiement16/ex16_2.php
// Exercice 2 : Utiliser Composer et l'autoload PSR-4

$composerJson = <<<JSON
{
    "name": "monsite/monapp",
    "description": "Mon application PHP",
    "type": "project",
    "require": {
        "php": ">=8.0",
        "vlucas/phpdotenv": "^5.5",
        "monolog/monolog": "^3.0"
    },
    "autoload": {
        "psr-4": {
            "App\\\\": "src/"
        }
    }
}
JSON;

$helloClass = <<<PHP
<?php
// src/Utils/Hello.php
namespace App\\Utils;

class Hello
{
    public static function greet(string \$name): string
    {
        return "Hello " . \$name . " from App\\\\Utils\\\\Hello !";
    }
}
PHP;

$indexPhp = <<<PHP
<?php
// public/index.php
require __DIR__ . '/../vendor/autoload.php';

use App\\Utils\\Hello;

echo Hello::greet('Diego');
PHP;
?>

<h2>Exercice 2 : Composer & autoload PSR-4</h2>

<ol>
    <li>À la racine de ton projet, crée un fichier <code>composer.json</code> avec :</li>
</ol>

<pre><?php echo htmlspecialchars($composerJson, ENT_QUOTES, 'UTF-8'); ?></pre>

<ol start="2">
    <li>Crée le dossier <code>src/Utils/</code> et ajoute le fichier <code>Hello.php</code> :</li>
</ol>

<pre><?php echo htmlspecialchars($helloClass, ENT_QUOTES, 'UTF-8'); ?></pre>

<ol start="3">
    <li>Dans <code>public/index.php</code>, utilise l'autoload :</li>
</ol>

<pre><?php echo htmlspecialchars($indexPhp, ENT_QUOTES, 'UTF-8'); ?></pre>

<p>
    Ensuite, en ligne de commande (dans le dossier du projet) :
</p>
<pre>
composer install
composer dump-autoload
</pre>
<p>
    Puis appelle <code>public/index.php</code> dans ton navigateur pour tester.
</p>
