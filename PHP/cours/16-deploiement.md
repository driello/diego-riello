# Leçon 16 : Déploiement minimal

## 1. Introduction au déploiement

Déployer une application PHP signifie :
- La rendre accessible sur Internet
- Configurer un serveur web (Apache ou Nginx)
- Gérer les dépendances avec Composer
- Configurer la base de données en production

## 2. Choisir un hébergeur

### Types d'hébergement

**Hébergement mutualisé** (le plus simple)
- ✅ Facile, pas cher (3-10€/mois)
- ✅ PHP préinstallé, panneau de contrôle
- ❌ Performances limitées, pas de contrôle total
- 📦 Exemples : OVH, Hostinger, o2switch

**VPS** (Virtual Private Server)
- ✅ Plus de contrôle, meilleures performances
- ✅ Vous gérez le serveur
- ❌ Plus technique, configuration nécessaire
- 📦 Exemples : DigitalOcean, Linode, Vultr

**Hébergement cloud**
- ✅ Scalabilité, haute disponibilité
- ✅ Paiement à l'usage
- ❌ Plus complexe à configurer
- 📦 Exemples : AWS, Google Cloud, Azure

**Plateformes PaaS** (Platform as a Service)
- ✅ Déploiement simplifié, infrastructure gérée
- ✅ Intégration Git, scaling automatique
- ❌ Plus cher que l'hébergement mutualisé
- 📦 Exemples : Heroku, Platform.sh, Clever Cloud

## 3. Configuration Apache

### Fichier `.htaccess`

Le fichier `.htaccess` permet de configurer Apache au niveau du répertoire.

#### Redirection HTTP → HTTPS

```apache
# .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

#### Redirection vers index.php

```apache
# .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L]
```

#### Cacher les fichiers sensibles

```apache
# .htaccess
<FilesMatch "\.(ini|log|sh|sql|env)$">
    Require all denied
</FilesMatch>

# Protéger le dossier vendor
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^vendor/.*$ - [F,L]
</IfModule>
```

#### Headers de sécurité

```apache
# .htaccess
<IfModule mod_headers.c>
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Content-Type-Options "nosniff"
    Header set Strict-Transport-Security "max-age=31536000" env=HTTPS
</IfModule>
```

#### Compression Gzip

```apache
# .htaccess
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>
```

#### Mise en cache

```apache
# .htaccess
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

#### Fichier `.htaccess` complet

```apache
# .htaccess
# Activer le moteur de réécriture
RewriteEngine On

# Forcer HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Rediriger vers index.php si le fichier n'existe pas
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L]

# Protéger les fichiers sensibles
<FilesMatch "\.(ini|log|sh|sql|env)$">
    Require all denied
</FilesMatch>

# Headers de sécurité
<IfModule mod_headers.c>
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Content-Type-Options "nosniff"
    Header set Strict-Transport-Security "max-age=31536000" env=HTTPS
</IfModule>

# Compression Gzip
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Mise en cache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

## 4. Configuration Nginx

### Fichier de configuration de base

```nginx
# /etc/nginx/sites-available/monsite.conf
server {
    listen 80;
    listen [::]:80;
    server_name monsite.com www.monsite.com;
    
    # Redirection HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name monsite.com www.monsite.com;
    
    root /var/www/monsite/public;
    index index.php;
    
    # Certificat SSL (Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/monsite.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/monsite.com/privkey.pem;
    
    # Logs
    access_log /var/log/nginx/monsite_access.log;
    error_log /var/log/nginx/monsite_error.log;
    
    # Headers de sécurité
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Strict-Transport-Security "max-age=31536000" always;
    
    # Bloquer l'accès aux fichiers sensibles
    location ~ /\. {
        deny all;
    }
    
    location ~ \.(ini|log|sh|sql|env)$ {
        deny all;
    }
    
    # Redirection vers index.php
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # Traiter les fichiers PHP
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Cache des assets statiques
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### Activer la configuration

```bash
# Créer un lien symbolique
sudo ln -s /etc/nginx/sites-available/monsite.conf /etc/nginx/sites-enabled/

# Tester la configuration
sudo nginx -t

# Recharger Nginx
sudo systemctl reload nginx
```

## 5. Introduction à Composer

Composer est le **gestionnaire de dépendances** de PHP.

### Installation de Composer

```bash
# Télécharger l'installateur
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

# Installer globalement (Linux/macOS)
php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Vérifier l'installation
composer --version
```

### Fichier `composer.json`

```json
{
    "name": "monsite/monapp",
    "description": "Mon application PHP",
    "type": "project",
    "require": {
        "php": ">=8.0",
        "vlucas/phpdotenv": "^5.5",
        "monolog/monolog": "^3.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

### Commandes essentielles

```bash
# Initialiser un nouveau projet
composer init

# Installer les dépendances
composer install

# Ajouter une dépendance
composer require vlucas/phpdotenv

# Ajouter une dépendance de développement
composer require --dev phpunit/phpunit

# Mettre à jour les dépendances
composer update

# Mettre à jour une dépendance spécifique
composer update monolog/monolog

# Générer l'autoloader
composer dump-autoload
```

### Utiliser l'autoloader

```php
<?php
// index.php
require __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use Monolog\Logger;

$user = new User();
$logger = new Logger('app');
```

## 6. Variables d'environnement avec `.env`

### Installation de phpdotenv

```bash
composer require vlucas/phpdotenv
```

### Fichier `.env`

```bash
# .env (à créer à la racine)
APP_ENV=production
APP_DEBUG=false

DB_HOST=localhost
DB_NAME=mabase
DB_USER=utilisateur
DB_PASS=motdepasse

MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USER=contact@example.com
MAIL_PASS=secret
```

### ⚠️ Ne jamais versionner `.env`

```bash
# .gitignore
vendor/
.env
*.log
```

### Fichier `.env.example`

```bash
# .env.example (à versionner)
APP_ENV=local
APP_DEBUG=true

DB_HOST=localhost
DB_NAME=
DB_USER=
DB_PASS=

MAIL_HOST=
MAIL_PORT=
MAIL_USER=
MAIL_PASS=
```

### Charger les variables

```php
<?php
// config/bootstrap.php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Utiliser les variables
$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$debug = $_ENV['APP_DEBUG'] === 'true';

if ($debug) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}
```

## 7. Structure de projet recommandée

```
monsite/
├── .env                  # Variables d'environnement (non versionné)
├── .env.example          # Template des variables
├── .gitignore            # Fichiers à ignorer
├── composer.json         # Dépendances
├── composer.lock         # Versions exactes installées
├── vendor/               # Dépendances Composer (non versionné)
├── public/               # Point d'entrée web
│   ├── index.php         # Front controller
│   ├── .htaccess         # Config Apache
│   ├── css/
│   ├── js/
│   └── uploads/
├── src/                  # Code source
│   ├── Models/
│   ├── Controllers/
│   └── Views/
├── config/               # Configuration
│   └── database.php
├── storage/              # Logs, cache
│   └── logs/
└── tests/                # Tests unitaires
```

## 8. Configuration PHP pour la production

### Fichier `php.ini`

```ini
; php.ini (production)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log

; Sécurité
expose_php = Off
allow_url_fopen = Off
allow_url_include = Off

; Performance
opcache.enable = 1
opcache.memory_consumption = 128
opcache.max_accelerated_files = 10000
opcache.validate_timestamps = 0

; Sessions
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1

; Uploads
upload_max_filesize = 10M
post_max_size = 10M
```

## 9. SSL avec Let's Encrypt

### Installation de Certbot

```bash
# Debian/Ubuntu
sudo apt install certbot python3-certbot-nginx

# CentOS/RHEL
sudo yum install certbot python3-certbot-nginx
```

### Obtenir un certificat

```bash
# Avec Nginx
sudo certbot --nginx -d monsite.com -d www.monsite.com

# Avec Apache
sudo certbot --apache -d monsite.com -d www.monsite.com
```

### Renouvellement automatique

```bash
# Tester le renouvellement
sudo certbot renew --dry-run

# Configurer le renouvellement automatique (cron)
sudo crontab -e

# Ajouter cette ligne (vérifier tous les jours à 2h)
0 2 * * * certbot renew --quiet
```

## 10. Déploiement avec Git

### Sur le serveur

```bash
# Se connecter en SSH
ssh utilisateur@monserveur.com

# Cloner le dépôt
cd /var/www
git clone https://github.com/user/monsite.git

# Installer les dépendances
cd monsite
composer install --no-dev --optimize-autoloader

# Copier et configurer .env
cp .env.example .env
nano .env

# Donner les permissions
sudo chown -R www-data:www-data /var/www/monsite
sudo chmod -R 755 /var/www/monsite
```

### Mise à jour

```bash
# Pull des dernières modifications
git pull origin main

# Mettre à jour les dépendances
composer install --no-dev --optimize-autoloader

# Vider le cache (si applicable)
php artisan cache:clear  # Laravel
# ou
rm -rf storage/cache/*
```

### Script de déploiement

```bash
#!/bin/bash
# deploy.sh

echo "🚀 Déploiement en cours..."

# Passer en mode maintenance (optionnel)
# touch maintenance.flag

# Pull du code
git pull origin main

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Migrations de base de données (si applicable)
# php migrate.php

# Vider le cache
rm -rf storage/cache/*

# Permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 .

# Sortir du mode maintenance
# rm maintenance.flag

echo "✅ Déploiement terminé !"
```

## 11. Checklist de déploiement

✅ **Avant le déploiement**
- [ ] Tests passent (`composer test`)
- [ ] `.env.example` à jour
- [ ] `.gitignore` configuré (`.env`, `vendor/`, `*.log`)
- [ ] Dépendances à jour (`composer update`)

✅ **Configuration serveur**
- [ ] PHP 8.0+ installé
- [ ] Extensions nécessaires (`pdo_mysql`, `mbstring`, `curl`, etc.)
- [ ] Apache/Nginx configuré
- [ ] SSL/HTTPS activé (Let's Encrypt)
- [ ] Firewall configuré

✅ **Configuration application**
- [ ] `.env` créé avec bonnes valeurs
- [ ] `APP_DEBUG=false` en production
- [ ] `display_errors=Off` en production
- [ ] Base de données créée et migrée
- [ ] Permissions fichiers correctes

✅ **Sécurité**
- [ ] `.htaccess` configuré
- [ ] Headers de sécurité activés
- [ ] Fichiers sensibles protégés
- [ ] SSL/HTTPS obligatoire
- [ ] Sessions sécurisées

✅ **Performance**
- [ ] OPcache activé
- [ ] Compression Gzip activée
- [ ] Cache navigateur configuré
- [ ] Autoloader optimisé (`--optimize-autoloader`)

✅ **Monitoring**
- [ ] Logs configurés et accessibles
- [ ] Système de backup en place
- [ ] Monitoring des erreurs

## 12. Exercices pratiques

### Exercice 1 : Configuration `.htaccess`

Créez un fichier `.htaccess` complet avec :
- Redirection HTTPS
- Headers de sécurité
- Mise en cache
- Protection des fichiers sensibles

### Exercice 2 : Utiliser Composer

Initialisez un projet avec Composer et installez :
- `vlucas/phpdotenv`
- `monolog/monolog`

Créez une classe avec autoloading PSR-4.

### Exercice 3 : Déploiement sur hébergement mutualisé

Simulez un déploiement en créant la structure complète du projet avec `.env`, `.htaccess`, et Composer.

## 13. Points clés à retenir

✅ **Hébergement** : Mutualisé pour débuter, VPS pour plus de contrôle  
✅ **Apache** : Fichier `.htaccess` pour configuration locale  
✅ **Nginx** : Configuration centralisée, meilleures performances  
✅ **Composer** : `composer install --no-dev --optimize-autoloader` en prod  
✅ **Variables** : `.env` pour la config, jamais versionné  
✅ **SSL** : Let's Encrypt gratuit, certificat auto-renouvelable  
✅ **Git** : Déploiement via `git pull`, script automatisé  
✅ **Production** : `display_errors=Off`, `APP_DEBUG=false`  
✅ **Performance** : OPcache, Gzip, cache navigateur  
✅ **Sécurité** : HTTPS, headers, protection fichiers  

---

**Leçon précédente** : [Sécurité essentielle](./15-securite.md)  
**Prochaine leçon** : [Exercices et corrigés](./17-exercices-corriges.md)
