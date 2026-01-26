<?php
// deploiement16/ex16_1.php
// Exercice 1 : Construire un fichier .htaccess complet

$htaccess = <<<HTACC
# Activer le moteur de réécriture
RewriteEngine On

# Forcer HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Rediriger vers index.php si le fichier ou le dossier n'existe pas
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L]

# Protéger les fichiers sensibles (.env, .ini, .log, .sql, .sh)
<FilesMatch "\\.(ini|log|sh|sql|env)$">
    Require all denied
</FilesMatch>

# Protéger le dossier vendor (Composer)
<IfModule mod_rewrite.c>
    RewriteRule ^vendor/.*$ - [F,L]
</IfModule>

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

# Mise en cache navigateur
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
HTACC;
?>

<h2>Exercice 1 : Fichier .htaccess complet</h2>

<p>Voici un exemple de fichier <code>.htaccess</code> à utiliser dans ton dossier <code>public/</code> en production :</p>

<pre><?php echo htmlspecialchars($htaccess, ENT_QUOTES, 'UTF-8'); ?></pre>
