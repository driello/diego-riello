<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Erreur création</title>
    </head>
    <body>
        <p>
            Erreur : l'immatriculation
            <?= htmlspecialchars($immat) ?>
            existe déjà en base, impossible de créer cette voiture.
        </p>

        <p>
            <a href="routeur.php?action=create">Retour au formulaire</a>
        </p>
    </body>
</html>
