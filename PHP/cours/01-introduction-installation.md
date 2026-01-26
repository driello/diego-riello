# Leçon 1 : Introduction et Installation

## Qu'est-ce que PHP ?

- **PHP** (PHP: Hypertext Preprocessor) est un langage de script côté serveur principalement utilisé pour développer des pages web dynamiques.
- Il s'exécute sur le serveur et génère du HTML envoyé au navigateur.
- **Cas d'usage** : sites web, APIs, backends, CMS (WordPress, Drupal), frameworks (Laravel, Symfony).

## Pourquoi apprendre PHP ?

- Large écosystème et grande base de projets existants.
- Facile à démarrer — syntaxe simple pour créer des pages web dynamiques.
- Bon support des bases de données, gestion de sessions, et nombreuses bibliothèques via Composer.

## Prérequis

- Connaissances de base en HTML (savoir où insérer du PHP dans une page).
- Un système avec PHP installé (Linux, macOS, Windows).

## Installer PHP

### Sur Linux (Debian/Ubuntu)

```bash
sudo apt update
sudo apt install php php-cli php-mbstring php-xml php-mysql
```

### Sur macOS

Utiliser Homebrew :

```bash
brew install php
```

### Sur Windows

- Installer à partir de [windows.php.net](https://windows.php.net)
- Ou utiliser XAMPP/WAMP pour un environnement complet (Apache + MySQL + PHP).

## Vérifier l'installation

Dans un terminal :

```bash
php -v        # Affiche la version de PHP
php -m        # Liste des modules installés
```

## Lancer le serveur PHP intégré

Le serveur intégré permet de tester rapidement sans installer Apache/Nginx.

Dans un dossier contenant un fichier `index.php` :

```bash
php -S localhost:8000
```

Puis ouvrez `http://localhost:8000` dans votre navigateur.

## Créer un fichier PHP minimal

Créez un fichier `index.php` :

```php
<?php
echo "Hello, PHP !";
```

Lancez le serveur intégré et visitez la page dans votre navigateur.

## Structure minimale d'un fichier PHP

### Balises PHP

- `<?php ... ?>` — Balises complètes (recommandé)
- `<?= $var ?>` — Équivaut à `<?php echo $var; ?>` (short echo)

Le serveur interprète tout le code PHP et remplace par sa sortie (HTML, JSON, texte).

## Bonnes pratiques d'environnement

### En développement (local)

Activer l'affichage des erreurs pour faciliter le débogage :

**Dans `php.ini`** :
```ini
display_errors = On
error_reporting = E_ALL
```

**Ou en début de script** :
```php
<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
```

### En production

- **Désactiver** `display_errors` pour ne pas exposer d'informations sensibles.
- Logguer les erreurs dans un fichier (configurer `log_errors` et `error_log` dans `php.ini`).

### Autres bonnes pratiques

- Utiliser **Composer** pour gérer les dépendances.
- Versionner le code avec **Git** et ne jamais committer de secrets (mots de passe, clés API).
- Utiliser un `.gitignore` pour exclure les fichiers sensibles.

## Ce que nous allons couvrir dans ce cours

1. Syntaxe de base et premier script
2. Variables et types
3. Opérateurs et expressions
4. Structures de contrôle (if, loops)
5. Fonctions
6. Tableaux
7. Chaînes de caractères
8. Superglobaux & formulaires (GET/POST)
9. Sessions et cookies
10. Fichiers et uploads
11. PDO et accès à la base de données
12. Bases de la POO en PHP
13. Gestion des erreurs et debugging
14. Sécurité essentielle et bonnes pratiques
15. Déploiement minimal
16. Exercices pratiques avec solutions

---

**Prochaine leçon** : [Syntaxe de base](./02-syntaxe-base.md)
