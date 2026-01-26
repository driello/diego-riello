<?php
// securite15/ex15_2.php
// Exercice 2 : Validation de formulaire (nom, email, mot de passe)

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$errors = [];
$successMessage = '';

$nom      = $_POST['nom']      ?? '';
$email    = $_POST['email']    ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Nom : obligatoire, sans caractères spéciaux
    $nomTrim = trim($nom);
    if ($nomTrim === '') {
        $errors[] = "Le nom est obligatoire.";
    } elseif (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ \-]+$/u', $nomTrim)) {
        $errors[] = "Le nom ne doit contenir que des lettres, espaces ou tirets.";
    }

    // 2. Email : obligatoire + format valide
    if (trim($email) === '') {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    // 3. Mot de passe : fort
    // - Au moins 8 caractères
    // - Au moins 1 majuscule
    // - Au moins 1 chiffre
    if ($password === '') {
        $errors[] = "Le mot de passe est obligatoire.";
    } else {
        if (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins une majuscule.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
        }
    }

    if (empty($errors)) {
        $successMessage = "Formulaire valide ✅";
    }
}
?>

<h2>Exercice 2 : Validation de formulaire</h2>

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
        <label for="nom">Nom :</label><br>
        <input
            type="text"
            id="nom"
            name="nom"
            value="<?= e($nom) ?>"
            required
        >
    </div>

    <div>
        <label for="email">Email :</label><br>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= e($email) ?>"
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
        <small>
            Au moins 8 caractères, une majuscule, un chiffre.
        </small>
    </div>

    <button type="submit" style="margin-top:10px;">Valider</button>
</form>
