<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">

    <h1 class="mb-4">Suivi NeoNess de <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Âge :</strong> <?= (int) $user['age'] ?> ans</p>
            <p><strong>Poids actuel :</strong> <?= (float) $user['poids'] ?> kg</p>
            <p><strong>Taille :</strong> <?= (float) $user['taille'] ?> m</p>
            <p><strong>Objectif de poids :</strong> <?= (float) $user['objectif_poids'] ?> kg</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>IMC actuel :</strong> <?= $imc ?></p>
            <p>
                <strong>Interprétation :</strong>
                <?= htmlspecialchars($imcCategorie) ?>
                <small class="text-muted">(normal entre 18,5 et 25)</small>
            </p>
        </div>
    </div>

    <h2 class="mt-4">Activité du jour</h2>

    <form action="index.php?p=UserSuivi/suivi" method="post" class="card p-3 mb-4">
        <input type="hidden" name="form_type" value="activite">

        <div class="mb-3">
            <label for="sport_id" class="form-label">Sport</label>
            <select id="sport_id" name="sport_id" class="form-select" required>
                <option value="">-- Choisir un sport --</option>
                <option value="1">Vélo</option>
                <option value="2">Course</option>
                <option value="3">Haltères</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="duree_minutes" class="form-label">Durée (en minutes)</label>
            <input type="number" id="duree_minutes" name="duree_minutes" min="1" step="1" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter l’activité</button>
    </form>

    <?php
    $emojiParSport = [
        1 => '🚴‍♂️',
        2 => '🏃‍♂️',
        3 => '🏋️‍♂️',
    ];
    ?>
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

            <?php $totalCaloriesJour = 0; ?>
            <tbody>
                <?php foreach ($activitesJour as $act): ?>
                    <tr>
                        <?php
                        $idSport = (int) $act['sport_id'];
                        $nomSport = $sportName[$idSport] ?? 'Inconnu';

                        $caloriesHeure = $sportCalories[$idSport] ?? 0;
                        $dureeMinutes = (int) $act['duree_minutes'];
                        $calories = $caloriesHeure * ($dureeMinutes / 60);
                        $totalCaloriesJour += $calories;
                        ?>
                    <tr>
                        <td><?= htmlspecialchars($nomSport) ?></td>
                        <td><?= $dureeMinutes ?></td>
                        <td><?= round($calories) ?> kcal</td>
                        <td><?= htmlspecialchars($act['date_activite']) ?></td>
                    </tr>

                <?php endforeach; ?>
                <p>
                    <strong>Total calories dépensées aujourd'hui :
                        <?= round($totalCaloriesJour) ?> kcal
                    </strong>
                </p>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Aucune activité enregistrée pour aujourd'hui.</p>
    <?php endif; ?>

    <p class="mt-4">
        <a href="index.php" class="btn btn-secondary">Retour à l’accueil</a>
    </p>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>