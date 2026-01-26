# Leçon 15 : Sécurité essentielle

## 1. Introduction à la sécurité en PHP

La sécurité est **cruciale** dans le développement web. Les principales vulnérabilités à connaître :

- **Injection SQL** : Manipulation de requêtes SQL
- **XSS** (Cross-Site Scripting) : Injection de code JavaScript
- **CSRF** (Cross-Site Request Forgery) : Exécution d'actions non autorisées
- **Upload de fichiers malveillants**
- **Session hijacking** : Vol de session
- **Inclusion de fichiers** : Lecture/exécution de fichiers non autorisés

## 2. Prévenir l'injection SQL

### ❌ Code vulnérable

```php
<?php
// NE JAMAIS FAIRE ÇA !
$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $pdo->query($query);

// Un attaquant peut entrer : ' OR '1'='1' -- 
// La requête devient : SELECT * FROM users WHERE email = '' OR '1'='1' -- ' AND password = ''
```

### ✅ Solution : Requêtes préparées

```php
<?php
$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo "Connexion réussie";
} else {
    echo "Identifiants invalides";
}
```

## 3. Prévenir les attaques XSS

### ❌ Code vulnérable

```php
<?php
// NE JAMAIS FAIRE ÇA !
$nom = $_GET['nom'];
echo "Bonjour $nom"; 

// Un attaquant peut entrer : <script>alert('XSS')</script>
```

### ✅ Solution : `htmlspecialchars()`

```php
<?php
$nom = $_GET['nom'];
echo "Bonjour " . htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');

// Le code JavaScript sera échappé : &lt;script&gt;alert('XSS')&lt;/script&gt;
```

### Fonction helper

```php
<?php
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Utilisation
echo "Bonjour " . e($_GET['nom']);
```

### Dans les attributs HTML

```php
<?php
$url = $_GET['url'];
?>
<a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>">Lien</a>
```

## 4. Prévenir les attaques CSRF

### Principe

Un attaquant fait exécuter une action à votre place via un site malveillant.

### ✅ Solution : Token CSRF

```php
<?php
session_start();

// Générer un token unique
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Traiter le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    
    // Vérifier le token
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        die("Token CSRF invalide");
    }
    
    // Traiter les données...
    echo "Action effectuée avec succès";
}
?>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <button type="submit">Supprimer mon compte</button>
</form>
```

## 5. Hachage de mots de passe

### ❌ JAMAIS stocker en clair

```php
<?php
// NE JAMAIS FAIRE ÇA !
$password = $_POST['password'];
$pdo->exec("INSERT INTO users (password) VALUES ('$password')");
```

### ❌ JAMAIS utiliser MD5 ou SHA1

```php
<?php
// NE JAMAIS FAIRE ÇA ! (MD5/SHA1 sont cassés)
$password = md5($_POST['password']);
```

### ✅ Utiliser `password_hash()` et `password_verify()`

```php
<?php
// Inscription
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hash]);

// Connexion
$password = $_POST['password'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo "Connexion réussie";
} else {
    echo "Identifiants invalides";
}
```

### Mettre à jour le hash si nécessaire

```php
<?php
if ($user && password_verify($password, $user['password'])) {
    // Vérifier si le hash doit être mis à jour
    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$newHash, $user['id']]);
    }
    
    echo "Connexion réussie";
}
```

## 6. Validation et filtrage des données

### Validation d'email

```php
<?php
$email = $_POST['email'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email invalide");
}
```

### Validation d'URL

```php
<?php
$url = $_POST['url'];

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    die("URL invalide");
}
```

### Filtrage de chaînes

```php
<?php
$texte = $_POST['texte'];

// Supprimer les balises HTML
$texte = strip_tags($texte);

// Ou garder certaines balises
$texte = strip_tags($texte, '<p><br><strong>');

// Nettoyer
$texte = filter_var($texte, FILTER_SANITIZE_STRING);
```

### Validation d'entier

```php
<?php
$age = $_POST['age'];

if (!filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 120]])) {
    die("Âge invalide");
}
```

## 7. Sécurité des sessions

### Configuration sécurisée

```php
<?php
ini_set('session.cookie_httponly', '1');  // Pas accessible via JavaScript
ini_set('session.cookie_secure', '1');    // HTTPS uniquement
ini_set('session.cookie_samesite', 'Strict'); // Protection CSRF
ini_set('session.use_strict_mode', '1');  // N'accepte que les IDs générés par PHP

session_start();
```

### Régénérer l'ID après connexion

```php
<?php
session_start();

if (connexionReussie()) {
    // Régénérer l'ID pour éviter le session fixation
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
}
```

### Timeout de session

```php
<?php
session_start();

$timeout = 1800; // 30 minutes

if (isset($_SESSION['derniere_activite']) && 
    (time() - $_SESSION['derniere_activite'] > $timeout)) {
    
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$_SESSION['derniere_activite'] = time();
```

## 8. Sécurité des uploads de fichiers

### Validation complète

```php
<?php
if (isset($_FILES['fichier'])) {
    $fichier = $_FILES['fichier'];
    
    // Vérifier les erreurs
    if ($fichier['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors de l'upload");
    }
    
    // Vérifier la taille (2 Mo max)
    $tailleMax = 2 * 1024 * 1024;
    if ($fichier['size'] > $tailleMax) {
        die("Fichier trop volumineux");
    }
    
    // Vérifier le type MIME réel
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $fichier['tmp_name']);
    finfo_close($finfo);
    
    $typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $typesAutorises)) {
        die("Type de fichier non autorisé");
    }
    
    // Vérifier l'extension
    $extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));
    $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extension, $extensionsAutorisees)) {
        die("Extension non autorisée");
    }
    
    // Générer un nom unique et sécurisé
    $nouveauNom = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = 'uploads/' . $nouveauNom;
    
    // Vérifier que le dossier n'est pas accessible directement
    if (!file_exists('uploads/.htaccess')) {
        file_put_contents('uploads/.htaccess', 'Options -Indexes');
    }
    
    // Déplacer le fichier
    if (move_uploaded_file($fichier['tmp_name'], $destination)) {
        echo "Fichier uploadé : $nouveauNom";
    } else {
        die("Erreur lors du déplacement");
    }
}
```

## 9. Prévenir l'inclusion de fichiers

### ❌ Code vulnérable

```php
<?php
// NE JAMAIS FAIRE ÇA !
$page = $_GET['page'];
include($page . '.php');

// Un attaquant peut entrer : ../../etc/passwd
```

### ✅ Solution : Liste blanche

```php
<?php
$pagesAutorisees = ['accueil', 'contact', 'apropos'];
$page = $_GET['page'] ?? 'accueil';

if (!in_array($page, $pagesAutorisees)) {
    $page = 'accueil';
}

include("pages/$page.php");
```

## 10. Headers de sécurité

### Configuration recommandée

```php
<?php
// Empêcher l'affichage dans une iframe (protection contre le clickjacking)
header('X-Frame-Options: SAMEORIGIN');

// Activer la protection XSS du navigateur
header('X-XSS-Protection: 1; mode=block');

// Empêcher le sniffing de type MIME
header('X-Content-Type-Options: nosniff');

// Content Security Policy (CSP)
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'");

// HTTPS uniquement (HSTS)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
```

## 11. Exemple : Fonction de validation sécurisée

```php
<?php
class Validator {
    private $errors = [];
    
    public function required($valeur, $nom) {
        if (empty(trim($valeur))) {
            $this->errors[] = "Le champ '$nom' est obligatoire";
        }
        return $this;
    }
    
    public function email($valeur, $nom) {
        if (!filter_var($valeur, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Le champ '$nom' doit être un email valide";
        }
        return $this;
    }
    
    public function minLength($valeur, $nom, $longueur) {
        if (strlen($valeur) < $longueur) {
            $this->errors[] = "Le champ '$nom' doit contenir au moins $longueur caractères";
        }
        return $this;
    }
    
    public function maxLength($valeur, $nom, $longueur) {
        if (strlen($valeur) > $longueur) {
            $this->errors[] = "Le champ '$nom' ne peut pas dépasser $longueur caractères";
        }
        return $this;
    }
    
    public function numeric($valeur, $nom) {
        if (!is_numeric($valeur)) {
            $this->errors[] = "Le champ '$nom' doit être un nombre";
        }
        return $this;
    }
    
    public function isValid() {
        return empty($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }
}

// Utilisation
$validator = new Validator();

$validator->required($_POST['nom'], 'nom')
          ->minLength($_POST['nom'], 'nom', 2)
          ->maxLength($_POST['nom'], 'nom', 50);

$validator->required($_POST['email'], 'email')
          ->email($_POST['email'], 'email');

if ($validator->isValid()) {
    echo "Formulaire valide !";
} else {
    foreach ($validator->getErrors() as $erreur) {
        echo "$erreur<br>";
    }
}
```

## 12. Checklist de sécurité

✅ **Base de données**
- Utiliser PDO avec requêtes préparées
- Ne jamais concaténer les données utilisateur dans les requêtes

✅ **Affichage**
- Toujours échapper avec `htmlspecialchars()`
- Utiliser `ENT_QUOTES` et `UTF-8`

✅ **Mots de passe**
- `password_hash()` et `password_verify()`
- Jamais MD5, SHA1 ou stockage en clair

✅ **Sessions**
- `httponly`, `secure`, `samesite`
- Régénérer l'ID après connexion
- Timeout de session

✅ **Formulaires**
- Token CSRF
- Validation côté serveur
- Nettoyer les entrées

✅ **Uploads**
- Vérifier taille, type MIME, extension
- Nom de fichier sécurisé
- Dossier protégé

✅ **Headers**
- X-Frame-Options, CSP, HSTS
- X-XSS-Protection, X-Content-Type-Options

✅ **Général**
- Erreurs loggées, pas affichées en production
- HTTPS obligatoire
- Mises à jour régulières de PHP

## 13. Exercices pratiques

### Exercice 1 : Sécuriser une page de connexion

Créez une page de connexion sécurisée avec :
- Protection CSRF
- Validation des données
- Hachage des mots de passe

### Exercice 2 : Validation de formulaire

Créez un validateur qui vérifie :
- Email valide
- Mot de passe fort (8+ caractères, majuscule, chiffre)
- Nom sans caractères spéciaux

### Exercice 3 : Upload sécurisé

Créez un système d'upload d'images sécurisé avec toutes les vérifications.

## 14. Points clés à retenir

✅ **Injection SQL** : Requêtes préparées avec PDO  
✅ **XSS** : `htmlspecialchars()` sur toutes les sorties  
✅ **CSRF** : Token unique par session avec `hash_equals()`  
✅ **Mots de passe** : `password_hash()` et `password_verify()`  
✅ **Validation** : Toujours côté serveur, `filter_var()`  
✅ **Sessions** : Configuration sécurisée, `session_regenerate_id()`  
✅ **Uploads** : Vérifier taille, MIME, extension, nom unique  
✅ **Headers** : CSP, X-Frame-Options, HSTS  
✅ **Production** : Désactiver `display_errors`, activer `log_errors`  
✅ **Principe** : **Ne jamais faire confiance aux données utilisateur**

---

**Leçon précédente** : [Gestion des erreurs et debugging](./14-erreurs-debugging.md)  
**Prochaine leçon** : [Déploiement minimal](./16-deploiement.md)
