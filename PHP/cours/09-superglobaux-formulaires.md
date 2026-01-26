# Leçon 9 : Superglobaux et formulaires

## 1. Les superglobales

Les **superglobales** sont des tableaux prédéfinis, accessibles partout dans le script (dans les fonctions, classes, etc.).

Principales superglobales :
- `$_GET` : Données envoyées via l'URL (paramètres de requête)
- `$_POST` : Données envoyées via un formulaire POST
- `$_REQUEST` : Contient `$_GET`, `$_POST` et `$_COOKIE`
- `$_SERVER` : Informations sur le serveur et la requête
- `$_SESSION` : Variables de session
- `$_COOKIE` : Cookies
- `$_FILES` : Fichiers uploadés
- `$_ENV` : Variables d'environnement
- `$GLOBALS` : Toutes les variables globales

## 2. `$_GET` : Paramètres d'URL

### Récupérer des paramètres

URL : `page.php?nom=Alice&age=30`

```php
<?php
$nom = $_GET['nom'] ?? 'Anonyme';
$age = $_GET['age'] ?? 0;

echo "Nom : $nom<br>";
echo "Âge : $age";
```

### Créer des liens avec paramètres

```php
<?php
$page = 2;
$categorie = "sports";
?>

<a href="articles.php?page=<?= $page ?>&cat=<?= $categorie ?>">
    Page suivante
</a>
```

### Vérifier l'existence d'un paramètre

```php
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "ID : $id";
} else {
    echo "Aucun ID fourni";
}

// Ou avec l'opérateur ??
$id = $_GET['id'] ?? null;
```

## 3. `$_POST` : Données de formulaire

### Formulaire HTML simple

**formulaire.html**
```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire</title>
</head>
<body>
    <form action="traitement.php" method="POST">
        <label>Nom : <input type="text" name="nom" required></label><br>
        <label>Email : <input type="email" name="email" required></label><br>
        <label>Message : <textarea name="message"></textarea></label><br>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
```

**traitement.php**
```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    echo "Nom : $nom<br>";
    echo "Email : $email<br>";
    echo "Message : $message<br>";
}
```

### Formulaire avec validation

```php
<?php
$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    // Validation
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire";
    }
    
    if (empty($email)) {
        $erreurs[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide";
    }
    
    // Si pas d'erreurs, traiter les données
    if (empty($erreurs)) {
        echo "Formulaire valide !";
        // Enregistrer en base de données, envoyer un email, etc.
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire avec validation</title>
</head>
<body>
    <?php if (!empty($erreurs)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"></label><br>
        <label>Email : <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label><br>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
```

## 4. `$_REQUEST` : Fusion de GET, POST et COOKIE

⚠️ **Attention** : Évitez `$_REQUEST`, préférez `$_GET` ou `$_POST` pour plus de clarté et de sécurité.

```php
<?php
// Accepte les données de GET ou POST
$nom = $_REQUEST['nom'] ?? 'Anonyme';
```

## 5. `$_SERVER` : Informations serveur et requête

### Variables utiles

```php
<?php
// Méthode HTTP
echo $_SERVER['REQUEST_METHOD']; // GET, POST, PUT, DELETE...

// URL de la page actuelle
echo $_SERVER['REQUEST_URI']; // /page.php?id=5

// Nom du script
echo $_SERVER['SCRIPT_NAME']; // /page.php

// Adresse IP du visiteur
echo $_SERVER['REMOTE_ADDR']; // 192.168.1.1

// User agent (navigateur)
echo $_SERVER['HTTP_USER_AGENT'];

// Protocole
echo $_SERVER['SERVER_PROTOCOL']; // HTTP/1.1

// Port
echo $_SERVER['SERVER_PORT']; // 80, 443...

// Nom de domaine
echo $_SERVER['HTTP_HOST']; // example.com
```

### Exemple : Détecter une requête AJAX

```php
<?php
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
          && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    echo json_encode(['success' => true]);
} else {
    echo "<h1>Page HTML</h1>";
}
```

## 6. Filtrage et validation des données

### `filter_var()` : Valider

```php
<?php
$email = "user@example.com";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email valide";
}

$url = "https://example.com";
if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL valide";
}

$ip = "192.168.1.1";
if (filter_var($ip, FILTER_VALIDATE_IP)) {
    echo "IP valide";
}
```

### `filter_var()` : Nettoyer

```php
<?php
$email = "user@EXAMPLE.com  ";
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
echo $email; // user@example.com

$texte = "<script>alert('XSS')</script>";
$texte = filter_var($texte, FILTER_SANITIZE_STRING);
echo $texte; // alert('XSS') (balises supprimées)
```

### `filter_input()` : Directement depuis GET/POST

```php
<?php
// Récupérer et valider
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    echo "ID invalide";
} else {
    echo "ID : $id";
}

// Récupérer et nettoyer
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
```

## 7. Sécurité des formulaires

### Échapper les sorties avec `htmlspecialchars()`

```php
<?php
$nom = $_POST['nom'] ?? '';

// ❌ Dangereux (XSS)
// echo $nom;

// ✅ Sécurisé
echo htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
```

### Valider côté serveur

⚠️ **JAMAIS** faire confiance aux données du client !

```php
<?php
function validerNom($nom) {
    $nom = trim($nom);
    
    if (empty($nom)) {
        return "Le nom est obligatoire";
    }
    
    if (strlen($nom) < 2) {
        return "Le nom doit contenir au moins 2 caractères";
    }
    
    if (strlen($nom) > 50) {
        return "Le nom est trop long";
    }
    
    if (!preg_match('/^[a-zA-ZÀ-ÿ\s-]+$/', $nom)) {
        return "Le nom contient des caractères invalides";
    }
    
    return null; // Pas d'erreur
}
```

### Protection CSRF (Cross-Site Request Forgery)

```php
<?php
session_start();

// Générer un token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token
    $token = $_POST['csrf_token'] ?? '';
    
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        die("Token CSRF invalide");
    }
    
    // Traiter le formulaire...
}
?>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <!-- Autres champs... -->
    <button type="submit">Envoyer</button>
</form>
```

## 8. Exemple pratique : Formulaire de contact complet

```php
<?php
session_start();

// Générer token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erreurs = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité");
    }
    
    // Récupérer et nettoyer
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validation
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire";
    } elseif (strlen($nom) < 2) {
        $erreurs[] = "Le nom doit contenir au moins 2 caractères";
    }
    
    if (empty($email)) {
        $erreurs[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide";
    }
    
    if (empty($sujet)) {
        $erreurs[] = "Le sujet est obligatoire";
    }
    
    if (empty($message)) {
        $erreurs[] = "Le message est obligatoire";
    } elseif (strlen($message) < 10) {
        $erreurs[] = "Le message doit contenir au moins 10 caractères";
    }
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($erreurs)) {
        // Envoyer l'email (exemple simplifié)
        $to = "contact@example.com";
        $headers = "From: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        if (mail($to, $sujet, $message, $headers)) {
            $succes = true;
            $_POST = []; // Vider le formulaire
        } else {
            $erreurs[] = "Erreur lors de l'envoi du message";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de contact</title>
    <style>
        .error { color: red; }
        .success { color: green; }
        input, textarea { display: block; margin: 10px 0; padding: 5px; width: 300px; }
    </style>
</head>
<body>
    <h1>Formulaire de contact</h1>
    
    <?php if ($succes): ?>
        <div class="success">Votre message a été envoyé avec succès !</div>
    <?php endif; ?>
    
    <?php if (!empty($erreurs)): ?>
        <div class="error">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
        
        <label>Email :</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        
        <label>Sujet :</label>
        <input type="text" name="sujet" value="<?= htmlspecialchars($_POST['sujet'] ?? '') ?>" required>
        
        <label>Message :</label>
        <textarea name="message" rows="5" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
```

## 9. Exercices pratiques

### Exercice 1 : Lien avec paramètres

Créez une page avec des liens vers `article.php?id=1`, `article.php?id=2`, etc.  
Dans `article.php`, affichez l'ID reçu.

### Exercice 2 : Formulaire d'inscription

Créez un formulaire avec :
- Nom
- Prénom
- Email
- Mot de passe

Validez les données et affichez les erreurs.

### Exercice 3 : Calculatrice

Créez un formulaire avec deux nombres et une opération (+, -, *, /).  
Affichez le résultat du calcul.

### Exercice 4 : Recherche

Créez une barre de recherche qui envoie le terme via GET.  
Simulez une recherche en filtrant un tableau de produits.

## 10. Points clés à retenir

✅ **`$_GET`** : Paramètres d'URL (visible, limité en taille)  
✅ **`$_POST`** : Données de formulaire (invisible, pas de limite)  
✅ **`$_SERVER`** : Informations serveur et requête  
✅ **Validation** : Toujours valider côté serveur avec `filter_var()`, `filter_input()`  
✅ **Échappement** : `htmlspecialchars()` pour afficher des données utilisateur  
✅ **CSRF** : Utiliser un token pour protéger les formulaires  
✅ **Opérateur `??`** : `$var = $_GET['key'] ?? 'default';`  
✅ **Méthode** : Vérifier avec `$_SERVER['REQUEST_METHOD'] === 'POST'`

---

**Leçon précédente** : [Chaînes de caractères](./08-chaines-caracteres.md)  
**Prochaine leçon** : [Sessions et cookies](./10-sessions-cookies.md)
