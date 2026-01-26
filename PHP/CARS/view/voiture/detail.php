<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Détail d'une voiture</title>
    </head>
    <style>
        .detail{
            display: block;
            
        }
    </style>
    <body>
        <p class="detail">
            Voiture d'immatriculation 
            <?= htmlspecialchars($v->getImmatriculation()) ?>
            de marque 
            <?= htmlspecialchars($v->getMarque()) ?>
            et de couleur 
            <?= htmlspecialchars($v->getCouleur()) ?>.
        </p>
    </body>
</html>
