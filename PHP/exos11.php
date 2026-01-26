<?php
// -------------------------
// Exercice 1 - Enregitrer le nombre de visiteurs
// -------------------------

$fichier = 'visites.txt';

// 1. Si le fichier n'existe pas encore, on le crée avec 0
if (!file_exists($fichier)) {
    file_put_contents($fichier, '0');
}

// 2. On lit le contenu du fichier
$contenu = file_get_contents($fichier);

// Sécurité : si la lecture échoue, on part de 0
if ($contenu === false) {
    $compteur = 0;
} else {
    $compteur = (int) $contenu;
}

// 3. On incrémente le compteur
$compteur++;

// 4. On réécrit la nouvelle valeur dans le fichier
file_put_contents($fichier, (string) $compteur);

?>
<?php
// -------------------------
// Exercice 2 - Système de logs
// -------------------------

function writeLog(string $message): void  //la fonction ne renvoie rien (pas de return utile).
{
    $fichierLog = 'app.log';
    $date = date('Y-m-d H:i:s');

    $ligne = "[$date] $message" . PHP_EOL;  // PHP_EOL renvoi a la ligne

    file_put_contents($fichierLog, $ligne, FILE_APPEND | LOCK_EX);
}

// exemples d'événements
writeLog('Page visitée');
writeLog('Utilisateur invité a consulté la page');

// -------------------------
// Exercice 3 - Gestionnaire de tâches (JSON)
// -------------------------

// 1) Chemin vers le fichier JSON qui stocke les tâches
// __DIR__ = dossier où se trouve ce fichier PHP
$tasksfile = __DIR__ . '/tasks.json';

// 2) Si le fichier n'existe pas, on le crée avec un tableau vide []
if (!file_exists($tasksfile)) {
    file_put_contents($tasksfile, json_encode([]));
}

// 3) On lit le contenu du fichier JSON (texte brut)
$json = file_get_contents($tasksfile);

// 4) On transforme le JSON en tableau PHP (true = tableau associatif)
$tasks = json_decode($json, true);

// Si le décodage échoue ou ne renvoie pas un tableau, on repart de zéro
if (!is_array($tasks)) {
    $tasks = [];
}

// -------------------------
// Ajout d'une nouvelle tâche
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
    // On récupère le titre de la tâche depuis le formulaire
    $title = trim($_POST['new_task']); // trim => supprime les espaces inutiles

    // On n'ajoute pas de tâche vide
    if ($title !== '') {
        // On pousse une nouvelle tâche dans le tableau
        $tasks[] = [
            'id' => uniqid(), // identifiant unique pour pouvoir la supprimer
            'title' => $title,   // texte de la tâche
        ];

        // On réécrit tout le tableau dans le fichier JSON
        file_put_contents(
            $tasksfile,
            json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}

// -------------------------
// Suppression d'une tâche
// -------------------------
if (isset($_GET['delete_task'])) {
    $id = $_GET['delete_task'];  // Identifiant de la tâche à supprimer

    // On filtre le tableau pour garder toutes les tâches SAUF celle dont l'id correspond
    $tasks = array_values(array_filter(
        $tasks,
        function ($task) use ($id) {
            return $task['id'] !== $id;
        }
    ));

    // On sauvegarde le nouveau tableau dans le fichier JSON
    file_put_contents(
        $tasksfile,
        json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}
?>
<?php
// ------------------------------
// Exercice 4 - Galerie d'images
// ------------------------------
// 1) Dossier ou on stocke les images à uploader
$uploadDir = __DIR__ . '/uploads';

// 2) on crée le dossier si il n'existe pas
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Message pour l'utilisateur
$uploadMessage = '';

// 3) Traitement du formulaire upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = ($_FILES['image'] ?? '');

    // a) Vérifier si il y a une erreur d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadMessage = "Erreur lors de l'upload";
    }
    // b) Vérifier la taille (max 2 Mo)
    elseif ($file['size'] > 2 * 1024 * 1024) {
        $uploadMessage = "Fichier trop volumineux (Max 2 Mo)";
    } else {
        // Vérifier l'extension
        $allowedExt = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt, true)) {
            $uploadMessage = "Format non autorisé (jpeg, jpeg, png, gif, webp seulement)";
        } else {
            // Génerer un nom unique et déplacer le fichier
            $newName = uniqid('img_', true) . '.' . $ext;
            $destPath = $uploadDir . '/' . $newName;

            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                $uploadMessage = "Image uploadée avec succès ✅";
            } else {
                $uploadMessage = "Erreur lors du téléchargement du fichier.";
            }

        }
    }
}

// 4) Récupérer la liste de images pour la gallerie
$images = [];
if (is_dir($uploadDir)) {
    // glob() sert à lister des fichiers qui correspondent à un motif.
    // GLOB_BRACE dit à glob() : “interprète les accolades {} comme une liste d’options”
    $images = glob($uploadDir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
}

// Vider la gallerie ou supprimer une image


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    h2 {
        background: blueviolet;
        color: whitesmoke;
    }

    .md-viewer {
        background: #0f172a;
        /* fond sombre type "editor" */
        color: #e5e7eb;
        /* texte gris clair */
        padding: 1.5rem;
        border-radius: 0.75rem;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-size: 0.95rem;
        line-height: 1.5;
        white-space: pre-wrap;
        /* les lignes longues reviennent à la ligne */
        border: 1px solid #1f2937;
    }
</style>

<body>
    <header>
        <a href="./exos10.php" <?= $page ?>&cat=<?= $categorie ?>>
            ⬅️ Sessions - Cookies
        </a><?= "-----PHP-----" ?>
        <a href="./exos12.php" <?= $page ?>&cat=<?= $categorie ?>>
            Accès aux bases de données avec PDO ➡️
        </a><br>
    </header>
    <h1>Fichiers et entrée/sortie</h1>
    <h2>Exercice 1 - Compteur de visites - enregistrement fichier</h2>

    <p>Cette page a été visitée <strong><?= $compteur ?></strong> fois.</p>
    <br>
    <h2>Exercie 2 - Système de logs</h2>
    <p>Deux lignes ont été ajoutées dans <code>app.log</code>.</p>

    <hr>
    <h2>Exercice 3 – Gestionnaire de tâches (JSON)</h2>

    <!-- Formulaire pour ajouter une nouvelle tâche -->
    <form method="post">
        <label>
            Nouvelle tâche :
            <input type="text" name="new_task" required>
        </label>
        <button type="submit">Ajouter</button>
    </form>

    <h3>Liste des tâches</h3>

    <?php if (empty($tasks)): ?>
        <p>Aucune tâche pour le moment.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?= htmlspecialchars($task['title']) ?>
                    <!-- Lien pour supprimer cette tâche -->
                    <a href="?delete_task=<?= urlencode($task['id']) ?>">[supprimer]</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>
    <h2>Exercice 4 – Galerie d'images (upload)</h2>

    <!-- Message après Upload --->
    <?php if (!empty($uploadMessage)): ?>
    <p>
        <?= htmlspecialchars($uploadMessage) ?>
    </p>
    <?php endif ?>

    <!-- Formulaire d'upload --->

    <form method="post" enctype="multipart/form-data">. <!-- // enctype="multipart/form-data == obligatoire pour uploader -->
        <label>
            Choisir une image (jpg, jpeg, png, gif, webp, max 2 Mo) :
            <input type="file" name="image" accept=".jpg, .jpeg, .png, .gif, .webp" required>
        </label>
        <button type="submit">Uploader</button>
    </form>

    <h3>Galerie d'images</h3>

    <?php if(empty($images)): ?>
        <p>Aucune image pour le moment.</p>
        <?php else: ?>
            <div style="display:flex; flex-wrap: wrap; gap: 1rem; margin-top: 1rem;">
                <?php foreach ($images as $image): ?>
                    <?php $fileName = basename($image); ?> <!-- On transforme le chemin absolu $imagePath en juste le nom de fichier -->
                    <figure style="max-width:200px;">
                        <img src="uploads/<?= htmlspecialchars($fileName) ?>" alt="Image uploadée"
                        style="max: width 100%; height: auto; display: block;">
                    </figure>
                    <?php endforeach; ?>
            </div>
            <?php endif; ?>
  <button><a href="./index.php">INDEX</a></button>

    <pre class="md-viewer"><?php
    // On lit le fichier Markdown
    $content = file_get_contents('./cours/11-fichiers-io.md');

    // On l'affiche en échappant les balises PHP/HTML
    echo htmlspecialchars($content, ENT_QUOTES);
    ?></pre>
</body>

</html>