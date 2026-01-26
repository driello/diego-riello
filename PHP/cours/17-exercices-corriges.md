# Leçon 17 : Exercices et corrigés

## 1. Exercice : Formulaire de contact complet

### Énoncé

Créez un formulaire de contact sécurisé avec :
- Validation côté serveur
- Protection CSRF
- Envoi d'email
- Message de confirmation

### Corrigé

```php
<?php
// contact.php
session_start();

// Générer un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erreurs = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Token CSRF invalide");
    }
    
    // Récupérer et nettoyer les données
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
    } elseif (strlen($sujet) < 3) {
        $erreurs[] = "Le sujet doit contenir au moins 3 caractères";
    }
    
    if (empty($message)) {
        $erreurs[] = "Le message est obligatoire";
    } elseif (strlen($message) < 10) {
        $erreurs[] = "Le message doit contenir au moins 10 caractères";
    }
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($erreurs)) {
        $destinataire = "contact@monsite.com";
        $sujetEmail = "Contact : " . $sujet;
        $corpsEmail = "Nom : $nom\n";
        $corpsEmail .= "Email : $email\n\n";
        $corpsEmail .= "Message :\n$message";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        if (mail($destinataire, $sujetEmail, $corpsEmail, $headers)) {
            $succes = true;
            $_SESSION['message_flash'] = "Votre message a été envoyé avec succès !";
            header('Location: contact.php');
            exit;
        } else {
            $erreurs[] = "Erreur lors de l'envoi de l'email";
        }
    }
}

// Récupérer le message flash
$messageFlash = $_SESSION['message_flash'] ?? '';
unset($_SESSION['message_flash']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .erreurs { background: #ffdddd; border: 1px solid #ff0000; padding: 10px; margin-bottom: 20px; }
        .succes { background: #ddffdd; border: 1px solid #00ff00; padding: 10px; margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; margin-top: 15px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Formulaire de contact</h1>
    
    <?php if ($messageFlash): ?>
        <div class="succes"><?= htmlspecialchars($messageFlash) ?></div>
    <?php endif; ?>
    
    <?php if (!empty($erreurs)): ?>
        <div class="erreurs">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <label>Nom *</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" required>
        
        <label>Email *</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        
        <label>Sujet *</label>
        <input type="text" name="sujet" value="<?= htmlspecialchars($sujet ?? '') ?>" required>
        
        <label>Message *</label>
        <textarea name="message" rows="6" required><?= htmlspecialchars($message ?? '') ?></textarea>
        
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
```

---

## 2. Exercice : Système d'authentification

### Énoncé

Créez un système d'inscription et de connexion avec :
- Inscription avec validation
- Hachage des mots de passe
- Connexion sécurisée
- Page protégée (tableau de bord)

### Corrigé

#### Base de données

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Connexion à la base de données

```php
<?php
// config/database.php
function getPDO() {
    static $pdo = null;
    
    if ($pdo === null) {
        $host = 'localhost';
        $dbname = 'monsite';
        $user = 'root';
        $password = '';
        
        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
    
    return $pdo;
}
```

#### Page d'inscription

```php
<?php
// inscription.php
session_start();
require_once 'config/database.php';

// Générer un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("Token CSRF invalide");
    }
    
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    
    // Validation
    if (empty($nom) || strlen($nom) < 2) {
        $erreurs[] = "Le nom doit contenir au moins 2 caractères";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Email invalide";
    }
    
    if (strlen($password) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    
    if ($password !== $passwordConfirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas";
    }
    
    // Vérifier si l'email existe déjà
    if (empty($erreurs)) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $erreurs[] = "Cet email est déjà utilisé";
        }
    }
    
    // Inscription
    if (empty($erreurs)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $passwordHash]);
        
        $_SESSION['message_flash'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header('Location: connexion.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        .erreurs { background: #ffdddd; border: 1px solid #ff0000; padding: 10px; margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { width: 100%; background: #28a745; color: white; padding: 10px; border: none; margin-top: 15px; cursor: pointer; }
        button:hover { background: #218838; }
        .lien { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Inscription</h1>
    
    <?php if (!empty($erreurs)): ?>
        <div class="erreurs">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <label>Nom *</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" required>
        
        <label>Email *</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        
        <label>Mot de passe *</label>
        <input type="password" name="password" required>
        
        <label>Confirmer le mot de passe *</label>
        <input type="password" name="password_confirm" required>
        
        <button type="submit">S'inscrire</button>
    </form>
    
    <div class="lien">
        <a href="connexion.php">Déjà inscrit ? Se connecter</a>
    </div>
</body>
</html>
```

#### Page de connexion

```php
<?php
// connexion.php
session_start();
require_once 'config/database.php';

// Rediriger si déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Générer un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erreurs = [];
$messageFlash = $_SESSION['message_flash'] ?? '';
unset($_SESSION['message_flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("Token CSRF invalide");
    }
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $erreurs[] = "Tous les champs sont obligatoires";
    } else {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Régénérer l'ID de session
            session_regenerate_id(true);
            
            // Enregistrer l'utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            
            header('Location: dashboard.php');
            exit;
        } else {
            $erreurs[] = "Email ou mot de passe incorrect";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        .erreurs { background: #ffdddd; border: 1px solid #ff0000; padding: 10px; margin-bottom: 20px; }
        .succes { background: #ddffdd; border: 1px solid #00ff00; padding: 10px; margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { width: 100%; background: #007bff; color: white; padding: 10px; border: none; margin-top: 15px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .lien { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Connexion</h1>
    
    <?php if ($messageFlash): ?>
        <div class="succes"><?= htmlspecialchars($messageFlash) ?></div>
    <?php endif; ?>
    
    <?php if (!empty($erreurs)): ?>
        <div class="erreurs">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        
        <label>Mot de passe</label>
        <input type="password" name="password" required>
        
        <button type="submit">Se connecter</button>
    </form>
    
    <div class="lien">
        <a href="inscription.php">Pas encore inscrit ? S'inscrire</a>
    </div>
</body>
</html>
```

#### Tableau de bord (page protégée)

```php
<?php
// dashboard.php
session_start();

// Rediriger si non connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .card { background: #f8f9fa; padding: 20px; margin-top: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Tableau de bord</h1>
        <a href="deconnexion.php">Déconnexion</a>
    </div>
    
    <div class="card">
        <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user_nom']) ?> !</h2>
        <p>Email : <?= htmlspecialchars($_SESSION['user_email']) ?></p>
        <p>Vous êtes connecté(e).</p>
    </div>
</body>
</html>
```

#### Déconnexion

```php
<?php
// deconnexion.php
session_start();
session_unset();
session_destroy();

header('Location: connexion.php');
exit;
```

---

## 3. Exercice : CRUD complet (Gestion de tâches)

### Énoncé

Créez une application de gestion de tâches (todo list) avec :
- Affichage des tâches
- Ajout d'une tâche
- Modification d'une tâche
- Suppression d'une tâche
- Marquage comme terminée

### Corrigé

#### Base de données

```sql
CREATE TABLE taches (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(200) NOT NULL,
    description TEXT,
    terminee BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Application complète

```php
<?php
// taches.php
session_start();
require_once 'config/database.php';

$pdo = getPDO();

// Générer un token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die("Token CSRF invalide");
    }
    
    $action = $_POST['action'] ?? '';
    
    // Ajouter une tâche
    if ($action === 'ajouter') {
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (!empty($titre)) {
            $stmt = $pdo->prepare("INSERT INTO taches (titre, description) VALUES (?, ?)");
            $stmt->execute([$titre, $description]);
            
            $_SESSION['message_flash'] = "Tâche ajoutée avec succès !";
            header('Location: taches.php');
            exit;
        }
    }
    
    // Marquer comme terminée / non terminée
    if ($action === 'toggle') {
        $id = (int)($_POST['id'] ?? 0);
        
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE taches SET terminee = NOT terminee WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: taches.php');
            exit;
        }
    }
    
    // Supprimer
    if ($action === 'supprimer') {
        $id = (int)($_POST['id'] ?? 0);
        
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM taches WHERE id = ?");
            $stmt->execute([$id]);
            
            $_SESSION['message_flash'] = "Tâche supprimée !";
            header('Location: taches.php');
            exit;
        }
    }
    
    // Modifier
    if ($action === 'modifier') {
        $id = (int)($_POST['id'] ?? 0);
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if ($id > 0 && !empty($titre)) {
            $stmt = $pdo->prepare("UPDATE taches SET titre = ?, description = ? WHERE id = ?");
            $stmt->execute([$titre, $description, $id]);
            
            $_SESSION['message_flash'] = "Tâche modifiée !";
            header('Location: taches.php');
            exit;
        }
    }
}

// Récupérer toutes les tâches
$stmt = $pdo->query("SELECT * FROM taches ORDER BY created_at DESC");
$taches = $stmt->fetchAll();

// Récupérer le message flash
$messageFlash = $_SESSION['message_flash'] ?? '';
unset($_SESSION['message_flash']);

// Tâche en cours d'édition
$tacheEdit = null;
if (isset($_GET['edit'])) {
    $idEdit = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM taches WHERE id = ?");
    $stmt->execute([$idEdit]);
    $tacheEdit = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de tâches</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .succes { background: #ddffdd; border: 1px solid #00ff00; padding: 10px; margin-bottom: 20px; }
        .form-container { background: #f8f9fa; padding: 20px; margin-bottom: 30px; border-radius: 5px; }
        input[type="text"], textarea { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        textarea { height: 60px; resize: vertical; }
        button { padding: 8px 15px; margin-top: 10px; border: none; cursor: pointer; border-radius: 3px; }
        .btn-ajouter { background: #28a745; color: white; }
        .btn-ajouter:hover { background: #218838; }
        .btn-annuler { background: #6c757d; color: white; margin-left: 5px; }
        .tache { background: white; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .tache.terminee { opacity: 0.6; }
        .tache.terminee h3 { text-decoration: line-through; }
        .tache-actions { margin-top: 10px; }
        .tache-actions button { padding: 5px 10px; margin-right: 5px; font-size: 12px; }
        .btn-toggle { background: #007bff; color: white; }
        .btn-modifier { background: #ffc107; color: black; }
        .btn-supprimer { background: #dc3545; color: white; }
        .aucune { text-align: center; color: #999; padding: 50px; }
    </style>
</head>
<body>
    <h1>📝 Gestion de tâches</h1>
    
    <?php if ($messageFlash): ?>
        <div class="succes"><?= htmlspecialchars($messageFlash) ?></div>
    <?php endif; ?>
    
    <!-- Formulaire d'ajout/modification -->
    <div class="form-container">
        <h2><?= $tacheEdit ? 'Modifier la tâche' : 'Ajouter une tâche' ?></h2>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="action" value="<?= $tacheEdit ? 'modifier' : 'ajouter' ?>">
            <?php if ($tacheEdit): ?>
                <input type="hidden" name="id" value="<?= $tacheEdit['id'] ?>">
            <?php endif; ?>
            
            <label>Titre *</label>
            <input type="text" name="titre" value="<?= htmlspecialchars($tacheEdit['titre'] ?? '') ?>" required>
            
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($tacheEdit['description'] ?? '') ?></textarea>
            
            <button type="submit" class="btn-ajouter">
                <?= $tacheEdit ? 'Modifier' : 'Ajouter' ?>
            </button>
            
            <?php if ($tacheEdit): ?>
                <a href="taches.php"><button type="button" class="btn-annuler">Annuler</button></a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Liste des tâches -->
    <h2>Liste des tâches (<?= count($taches) ?>)</h2>
    
    <?php if (empty($taches)): ?>
        <div class="aucune">Aucune tâche pour le moment.</div>
    <?php else: ?>
        <?php foreach ($taches as $tache): ?>
            <div class="tache <?= $tache['terminee'] ? 'terminee' : '' ?>">
                <h3><?= htmlspecialchars($tache['titre']) ?></h3>
                <?php if ($tache['description']): ?>
                    <p><?= nl2br(htmlspecialchars($tache['description'])) ?></p>
                <?php endif; ?>
                <small>Créée le <?= date('d/m/Y à H:i', strtotime($tache['created_at'])) ?></small>
                
                <div class="tache-actions">
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="toggle">
                        <input type="hidden" name="id" value="<?= $tache['id'] ?>">
                        <button type="submit" class="btn-toggle">
                            <?= $tache['terminee'] ? 'Marquer comme non terminée' : 'Marquer comme terminée' ?>
                        </button>
                    </form>
                    
                    <a href="?edit=<?= $tache['id'] ?>">
                        <button class="btn-modifier">Modifier</button>
                    </a>
                    
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette tâche ?');">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="id" value="<?= $tache['id'] ?>">
                        <button type="submit" class="btn-supprimer">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
```

---

## 4. Points clés à retenir

✅ **Formulaire de contact** : CSRF, validation, htmlspecialchars()  
✅ **Authentification** : password_hash(), password_verify(), session_regenerate_id()  
✅ **CRUD** : Requêtes préparées, actions multiples dans un fichier  
✅ **Sécurité** : Token CSRF, validation serveur, échappement des sorties  
✅ **UX** : Messages flash, confirmation de suppression, formulaire unique pour ajout/modification  
✅ **Base de données** : PDO, requêtes préparées, transactions si nécessaire  
✅ **Structure** : Séparation config/logique/affichage pour les gros projets  

---

**Leçon précédente** : [Déploiement minimal](./16-deploiement.md)  
**Prochaine leçon** : [Ressources et suite](./18-ressources.md)
