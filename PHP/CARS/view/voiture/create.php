<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Création d'une voiture</title>
    </head>
    <body>
        <form method="get" action="routeur.php">
            <fieldset>
                <legend>Créer une voiture :</legend>

                <!-- action du routeur -->
                <input type="hidden" name="action" value="created">

                <p>
                    <label for="immat_id">Immatriculation</label> :
                    <input type="text"
                           placeholder="Ex : AB123CD"
                           name="immatriculation"
                           id="immat_id"
                           required />
                </p>

                <p>
                    <label for="marque_id">Marque</label> :
                    <input type="text"
                           placeholder="Ex : Peugeot"
                           name="marque"
                           id="marque_id" />
                </p>

                <p>
                    <label for="couleur_id">Couleur</label> :
                    <input type="text"
                           placeholder="Ex : bleu"
                           name="couleur"
                           id="couleur_id" />
                </p>

                <p>
                    <input type="submit" value="Créer la voiture" />
                </p>
            </fieldset>
        </form>
    </body>
</html>
