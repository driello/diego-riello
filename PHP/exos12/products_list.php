<?php
// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'bdd_produits';
$username = 'root';
$password = '';

try {
    // Création de l'objet PDO pour se connecter à MySQL
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Configuration de PDO :
    // - lever des exceptions en cas d'erreur SQL
    // - récupérer les résultats sous forme de tableau associatif
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Variable pour afficher des messages d'erreur ou d'info dans la vue
    $message = '';
    // Contiendra les données du produit en cours de modification (pour pré-remplir le formulaire)
    $editProduct = null;

    // -------------------------------
    // RECHERCHE + PAGINATION
    // -------------------------------
    $search = trim($_GET['search'] ?? ''); // terme recherché
    $parPage = 10;                         // 10 produits par page (Exo 5)
    $page = max(1, (int) ($_GET['page'] ?? 1));


    // -------------------------------------------------
    // 1) SUPPRESSION (DELETE) : ?delete=ID dans l'URL
    // -------------------------------------------------
    if (isset($_GET['delete'])) {
        // On force l'ID en entier pour éviter les injections par l'URL
        $id = (int) $_GET['delete'];

        if ($id > 0) {
            // Requête préparée pour supprimer un produit par son ID
            $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
            $stmt->execute([$id]);
        }

        // PRG (Post/Redirect/Get) : on redirige pour éviter
        // que la suppression se relance si on recharge la page
        header('Location: products_list.php');
        exit;
    }

    // -------------------------------------------------
    // 2) TRAITEMENT FORMULAIRE (CREATE / UPDATE)
    // -------------------------------------------------
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Si "id" > 0 → on met à jour (UPDATE)
        // Si "id" vide ou 0 → on insère (INSERT)
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $nom = trim($_POST['nom'] ?? '');
        $prix = (float) ($_POST['prix'] ?? 0);
        $stock = (int) ($_POST['stock'] ?? 0);

        // Petite validation côté serveur
        if ($nom !== '' && $prix >= 0 && $stock >= 0) {

            if ($id > 0) {
                // ------- UPDATE : modification d'un produit existant -------
                $stmt = $pdo->prepare(
                    "UPDATE produits
                     SET nom = :nom, prix = :prix, stock = :stock
                     WHERE id = :id"
                );

                $stmt->execute([
                    ':nom' => $nom,
                    ':prix' => $prix,
                    ':stock' => $stock,
                    ':id' => $id,
                ]);
            } else {
                // ------- INSERT : ajout d'un nouveau produit -------
                $stmt = $pdo->prepare(
                    "INSERT INTO produits (nom, prix, stock)
                     VALUES (:nom, :prix, :stock)"
                );

                $stmt->execute([
                    ':nom' => $nom,
                    ':prix' => $prix,
                    ':stock' => $stock,
                ]);
            }

            // On redirige pour éviter les re-soumissions du formulaire
            header('Location: products_list.php');
            exit;

        } else {
            // Si la validation échoue, on garde un message d'erreur
            $message = "Merci de remplir correctement tous les champs.";

            // On stocke les valeurs pour les réafficher dans le formulaire
            $editProduct = [
                'id' => $id,
                'nom' => $nom,
                'prix' => $prix,
                'stock' => $stock,
            ];
        }
    }

    // -------------------------------------------------
    // 3) MODE ÉDITION (EDIT) : ?edit=ID dans l'URL
    // -------------------------------------------------
    // Si on arrive ici avec un paramètre edit, et qu'on n’a pas déjà
    // des valeurs en erreur dans $editProduct (cas précédent)
    if (isset($_GET['edit']) && $editProduct === null) {
        $id = (int) $_GET['edit'];

        if ($id > 0) {
            // On récupère le produit à modifier
            $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
            $stmt->execute([$id]);
            $editProduct = $stmt->fetch();

            // Si aucun produit trouvé pour cet ID
            if (!$editProduct) {
                $message = "Produit introuvable.";
            }
        }
    }

    // -------------------------------------------------
    // 4) LECTURE (READ) + RECHERCHE + PAGINATION
    // -------------------------------------------------

    // 4.1 Nombre total de produits (pour calculer le nombre de pages)
    if ($search !== '') {
        // On ne compte que les produits dont le nom matche la recherche
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM produits WHERE nom LIKE :search");
        $stmt->execute([':search' => "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT COUNT(*) FROM produits");
    }

    $total = (int) $stmt->fetchColumn();
    $nbPages = max(1, (int) ceil($total / $parPage));

    // On évite d'avoir une page > nbPages
    if ($page > $nbPages) {
        $page = $nbPages;
    }

    $offset = ($page - 1) * $parPage;

    // 4.2 Récupération des produits de la page courante
    if ($search !== '') {
        $stmt = $pdo->prepare(
            "SELECT * FROM produits
             WHERE nom LIKE :search
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare(
            "SELECT * FROM produits
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );
    }

    $stmt->bindValue(':limit', $parPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $produits = $stmt->fetchAll();

    $stmt->execute();
    $produits = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
    <meta charset="UTF-8">
    <title>Gestion des produits</title>
        </head>

    <body>
    <h1>Gestion des produits (PDO)</h1>

    <!--
        Formulaire unique :
        - Si $editProduct est null → mode ajout (CREATE)
        - Si $editProduct contient un produit → mode édition (UPDATE)
    -->
    <h2><?= $editProduct ? 'Modifier un produit' : 'Ajouter un produit' ?></h2>

    <?php if (!empty($message)): ?>
        <!-- Affichage des messages d'erreur/info -->
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <!-- Champ caché pour savoir si on met à jour ou si on insère -->
        <input type="hidden" name="id" value="<?= $editProduct['id'] ?? '' ?>">

        <label>
            Nom :
            <!-- On pré-remplit le champ si on est en mode édition -->
            <input type="text" name="nom" value="<?= htmlspecialchars($editProduct['nom'] ?? '') ?>" required>
        </label><br><br>

        <label>
            Prix :
            <input type="number" name="prix" step="0.01" min="0" value="<?= $editProduct['prix'] ?? '' ?>" required>
        </label><br><br>

        <label>
            Stock :
            <input type="number" name="stock" min="0" value="<?= $editProduct['stock'] ?? '' ?>" required>
        </label><br><br>

        <!-- Libellé du bouton change selon le mode -->
        <button type="submit">
            <?= $editProduct ? 'Mettre à jour' : 'Ajouter' ?>
        </button>

        <?php if ($editProduct): ?>
            <!-- Lien pour quitter le mode édition et revenir en mode ajout -->
            <a href="products_list.php">Annuler la modification</a>
        <?php endif; ?>
    </form>

    <hr>
    
    <!-- Formulaire de recherche (GET) -->
    <form method="get" style="margin-bottom: 1rem;" >
        <label>
            Rechercher par nom :
            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search ?? '') ?>"
            >
        </label>
        <button type="submit">Rechercher</button>

        <?php if (!empty($search)): ?>
            <!-- Lien pour réinitialiser la recherche -->
            <a href="products_list.php">Réinitialiser</a>
        <?php endif; ?>
    </form>

    <!-- Affichage de la liste des produits -->
    <h2>Liste des produits</h2>

    <?php if (empty($produits)): ?>
        <p>Aucun produit en base.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Actions</th> <!-- Modifier / Supprimer -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= $produit['id'] ?></td>
                        <td><?= htmlspecialchars($produit['nom']) ?></td>
                        <td><?= $produit['prix'] ?> €</td>
                        <td><?= $produit['stock'] ?></td>
                        <td>
                            <!-- Lien pour passer en mode édition sur ce produit -->
                            <a href="products_list.php?edit=<?= $produit['id'] ?>">Modifier</a>
                            |
                            <!-- Lien pour supprimer le produit (avec confirmation JS) -->
                            <a href="products_list.php?delete=<?= $produit['id'] ?>"
                                onclick="return confirm('Supprimer ce produit ?');">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                <!-- Pagination -->
        <?php if ($nbPages > 1): ?>
            <nav style="margin-top: 1rem;">
                <?php for ($i = 1; $i <= $nbPages; $i++): ?>
                    <?php if ($i === $page): ?>
                        <strong>[<?= $i ?>]</strong>
                    <?php else: ?>
                        <a href="?page=<?= $i ?><?= $search !== '' ? '&search=' . urlencode($search) : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endif; ?>
                    &nbsp;
                <?php endfor; ?>
            </nav>
        <?php endif; ?>

    <?php endif; ?>
 </body>

</html>