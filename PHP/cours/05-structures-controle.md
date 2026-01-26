# Leçon 5 : Structures de contrôle

## 1. Introduction

Les **structures de contrôle** permettent de diriger l'exécution du code en fonction de conditions ou de répéter des instructions.

Types de structures :
- **Conditionnelles** : `if`, `else`, `elseif`, `switch`
- **Boucles** : `for`, `foreach`, `while`, `do-while`
- **Contrôle de boucle** : `break`, `continue`

## 2. Structure conditionnelle : `if`

### Syntaxe de base

```php
<?php
$age = 20;

if ($age >= 18) {
    echo "Vous êtes majeur";
}
```

### `if...else`

```php
<?php
$age = 15;

if ($age >= 18) {
    echo "Vous êtes majeur";
} else {
    echo "Vous êtes mineur";
}
```

### `if...elseif...else`

```php
<?php
$note = 14;

if ($note >= 16) {
    echo "Mention Très Bien";
} elseif ($note >= 14) {
    echo "Mention Bien";
} elseif ($note >= 12) {
    echo "Mention Assez Bien";
} elseif ($note >= 10) {
    echo "Admis";
} else {
    echo "Recalé";
}
```

### Conditions imbriquées

```php
<?php
$age = 25;
$permis = true;

if ($age >= 18) {
    if ($permis) {
        echo "Vous pouvez conduire";
    } else {
        echo "Vous devez passer le permis";
    }
} else {
    echo "Vous êtes trop jeune";
}
```

### Syntaxe alternative (pour templates)

```php
<?php if ($age >= 18): ?>
    <p>Contenu pour majeur</p>
<?php else: ?>
    <p>Contenu pour mineur</p>
<?php endif; ?>
```

## 3. Structure conditionnelle : `switch`

Utile pour comparer une variable à plusieurs valeurs possibles.

### Syntaxe

```php
<?php
$jour = "lundi";

switch ($jour) {
    case "lundi":
        echo "Début de semaine";
        break;
    case "mercredi":
        echo "Milieu de semaine";
        break;
    case "vendredi":
        echo "Bientôt le week-end !";
        break;
    case "samedi":
    case "dimanche":
        echo "Week-end !";
        break;
    default:
        echo "Jour ordinaire";
}
```

⚠️ **Important** : N'oubliez pas le `break` ! Sans lui, PHP continue d'exécuter les cases suivants (fall-through).

### Fall-through intentionnel

```php
<?php
$mois = 2;

switch ($mois) {
    case 12:
    case 1:
    case 2:
        echo "Hiver";
        break;
    case 3:
    case 4:
    case 5:
        echo "Printemps";
        break;
    case 6:
    case 7:
    case 8:
        echo "Été";
        break;
    case 9:
    case 10:
    case 11:
        echo "Automne";
        break;
    default:
        echo "Mois invalide";
}
```

### Syntaxe alternative

```php
<?php
switch ($jour):
    case "lundi":
        echo "Lundi";
        break;
    case "mardi":
        echo "Mardi";
        break;
    default:
        echo "Autre jour";
endswitch;
```

## 4. Boucle `for`

Utilisée quand on connaît à l'avance le nombre d'itérations.

### Syntaxe

```php
<?php
for ($i = 0; $i < 5; $i++) {
    echo "Itération $i<br>";
}
// Affiche : Itération 0, 1, 2, 3, 4
```

**Structure** :
- `$i = 0` : initialisation
- `$i < 5` : condition de continuation
- `$i++` : incrémentation

### Exemples

**Compter de 1 à 10** :
```php
<?php
for ($i = 1; $i <= 10; $i++) {
    echo "$i ";
}
// Affiche : 1 2 3 4 5 6 7 8 9 10
```

**Compter à rebours** :
```php
<?php
for ($i = 10; $i >= 1; $i--) {
    echo "$i ";
}
// Affiche : 10 9 8 7 6 5 4 3 2 1
```

**Incrémenter par 2** :
```php
<?php
for ($i = 0; $i <= 10; $i += 2) {
    echo "$i ";
}
// Affiche : 0 2 4 6 8 10
```

### Boucle infinie (à éviter !)

```php
<?php
// for (;;) {
//     echo "Boucle infinie !";
// }
```

## 5. Boucle `foreach`

Utilisée pour parcourir les tableaux.

### Parcourir un tableau indexé

```php
<?php
$fruits = ["pomme", "banane", "orange"];

foreach ($fruits as $fruit) {
    echo "$fruit<br>";
}
// Affiche :
// pomme
// banane
// orange
```

### Parcourir un tableau associatif

```php
<?php
$personne = [
    "nom" => "Dupont",
    "prenom" => "Alice",
    "age" => 30
];

foreach ($personne as $cle => $valeur) {
    echo "$cle : $valeur<br>";
}
// Affiche :
// nom : Dupont
// prenom : Alice
// age : 30
```

### Modifier les valeurs du tableau (par référence)

```php
<?php
$nombres = [1, 2, 3, 4, 5];

foreach ($nombres as &$nombre) {
    $nombre = $nombre * 2;
}
unset($nombre); // Important : détruire la référence

print_r($nombres); // [2, 4, 6, 8, 10]
```

⚠️ **Important** : Toujours faire `unset()` après une boucle avec référence pour éviter les bugs.

## 6. Boucle `while`

Exécute le code tant que la condition est vraie.

### Syntaxe

```php
<?php
$i = 0;

while ($i < 5) {
    echo "Itération $i<br>";
    $i++;
}
```

### Exemple : Lire un fichier ligne par ligne

```php
<?php
$fichier = fopen("data.txt", "r");

while (!feof($fichier)) {
    $ligne = fgets($fichier);
    echo $ligne . "<br>";
}

fclose($fichier);
```

### Attention à la boucle infinie

```php
<?php
// $i = 0;
// while ($i < 5) {
//     echo "Boucle infinie !"; // Oubli de l'incrémentation !
// }
```

## 7. Boucle `do...while`

Exécute le code **au moins une fois**, puis vérifie la condition.

### Syntaxe

```php
<?php
$i = 0;

do {
    echo "Itération $i<br>";
    $i++;
} while ($i < 5);
```

### Différence avec `while`

```php
<?php
// Avec while : ne s'exécute pas
$i = 10;
while ($i < 5) {
    echo "Jamais affiché";
}

// Avec do...while : s'exécute au moins une fois
$i = 10;
do {
    echo "Affiché une fois";
} while ($i < 5);
```

## 8. `break` : Sortir d'une boucle

```php
<?php
for ($i = 0; $i < 10; $i++) {
    if ($i == 5) {
        break; // Sort de la boucle
    }
    echo "$i ";
}
// Affiche : 0 1 2 3 4
```

### `break` avec niveau

```php
<?php
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        if ($j == 1) {
            break 2; // Sort des deux boucles
        }
        echo "($i, $j) ";
    }
}
// Affiche : (0, 0)
```

## 9. `continue` : Passer à l'itération suivante

```php
<?php
for ($i = 0; $i < 10; $i++) {
    if ($i % 2 == 0) {
        continue; // Passe à l'itération suivante
    }
    echo "$i "; // Affiche uniquement les impairs
}
// Affiche : 1 3 5 7 9
```

### `continue` avec niveau

```php
<?php
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        if ($j == 1) {
            continue 2; // Passe à l'itération suivante de la boucle externe
        }
        echo "($i, $j) ";
    }
}
// Affiche : (0, 0) (1, 0) (2, 0)
```

## 10. Exemple pratique : Table de multiplication

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Table de multiplication</title>
    <style>
        table { border-collapse: collapse; }
        td { border: 1px solid #ccc; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h1>Table de multiplication</h1>
    <table>
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <tr>
                <?php for ($j = 1; $j <= 10; $j++): ?>
                    <td><?= $i * $j ?></td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>
```

## 11. Exemple pratique : Menu de navigation

```php
<?php
$pages = [
    "accueil" => "Accueil",
    "services" => "Nos Services",
    "contact" => "Contact",
    "apropos" => "À propos"
];

$pageActuelle = "services";
?>

<nav>
    <ul>
        <?php foreach ($pages as $url => $titre): ?>
            <li>
                <a href="<?= $url ?>.php" 
                   class="<?= ($url === $pageActuelle) ? 'active' : '' ?>">
                    <?= $titre ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
```

## 12. Exercices pratiques

### Exercice 1 : Nombre pair ou impair

Écrivez un script qui vérifie si un nombre est pair ou impair avec `if/else`.

### Exercice 2 : Note et mention

Créez un script qui affiche la mention en fonction d'une note (avec `if/elseif/else`) :
- >= 16 : Très Bien
- >= 14 : Bien
- >= 12 : Assez Bien
- >= 10 : Passable
- < 10 : Insuffisant

### Exercice 3 : Afficher les nombres de 1 à 20

Utilisez une boucle `for`.

### Exercice 4 : Somme des nombres de 1 à 100

Calculez la somme avec une boucle.

### Exercice 5 : FizzBuzz

Affichez les nombres de 1 à 100 :
- Si divisible par 3 : "Fizz"
- Si divisible par 5 : "Buzz"
- Si divisible par 3 ET 5 : "FizzBuzz"
- Sinon : le nombre

### Exercice 6 : Table de multiplication

Affichez la table de multiplication de 7 (de 1 à 10).

### Exercice 7 : Tableau de fruits

Créez un tableau de fruits et affichez-les avec `foreach`.

## 13. Points clés à retenir

✅ **`if/elseif/else`** : Pour les conditions  
✅ **`switch`** : Pour comparer une variable à plusieurs valeurs (n'oubliez pas `break`)  
✅ **`for`** : Quand on connaît le nombre d'itérations  
✅ **`foreach`** : Pour parcourir les tableaux  
✅ **`while`** : Tant que la condition est vraie  
✅ **`do...while`** : Au moins une fois, puis tant que la condition est vraie  
✅ **`break`** : Sortir d'une boucle  
✅ **`continue`** : Passer à l'itération suivante  
✅ **Syntaxe alternative** : `:` et `endif`, `endfor`, `endforeach`, `endwhile` pour les templates

---

**Leçon précédente** : [Opérateurs et expressions](./04-operateurs-expressions.md)  
**Prochaine leçon** : [Fonctions](./06-fonctions.md)
