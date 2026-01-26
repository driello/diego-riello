# Leçon 6 : Fonctions

## 1. Qu'est-ce qu'une fonction ?

Une **fonction** est un bloc de code réutilisable qui effectue une tâche spécifique.

**Avantages** :
- Réutilisation du code
- Organisation et lisibilité
- Facilite la maintenance
- Évite les répétitions (DRY : Don't Repeat Yourself)

## 2. Définir et appeler une fonction

### Syntaxe de base

```php
<?php
function direBonjour() {
    echo "Bonjour !";
}

// Appel de la fonction
direBonjour(); // Affiche : Bonjour !
```

### Conventions de nommage

- Utiliser `camelCase` ou `snake_case`
- Nom descriptif de l'action effectuée
- Commencer par un verbe

✅ Bons noms : `calculerTotal()`, `afficher_message()`, `validerEmail()`  
❌ Mauvais noms : `fonction1()`, `x()`, `traitement()`

## 3. Fonctions avec paramètres

### Un paramètre

```php
<?php
function direBonjour($nom) {
    echo "Bonjour, $nom !";
}

direBonjour("Alice"); // Affiche : Bonjour, Alice !
direBonjour("Bob");   // Affiche : Bonjour, Bob !
```

### Plusieurs paramètres

```php
<?php
function additionner($a, $b) {
    $resultat = $a + $b;
    echo "$a + $b = $resultat";
}

additionner(5, 3); // Affiche : 5 + 3 = 8
```

### Paramètres avec valeurs par défaut

```php
<?php
function direBonjour($nom = "visiteur") {
    echo "Bonjour, $nom !";
}

direBonjour("Alice"); // Affiche : Bonjour, Alice !
direBonjour();        // Affiche : Bonjour, visiteur !
```

**Règle** : Les paramètres avec valeur par défaut doivent être **après** les paramètres obligatoires.

```php
<?php
// ✅ Correct
function creerUtilisateur($nom, $age = 18, $ville = "Paris") {
    // ...
}

// ❌ Incorrect
// function creerUtilisateur($nom = "Inconnu", $age) {
//     // ...
// }
```

## 4. Valeur de retour

### Fonction avec `return`

```php
<?php
function additionner($a, $b) {
    return $a + $b;
}

$resultat = additionner(5, 3);
echo $resultat; // Affiche : 8
```

### Retour multiple (avec un tableau)

```php
<?php
function calculer($a, $b) {
    $somme = $a + $b;
    $produit = $a * $b;
    return [$somme, $produit];
}

// Déstructuration (PHP 7.1+)
[$s, $p] = calculer(5, 3);
echo "Somme : $s, Produit : $p"; // Somme : 8, Produit : 15

// Ou avec list()
list($somme, $produit) = calculer(5, 3);
```

### Retour anticipé

```php
<?php
function diviser($a, $b) {
    if ($b == 0) {
        return "Erreur : division par zéro";
    }
    return $a / $b;
}

echo diviser(10, 2); // 5
echo diviser(10, 0); // Erreur : division par zéro
```

### Fonction sans valeur de retour

```php
<?php
function afficherMessage($message) {
    echo $message;
    // return; (implicite, retourne NULL)
}
```

## 5. Type hinting (typage des paramètres et retour)

### Type des paramètres (PHP 7+)

```php
<?php
function additionner(int $a, int $b) {
    return $a + $b;
}

echo additionner(5, 3);   // 8
echo additionner(5.5, 3); // 8 (conversion automatique)
// echo additionner("a", 3); // TypeError
```

Types disponibles :
- `int`, `float`, `string`, `bool`, `array`, `object`, `callable`, `iterable`
- Classes et interfaces

### Type de retour (PHP 7+)

```php
<?php
function additionner(int $a, int $b): int {
    return $a + $b;
}

function obtenirNom(): string {
    return "Alice";
}

function obtenirUtilisateur(): ?array { // Peut retourner null
    return null;
}
```

### Types stricts (PHP 7+)

```php
<?php
declare(strict_types=1);

function additionner(int $a, int $b): int {
    return $a + $b;
}

// echo additionner(5.5, 3); // TypeError en mode strict
```

⚠️ `declare(strict_types=1)` doit être la **première ligne** du fichier.

## 6. Portée des variables (scope)

### Variables locales

```php
<?php
function test() {
    $x = 10; // Variable locale
    echo $x;
}

test(); // Affiche : 10
// echo $x; // Erreur : $x n'existe pas en dehors de la fonction
```

### Variables globales

```php
<?php
$x = 10; // Variable globale

function test() {
    global $x; // Accès à la variable globale
    echo $x;
}

test(); // Affiche : 10
```

⚠️ **Évitez les variables globales** : préférez passer les valeurs en paramètres.

### Superglobales

Les superglobales sont accessibles partout sans `global` :
- `$_GET`, `$_POST`, `$_REQUEST`, `$_SESSION`, `$_COOKIE`, `$_SERVER`, `$_FILES`, `$_ENV`, `$GLOBALS`

```php
<?php
function afficherIP() {
    echo $_SERVER['REMOTE_ADDR'];
}
```

### Variables statiques

Une variable `static` conserve sa valeur entre les appels :

```php
<?php
function compteur() {
    static $count = 0;
    $count++;
    echo $count . " ";
}

compteur(); // 1
compteur(); // 2
compteur(); // 3
```

## 7. Fonctions anonymes (closures)

### Syntaxe

```php
<?php
$direBonjour = function($nom) {
    echo "Bonjour, $nom !";
};

$direBonjour("Alice"); // Affiche : Bonjour, Alice !
```

### Utilisation avec `array_map()`

```php
<?php
$nombres = [1, 2, 3, 4, 5];

$doubles = array_map(function($n) {
    return $n * 2;
}, $nombres);

print_r($doubles); // [2, 4, 6, 8, 10]
```

### Capturer des variables externes avec `use`

```php
<?php
$facteur = 10;

$multiplier = function($n) use ($facteur) {
    return $n * $facteur;
};

echo $multiplier(5); // 50
```

### Arrow functions (PHP 7.4+)

Syntaxe courte pour les fonctions simples :

```php
<?php
$double = fn($n) => $n * 2;
echo $double(5); // 10

// Équivalent à :
$double = function($n) {
    return $n * 2;
};

// Les variables externes sont automatiquement capturées
$facteur = 10;
$multiplier = fn($n) => $n * $facteur;
echo $multiplier(5); // 50
```

## 8. Fonctions variadiques (nombre variable d'arguments)

### Avec `func_get_args()`

```php
<?php
function additionner() {
    $args = func_get_args();
    return array_sum($args);
}

echo additionner(1, 2, 3);       // 6
echo additionner(10, 20, 30, 40); // 100
```

### Avec l'opérateur `...` (PHP 5.6+)

```php
<?php
function additionner(...$nombres) {
    return array_sum($nombres);
}

echo additionner(1, 2, 3);       // 6
echo additionner(10, 20, 30, 40); // 100
```

### Unpacking d'arguments

```php
<?php
function additionner($a, $b, $c) {
    return $a + $b + $c;
}

$nombres = [1, 2, 3];
echo additionner(...$nombres); // 6
```

## 9. Fonctions utiles intégrées

PHP possède des milliers de fonctions intégrées. Quelques exemples :

### Chaînes

```php
<?php
strlen("hello");           // Longueur d'une chaîne
strtoupper("hello");       // HELLO
strtolower("HELLO");       // hello
substr("hello", 0, 3);     // hel
str_replace("o", "0", "hello"); // hell0
```

### Tableaux

```php
<?php
count([1, 2, 3]);          // 3
array_push($arr, "item");  // Ajoute un élément
array_pop($arr);           // Retire le dernier élément
in_array("pomme", $fruits); // Vérifie si un élément existe
```

### Mathématiques

```php
<?php
abs(-5);       // 5
round(3.14159, 2); // 3.14
rand(1, 10);   // Nombre aléatoire entre 1 et 10
max(1, 5, 3);  // 5
min(1, 5, 3);  // 1
```

### Date et heure

```php
<?php
date('Y-m-d');     // 2025-11-19
time();            // Timestamp actuel
strtotime("+1 day"); // Timestamp de demain
```

## 10. Exemple pratique : Calculatrice

```php
<?php
function calculer(float $a, float $b, string $operation): float {
    switch ($operation) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            if ($b == 0) {
                throw new Exception("Division par zéro");
            }
            return $a / $b;
        default:
            throw new Exception("Opération invalide");
    }
}

try {
    echo calculer(10, 5, '+');  // 15
    echo calculer(10, 5, '-');  // 5
    echo calculer(10, 5, '*');  // 50
    echo calculer(10, 5, '/');  // 2
    // echo calculer(10, 0, '/'); // Exception
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
```

## 11. Exercices pratiques

### Exercice 1 : Fonction simple

Créez une fonction `carre($n)` qui retourne le carré d'un nombre.

### Exercice 2 : Fonction avec valeur par défaut

Créez une fonction `saluer($nom, $langue = "fr")` qui affiche un message de salutation :
- "fr" → "Bonjour, {nom}"
- "en" → "Hello, {nom}"
- "es" → "Hola, {nom}"

### Exercice 3 : Calculer l'aire

Créez une fonction `aireRectangle($longueur, $largeur)` qui retourne l'aire d'un rectangle.

### Exercice 4 : Nombre pair ou impair

Créez une fonction `estPair($n)` qui retourne `true` si le nombre est pair, `false` sinon.

### Exercice 5 : Température

Créez deux fonctions :
- `celsiusVersFahrenheit($celsius)`
- `fahrenheitVersCelsius($fahrenheit)`

Formules :
- F = C × 9/5 + 32
- C = (F - 32) × 5/9

### Exercice 6 : Fonction variadique

Créez une fonction `moyenne(...$nombres)` qui calcule la moyenne de tous les nombres passés en paramètres.

## 12. Points clés à retenir

✅ **Définition** : `function nomFonction($param) { ... }`  
✅ **Retour** : `return $valeur;`  
✅ **Paramètres par défaut** : `function test($a = 10) { ... }`  
✅ **Type hinting** : `function add(int $a, int $b): int { ... }`  
✅ **Portée** : Variables locales, `global`, `static`, superglobales  
✅ **Anonymes** : `$fn = function() { ... };`  
✅ **Arrow functions** : `$fn = fn($x) => $x * 2;` (PHP 7.4+)  
✅ **Variadiques** : `function sum(...$nums) { ... }`  
✅ **DRY** : Ne répétez pas votre code, créez des fonctions réutilisables

---

**Leçon précédente** : [Structures de contrôle](./05-structures-controle.md)  
**Prochaine leçon** : [Tableaux](./07-tableaux.md)
