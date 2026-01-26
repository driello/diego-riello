<?php
// src/View/personnage/create.php
// Variables attendues :
// - $errors (array)
// - $personnageCree (null | \Rpg\Model\Personnage)
// - $racesDisponibles (array)
// - $armesDisponibles (array)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un personnage</title>
</head>
<body>

    <h1>Créer un personnage</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($personnageCree instanceof \Rpg\Model\Personnage): ?>
        <div style="color: green;">
            Personnage <strong><?= htmlspecialchars($personnageCree->getNom(), ENT_QUOTES, 'UTF-8') ?></strong> créé avec succès.
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div>
            <label for="nom">Nom du personnage</label><br>
            <input
                type="text"
                id="nom"
                name="nom"
                value="<?= htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>

        <div>
            <label for="race">Race</label><br>
            <select id="race" name="race">
                <option value="">-- Choisir une race --</option>
                <?php foreach ($racesDisponibles as $key => $label): ?>
                    <option
                        value="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                        <?= (($_POST['race'] ?? '') === $key) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="arme">Arme</label><br>
            <select id="arme" name="arme">
                <option value="">-- Choisir une arme --</option>
                <?php foreach ($armesDisponibles as $key => $label): ?>
                    <option
                        value="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                        <?= (($_POST['arme'] ?? '') === $key) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Créer le personnage</button>
    </form>

</body>
</html>
