# Leçon 10 : Sessions et cookies

## 1. Comprendre les sessions

Une **session** permet de stocker des informations sur le serveur pour un utilisateur spécifique pendant toute la durée de sa visite.

**Utilité** :
- Authentification utilisateur
- Panier d'achat
- Préférences temporaires
- Messages flash (notifications)

**Fonctionnement** :
1. PHP génère un identifiant unique (session ID)
2. Le session ID est stocké dans un cookie côté client
3. Les données sont stockées sur le serveur

## 2. Démarrer une session

### `session_start()`

⚠️ **Important** : Doit être appelée **avant toute sortie HTML** !

```php
<?php
session_start(); // Toujours en premier !

// Maintenant on peut utiliser $_SESSION
$_SESSION['nom'] = "Alice";
$_SESSION['role'] = "admin";
?>
```

### Vérifier si une session est démarrée

```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

## 3. Stocker et récupérer des données

### Stocker des données

```php
<?php
session_start();

$_SESSION['utilisateur'] = "Alice";
$_SESSION['email'] = "alice@example.com";
$_SESSION['role'] = "admin";
$_SESSION['connexion'] = time();
```

### Récupérer des données

```php
<?php
session_start();

$nom = $_SESSION['utilisateur'] ?? 'Invité';
echo "Bonjour, $nom !";

// Vérifier l'existence
if (isset($_SESSION['role'])) {
    echo "Rôle : " . $_SESSION['role'];
}
```

### Stocker des tableaux et objets

```php
<?php
session_start();

// Tableau
$_SESSION['panier'] = [
    ['produit' => 'Livre', 'prix' => 15],
    ['produit' => 'Stylo', 'prix' => 2]
];

// Objet
class Utilisateur {
    public $nom;
    public $email;
}

$user = new Utilisateur();
$user->nom = "Alice";
$user->email = "alice@example.com";

$_SESSION['user_object'] = $user;
```

## 4. Supprimer des données de session

### Supprimer une variable spécifique

```php
<?php
session_start();

unset($_SESSION['panier']);
```

### Vider toutes les variables de session

```php
<?php
session_start();

$_SESSION = []; // Vide le tableau
```

### Détruire complètement la session

```php
<?php
session_start();

// Supprimer toutes les variables
$_SESSION = [];

// Supprimer le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();
```

## 5. Exemple : Système d'authentification simple

### Page de connexion (login.php)

```php
<?php
session_start();

// Utilisateurs fictifs (en production : base de données)
$utilisateurs = [
    'alice' => password_hash('password123', PASSWORD_DEFAULT),
    'bob' => password_hash('secret456', PASSWORD_DEFAULT)
];

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (isset($utilisateurs[$username]) && 
        password_verify($password, $utilisateurs[$username])) {
        
        // Connexion réussie
        $_SESSION['utilisateur'] = $username;
        $_SESSION['connexion'] = time();
        
        header('Location: dashboard.php');
        exit;
    } else {
        $erreur = "Identifiants invalides";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    
    <?php if ($erreur): ?>
        <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Nom d'utilisateur : <input type="text" name="username" required></label><br>
        <label>Mot de passe : <input type="password" name="password" required></label><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
```

### Page protégée (dashboard.php)

```php
<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

$utilisateur = $_SESSION['utilisateur'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($utilisateur) ?> !</h1>
    <p>Vous êtes connecté depuis <?= date('H:i:s', $_SESSION['connexion']) ?></p>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
```

### Page de déconnexion (logout.php)

```php
<?php
session_start();

// Détruire la session
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header('Location: login.php');
exit;
```

## 6. Comprendre les cookies

Un **cookie** est un petit fichier texte stocké **côté client** (navigateur).

**Utilité** :
- Se souvenir des préférences
- Garder une connexion ("Se souvenir de moi")
- Tracking et analytics

## 7. Créer et lire des cookies

### `setcookie()` : Créer un cookie

```php
<?php
// Doit être appelé AVANT toute sortie HTML
setcookie('nom', 'Alice', time() + 3600); // Expire dans 1 heure

// Cookie avec options
setcookie('theme', 'dark', [
    'expires' => time() + 86400 * 30, // 30 jours
    'path' => '/',
    'domain' => 'example.com',
    'secure' => true,    // HTTPS uniquement
    'httponly' => true,  // Pas accessible via JavaScript
    'samesite' => 'Strict' // Protection CSRF
]);
?>
```

### Lire un cookie

```php
<?php
$nom = $_COOKIE['nom'] ?? 'Invité';
echo "Bonjour, $nom !";

// Vérifier l'existence
if (isset($_COOKIE['theme'])) {
    $theme = $_COOKIE['theme'];
    echo "Thème : $theme";
}
```

### Supprimer un cookie

```php
<?php
// Définir une date d'expiration dans le passé
setcookie('nom', '', time() - 3600);
```

## 8. Exemple : "Se souvenir de moi"

```php
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Vérifier les identifiants...
    $connexionReussie = true; // Exemple simplifié
    
    if ($connexionReussie) {
        $_SESSION['utilisateur'] = $username;
        
        // Si "Se souvenir de moi" est coché
        if ($remember) {
            // Créer un token sécurisé
            $token = bin2hex(random_bytes(32));
            
            // Stocker le token en cookie (30 jours)
            setcookie('remember_token', $token, [
                'expires' => time() + 86400 * 30,
                'httponly' => true,
                'secure' => true,
                'samesite' => 'Strict'
            ]);
            
            // Enregistrer le token en base de données
            // saveTokenToDatabase($username, $token);
        }
        
        header('Location: dashboard.php');
        exit;
    }
}

// Vérifier le token "remember me"
if (!isset($_SESSION['utilisateur']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    // Vérifier le token en base de données
    // $username = getUsernameFromToken($token);
    
    // if ($username) {
    //     $_SESSION['utilisateur'] = $username;
    //     header('Location: dashboard.php');
    //     exit;
    // }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Nom d'utilisateur"><br>
    <input type="password" name="password" placeholder="Mot de passe"><br>
    <label><input type="checkbox" name="remember"> Se souvenir de moi</label><br>
    <button type="submit">Se connecter</button>
</form>
```

## 9. Configuration des sessions

### Dans php.ini

```ini
session.cookie_lifetime = 0          ; Cookie expire à la fermeture du navigateur
session.cookie_httponly = 1          ; Pas accessible via JavaScript
session.cookie_secure = 1            ; HTTPS uniquement
session.cookie_samesite = "Strict"   ; Protection CSRF
session.gc_maxlifetime = 1440        ; Durée de vie en secondes (24 min)
```

### Avec `session_set_cookie_params()`

```php
<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'example.com',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();
```

## 10. Sécurité des sessions

### Régénérer l'ID de session

```php
<?php
session_start();

// Après une connexion réussie
if ($connexionReussie) {
    session_regenerate_id(true); // Empêche le session fixation
    $_SESSION['utilisateur'] = $username;
}
```

### Timeout de session

```php
<?php
session_start();

$timeout = 1800; // 30 minutes

if (isset($_SESSION['derniere_activite']) && 
    (time() - $_SESSION['derniere_activite'] > $timeout)) {
    
    // Session expirée
    session_unset();
    session_destroy();
    header('Location: login.php?timeout=1');
    exit;
}

$_SESSION['derniere_activite'] = time();
```

### Valider l'IP et le User Agent

```php
<?php
session_start();

$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

if (!isset($_SESSION['ip'])) {
    $_SESSION['ip'] = $ip;
    $_SESSION['user_agent'] = $userAgent;
} else {
    // Vérifier que l'IP et le user agent n'ont pas changé
    if ($_SESSION['ip'] !== $ip || $_SESSION['user_agent'] !== $userAgent) {
        // Session hijacking possible
        session_unset();
        session_destroy();
        die("Erreur de sécurité");
    }
}
```

## 11. Messages flash

Messages affichés une seule fois (après redirection).

```php
<?php
session_start();

// Définir un message flash
function setFlash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

// Récupérer et supprimer
function getFlash($type) {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

// Utilisation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traiter le formulaire...
    setFlash('success', 'Votre profil a été mis à jour !');
    header('Location: profile.php');
    exit;
}

// Afficher le message
$message = getFlash('success');
if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
```

## 12. Exercices pratiques

### Exercice 1 : Compteur de visites

Créez un compteur qui affiche le nombre de fois qu'un utilisateur a visité la page (utilisez une session).

### Exercice 2 : Préférence de langue

Créez un système qui permet de changer la langue du site (FR/EN) et la sauvegarde dans un cookie.

### Exercice 3 : Panier d'achat

Créez un mini-panier :
- Ajouter des produits
- Afficher le panier
- Supprimer des produits
- Vider le panier

### Exercice 4 : Système de connexion complet

Implémentez :
- Page de connexion
- Page d'inscription
- Page protégée (dashboard)
- Déconnexion
- Message "Session expirée"

## 13. Points clés à retenir

✅ **Sessions** : Données stockées côté serveur, identifiées par un cookie  
✅ **`session_start()`** : À appeler avant toute sortie HTML  
✅ **`$_SESSION`** : Tableau pour stocker les données  
✅ **Cookies** : Données stockées côté client avec `setcookie()`  
✅ **Sécurité** : `session_regenerate_id()`, timeout, validation IP/UA  
✅ **Options** : `httponly`, `secure`, `samesite` pour protéger les cookies  
✅ **Déconnexion** : Vider `$_SESSION`, supprimer le cookie, `session_destroy()`  
✅ **Flash messages** : Messages affichés une seule fois après redirection

---

**Leçon précédente** : [Superglobaux et formulaires](./09-superglobaux-formulaires.md)  
**Prochaine leçon** : [Fichiers et entrée/sortie](./11-fichiers-io.md)
