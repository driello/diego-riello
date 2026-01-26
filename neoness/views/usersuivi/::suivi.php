<h1>Suivi NeoNess de <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h1>

<p><strong>Âge :</strong> <?= (int) $user['age'] ?> ans</p>
<p><strong>Poids actuel :</strong> <?= (float) $user['poids'] ?> kg</p>
<p><strong>Taille :</strong> <?= (float) $user['taille'] ?> m</p>
<p><strong>Objectif de poids :</strong> <?= (float) $user['objectif_poids'] ?> kg</p>

<hr>

<p><strong>IMC actuel :</strong> <?= $imc ?></p>
<p><strong>Interprétation :</strong>
    <?= htmlspecialchars($imcCategorie) ?> (normal entre 18,5 et 25)
</p>

<hr>

<h2>Activité du jour</h2>
<?php
$emojiParSport = [
    1 => '🚴‍♂️',
    2 => '🏃‍♂️',
    3 => '🏋️‍♂️',
];
?>

<form action="index.php?p=UserSuivi/suivi" method="post">
    <!-- pour distinguer ce formulaire côté PHP -->
    <input type="hidden" name="form_type" value="activite">

    <p>
        <label for="sport_id">Sport</label><br>
        <select id="sport_id" name="sport_id" required>
            <option value="">-- Choisir un sport --</option>
            <?php foreach ($sports as $sport): ?>
                <?php
                $idSport = (int) $sport['id'];
                $emoji = $emojiParSport[$idSport] ?? '';
                ?>
                <option value="<?= $idSport ?>">
                    <?= htmlspecialchars(trim($emoji . ' ' . $sport['nom'])) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="duree_minutes">Durée (en minutes)</label><br>
        <input type="number" id="duree_minutes" name="duree_minutes" min="1" step="1" required>
    </p>

    <p>
        <button type="submit">Ajouter l’activité</button>
    </p>
</form>

<?php if (!empty($activitesJour)): ?>
    <?php
    // construire un tableau id_sport => nom_sport
    $sportName = [];
    foreach ($sports as $sport) {
        $sportName[(int) $sport['id']] = $sport['nom'];
    }
    // construire un tableau id_sport => calories_heure
    $sportCalories = [];
    foreach ($sports as $sport) {
        $sportCalories[(int) $sport['id']] = (int) $sport['calories_heure'];
    }

    ?>

    <pre><?php var_dump($sportName); ?></pre>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Sport</th>
                <th>Durée (minutes)</th>
                <th>Calories dépensées</th>
                <th>Date</th>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($activitesJour as $act): ?>
                <tr>
                    <?php
                    $idSport = (int) $act['sport_id'];
                    $nomSport = $sportName[$idSport] ?? 'Inconnu';

                    $caloriesHeure = $sportCalories[$idSport] ?? 0;
                    $dureeMinutes = (int) $act['duree_minutes'];
                    $calories = $caloriesHeure * ($dureeMinutes / 60);
                    ?>
                <tr>
                    <td><?= htmlspecialchars($nomSport) ?></td>
                    <td><?= $dureeMinutes ?></td>
                    <td><?= round($calories) ?> kcal</td>
                    <td><?= htmlspecialchars($act['date_activite']) ?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune activité enregistrée pour aujourd'hui.</p>
<?php endif; ?>

<p style="margin-top: 2rem;">
    <a href="index.php">Retour à l’accueil</a>
</p>