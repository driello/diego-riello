# Leçon 2 : Syntaxe de base

## 1. Les balises PHP

PHP s'insère dans un fichier (HTML ou pur PHP) à l'aide de balises spéciales :

### Balises standards (recommandées)

```php
<?php
// Votre code PHP ici
?>
```

### Short echo (pour afficher rapidement une variable)

```php
<?= $variable ?>
<!-- Équivalent à : <?php echo $variable; ?> -->
```

⚠️ **Important** :
- Si le fichier ne contient **que du PHP** (pas de HTML), omettez la balise fermante `?>` pour éviter les espaces/retours à la ligne parasites.
- Les balises courtes `<? ... ?>` sont déconseillées (peuvent ne pas être activées partout).

## 2. Premier script : Hello World

Créez un fichier `hello.php` :

```php
<?php
echo "Hello, World!";
```

### Exécution dans le terminal

```bash
php hello.php
```

**Sortie** :
```
Hello, World!
```

### Via le serveur intégré

Dans le dossier contenant `hello.php` :

```bash
php -S localhost:8000
```

Puis ouvrez `http://localhost:8000/hello.php` dans votre navigateur.

## 3. Mélanger PHP et HTML

PHP génère du HTML dynamiquement :

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma première page PHP</title>
</head>
<body>
    <h1><?php echo "Bienvenue sur mon site !"; ?></h1>
    <p>Aujourd'hui nous sommes le <?= date('d/m/Y'); ?></p>
</body>
</html>
```

**Explication** :
- Le code PHP est exécuté côté serveur.
- `date('d/m/Y')` affiche la date actuelle au format `jour/mois/année`.
- Le navigateur reçoit uniquement le HTML généré (pas le code PHP).

## 4. Les commentaires

### Commentaire sur une ligne

```php
<?php
// Ceci est un commentaire sur une ligne
echo "Hello"; // Commentaire en fin de ligne
```

### Commentaire sur plusieurs lignes

```php
<?php
/*
  Ceci est un commentaire
  sur plusieurs lignes
*/
echo "Bonjour";
```

### Commentaire de documentation (DocBlock)

```php
<?php
/**
 * Cette fonction calcule la somme de deux nombres.
 * 
 * @param int $a Premier nombre
 * @param int $b Deuxième nombre
 * @return int La somme
 */
function additionner($a, $b) {
    return $a + $b;
}
```

## 5. Instructions et points-virgules

Chaque instruction PHP se termine par un **point-virgule** `;` :

```php
<?php
echo "Ligne 1";
echo "Ligne 2";
$nombre = 42;
```

⚠️ **Oubli fréquent** : oublier le `;` provoque une erreur de syntaxe.

## 6. Affichage avec `echo` et `print`

### `echo` (le plus utilisé)

```php
<?php
echo "Bonjour";
echo "Bonjour", " ", "tout", " ", "le monde"; // Peut prendre plusieurs arguments
```

### `print` (similaire, mais retourne 1)

```php
<?php
print "Hello";
// print ne peut prendre qu'un seul argument
```

💡 **Différence** : `echo` est légèrement plus rapide et accepte plusieurs arguments. Utilisez `echo` par convention.

## 7. Concaténation de chaînes

L'opérateur de concaténation est le **point** `.` :

```php
<?php
$prenom = "Alice";
$nom = "Dupont";

// Concaténation
$nomComplet = $prenom . " " . $nom;
echo $nomComplet; // Affiche : Alice Dupont

// Concaténation avec echo
echo "Bonjour " . $prenom . " !"; // Affiche : Bonjour Alice !
```

## 8. Interpolation de variables dans les chaînes

### Avec des guillemets doubles

Avec les **guillemets doubles** `"..."`, PHP interpole les variables :

```php
<?php
$prenom = "Bob";
echo "Bonjour $prenom !"; // Affiche : Bonjour Bob !

// Accolades pour lever toute ambiguïté
$fruit = "pomme";
echo "J'adore les {$fruit}s"; // Affiche : J'adore les pommes
```

### Avec des guillemets simples

Avec les **guillemets simples** `'...'`, **pas d'interpolation** :

```php
<?php
$prenom = "Bob";
echo 'Bonjour $prenom !'; // Affiche littéralement : Bonjour $prenom !
```

💡 **Astuce** : Utilisez des guillemets simples pour les chaînes sans variables (légèrement plus rapide).

## 9. Exemple pratique : Page dynamique

Fichier `bienvenue.php` :

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
</head>
<body>
    <?php
    $nom = "Alice";
    $heure = date('H');
    
    // Salutation selon l'heure
    if ($heure < 12) {
        $salutation = "Bonjour";
    } elseif ($heure < 18) {
        $salutation = "Bon après-midi";
    } else {
        $salutation = "Bonsoir";
    }
    ?>
    
    <h1><?= $salutation ?>, <?= $nom ?> !</h1>
    <p>Il est actuellement <?= date('d,m,y,H,i') ?>.</p>
</body>
</html>
```

## 10. Exercices pratiques

### Exercice 1

Créez un fichier `info.php` qui affiche :
- Votre prénom
- Votre âge
- Une phrase de bienvenue (en utilisant la concaténation)

### Exercice 2

Créez une page HTML avec du PHP qui affiche :
- Un titre `<h1>` contenant "Bienvenue sur mon site"
- Un paragraphe `<p>` affichant la date et l'heure actuelles avec `date('d/m/Y H:i:s')`

### Exercice 3

Écrivez un script qui :
- Définit trois variables : `$ville`, `$pays`, `$population`
- Affiche une phrase complète en utilisant l'interpolation de variables

**Exemple de sortie** : "Paris est une ville de France avec une population de 2 millions d'habitants."

## 11. Points clés à retenir

✅ **Balises** : `<?php ... ?>` pour le code PHP, `<?= ... ?>` pour afficher rapidement.  
✅ **Commentaires** : `//` pour une ligne, `/* ... */` pour plusieurs lignes.  
✅ **Instructions** : Terminer chaque instruction par `;`.  
✅ **Affichage** : Privilégiez `echo`.  
✅ **Concaténation** : Utilisez le point `.` pour assembler des chaînes.  
✅ **Interpolation** : Guillemets doubles `"..."` interprètent les variables, pas les simples `'...'`.  
✅ **Mélange PHP/HTML** : PHP génère du HTML dynamiquement côté serveur.

---

**Leçon précédente** : [Introduction et Installation](./01-introduction-installation.md)  
**Prochaine leçon** : [Variables et types](./03-variables-types.md)
