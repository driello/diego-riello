<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Liste des voitures</title>
</head>
<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<body>
    <?php
    foreach ($tab_v as $v) {
        $immat = htmlspecialchars($v->getImmatriculation());

        $urlImmat = 'routeur.php?action=read&immat=' . rawurlencode($v->getImmatriculation());
        $urlDelete = 'routeur.php?action=delete&immat=' . rawurlencode($v->getImmatriculation());

        echo '<p> Voiture d\'immatriculation 
                    <a href="' . $urlImmat . '">' . $immat . '</a>
                    (<a href="' . $urlDelete . '">supprimer</a>)
                  </p>';
    }
    ?>


</body>

</html>