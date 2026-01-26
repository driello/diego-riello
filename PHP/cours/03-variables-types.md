# Leçon 3 : Variables et types

## 1. Qu'est-ce qu'une variable ?

Une **variable** est un conteneur permettant de stocker des données (texte, nombres, tableaux, objets, etc.).

En PHP :
- Les noms de variables commencent par `$`
- Sensibles à la casse (`$nom` ≠ `$Nom`)
- Pas besoin de déclarer le type explicitement (typage dynamique)

## 2. Déclaration et affectation

```php
<?php
$prenom = "Alice";
$age = 25;
$taille = 1.65;
$estEtudiant = true;
```

**Règles de nommage** :
- Commence par une lettre ou underscore `_`
- Peut contenir des lettres, chiffres et underscores
- Pas d'espaces ni de caractères spéciaux
- Convention : `camelCase` ou `snake_case`

✅ Valides : `$nom`, `$age_utilisateur`, `$total2024`  
❌ Invalides : `$2nom`, `$nom-utilisateur`, `$mon nom`

## 3. Les types scalaires

PHP possède plusieurs types de base (scalaires) :

### Entier (integer)

```php
<?php
$age = 25;
$negatif = -10;
$hexadecimal = 0xFF; // 255 en décimal
```

### Nombre à virgule flottante (float / double)

```php
<?php
$prix = 19.99;
$pi = 3.14159;
$scientifique = 1.5e3; // 1500
```

### Chaîne de caractères (string)

```php
<?php
$nom = "Alice";
$message = 'Bonjour tout le monde';
$multiline = "Ligne 1
Ligne 2"; // Les sauts de ligne sont conservés
```

### Booléen (boolean)

```php
<?php
$estVrai = true;
$estFaux = false;

// Utilisé souvent dans les conditions
$estMajeur = ($age >= 18); // true si age >= 18
```

## 4. Autres types importants

### NULL

Représente l'absence de valeur :

```php
<?php
$variable = null;
$autreVariable = NULL; // Insensible à la casse

// Vérifier si une variable est null
if ($variable === null) {
    echo "La variable est null";
}
```

### Tableaux (array)

```php
<?php
$fruits = ["pomme", "banane", "orange"];
$personne = ["nom" => "Dupont", "age" => 30];
```
*(Détaillé dans la leçon sur les tableaux)*

### Objets (object)

```php
<?php
class Personne {
    public $nom;
}

$p = new Personne();
$p->nom = "Alice";
```
*(Détaillé dans la leçon sur la POO)*

## 5. Vérifier le type d'une variable

### Fonction `gettype()`

```php
<?php
$age = 25;
echo gettype($age); // Affiche : integer

$prix = 19.99;
echo gettype($prix); // Affiche : double
```

### Fonctions de test de type

```php
<?php
$nombre = 42;

var_dump(is_int($nombre));     // bool(true)
var_dump(is_float($nombre));   // bool(false)
var_dump(is_string($nombre));  // bool(false)
var_dump(is_bool($nombre));    // bool(false)
var_dump(is_null($nombre));    // bool(false)
var_dump(is_array($nombre));   // bool(false)
```

Fonctions disponibles :
- `is_int()` ou `is_integer()`
- `is_float()` ou `is_double()`
- `is_string()`
- `is_bool()`
- `is_null()`
- `is_array()`
- `is_object()`
- `is_numeric()` (vérifie si c'est un nombre ou une chaîne numérique)

## 6. Type Juggling (conversion automatique)

PHP convertit automatiquement les types selon le contexte :

```php
<?php
$nombre = "10";      // string
$resultat = $nombre + 5;  // PHP convertit "10" en 10 (int)
echo $resultat;      // Affiche : 15

$total = "20 pommes" + 10;
echo $total;         // Affiche : 30 (PHP extrait le nombre au début)

// Attention aux conversions surprenantes !
$texte = "abc" + 5;
echo $texte;         // Affiche : 5 (car "abc" vaut 0 en int)
```

⚠️ **Attention** : Le type juggling peut causer des bugs. Privilégiez les conversions explicites.

## 7. Cast (conversion explicite)

Forcer le type d'une variable :

```php
<?php
$nombre = "123";

$entier = (int) $nombre;      // 123 (integer)
$flottant = (float) $nombre;  // 123.0 (float)
$chaine = (string) $entier;   // "123" (string)
$booleen = (bool) $nombre;    // true

// Cast vers array et object
$tableau = (array) $nombre;   // ["123"]
$objet = (object) $nombre;    // stdClass Object
```

### Conversions booléennes importantes

Valeurs considérées comme **false** :
- `false`
- `0` (entier)
- `0.0` (float)
- `""` (chaîne vide)
- `"0"` (chaîne contenant zéro)
- `[]` (tableau vide)
- `null`

Tout le reste est **true** :

```php
<?php
var_dump((bool) "");      // false
var_dump((bool) "0");     // false
var_dump((bool) "false"); // true (!!)
var_dump((bool) []);      // false
var_dump((bool) [0]);     // true
```

## 8. Les constantes

Une **constante** est une valeur qui ne peut pas être modifiée une fois définie.

### Définir une constante avec `define()`

```php
<?php
define("SITE_NAME", "Mon Super Site");
define("MAX_USERS", 100);

echo SITE_NAME; // Affiche : Mon Super Site

// Tentative de modification (génère une erreur)
// SITE_NAME = "Nouveau nom"; // Erreur !
```

### Constantes avec `const` (dans les classes)

```php
<?php
const PI = 3.14159;
const GRAVITY = 9.81;

echo PI; // Affiche : 3.14159
```

**Différences** :
- `define()` : utilisable partout, même conditionnellement
- `const` : plus rapide, mais seulement au niveau global ou dans une classe

### Constantes magiques

PHP fournit des constantes prédéfinies :

```php
<?php
echo __FILE__;      // Chemin complet du fichier
echo __DIR__;       // Répertoire du fichier
echo __LINE__;      // Numéro de ligne actuel
echo __FUNCTION__;  // Nom de la fonction actuelle
echo __CLASS__;     // Nom de la classe actuelle
echo __METHOD__;    // Nom de la méthode actuelle (Classe::methode)
```

## 9. Afficher les variables pour le débogage

### `var_dump()`

Affiche le type et la valeur :

```php
<?php
$age = 25;
var_dump($age); // int(25)

$fruits = ["pomme", "banane"];
var_dump($fruits);
// array(2) {
//   [0]=> string(5) "pomme"
//   [1]=> string(6) "banane"
// }
```

### `print_r()`

Affichage plus lisible (sans les types) :

```php
<?php
$personne = ["nom" => "Alice", "age" => 30];
print_r($personne);
// Array
// (
//     [nom] => Alice
//     [age] => 30
// )
```

## 10. Exemple pratique

```php
<?php
// Déclaration de variables
$prenom = "Alice";
$nom = "Dupont";
$age = 28;
$salaire = 2500.50;
$estManager = false;

// Affichage
echo "Prénom : $prenom<br>";
echo "Nom : $nom<br>";
echo "Âge : $age ans<br>";
echo "Salaire : $salaire €<br>";
echo "Manager : " . ($estManager ? "Oui" : "Non") . "<br>";

// Vérification de type
echo "<br>Type de \$age : " . gettype($age) . "<br>";
echo "Est un entier ? " . (is_int($age) ? "Oui" : "Non") . "<br>";

// Conversion
$ageTexte = (string) $age;
echo "Âge en texte : '$ageTexte' (type : " . gettype($ageTexte) . ")<br>";

// Constante
define("ENTREPRISE", "TechCorp");
echo "Entreprise : " . ENTREPRISE;
```

## 11. Exercices pratiques

### Exercice 1 : Déclaration de variables

Créez un script qui déclare et affiche :
- Votre prénom (string)
- Votre âge (integer)
- Votre taille en mètres (float)
- Si vous aimez la programmation (boolean)

### Exercice 2 : Conversion de types

```php
<?php
$nombre = "42";
// Convertissez cette chaîne en entier et ajoutez 8
// Affichez le résultat et son type
```

### Exercice 3 : Constantes

Définissez trois constantes :
- `TVA` avec la valeur 0.20
- `PRIX_HT` avec la valeur 100
- Calculez et affichez le prix TTC

### Exercice 4 : Test de types

Écrivez un script qui teste si les valeurs suivantes sont considérées comme `true` ou `false` :
- `"0"`
- `"false"`
- `[]`
- `[0]`
- `null`

## 12. Points clés à retenir

✅ Les variables commencent par `$` et sont sensibles à la casse  
✅ Types scalaires : `int`, `float`, `string`, `bool`, `null`  
✅ PHP fait du **type juggling** (conversion automatique), parfois surprenant  
✅ Utilisez le **cast** pour convertir explicitement : `(int)`, `(float)`, `(string)`, `(bool)`  
✅ `var_dump()` et `print_r()` pour déboguer  
✅ Les **constantes** se définissent avec `define()` ou `const`  
✅ Fonctions de test : `is_int()`, `is_string()`, `is_null()`, etc.

---

**Leçon précédente** : [Syntaxe de base](./02-syntaxe-base.md)  
**Prochaine leçon** : [Opérateurs et expressions](./04-operateurs-expressions.md)
