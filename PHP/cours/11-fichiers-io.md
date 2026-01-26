# Leçon 11 : Fichiers et entrée/sortie

## 1. Lire un fichier

### `file_get_contents()` : Lire tout le contenu

```php
<?php
$contenu = file_get_contents('fichier.txt');
echo $contenu;

// Gérer les erreurs
if ($contenu === false) {
    echo "Erreur lors de la lecture du fichier";
}
```

### `file()` : Lire ligne par ligne dans un tableau

```php
<?php
$lignes = file('fichier.txt');

foreach ($lignes as $numero => $ligne) {
    echo "Ligne $numero : $ligne<br>";
}

// Options
$lignes = file('fichier.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
```

### `fopen()`, `fgets()`, `fclose()` : Lecture avancée

```php
<?php
$fichier = fopen('fichier.txt', 'r');

if ($fichier) {
    while (($ligne = fgets($fichier)) !== false) {
        echo $ligne . "<br>";
    }
    fclose($fichier);
} else {
    echo "Impossible d'ouvrir le fichier";
}
```

### `fread()` : Lire un nombre spécifique d'octets

```php
<?php
$fichier = fopen('fichier.txt', 'r');
$contenu = fread($fichier, filesize('fichier.txt'));
fclose($fichier);

echo $contenu;
```

## 2. Écrire dans un fichier

### `file_put_contents()` : Écrire tout le contenu

```php
<?php
$contenu = "Bonjour le monde !";
file_put_contents('fichier.txt', $contenu);

// Ajouter (append) au lieu d'écraser
file_put_contents('fichier.txt', $contenu, FILE_APPEND);

// Gérer les erreurs
if (file_put_contents('fichier.txt', $contenu) === false) {
    echo "Erreur lors de l'écriture";
}
```

### `fopen()`, `fwrite()`, `fclose()` : Écriture avancée

```php
<?php
$fichier = fopen('fichier.txt', 'w'); // 'w' = écriture (écrase)

if ($fichier) {
    fwrite($fichier, "Première ligne\n");
    fwrite($fichier, "Deuxième ligne\n");
    fclose($fichier);
} else {
    echo "Impossible d'ouvrir le fichier";
}
```

### Modes d'ouverture

| Mode | Description |
|------|-------------|
| `r` | Lecture seule, pointeur au début |
| `r+` | Lecture/écriture, pointeur au début |
| `w` | Écriture seule, écrase le fichier, crée s'il n'existe pas |
| `w+` | Lecture/écriture, écrase le fichier |
| `a` | Écriture seule (append), pointeur à la fin |
| `a+` | Lecture/écriture (append), pointeur à la fin |
| `x` | Création seule, erreur si le fichier existe |
| `x+` | Création et lecture/écriture, erreur si existe |

## 3. Vérifier l'existence et les permissions

### `file_exists()` : Vérifier l'existence

```php
<?php
if (file_exists('fichier.txt')) {
    echo "Le fichier existe";
} else {
    echo "Le fichier n'existe pas";
}
```

### `is_file()` et `is_dir()` : Type

```php
<?php
if (is_file('fichier.txt')) {
    echo "C'est un fichier";
}

if (is_dir('dossier')) {
    echo "C'est un répertoire";
}
```

### `is_readable()`, `is_writable()` : Permissions

```php
<?php
if (is_readable('fichier.txt')) {
    echo "Le fichier est lisible";
}

if (is_writable('fichier.txt')) {
    echo "Le fichier est modifiable";
}
```

## 4. Informations sur un fichier

### `filesize()` : Taille en octets

```php
<?php
$taille = filesize('fichier.txt');
echo "Taille : $taille octets";

// Convertir en Ko, Mo
echo "Taille : " . round($taille / 1024, 2) . " Ko";
```

### `filemtime()` : Date de dernière modification

```php
<?php
$timestamp = filemtime('fichier.txt');
echo "Modifié le : " . date('Y-m-d H:i:s', $timestamp);
```

### `pathinfo()` : Informations sur le chemin

```php
<?php
$info = pathinfo('/chemin/vers/fichier.txt');

echo $info['dirname'];   // /chemin/vers
echo $info['basename'];  // fichier.txt
echo $info['extension']; // txt
echo $info['filename'];  // fichier
```

## 5. Copier, renommer, supprimer

### `copy()` : Copier

```php
<?php
if (copy('source.txt', 'copie.txt')) {
    echo "Fichier copié";
} else {
    echo "Erreur lors de la copie";
}
```

### `rename()` : Renommer ou déplacer

```php
<?php
// Renommer
rename('ancien.txt', 'nouveau.txt');

// Déplacer
rename('fichier.txt', 'dossier/fichier.txt');
```

### `unlink()` : Supprimer un fichier

```php
<?php
if (unlink('fichier.txt')) {
    echo "Fichier supprimé";
} else {
    echo "Erreur lors de la suppression";
}
```

## 6. Manipuler les répertoires

### `mkdir()` : Créer un répertoire

```php
<?php
if (mkdir('nouveau_dossier', 0755, true)) {
    echo "Répertoire créé";
}

// true = créer les répertoires parents si nécessaires
```

### `rmdir()` : Supprimer un répertoire vide

```php
<?php
if (rmdir('dossier')) {
    echo "Répertoire supprimé";
}
```

### `scandir()` : Lister le contenu

```php
<?php
$fichiers = scandir('.');

foreach ($fichiers as $fichier) {
    if ($fichier !== '.' && $fichier !== '..') {
        echo "$fichier<br>";
    }
}
```

### `glob()` : Rechercher avec motif

```php
<?php
// Tous les fichiers .txt
$fichiers = glob('*.txt');
print_r($fichiers);

// Tous les fichiers PHP dans un dossier
$fichiers = glob('src/*.php');

// Récursif avec ** (PHP 7.3+)
$fichiers = glob('**/*.php', GLOB_BRACE);
```

## 7. Upload de fichiers

### Formulaire HTML

```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Upload de fichier</title>
</head>
<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label>Sélectionnez un fichier :</label>
        <input type="file" name="fichier" required>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
```

⚠️ **Important** : `enctype="multipart/form-data"` est obligatoire !

### Traiter l'upload (upload.php)

```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier'])) {
    $fichier = $_FILES['fichier'];
    
    // Vérifier les erreurs
    if ($fichier['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors de l'upload");
    }
    
    // Informations sur le fichier
    $nom = $fichier['name'];           // Nom original
    $tmpName = $fichier['tmp_name'];   // Nom temporaire
    $taille = $fichier['size'];        // Taille en octets
    $type = $fichier['type'];          // Type MIME
    
    // Vérifier la taille (2 Mo max)
    if ($taille > 2 * 1024 * 1024) {
        die("Fichier trop volumineux");
    }
    
    // Vérifier le type
    $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    $extension = strtolower(pathinfo($nom, PATHINFO_EXTENSION));
    
    if (!in_array($extension, $extensionsAutorisees)) {
        die("Type de fichier non autorisé");
    }
    
    // Générer un nom unique
    $nouveauNom = uniqid() . '.' . $extension;
    $destination = 'uploads/' . $nouveauNom;
    
    // Créer le dossier s'il n'existe pas
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }
    
    // Déplacer le fichier
    if (move_uploaded_file($tmpName, $destination)) {
        echo "Fichier uploadé avec succès : $nouveauNom";
    } else {
        echo "Erreur lors du déplacement du fichier";
    }
}
?>
```

### Upload multiple

```html
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="fichiers[]" multiple required>
    <button type="submit">Envoyer</button>
</form>
```

```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichiers'])) {
    $fichiers = $_FILES['fichiers'];
    
    $nbFichiers = count($fichiers['name']);
    
    for ($i = 0; $i < $nbFichiers; $i++) {
        if ($fichiers['error'][$i] === UPLOAD_ERR_OK) {
            $nom = $fichiers['name'][$i];
            $tmpName = $fichiers['tmp_name'][$i];
            
            // Traiter chaque fichier...
            $extension = strtolower(pathinfo($nom, PATHINFO_EXTENSION));
            $nouveauNom = uniqid() . '.' . $extension;
            
            move_uploaded_file($tmpName, 'uploads/' . $nouveauNom);
            echo "Fichier $nom uploadé<br>";
        }
    }
}
?>
```

## 8. Lire et écrire du CSV

### Lire un fichier CSV

```php
<?php
$fichier = fopen('data.csv', 'r');

while (($ligne = fgetcsv($fichier, 1000, ',')) !== false) {
    echo "Nom : {$ligne[0]}, Âge : {$ligne[1]}<br>";
}

fclose($fichier);
```

### Écrire un fichier CSV

```php
<?php
$donnees = [
    ['Alice', 30, 'Paris'],
    ['Bob', 25, 'Lyon'],
    ['Charlie', 35, 'Marseille']
];

$fichier = fopen('export.csv', 'w');

// En-têtes
fputcsv($fichier, ['Nom', 'Âge', 'Ville']);

// Données
foreach ($donnees as $ligne) {
    fputcsv($fichier, $ligne);
}

fclose($fichier);
```

## 9. Lire et écrire du JSON

### Lire un fichier JSON

```php
<?php
$json = file_get_contents('data.json');
$donnees = json_decode($json, true); // true = tableau associatif

print_r($donnees);
```

### Écrire un fichier JSON

```php
<?php
$donnees = [
    'nom' => 'Alice',
    'age' => 30,
    'ville' => 'Paris'
];

$json = json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents('data.json', $json);
```

## 10. Exemple pratique : Livre d'or

```php
<?php
$fichier = 'livre_or.txt';

// Traiter le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (!empty($nom) && !empty($message)) {
        $date = date('Y-m-d H:i:s');
        $entree = "[$date] $nom : $message\n";
        
        file_put_contents($fichier, $entree, FILE_APPEND);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Afficher les messages
$messages = file_exists($fichier) ? file($fichier, FILE_IGNORE_NEW_LINES) : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
</head>
<body>
    <h1>Livre d'or</h1>
    
    <form method="POST">
        <label>Nom : <input type="text" name="nom" required></label><br>
        <label>Message : <textarea name="message" required></textarea></label><br>
        <button type="submit">Ajouter</button>
    </form>
    
    <h2>Messages</h2>
    <?php foreach (array_reverse($messages) as $message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endforeach; ?>
</body>
</html>
```

## 11. Sécurité

### Valider les noms de fichiers

```php
<?php
function nomFichierSecurise($nom) {
    // Supprimer les caractères dangereux
    $nom = preg_replace('/[^a-zA-Z0-9_.-]/', '', $nom);
    
    // Empêcher la traversée de répertoires
    $nom = basename($nom);
    
    return $nom;
}
```

### Vérifier le type MIME réel

```php
<?php
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $_FILES['fichier']['tmp_name']);
finfo_close($finfo);

$typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];

if (!in_array($mimeType, $typesAutorises)) {
    die("Type de fichier non autorisé");
}
```

## 12. Exercices pratiques

### Exercice 1 : Compteur de visites

Créez un compteur qui enregistre le nombre de visites dans un fichier.

### Exercice 2 : Système de logs

Créez une fonction qui enregistre les événements dans un fichier de logs avec date et heure.

### Exercice 3 : Gestionnaire de tâches

Créez un système pour ajouter, afficher et supprimer des tâches (stockées dans un fichier JSON).

### Exercice 4 : Galerie d'images

Créez un système d'upload d'images avec :
- Vérification du type (JPEG, PNG, GIF)
- Limite de taille (2 Mo max)
- Affichage des images uploadées

## 13. Points clés à retenir

✅ **Lecture** : `file_get_contents()`, `file()`, `fopen()`/`fgets()`  
✅ **Écriture** : `file_put_contents()`, `fopen()`/`fwrite()`  
✅ **Modes** : `r` (lecture), `w` (écriture/écrase), `a` (ajout)  
✅ **Vérifications** : `file_exists()`, `is_file()`, `is_readable()`, `is_writable()`  
✅ **Infos** : `filesize()`, `filemtime()`, `pathinfo()`  
✅ **Upload** : `$_FILES`, `move_uploaded_file()`, `enctype="multipart/form-data"`  
✅ **Sécurité** : Valider taille, type, nom de fichier ; utiliser `basename()`  
✅ **CSV** : `fgetcsv()`, `fputcsv()`  
✅ **JSON** : `json_decode()`, `json_encode()`

---

**Leçon précédente** : [Sessions et cookies](./10-sessions-cookies.md)  
**Prochaine leçon** : [Accès BD avec PDO](./12-pdo-bdd.md)
