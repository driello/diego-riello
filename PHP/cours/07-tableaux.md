# Leçon 7 : Tableaux

## 1. Qu'est-ce qu'un tableau ?

Un **tableau** (array) est une structure de données permettant de stocker plusieurs valeurs dans une seule variable.

Types de tableaux en PHP :
- **Tableaux indexés** : clés numériques (0, 1, 2...)
- **Tableaux associatifs** : clés textuelles (nom, age, ville...)
- **Tableaux multidimensionnels** : tableaux contenant des tableaux

## 2. Tableaux indexés

### Création

```php
<?php
// Syntaxe avec array()
$fruits = array("pomme", "banane", "orange");

// Syntaxe courte (recommandée depuis PHP 5.4)
$fruits = ["pomme", "banane", "orange"];
```

### Accès aux éléments

```php
<?php
$fruits = ["pomme", "banane", "orange"];

echo $fruits[0]; // pomme
echo $fruits[1]; // banane
echo $fruits[2]; // orange
```

Les index commencent à **0**.

### Modification

```php
<?php
$fruits = ["pomme", "banane", "orange"];

$fruits[1] = "fraise"; // Modifie "banane" en "fraise"
$fruits[] = "kiwi";    // Ajoute "kiwi" à la fin

print_r($fruits);
// Array ( [0] => pomme [1] => fraise [2] => orange [3] => kiwi )
```

## 3. Tableaux associatifs

Utilisent des **clés textuelles** au lieu de numériques.

### Création

```php
<?php
$personne = [
    "nom" => "Dupont",
    "prenom" => "Alice",
    "age" => 30,
    "ville" => "Paris"
];
```

### Accès aux éléments

```php
<?php
echo $personne["nom"];    // Dupont
echo $personne["prenom"]; // Alice
echo $personne["age"];    // 30
```

### Modification et ajout

```php
<?php
$personne["age"] = 31;           // Modifie l'âge
$personne["email"] = "a@b.com";  // Ajoute une nouvelle clé

print_r($personne);
```

## 4. Parcourir les tableaux

### Avec `foreach` (recommandé)

**Tableau indexé** :
```php
<?php
$fruits = ["pomme", "banane", "orange"];

foreach ($fruits as $fruit) {
    echo "$fruit<br>";
}
```

**Tableau associatif** :
```php
<?php
$personne = ["nom" => "Dupont", "prenom" => "Alice", "age" => 30];

foreach ($personne as $cle => $valeur) {
    echo "$cle : $valeur<br>";
}
// Affiche :
// nom : Dupont
// prenom : Alice
// age : 30
```

### Avec `for` (tableaux indexés uniquement)

```php
<?php
$fruits = ["pomme", "banane", "orange"];

for ($i = 0; $i < count($fruits); $i++) {
    echo $fruits[$i] . "<br>";
}
```

⚠️ **Performance** : Évitez `count()` dans la condition de boucle, stockez-le dans une variable.

```php
<?php
$total = count($fruits);
for ($i = 0; $i < $total; $i++) {
    echo $fruits[$i] . "<br>";
}
```

## 5. Fonctions utiles pour les tableaux

### `count()` : Nombre d'éléments

```php
<?php
$fruits = ["pomme", "banane", "orange"];
echo count($fruits); // 3
```

### `array_push()` : Ajouter à la fin

```php
<?php
$fruits = ["pomme", "banane"];
array_push($fruits, "orange", "kiwi");
print_r($fruits); // [pomme, banane, orange, kiwi]

// Ou plus simple :
$fruits[] = "mangue";
```

### `array_pop()` : Retirer le dernier élément

```php
<?php
$fruits = ["pomme", "banane", "orange"];
$dernier = array_pop($fruits);
echo $dernier; // orange
print_r($fruits); // [pomme, banane]
```

### `array_shift()` : Retirer le premier élément

```php
<?php
$fruits = ["pomme", "banane", "orange"];
$premier = array_shift($fruits);
echo $premier; // pomme
print_r($fruits); // [banane, orange]
```

### `array_unshift()` : Ajouter au début

```php
<?php
$fruits = ["banane", "orange"];
array_unshift($fruits, "pomme");
print_r($fruits); // [pomme, banane, orange]
```

### `in_array()` : Vérifier si un élément existe

```php
<?php
$fruits = ["pomme", "banane", "orange"];

if (in_array("banane", $fruits)) {
    echo "Banane trouvée !";
}
```

### `array_search()` : Trouver l'index d'un élément

```php
<?php
$fruits = ["pomme", "banane", "orange"];
$index = array_search("banane", $fruits);
echo $index; // 1
```

### `array_key_exists()` : Vérifier si une clé existe

```php
<?php
$personne = ["nom" => "Dupont", "age" => 30];

if (array_key_exists("nom", $personne)) {
    echo "La clé 'nom' existe";
}
```

### `array_keys()` et `array_values()`

```php
<?php
$personne = ["nom" => "Dupont", "prenom" => "Alice", "age" => 30];

$cles = array_keys($personne);
print_r($cles); // [nom, prenom, age]

$valeurs = array_values($personne);
print_r($valeurs); // [Dupont, Alice, 30]
```

### `array_merge()` : Fusionner des tableaux

```php
<?php
$arr1 = ["a", "b"];
$arr2 = ["c", "d"];
$resultat = array_merge($arr1, $arr2);
print_r($resultat); // [a, b, c, d]

// Pour les tableaux associatifs
$p1 = ["nom" => "Dupont", "age" => 30];
$p2 = ["ville" => "Paris", "age" => 31]; // age écrase
$resultat = array_merge($p1, $p2);
print_r($resultat); // [nom => Dupont, age => 31, ville => Paris]
```

### `sort()`, `rsort()`, `asort()`, `ksort()`

```php
<?php
// Tri croissant (réindexe les clés)
$nombres = [3, 1, 4, 1, 5];
sort($nombres);
print_r($nombres); // [1, 1, 3, 4, 5]

// Tri décroissant
rsort($nombres);
print_r($nombres); // [5, 4, 3, 1, 1]

// Tri associatif par valeur (conserve les clés)
$ages = ["Alice" => 30, "Bob" => 25, "Charlie" => 35];
asort($ages);
print_r($ages); // [Bob => 25, Alice => 30, Charlie => 35]

// Tri par clés
ksort($ages);
print_r($ages); // [Alice => 30, Bob => 25, Charlie => 35]
```

### `array_map()` : Transformer chaque élément

```php
<?php
$nombres = [1, 2, 3, 4, 5];

$doubles = array_map(function($n) {
    return $n * 2;
}, $nombres);

print_r($doubles); // [2, 4, 6, 8, 10]

// Ou avec arrow function (PHP 7.4+)
$doubles = array_map(fn($n) => $n * 2, $nombres);
```

### `array_filter()` : Filtrer les éléments

```php
<?php
$nombres = [1, 2, 3, 4, 5, 6];

$pairs = array_filter($nombres, function($n) {
    return $n % 2 == 0;
});

print_r($pairs); // [2, 4, 6]
```

### `array_reduce()` : Réduire à une seule valeur

```php
<?php
$nombres = [1, 2, 3, 4, 5];

$somme = array_reduce($nombres, function($carry, $item) {
    return $carry + $item;
}, 0);

echo $somme; // 15
```

## 6. Tableaux multidimensionnels

Tableaux contenant d'autres tableaux.

### Création

```php
<?php
$etudiants = [
    ["nom" => "Dupont", "age" => 20, "note" => 15],
    ["nom" => "Martin", "age" => 22, "note" => 17],
    ["nom" => "Bernard", "age" => 21, "note" => 14]
];
```

### Accès

```php
<?php
echo $etudiants[0]["nom"];  // Dupont
echo $etudiants[1]["age"];  // 22
echo $etudiants[2]["note"]; // 14
```

### Parcours

```php
<?php
foreach ($etudiants as $etudiant) {
    echo $etudiant["nom"] . " : " . $etudiant["note"] . "/20<br>";
}
// Affiche :
// Dupont : 15/20
// Martin : 17/20
// Bernard : 14/20
```

### Tableaux à trois dimensions

```php
<?php
$classes = [
    "Classe A" => [
        ["nom" => "Alice", "note" => 15],
        ["nom" => "Bob", "note" => 17]
    ],
    "Classe B" => [
        ["nom" => "Charlie", "note" => 14],
        ["nom" => "David", "note" => 16]
    ]
];

echo $classes["Classe A"][0]["nom"]; // Alice
```

## 7. Déstructuration de tableaux (PHP 7.1+)

```php
<?php
$personne = ["Alice", "Dupont", 30];

// Ancienne méthode avec list()
list($prenom, $nom, $age) = $personne;

// Nouvelle syntaxe (PHP 7.1+)
[$prenom, $nom, $age] = $personne;

echo "$prenom $nom, $age ans"; // Alice Dupont, 30 ans

// Avec clés
$personne = ["nom" => "Dupont", "prenom" => "Alice", "age" => 30];
["nom" => $n, "prenom" => $p] = $personne;
echo "$p $n"; // Alice Dupont
```

## 8. Opérateur spread (PHP 7.4+)

```php
<?php
$arr1 = [1, 2, 3];
$arr2 = [4, 5, 6];

$resultat = [...$arr1, ...$arr2];
print_r($resultat); // [1, 2, 3, 4, 5, 6]

// Avec des tableaux associatifs (PHP 8.1+)
$p1 = ["nom" => "Dupont"];
$p2 = ["prenom" => "Alice"];
$personne = [...$p1, ...$p2];
print_r($personne); // [nom => Dupont, prenom => Alice]
```

## 9. Exemple pratique : Liste de courses

```php
<?php
$courses = [
    ["nom" => "Pain", "quantite" => 1, "prix" => 1.20],
    ["nom" => "Lait", "quantite" => 2, "prix" => 0.90],
    ["nom" => "Fromage", "quantite" => 1, "prix" => 3.50],
    ["nom" => "Pommes", "quantite" => 3, "prix" => 0.80]
];

$total = 0;

echo "<h1>Liste de courses</h1>";
echo "<table border='1'>";
echo "<tr><th>Article</th><th>Quantité</th><th>Prix unitaire</th><th>Total</th></tr>";

foreach ($courses as $article) {
    $sousTotal = $article["quantite"] * $article["prix"];
    $total += $sousTotal;
    
    echo "<tr>";
    echo "<td>{$article['nom']}</td>";
    echo "<td>{$article['quantite']}</td>";
    echo "<td>{$article['prix']} €</td>";
    echo "<td>" . number_format($sousTotal, 2) . " €</td>";
    echo "</tr>";
}

echo "<tr><td colspan='3'><strong>TOTAL</strong></td>";
echo "<td><strong>" . number_format($total, 2) . " €</strong></td></tr>";
echo "</table>";
```

## 10. Exercices pratiques

### Exercice 1 : Créer et afficher un tableau

Créez un tableau de 5 couleurs et affichez-les avec `foreach`.

### Exercice 2 : Tableau associatif

Créez un tableau représentant une voiture (marque, modèle, année, couleur) et affichez toutes les informations.

### Exercice 3 : Moyenne

Créez un tableau de notes et calculez la moyenne.

### Exercice 4 : Recherche

Créez un tableau de prénoms et vérifiez si "Alice" est présent.

### Exercice 5 : Tri

Créez un tableau de nombres aléatoires et triez-le par ordre croissant.

### Exercice 6 : Tableau multidimensionnel

Créez un tableau de 3 produits (nom, prix, stock) et affichez-les dans un tableau HTML.

### Exercice 7 : Filtrage

Créez un tableau de nombres et ne gardez que les nombres supérieurs à 10.

## 11. Points clés à retenir

✅ **Indexés** : `$arr = [1, 2, 3];` (clés numériques)  
✅ **Associatifs** : `$arr = ["nom" => "Alice"];` (clés textuelles)  
✅ **Multidimensionnels** : Tableaux de tableaux  
✅ **Parcours** : `foreach` (recommandé) ou `for`  
✅ **Ajout** : `$arr[] = $valeur;` ou `array_push()`  
✅ **Suppression** : `array_pop()`, `array_shift()`, `unset()`  
✅ **Fonctions utiles** : `count()`, `in_array()`, `array_merge()`, `sort()`, `array_map()`, `array_filter()`  
✅ **Déstructuration** : `[$a, $b] = $arr;` (PHP 7.1+)  
✅ **Spread** : `[...$arr1, ...$arr2]` (PHP 7.4+)

---

**Leçon précédente** : [Fonctions](./06-fonctions.md)  
**Prochaine leçon** : [Chaînes de caractères](./08-chaines-caracteres.md)
