<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>


    <h2>Bienvenue</h2>


    <?php if (!empty($erreurs)): ?>
        <div style="color: red; margin-bottom: 1rem;">
            <ul>
                <?php foreach ($erreurs as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <div style="color: green; margin-bottom: 1rem;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>



    <section class="container mt-2" style="margin-bottom: 2rem;">
        <div class="row">


            <div class="col-md-6 col-12 mt-5 justify-content-center">

                <div class="imc">
                    <h3>Calculer votre IMC</h3>

                    <form action="index.php" method="post">
                        <input type="hidden" name="form_type" value="imc_calc">

                        <input type="number" id="imc_poids" name="imc_poids" step="0.1" min="1" required
                            placeholder="Poids (kg)">

                        <input type="number" id="imc_taille" name="imc_taille" step="0.01" min="0.5" required
                            placeholder="Taille (m)">

                        <button type="submit">Calculer votre IMC</button>
                    </form>

                    <?php if (!is_null($imcLibre)): ?>
                        <p>
                            Votre IMC est de : <strong><?= htmlspecialchars($imcLibre) ?></strong><br>
                            Résultat : <?= htmlspecialchars($imcLibreCategorie) ?>
                        </p>
                    <?php endif; ?><br>
                   


                </div>
                <div class="login">
                    <h3>Déjà inscrit ?</h3>
                    <form method="post" action="">
                        <input type="hidden" name="form_type" value="login">

                        <p>
                            <input type="text" name="tel" required placeholder="Téléphone (identifiant) *">
                        </p>

                        <p>
                            <input type="password" name="password" required placeholder="Mot de passe *">
                        </p>

                        <p>
                            <button type="submit">Se connecter</button>
                        </p>
                    </form>
                </div>


            </div>



            <div class="col-md-6 col-12">
                <h3>Première inscription</h3>
                <form method="post" action="">
                    <input type="hidden" name="form_type" value="register">

                    <p>
                        <input type="text" name="nom" required placeholder="Nom *">
                    </p>

                    <p>
                        <input type="text" name="prenom" required placeholder="Prénom *">
                    </p>

                    <p>
                        <input type="text" name="tel" required placeholder="Téléphone (identifiant) *">
                    </p>

                    <p>
                        <input type="number" name="age" min="1" required placeholder="Âge *">
                    </p>

                    <p>
                        <input type="number" step="0.1" name="poids" min="1" required placeholder="Poids (kg) *">
                    </p>

                    <p>
                        <input type="number" step="0.01" name="taille" min="0.5" required
                            placeholder="Taille (en mètres, ex : 1.75) *">
                    </p>

                    <p>
                        <input type="number" step="0.1" name="objectif_poids" placeholder="Objectif de poids (kg)">
                    </p>

                    <p>
                        <input type="password" name="password" required placeholder="Mot de passe *">
                    </p>

                    <p>
                        <button type="submit">S’inscrire</button>
                    </p>
                </form>

            </div>

        </div>

    </section>

</body>

</html>