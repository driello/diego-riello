<?php
// Exercice 2 : Validation avec exceptions

class ValidationException extends Exception
{
    private string $champ;

    public function __construct(string $message, string $champ)
    {
        parent::__construct($message);
        $this->champ = $champ;
    }

    public function getChamp(): string
    {
        return $this->champ;
    }
}

// Fonction de validation d'un pseudo + email + mot de passe
function validerInscription(array $data): void
{
    // Pseudo
    if (empty($data['pseudo'])) {
        throw new ValidationException("Le pseudo est obligatoire", "pseudo");
    }

    if (strlen($data['pseudo']) < 3) {
        throw new ValidationException("Le pseudo doit faire au moins 3 caractères", "pseudo");
    }

    // Email
    if (empty($data['email'])) {
        throw new ValidationException("L'email est obligatoire", "email");
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException("L'email est invalide", "email");
    }

    // Mot de passe
    if (empty($data['password'])) {
        throw new ValidationException("Le mot de passe est obligatoire", "password");
    }

    if (strlen($data['password']) < 6) {
        throw new ValidationException("Le mot de passe doit faire au moins 6 caractères", "password");
    }
}

echo "<h2>Exercice 2 : Validation avec exceptions</h2>";

// Jeu de données de test (tu peux modifier pour tester différents cas)
$formData = [
    'pseudo'   => 'Di',
    'email'    => 'email_invalide',
    'password' => '123',
];

try {
    validerInscription($formData);
    echo "<p style='color: green;'>Inscription valide ✅</p>";
} catch (ValidationException $e) {
    echo "<p style='color: darkred;'>
            Erreur de validation sur le champ 
            <strong>{$e->getChamp()}</strong> : {$e->getMessage()}
          </p>";
}
