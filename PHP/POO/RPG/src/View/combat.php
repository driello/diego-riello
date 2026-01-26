<!-- src/View/combat.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Combat RPG</title>
</head>

<body>
    <h1>Combat RPG</h1>

    <h2>Personnages</h2>
    <p>
        <strong>Héros :</strong>
        <?= htmlspecialchars($hero->getNom()) ?>
        (PV : <?= $hero->getPvMax() ?>)
    </p>
    <p>
        <strong>Ennemi :</strong>
        <?= htmlspecialchars($enemy->getNom()) ?>
        (PV : <?= $enemy->getPvActuels() ?>)
    </p>

    <h2>Journal de combat</h2>
    <ul>
        <?php foreach ($log as $ligne): ?>
            <li><?= htmlspecialchars($ligne) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Vainqueur</h2>
    <p>
        Le vainqueur est :
        <strong><?= htmlspecialchars($winner->getNom()) ?></strong>
        (PV restants : <?= $winner->getPvActuels() ?>)
    </p>
</body>

</html>