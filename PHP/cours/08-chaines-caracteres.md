# Leçon 8 : Chaînes de caractères

## 1. Créer des chaînes

### Guillemets simples vs doubles

**Guillemets simples `'...'`** : Pas d'interpolation

```php
<?php
$nom = "Alice";
echo 'Bonjour $nom'; // Affiche : Bonjour $nom
```

**Guillemets doubles `"..."`** : Interpolation des variables

```php
<?php
$nom = "Alice";
echo "Bonjour $nom"; // Affiche : Bonjour Alice
```

**Syntaxe Heredoc** : Pour les chaînes multi-lignes avec interpolation

```php
<?php
$nom = "Alice";
$message = <<<EOT
Bonjour $nom,
Bienvenue sur notre site.
Cordialement,
L'équipe
EOT;

echo $message;
```

**Syntaxe Nowdoc** : Comme Heredoc mais sans interpolation

```php
<?php
$message = <<<'EOT'
Bonjour $nom,
Cette variable n'est pas interprétée.
EOT;

echo $message;
```

## 2. Concaténation

### Opérateur `.`

```php
<?php
$prenom = "Alice";
$nom = "Dupont";

$nomComplet = $prenom . " " . $nom;
echo $nomComplet; // Alice Dupont
```

### Opérateur `.=`

```php
<?php
$message = "Bonjour";
$message .= " ";
$message .= "le monde";
echo $message; // Bonjour le monde
```

## 3. Interpolation de variables

### Variables simples

```php
<?php
$nom = "Alice";
echo "Bonjour $nom !"; // Bonjour Alice !
```

### Variables avec accolades (syntaxe complexe)

```php
<?php
$fruit = "pomme";
echo "J'adore les {$fruit}s"; // J'adore les pommes

$arr = ["nom" => "Alice"];
echo "Nom : {$arr['nom']}"; // Nom : Alice
```

### Échappement

```php
<?php
$prix = 10;
echo "Prix : \$$prix"; // Prix : $10
echo "Nouvelle\nligne"; // Saut de ligne
echo "Tabulation\tici"; // Tabulation
```

## 4. Longueur d'une chaîne

### `strlen()`

```php
<?php
$texte = "Bonjour";
echo strlen($texte); // 7

// Attention avec les caractères accentués !
$texte = "été";
echo strlen($texte); // 5 (en UTF-8, é = 2 octets)

// Pour compter les caractères (pas les octets)
echo mb_strlen($texte, 'UTF-8'); // 3
```

⚠️ **Important** : Utilisez `mb_strlen()` pour les chaînes UTF-8 avec accents.

## 5. Extraire une sous-chaîne

### `substr()`

```php
<?php
$texte = "Bonjour le monde";

echo substr($texte, 0, 7);  // Bonjour
echo substr($texte, 8);     // le monde
echo substr($texte, -5);    // monde (à partir de la fin)
echo substr($texte, 0, -9); // Bonjour (enlève les 9 derniers)
```

### `mb_substr()` (pour UTF-8)

```php
<?php
$texte = "Été";
echo substr($texte, 0, 2);    // �� (incorrect)
echo mb_substr($texte, 0, 2, 'UTF-8'); // Ét (correct)
```

## 6. Rechercher dans une chaîne

### `strpos()` : Trouver la position

```php
<?php
$texte = "Bonjour le monde";

$pos = strpos($texte, "le");
echo $pos; // 8

// Attention : retourne false si non trouvé
if (strpos($texte, "monde") !== false) {
    echo "Trouvé !";
}

// ⚠️ Erreur commune :
// if (strpos($texte, "Bonjour")) { } // Faux si position = 0 !
```

### `strrpos()` : Dernière occurrence

```php
<?php
$texte = "Bonjour le monde, le soleil";
echo strrpos($texte, "le"); // 18 (dernière occurrence)
```

### `str_contains()` : Vérifier la présence (PHP 8+)

```php
<?php
$texte = "Bonjour le monde";

if (str_contains($texte, "monde")) {
    echo "Contient 'monde'";
}
```

### `str_starts_with()` et `str_ends_with()` (PHP 8+)

```php
<?php
$texte = "Bonjour le monde";

if (str_starts_with($texte, "Bonjour")) {
    echo "Commence par 'Bonjour'";
}

if (str_ends_with($texte, "monde")) {
    echo "Se termine par 'monde'";
}
```

## 7. Remplacer dans une chaîne

### `str_replace()`

```php
<?php
$texte = "Bonjour le monde";

// Remplacement simple
$nouveau = str_replace("monde", "univers", $texte);
echo $nouveau; // Bonjour le univers

// Remplacement multiple
$texte = "Les chats sont des animaux. Les chiens aussi.";
$nouveau = str_replace(["chats", "chiens"], ["félins", "canidés"], $texte);
echo $nouveau; // Les félins sont des animaux. Les canidés aussi.

// Compter les remplacements
$count = 0;
$nouveau = str_replace("le", "la", $texte, $count);
echo "Remplacements : $count";
```

### `str_ireplace()` : Insensible à la casse

```php
<?php
$texte = "Bonjour Le Monde";
$nouveau = str_ireplace("LE", "la", $texte);
echo $nouveau; // Bonjour la Monde
```

## 8. Convertir la casse

### `strtoupper()` et `strtolower()`

```php
<?php
$texte = "Bonjour Le Monde";

echo strtoupper($texte); // BONJOUR LE MONDE
echo strtolower($texte); // bonjour le monde
```

### `ucfirst()` et `ucwords()`

```php
<?php
$texte = "bonjour le monde";

echo ucfirst($texte);  // Bonjour le monde (1ère lettre en majuscule)
echo ucwords($texte);  // Bonjour Le Monde (chaque mot en majuscule)
```

### `mb_strtoupper()` et `mb_strtolower()` (pour UTF-8)

```php
<?php
$texte = "été";
echo strtoupper($texte);    // éTé (incorrect)
echo mb_strtoupper($texte, 'UTF-8'); // ÉTÉ (correct)
```

## 9. Nettoyer une chaîne

### `trim()`, `ltrim()`, `rtrim()`

```php
<?php
$texte = "  Bonjour  ";

echo trim($texte);   // "Bonjour" (supprime espaces des 2 côtés)
echo ltrim($texte);  // "Bonjour  " (supprime à gauche)
echo rtrim($texte);  // "  Bonjour" (supprime à droite)

// Supprimer d'autres caractères
$texte = "...Bonjour...";
echo trim($texte, "."); // "Bonjour"
```

### `strip_tags()` : Supprimer les balises HTML

```php
<?php
$html = "<p>Bonjour <strong>le monde</strong></p>";
echo strip_tags($html); // Bonjour le monde

// Garder certaines balises
echo strip_tags($html, "<strong>"); // Bonjour <strong>le monde</strong>
```

### `htmlspecialchars()` : Échapper les caractères HTML

```php
<?php
$texte = "<script>alert('XSS')</script>";
echo htmlspecialchars($texte);
// Affiche : &lt;script&gt;alert('XSS')&lt;/script&gt;
```

⚠️ **Sécurité** : Toujours utiliser `htmlspecialchars()` avant d'afficher du contenu utilisateur !

## 10. Diviser et joindre

### `explode()` : Diviser en tableau

```php
<?php
$texte = "pomme,banane,orange";
$fruits = explode(",", $texte);
print_r($fruits); // ["pomme", "banane", "orange"]

// Limiter le nombre de divisions
$texte = "a,b,c,d,e";
$parties = explode(",", $texte, 3);
print_r($parties); // ["a", "b", "c,d,e"]
```

### `implode()` (ou `join()`) : Joindre un tableau

```php
<?php
$fruits = ["pomme", "banane", "orange"];
$texte = implode(", ", $fruits);
echo $texte; // pomme, banane, orange
```

### `str_split()` : Diviser en caractères

```php
<?php
$texte = "Hello";
$lettres = str_split($texte);
print_r($lettres); // ["H", "e", "l", "l", "o"]

// Par blocs de N caractères
$blocs = str_split($texte, 2);
print_r($blocs); // ["He", "ll", "o"]
```

## 11. Inverser une chaîne

### `strrev()`

```php
<?php
$texte = "Hello";
echo strrev($texte); // olleH
```

## 12. Répéter une chaîne

### `str_repeat()`

```php
<?php
echo str_repeat("=", 20); // ====================
echo str_repeat("Ha", 3); // HaHaHa
```

## 13. Comparer des chaînes

### Opérateurs `==`, `===`

```php
<?php
$a = "hello";
$b = "HELLO";

var_dump($a == $b);  // false
var_dump($a === $b); // false
```

### `strcmp()` : Comparaison sensible à la casse

```php
<?php
$a = "hello";
$b = "hello";
$c = "world";

echo strcmp($a, $b); // 0 (égaux)
echo strcmp($a, $c); // < 0 (a < c)
```

### `strcasecmp()` : Insensible à la casse

```php
<?php
echo strcasecmp("hello", "HELLO"); // 0 (égaux)
```

## 14. Formater des chaînes

### `sprintf()` : Formater selon un modèle

```php
<?php
$nom = "Alice";
$age = 30;

$message = sprintf("Je m'appelle %s et j'ai %d ans.", $nom, $age);
echo $message; // Je m'appelle Alice et j'ai 30 ans.

// Formater des nombres
$prix = 1234.567;
echo sprintf("Prix : %.2f €", $prix); // Prix : 1234.57 €

// Padding
echo sprintf("%05d", 42); // 00042
```

**Spécificateurs** :
- `%s` : Chaîne
- `%d` : Entier
- `%f` : Float
- `%x` : Hexadécimal

### `number_format()`

```php
<?php
$nombre = 1234567.89;

echo number_format($nombre);              // 1,234,568
echo number_format($nombre, 2);           // 1,234,567.89
echo number_format($nombre, 2, ',', ' '); // 1 234 567,89
```

## 15. Exemple pratique : Validation d'email

```php
<?php
function validerEmail($email) {
    // Nettoyer
    $email = trim($email);
    
    // Vérifier le format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    // Vérifier la longueur
    if (strlen($email) > 255) {
        return false;
    }
    
    // Convertir en minuscules
    $email = strtolower($email);
    
    return $email;
}

$email = "  User@EXAMPLE.com  ";
$emailValide = validerEmail($email);

if ($emailValide) {
    echo "Email valide : $emailValide"; // user@example.com
} else {
    echo "Email invalide";
}
```

## 16. Exercices pratiques

### Exercice 1 : Longueur

Créez une fonction qui affiche le nombre de caractères d'une phrase.

### Exercice 2 : Inverser

Créez une fonction qui inverse une chaîne de caractères.

### Exercice 3 : Compter les mots

Créez une fonction qui compte le nombre de mots dans une phrase.  
Indice : `str_word_count()`

### Exercice 4 : Censurer

Créez une fonction qui remplace tous les mots interdits par des astérisques.

```php
<?php
function censurer($texte, $motsInterdits) {
    // Votre code ici
}

$texte = "Ceci est un texte avec des gros mots";
$interdits = ["gros", "mots"];
echo censurer($texte, $interdits);
// Affiche : Ceci est un texte avec des **** ****
```

### Exercice 5 : Slug

Créez une fonction qui transforme un titre en slug :
- "Mon Super Article !" → "mon-super-article"
- Minuscules
- Espaces remplacés par des tirets
- Suppression des caractères spéciaux

### Exercice 6 : Extraire le domaine

Créez une fonction qui extrait le domaine d'une adresse email.

```php
<?php
function extraireDomaine($email) {
    // Votre code ici
}

echo extraireDomaine("user@example.com"); // example.com
```

## 17. Points clés à retenir

✅ **Guillemets** : `'...'` (pas d'interpolation) vs `"..."` (interpolation)  
✅ **Concaténation** : `.` et `.=`  
✅ **Longueur** : `strlen()` ou `mb_strlen()` (UTF-8)  
✅ **Extraction** : `substr()` ou `mb_substr()`  
✅ **Recherche** : `strpos()`, `str_contains()` (PHP 8+)  
✅ **Remplacement** : `str_replace()`, `str_ireplace()`  
✅ **Casse** : `strtoupper()`, `strtolower()`, `ucfirst()`, `ucwords()`  
✅ **Nettoyage** : `trim()`, `strip_tags()`, `htmlspecialchars()`  
✅ **Division** : `explode()`, `str_split()`  
✅ **Jointure** : `implode()`  
✅ **UTF-8** : Préférez les fonctions `mb_*` pour les caractères accentués

---

**Leçon précédente** : [Tableaux](./07-tableaux.md)  
**Prochaine leçon** : [Superglobaux et formulaires](./09-superglobaux-formulaires.md)
