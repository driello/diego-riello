# Leçon 12 : Accès aux bases de données avec PDO

## 1. Introduction à PDO

**PDO** (PHP Data Objects) est une extension qui fournit une interface unifiée pour accéder à différentes bases de données (MySQL, PostgreSQL, SQLite, etc.).

**Avantages** :
- Portable entre différents SGBD
- Requêtes préparées (sécurité contre l'injection SQL)
- Gestion d'erreurs avec exceptions
- Plus moderne que `mysqli`

## 2. Se connecter à une base de données

### Connexion MySQL

```php
<?php
$host = 'localhost';
$dbname = 'ma_base';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Options recommandées
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    echo "Connexion réussie !";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
```

### Connexion SQLite

```php
<?php
try {
    $pdo = new PDO('sqlite:database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
```

### Options importantes

```php
<?php
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Exceptions en cas d'erreur
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Tableau associatif par défaut
    PDO::ATTR_EMULATE_PREPARES => false,                // Vraies requêtes préparées
];

$pdo = new PDO($dsn, $username, $password, $options);
```

## 3. Exécuter une requête simple

### `exec()` : Pour INSERT, UPDATE, DELETE

```php
<?php
// Retourne le nombre de lignes affectées
$nbLignes = $pdo->exec("DELETE FROM users WHERE age < 18");
echo "$nbLignes lignes supprimées";
```

### `query()` : Pour SELECT

```php
<?php
$stmt = $pdo->query("SELECT * FROM users");

while ($row = $stmt->fetch()) {
    echo $row['nom'] . " - " . $row['email'] . "<br>";
}
```

⚠️ **Attention** : N'utilisez jamais `query()` ou `exec()` avec des données utilisateur ! Risque d'injection SQL.

## 4. Requêtes préparées (sécurisées)

### Avec des marqueurs positionnels `?`

```php
<?php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND age > ?");
$stmt->execute(['alice@example.com', 18]);

while ($row = $stmt->fetch()) {
    echo $row['nom'] . "<br>";
}
```

### Avec des marqueurs nommés `:name`

```php
<?php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND age > :age");
$stmt->execute([
    ':email' => 'alice@example.com',
    ':age' => 18
]);

while ($row = $stmt->fetch()) {
    echo $row['nom'] . "<br>";
}
```

💡 **Recommandation** : Utilisez les marqueurs nommés pour plus de clarté.

## 5. Récupérer les résultats

### `fetch()` : Une ligne à la fois

```php
<?php
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([1]);

$user = $stmt->fetch();

if ($user) {
    echo $user['nom'];
} else {
    echo "Utilisateur non trouvé";
}
```

### `fetchAll()` : Toutes les lignes

```php
<?php
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

foreach ($users as $user) {
    echo $user['nom'] . "<br>";
}
```

### `fetchColumn()` : Une seule colonne

```php
<?php
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$nbUsers = $stmt->fetchColumn();
echo "Nombre d'utilisateurs : $nbUsers";
```

### Modes de récupération

```php
<?php
// Tableau associatif (par défaut)
$stmt->fetch(PDO::FETCH_ASSOC);

// Tableau indexé
$stmt->fetch(PDO::FETCH_NUM);

// Les deux
$stmt->fetch(PDO::FETCH_BOTH);

// Objet stdClass
$user = $stmt->fetch(PDO::FETCH_OBJ);
echo $user->nom;

// Objet d'une classe spécifique
$stmt->fetchObject('User');
```

## 6. Insertion de données

### INSERT simple

```php
<?php
$stmt = $pdo->prepare("INSERT INTO users (nom, email, age) VALUES (:nom, :email, :age)");

$stmt->execute([
    ':nom' => 'Alice',
    ':email' => 'alice@example.com',
    ':age' => 30
]);

echo "Utilisateur créé avec l'ID : " . $pdo->lastInsertId();
```

### INSERT multiple

```php
<?php
$stmt = $pdo->prepare("INSERT INTO users (nom, email, age) VALUES (?, ?, ?)");

$users = [
    ['Alice', 'alice@example.com', 30],
    ['Bob', 'bob@example.com', 25],
    ['Charlie', 'charlie@example.com', 35]
];

foreach ($users as $user) {
    $stmt->execute($user);
}

echo count($users) . " utilisateurs créés";
```

## 7. Mise à jour de données

### UPDATE

```php
<?php
$stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");

$stmt->execute([
    ':email' => 'newemail@example.com',
    ':id' => 1
]);

echo $stmt->rowCount() . " ligne(s) mise(s) à jour";
```

## 8. Suppression de données

### DELETE

```php
<?php
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([5]);

echo $stmt->rowCount() . " ligne(s) supprimée(s)";
```

## 9. Transactions

Les **transactions** permettent de regrouper plusieurs requêtes : soit toutes réussissent, soit toutes échouent.

```php
<?php
try {
    $pdo->beginTransaction();
    
    // Débiter le compte A
    $stmt = $pdo->prepare("UPDATE comptes SET solde = solde - ? WHERE id = ?");
    $stmt->execute([100, 1]);
    
    // Créditer le compte B
    $stmt = $pdo->prepare("UPDATE comptes SET solde = solde + ? WHERE id = ?");
    $stmt->execute([100, 2]);
    
    $pdo->commit();
    echo "Transaction réussie";
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Transaction annulée : " . $e->getMessage();
}
```

## 10. Prévenir l'injection SQL

### ❌ Mauvaise pratique (DANGEREUX !)

```php
<?php
// NE JAMAIS FAIRE ÇA !
$email = $_POST['email'];
$sql = "SELECT * FROM users WHERE email = '$email'";
$stmt = $pdo->query($sql);
// Un attaquant peut injecter : ' OR '1'='1
```

### ✅ Bonne pratique (SÉCURISÉ)

```php
<?php
$email = $_POST['email'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
```

Les requêtes préparées **séparent** la requête SQL des données, empêchant l'injection.

## 11. Exemple pratique : CRUD complet

### Créer la table

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Configuration de la connexion

**config/database.php**
```php
<?php
function getDB() {
    static $pdo = null;
    
    if ($pdo === null) {
        $host = 'localhost';
        $dbname = 'ma_base';
        $username = 'root';
        $password = '';
        
        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
    
    return $pdo;
}
```

### Créer (Create)

```php
<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $age = (int) $_POST['age'];
    
    $pdo = getDB();
    $stmt = $pdo->prepare("INSERT INTO users (nom, email, age) VALUES (?, ?, ?)");
    
    try {
        $stmt->execute([$nom, $email, $age]);
        echo "Utilisateur créé avec succès !";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<form method="POST">
    <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="number" name="age" placeholder="Âge"><br>
    <button type="submit">Créer</button>
</form>
```

### Lire (Read)

```php
<?php
require_once 'config/database.php';

$pdo = getDB();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Âge</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['nom']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['age'] ?></td>
            <td>
                <a href="edit.php?id=<?= $user['id'] ?>">Modifier</a>
                <a href="delete.php?id=<?= $user['id'] ?>">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
```

### Mettre à jour (Update)

```php
<?php
require_once 'config/database.php';

$pdo = getDB();
$id = (int) $_GET['id'];

// Récupérer l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("Utilisateur non trouvé");
}

// Traiter le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $age = (int) $_POST['age'];
    
    $stmt = $pdo->prepare("UPDATE users SET nom = ?, email = ?, age = ? WHERE id = ?");
    $stmt->execute([$nom, $email, $age, $id]);
    
    header('Location: list.php');
    exit;
}
?>

<form method="POST">
    <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
    <input type="number" name="age" value="<?= $user['age'] ?>"><br>
    <button type="submit">Mettre à jour</button>
</form>
```

### Supprimer (Delete)

```php
<?php
require_once 'config/database.php';

$pdo = getDB();
$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header('Location: list.php');
exit;
```

## 12. Recherche et pagination

### Recherche

```php
<?php
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE nom LIKE ? OR email LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM users");
}

$users = $stmt->fetchAll();
```

### Pagination

```php
<?php
$parPage = 10;
$page = (int) ($_GET['page'] ?? 1);
$offset = ($page - 1) * $parPage;

// Nombre total d'utilisateurs
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total = $stmt->fetchColumn();
$nbPages = ceil($total / $parPage);

// Récupérer la page actuelle
$stmt = $pdo->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $parPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

// Afficher les liens de pagination
for ($i = 1; $i <= $nbPages; $i++) {
    echo "<a href='?page=$i'>$i</a> ";
}
```

## 13. Exercices pratiques

### Exercice 1 : Connexion

Créez un fichier de configuration pour la connexion PDO.

### Exercice 2 : Afficher des articles

Créez une table `articles` et affichez tous les articles.

### Exercice 3 : CRUD complet

Créez un système CRUD pour gérer des produits (nom, prix, stock).

### Exercice 4 : Recherche

Ajoutez une barre de recherche pour filtrer les produits par nom.

### Exercice 5 : Pagination

Implémentez un système de pagination (10 produits par page).

## 14. Points clés à retenir

✅ **PDO** : Interface unifiée pour accéder aux bases de données  
✅ **Connexion** : `new PDO($dsn, $user, $pass, $options)`  
✅ **Options** : `ERRMODE_EXCEPTION`, `FETCH_ASSOC`, `EMULATE_PREPARES = false`  
✅ **Requêtes préparées** : `prepare()` + `execute()` (sécurité contre l'injection SQL)  
✅ **Marqueurs** : `?` (positionnels) ou `:name` (nommés)  
✅ **Récupération** : `fetch()`, `fetchAll()`, `fetchColumn()`  
✅ **Transactions** : `beginTransaction()`, `commit()`, `rollBack()`  
✅ **Sécurité** : TOUJOURS utiliser des requêtes préparées avec des données utilisateur  
✅ **Dernière ID** : `lastInsertId()` après un INSERT  
✅ **Lignes affectées** : `rowCount()` après UPDATE/DELETE

---

**Leçon précédente** : [Fichiers et entrée/sortie](./11-fichiers-io.md)  
**Prochaine leçon** : [POO (bases)](./13-poo-bases.md)
