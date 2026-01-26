<?php
// securite15/ex15_3.php
// Exercice 3 : Upload d'images sécurisé

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$messages = [];

// Dossier des uploads (dans securite15/uploads)
$uploadDir = __DIR__ . '/uploads';
$relativeUploadDir = 'securite15/uploads'; // juste pour l'affichage éventuel

// Création du dossier si besoin
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

// Protection basique du dossier (pas d’index)
$htaccessPath = $uploadDir . '/.htaccess';
if (!file_exists($htaccessPath)) {
    file_put_contents($htaccessPath, "Options -Indexes\n");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // 1. Erreur de l'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $messages[] = "Erreur lors de l'upload (code : {$file['error']}).";
    } else {

        // 2. Taille max 2 Mo
        $maxSize = 2 * 1024 * 1024; // 2 Mo
        if ($file['size'] > $maxSize) {
            $messages[] = "Fichier trop volumineux (max 2 Mo).";
        }

        // 3. Type MIME réel
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mimeType, $allowedMimes, true)) {
            $messages[] = "Type de fichier non autorisé ({$mimeType}).";
        }

        // 4. Extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowedExt, true)) {
            $messages[] = "Extension non autorisée ({$extension}).";
        }

        // 5. Si tout est OK, on déplace le fichier
        if (empty($messages)) {
            $newName = bin2hex(random_bytes(16)) . '.' . $extension;
            $destination = $uploadDir . '/' . $newName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $messages[] = "Fichier uploadé avec succès ✅ : " . e($newName);
            } else {
                $messages[] = "Erreur lors du déplacement du fichier.";
            }
        }
    }
}
?>

<h2>Exercice 3 : Upload d'images sécurisé</h2>

<?php if (!empty($messages)): ?>
    <div style="border:1px solid #333; padding:10px; margin-bottom:10px;">
        <ul>
            <?php foreach ($messages as $msg): ?>
                <li><?= e($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="" enctype="multipart/form-data">
    <div>
        <label for="image">Choisir une image (JPG, PNG, GIF, 2 Mo max) :</label><br>
        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif" required>
    </div>

    <button type="submit" style="margin-top:10px;">Uploader</button>
</form>

<p style="margin-top:10px;">
    Les fichiers sont stockés dans : <code><?= e($relativeUploadDir) ?></code>
</p>
