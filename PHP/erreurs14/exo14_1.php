<?php
// Exercice 1 : Gestionnaire d'erreurs simple avec CSS

// 1. Fonction de gestion des erreurs
function monGestionnaireErreurs(int $niveau, string $message, string $fichier, int $ligne): bool
{
    // On peut mapper quelques niveaux pour afficher un libellé plus propre
    $types = [
        E_ERROR   => 'Erreur fatale',
        E_WARNING => 'Avertissement',
        E_NOTICE  => 'Notice',
    ];

    $type = $types[$niveau] ?? 'Erreur';

    echo "
        <div style=\"
            border: 2px solid #e74c3c;
            background: #fdecea;
            color: #c0392b;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-family: system-ui, sans-serif;
        \">
            <strong>{$type}</strong><br>
            Message : {$message}<br>
            Fichier : {$fichier}<br>
            Ligne : {$ligne}
        </div>
    ";

    // On peut aussi logger
    error_log("[{$type}] {$message} in {$fichier}:{$ligne}");

    // true = on indique à PHP de NE PAS utiliser son gestionnaire par défaut
    return true;
}

// 2. On enregistre le gestionnaire personnalisé
set_error_handler('monGestionnaireErreurs');

// 3. Petit test : utilisation d'une variable non définie
echo "<h2>Exercice 1 : Gestionnaire d'erreurs simple</h2>";
echo $variableInexistante; // Provoque un E_NOTICE géré par notre fonction
