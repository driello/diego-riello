<?php
// securite15/ex15_1.php
// Exercice 1 : Page de connexion sécurisée

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper pour échapper le HTML (protection XSS)
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Génération du token CSRF
if (empty($_SESSION['csrf_token_login'])) {
    $_SESSION['csrf_token_login'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token_login'];

$errors = [];
$successMessage = '';

// Utilisateur simulé (comme s'il venait de la BDD)
$fakeUser = [
    'email'         => 'user@example.com',
    // Mot de passe en clair : Secret123!
    'password_hash' => password_hash('Secret123!', PASSWORD_DEFAULT),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token    = $_POST['csrf_token'] ?? '';

    // 1. Vérif CSRF
    if (!hash_equals($csrfToken, $token)) {
        $errors[] = "Token CSRF invalide. Merci de recharger la page.";
    }

    // 2. Validation des champs
    if ($email === '') {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    if ($password === '') {
        $errors[] = "Le mot de passe est obligatoire.";
    }

    // 3. Authentification si pas d'erreurs de validation
    if (empty($errors)) {
        if ($email === $fakeUser['email'] && password_verify($password, $fakeUser['password_hash'])) {
            // En vrai : session_regenerate_id(true); et $_SESSION['user_id'] = ...
            $successMessage = "Connexion réussie ✅ (utilisateur simulé)";
        } else {
            $errors[] = "Identifiants invalides.";
        }
    }
}
?>

<h2>Exercice 1 : Page de connexion sécurisée</h2>

<?php if (!empty($errors)): ?>
    <div style="color: darkred; border:1px solid darkred; padding:10px; margin-bottom:10px;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($successMessage): ?>
    <p style="color: green;"><?= e($successMessage) ?></p>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label for="email">Email :</label><br>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= isset($email) ? e($email) : '' ?>"
            required
        >
    </div>

    <div>
        <label for="password">Mot de passe :</label><br>
        <input
            type="password"
            id="password"
            name="password"
            required
        >
    </div>

    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

    <button type="submit" style="margin-top:10px;">Se connecter</button>
</form>

<p style="margin-top:10px;">
    <em>Indice pour tester :</em> email : <code>user@example.com</code>, mot de passe : <code>Secret123!</code>
</p>
