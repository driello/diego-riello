# Leçon 4 : Opérateurs et expressions

## 1. Introduction

Les **opérateurs** permettent de manipuler des valeurs et des variables pour former des **expressions**.

Une **expression** est une combinaison de valeurs, variables et opérateurs qui produit un résultat.

Exemple :
```php
<?php
$resultat = 10 + 5; // Expression : 10 + 5, résultat : 15
```

## 2. Opérateurs arithmétiques

Permettent d'effectuer des calculs mathématiques.

| Opérateur | Description | Exemple | Résultat |
|-----------|-------------|---------|----------|
| `+` | Addition | `5 + 3` | `8` |
| `-` | Soustraction | `5 - 3` | `2` |
| `*` | Multiplication | `5 * 3` | `15` |
| `/` | Division | `10 / 2` | `5` |
| `%` | Modulo (reste) | `10 % 3` | `1` |
| `**` | Puissance (PHP 5.6+) | `2 ** 3` | `8` |

### Exemples

```php
<?php
$a = 10;
$b = 3;

echo $a + $b;  // 13
echo $a - $b;  // 7
echo $a * $b;  // 30
echo $a / $b;  // 3.333...
echo $a % $b;  // 1 (reste de la division)
echo $a ** $b; // 1000 (10 puissance 3)

// Division entière
echo intdiv(10, 3); // 3
```

### Priorité des opérateurs

```php
<?php
$resultat = 2 + 3 * 4; // 14 (pas 20 !)
// La multiplication est prioritaire

$resultat = (2 + 3) * 4; // 20
// Les parenthèses forcent la priorité
```

## 3. Opérateurs d'affectation

### Affectation simple

```php
<?php
$x = 10; // Affecte 10 à $x
```

### Affectations combinées

| Opérateur | Équivalent | Exemple | Résultat |
|-----------|------------|---------|----------|
| `+=` | `$a = $a + $b` | `$a += 5` | Ajoute 5 à `$a` |
| `-=` | `$a = $a - $b` | `$a -= 3` | Soustrait 3 de `$a` |
| `*=` | `$a = $a * $b` | `$a *= 2` | Multiplie `$a` par 2 |
| `/=` | `$a = $a / $b` | `$a /= 4` | Divise `$a` par 4 |
| `%=` | `$a = $a % $b` | `$a %= 3` | Modulo de `$a` par 3 |
| `.=` | `$a = $a . $b` | `$a .= "!"` | Concatène `"!"` à `$a` |

### Exemples

```php
<?php
$nombre = 10;
$nombre += 5;  // $nombre vaut maintenant 15
$nombre *= 2;  // $nombre vaut maintenant 30
$nombre /= 3;  // $nombre vaut maintenant 10
$nombre %= 4;  // $nombre vaut maintenant 2

$texte = "Bonjour";
$texte .= " le monde"; // $texte vaut "Bonjour le monde"
```

### Incrémentation et décrémentation

```php
<?php
$i = 5;

$i++;  // Post-incrémentation : $i vaut 6
++$i;  // Pré-incrémentation : $i vaut 7

$i--;  // Post-décrémentation : $i vaut 6
--$i;  // Pré-décrémentation : $i vaut 5

// Différence pré/post :
$a = 5;
$b = $a++;  // $b = 5, puis $a devient 6
echo "$a, $b"; // 6, 5

$a = 5;
$b = ++$a;  // $a devient 6, puis $b = 6
echo "$a, $b"; // 6, 6
```

## 4. Opérateurs de comparaison

Comparent deux valeurs et retournent `true` ou `false`.

| Opérateur | Description | Exemple | Résultat |
|-----------|-------------|---------|----------|
| `==` | Égal à (valeur) | `5 == "5"` | `true` |
| `===` | Identique (valeur et type) | `5 === "5"` | `false` |
| `!=` | Différent de | `5 != 3` | `true` |
| `!==` | Non identique | `5 !== "5"` | `true` |
| `<` | Inférieur à | `3 < 5` | `true` |
| `>` | Supérieur à | `5 > 3` | `true` |
| `<=` | Inférieur ou égal | `5 <= 5` | `true` |
| `>=` | Supérieur ou égal | `5 >= 3` | `true` |
| `<=>` | Spaceship (PHP 7+) | `1 <=> 2` | `-1` |

### Exemples

```php
<?php
var_dump(5 == 5);    // bool(true)
var_dump(5 == "5");  // bool(true) - Type juggling !
var_dump(5 === "5"); // bool(false) - Types différents

var_dump(10 != 20);  // bool(true)
var_dump(10 !== 10); // bool(false)

var_dump(5 < 10);    // bool(true)
var_dump(5 > 10);    // bool(false)
```

### Opérateur Spaceship `<=>`

Retourne :
- `-1` si la valeur de gauche est inférieure
- `0` si les deux valeurs sont égales
- `1` si la valeur de gauche est supérieure

```php
<?php
echo 1 <=> 2;  // -1
echo 2 <=> 2;  // 0
echo 3 <=> 2;  // 1

// Utile pour les tris personnalisés
```

⚠️ **Important** : Utilisez `===` et `!==` pour éviter les surprises du type juggling.

## 5. Opérateurs logiques

Combinent des expressions booléennes.

| Opérateur | Description | Exemple | Résultat |
|-----------|-------------|---------|----------|
| `&&` ou `and` | ET logique | `true && false` | `false` |
| <code>&#124;&#124;</code> ou `or` | OU logique | `true || false` | `true` |
| `!` | NON logique | `!true` | `false` |
| `xor` | OU exclusif | `true xor false` | `true` |

### Exemples

```php
<?php
$age = 25;
$permis = true;

// ET logique : les deux conditions doivent être vraies
if ($age >= 18 && $permis) {
    echo "Peut conduire";
}

// OU logique : au moins une condition doit être vraie
$estEtudiant = true;
$estRetraite = false;

if ($estEtudiant || $estRetraite) {
    echo "Réduction applicable";
}

// NON logique : inverse la valeur booléenne
$estConnecte = false;
if (!$estConnecte) {
    echo "Veuillez vous connecter";
}
```

### Priorité : `&&` vs `and`, `||` vs `or`

```php
<?php
// && et || ont une priorité plus élevée que and et or
$result = true && false;   // false
$result = true and false;  // true (!)

// Recommandation : utilisez && et ||
```

### Court-circuit (short-circuit)

PHP évalue les expressions de gauche à droite et s'arrête dès que le résultat est déterminé :

```php
<?php
function test() {
    echo "Fonction appelée !";
    return true;
}

// Avec &&, la fonction n'est pas appelée si la première condition est false
if (false && test()) {
    echo "Jamais affiché";
}
// Sortie : rien (test() n'est pas appelé)

// Avec ||, la fonction n'est pas appelée si la première condition est true
if (true || test()) {
    echo "Affiché";
}
// Sortie : "Affiché" (test() n'est pas appelé)
```

## 6. Opérateur de concaténation

L'opérateur `.` permet de concaténer des chaînes :

```php
<?php
$prenom = "Alice";
$nom = "Dupont";

$nomComplet = $prenom . " " . $nom;
echo $nomComplet; // Alice Dupont

// Avec l'opérateur .=
$message = "Bonjour";
$message .= " ";
$message .= $prenom;
echo $message; // Bonjour Alice
```

## 7. Opérateur ternaire

Syntaxe condensée pour une condition simple :

```php
<?php
$age = 20;
$statut = ($age >= 18) ? "majeur" : "mineur";
echo $statut; // majeur

// Équivalent à :
if ($age >= 18) {
    $statut = "majeur";
} else {
    $statut = "mineur";
}
```

### Ternaire imbriqué (à éviter)

```php
<?php
$note = 15;
$mention = ($note >= 16) ? "TB" : (($note >= 14) ? "B" : "AB");
echo $mention; // B

// Mieux : utiliser if/elseif pour la lisibilité
```

## 8. Opérateur de coalescence null `??` (PHP 7+)

Retourne la valeur de gauche si elle existe et n'est pas `null`, sinon la valeur de droite :

```php
<?php
$nom = null;
$nomAffiche = $nom ?? "Anonyme";
echo $nomAffiche; // Anonyme

// Équivalent à :
$nomAffiche = isset($nom) ? $nom : "Anonyme";

// Utile avec les superglobaux
$page = $_GET['page'] ?? 1;
```

### Chaînage

```php
<?php
$a = null;
$b = null;
$c = "Valeur C";

$resultat = $a ?? $b ?? $c ?? "Défaut";
echo $resultat; // Valeur C
```

## 9. Opérateurs sur les bits (avancé)

Manipulent les bits individuels des entiers :

| Opérateur | Description | Exemple |
|-----------|-------------|---------|
| `&` | ET bit à bit | `5 & 3` → `1` |
| <code>&#124;</code> | OU bit à bit | `5 | 3` → `7` |
| `^` | XOR bit à bit | `5 ^ 3` → `6` |
| `~` | NON bit à bit | `~5` → `-6` |
| `<<` | Décalage à gauche | `5 << 1` → `10` |
| `>>` | Décalage à droite | `5 >> 1` → `2` |

*(Rarement utilisés en développement web classique)*

## 10. Exemple pratique complet

```php
<?php
// Calculatrice simple
$a = 20;
$b = 5;

echo "Addition : " . ($a + $b) . "<br>";
echo "Soustraction : " . ($a - $b) . "<br>";
echo "Multiplication : " . ($a * $b) . "<br>";
echo "Division : " . ($a / $b) . "<br>";
echo "Modulo : " . ($a % $b) . "<br>";

// Comparaisons
echo "<br>$a == $b : " . ($a == $b ? "vrai" : "faux") . "<br>";
echo "$a > $b : " . ($a > $b ? "vrai" : "faux") . "<br>";

// Logique
$age = 25;
$permis = true;

if ($age >= 18 && $permis) {
    echo "<br>Vous pouvez conduire<br>";
}

// Ternaire
$statut = ($age >= 18) ? "majeur" : "mineur";
echo "Statut : $statut<br>";

// Coalescence null
$nom = $_GET['nom'] ?? "Visiteur";
echo "Bienvenue, $nom !";
```

## 11. Exercices pratiques

### Exercice 1 : Calculatrice

Créez un script qui :
- Déclare deux variables `$nombre1` et `$nombre2`
- Affiche les résultats des 5 opérations arithmétiques de base

### Exercice 2 : Comparaisons

Testez et affichez le résultat de :
```php
<?php
var_dump(10 == "10");
var_dump(10 === "10");
var_dump(0 == false);
var_dump(0 === false);
```

### Exercice 3 : Conditions logiques

Écrivez un script qui vérifie si une personne peut accéder à une salle de cinéma :
- Âge >= 18 OU accompagné d'un adulte
- ET possède un billet

### Exercice 4 : Opérateur ternaire

Convertissez ce code avec un opérateur ternaire :
```php
<?php
$note = 12;
if ($note >= 10) {
    $resultat = "Admis";
} else {
    $resultat = "Recalé";
}
```

## 12. Points clés à retenir

✅ **Arithmétiques** : `+`, `-`, `*`, `/`, `%`, `**`  
✅ **Affectation** : `=`, `+=`, `-=`, `*=`, `/=`, `.=`  
✅ **Comparaison** : Utilisez `===` et `!==` pour éviter le type juggling  
✅ **Logiques** : `&&`, `||`, `!` (privilégier sur `and`, `or`)  
✅ **Ternaire** : `condition ? valeur_si_vrai : valeur_si_faux`  
✅ **Coalescence null** : `$var ?? "défaut"` (PHP 7+)  
✅ **Concaténation** : `.` pour assembler des chaînes  
✅ **Priorités** : Utilisez des parenthèses pour clarifier

---

**Leçon précédente** : [Variables et types](./03-variables-types.md)  
**Prochaine leçon** : [Structures de contrôle](./05-structures-controle.md)
