<?php
// src/View/show.php
// Variable attendue : $fiche (array|null)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche personnage</title>
</head>
<body>

    <h1>Fiche du personnage</h1>

    <?php if ($fiche === null): ?>
        <p>Aucun personnage trouvé en session.</p>
        <p><a href="index.php?action=create">Créer un personnage</a></p>
    <?php else: ?>
        <ul>
            <li><strong>Nom :</strong> <?= htmlspecialchars($fiche['nom'], ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Race :</strong> <?= htmlspecialchars($fiche['race_nom'], ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Niveau :</strong> <?= (int)$fiche['niveau'] ?></li>
            <li><strong>Expérience :</strong> <?= (int)$fiche['experience'] ?></li>
            <li><strong>PV :</strong> <?= (int)$fiche['pv_actuels'] ?> / <?= (int)$fiche['pv_max'] ?></li>
            <li><strong>Mana :</strong> <?= (int)$fiche['mana_actuels'] ?> / <?= (int)$fiche['mana_max'] ?></li>
            <li><strong>Arme :</strong> <?= htmlspecialchars($fiche['arme_nom'] ?? 'Aucune', ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Description de l’arme :</strong> <?= htmlspecialchars($fiche['arme_desc'] ?? '-', ENT_QUOTES, 'UTF-8') ?></li>
        </ul>

        <p><a href="index.php?action=create">Créer un nouveau personnage</a></p>
    <?php endif; ?>

</body>
</html>
