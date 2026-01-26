# Leçon 13 : Programmation orientée objet (POO) - Bases

## 1. Introduction à la POO

La **Programmation Orientée Objet** (POO) est un paradigme de programmation basé sur le concept d'**objets** qui contiennent des données (propriétés) et du code (méthodes).

**Avantages** :
- Réutilisabilité du code
- Organisation et structure
- Encapsulation des données
- Héritage et polymorphisme
- Facilite la maintenance

## 2. Classes et objets

### Définir une classe

```php
<?php
class Personne {
    // Propriétés
    public $nom;
    public $age;
    
    // Méthode
    public function sePresenter() {
        echo "Je m'appelle {$this->nom} et j'ai {$this->age} ans.";
    }
}
```

### Créer un objet (instance)

```php
<?php
$alice = new Personne();
$alice->nom = "Alice";
$alice->age = 30;
$alice->sePresenter(); // Je m'appelle Alice et j'ai 30 ans.
```

### Le mot-clé `$this`

`$this` fait référence à l'instance actuelle de la classe.

```php
<?php
class Compteur {
    public $valeur = 0;
    
    public function incrementer() {
        $this->valeur++;
    }
    
    public function afficher() {
        echo $this->valeur;
    }
}

$compteur = new Compteur();
$compteur->incrementer();
$compteur->afficher(); // 1
```

## 3. Constructeur

Le **constructeur** est une méthode spéciale appelée automatiquement lors de la création d'un objet.

```php
<?php
class Personne {
    public $nom;
    public $age;
    
    public function __construct($nom, $age) {
        $this->nom = $nom;
        $this->age = $age;
    }
    
    public function sePresenter() {
        echo "Je m'appelle {$this->nom} et j'ai {$this->age} ans.";
    }
}

// Création avec constructeur
$alice = new Personne("Alice", 30);
$alice->sePresenter();
```

### Constructeur avec valeurs par défaut

```php
<?php
class Personne {
    public $nom;
    public $age;
    
    public function __construct($nom, $age = 18) {
        $this->nom = $nom;
        $this->age = $age;
    }
}

$bob = new Personne("Bob"); // age = 18
```

## 4. Visibilité des propriétés et méthodes

### `public` : Accessible partout

```php
<?php
class Voiture {
    public $marque = "Toyota";
}

$voiture = new Voiture();
echo $voiture->marque; // OK
```

### `private` : Accessible uniquement dans la classe

```php
<?php
class CompteBancaire {
    private $solde = 0;
    
    public function deposer($montant) {
        $this->solde += $montant;
    }
    
    public function getSolde() {
        return $this->solde;
    }
}

$compte = new CompteBancaire();
$compte->deposer(100);
echo $compte->getSolde(); // 100
// echo $compte->solde; // Erreur !
```

### `protected` : Accessible dans la classe et ses enfants

```php
<?php
class Animal {
    protected $nom;
    
    public function __construct($nom) {
        $this->nom = $nom;
    }
}

class Chien extends Animal {
    public function aboyer() {
        echo "{$this->nom} aboie !"; // OK, protected accessible
    }
}

$chien = new Chien("Rex");
$chien->aboyer();
// echo $chien->nom; // Erreur !
```

## 5. Getters et Setters

Permettent de contrôler l'accès aux propriétés privées.

```php
<?php
class Produit {
    private $nom;
    private $prix;
    
    public function __construct($nom, $prix) {
        $this->nom = $nom;
        $this->setPrix($prix);
    }
    
    // Getter
    public function getNom() {
        return $this->nom;
    }
    
    // Setter avec validation
    public function setPrix($prix) {
        if ($prix < 0) {
            throw new Exception("Le prix ne peut pas être négatif");
        }
        $this->prix = $prix;
    }
    
    public function getPrix() {
        return $this->prix;
    }
}

$produit = new Produit("Livre", 15);
echo $produit->getNom(); // Livre
echo $produit->getPrix(); // 15
```

## 6. Héritage

L'**héritage** permet à une classe d'hériter des propriétés et méthodes d'une autre classe.

```php
<?php
class Animal {
    protected $nom;
    
    public function __construct($nom) {
        $this->nom = $nom;
    }
    
    public function manger() {
        echo "{$this->nom} mange.";
    }
}

class Chien extends Animal {
    public function aboyer() {
        echo "{$this->nom} aboie !";
    }
}

class Chat extends Animal {
    public function miauler() {
        echo "{$this->nom} miaule !";
    }
}

$chien = new Chien("Rex");
$chien->manger(); // Hérité de Animal
$chien->aboyer(); // Spécifique à Chien

$chat = new Chat("Minou");
$chat->manger();
$chat->miauler();
```

### Redéfinir une méthode (override)

```php
<?php
class Animal {
    public function seDeplacer() {
        echo "L'animal se déplace.";
    }
}

class Oiseau extends Animal {
    public function seDeplacer() {
        echo "L'oiseau vole.";
    }
}

$oiseau = new Oiseau();
$oiseau->seDeplacer(); // L'oiseau vole.
```

### Appeler la méthode parente avec `parent::`

```php
<?php
class Animal {
    protected $nom;
    
    public function __construct($nom) {
        $this->nom = $nom;
    }
}

class Chien extends Animal {
    private $race;
    
    public function __construct($nom, $race) {
        parent::__construct($nom); // Appel du constructeur parent
        $this->race = $race;
    }
    
    public function afficher() {
        echo "{$this->nom} est un {$this->race}";
    }
}

$chien = new Chien("Rex", "Labrador");
$chien->afficher();
```

## 7. Méthodes et propriétés statiques

Les membres **statiques** appartiennent à la classe, pas aux instances.

```php
<?php
class Compteur {
    private static $compte = 0;
    
    public function __construct() {
        self::$compte++;
    }
    
    public static function getCompte() {
        return self::$compte;
    }
}

$c1 = new Compteur();
$c2 = new Compteur();
$c3 = new Compteur();

echo Compteur::getCompte(); // 3
```

### Constantes de classe

```php
<?php
class Mathematiques {
    const PI = 3.14159;
    const E = 2.71828;
    
    public static function aireCercle($rayon) {
        return self::PI * $rayon * $rayon;
    }
}

echo Mathematiques::PI; // 3.14159
echo Mathematiques::aireCercle(5);
```

## 8. Interfaces

Une **interface** définit un contrat que les classes doivent respecter.

```php
<?php
interface Vehicule {
    public function demarrer();
    public function arreter();
}

class Voiture implements Vehicule {
    public function demarrer() {
        echo "La voiture démarre.";
    }
    
    public function arreter() {
        echo "La voiture s'arrête.";
    }
}

class Moto implements Vehicule {
    public function demarrer() {
        echo "La moto démarre.";
    }
    
    public function arreter() {
        echo "La moto s'arrête.";
    }
}
```

### Implémenter plusieurs interfaces

```php
<?php
interface Volant {
    public function voler();
}

interface Nageant {
    public function nager();
}

class Canard implements Volant, Nageant {
    public function voler() {
        echo "Le canard vole.";
    }
    
    public function nager() {
        echo "Le canard nage.";
    }
}
```

## 9. Classes abstraites

Une **classe abstraite** ne peut pas être instanciée directement et peut contenir des méthodes abstraites (sans implémentation).

```php
<?php
abstract class Forme {
    abstract public function calculerAire();
    abstract public function calculerPerimetre();
    
    // Méthode concrète
    public function afficher() {
        echo "Aire : " . $this->calculerAire() . "\n";
        echo "Périmètre : " . $this->calculerPerimetre() . "\n";
    }
}

class Rectangle extends Forme {
    private $longueur;
    private $largeur;
    
    public function __construct($longueur, $largeur) {
        $this->longueur = $longueur;
        $this->largeur = $largeur;
    }
    
    public function calculerAire() {
        return $this->longueur * $this->largeur;
    }
    
    public function calculerPerimetre() {
        return 2 * ($this->longueur + $this->largeur);
    }
}

class Cercle extends Forme {
    private $rayon;
    
    public function __construct($rayon) {
        $this->rayon = $rayon;
    }
    
    public function calculerAire() {
        return pi() * $this->rayon * $this->rayon;
    }
    
    public function calculerPerimetre() {
        return 2 * pi() * $this->rayon;
    }
}

$rectangle = new Rectangle(5, 3);
$rectangle->afficher();

$cercle = new Cercle(4);
$cercle->afficher();
```

## 10. Autoloading

Charger automatiquement les classes sans `require` manuel.

### PSR-4 Autoloading

**composer.json**
```json
{
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

**src/Utilisateur.php**
```php
<?php
namespace App;

class Utilisateur {
    private $nom;
    
    public function __construct($nom) {
        $this->nom = $nom;
    }
    
    public function getNom() {
        return $this->nom;
    }
}
```

**index.php**
```php
<?php
require 'vendor/autoload.php';

use App\Utilisateur;

$user = new Utilisateur("Alice");
echo $user->getNom();
```

### Autoloader simple (sans Composer)

```php
<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Maintenant on peut utiliser les classes sans require
$user = new Utilisateur("Alice");
```

## 11. Exemple pratique : Système de blog

```php
<?php
abstract class Post {
    protected $titre;
    protected $contenu;
    protected $auteur;
    protected $dateCreation;
    
    public function __construct($titre, $contenu, $auteur) {
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->dateCreation = new DateTime();
    }
    
    abstract public function afficher();
    
    public function getTitre() {
        return $this->titre;
    }
}

class Article extends Post {
    private $categorie;
    
    public function __construct($titre, $contenu, $auteur, $categorie) {
        parent::__construct($titre, $contenu, $auteur);
        $this->categorie = $categorie;
    }
    
    public function afficher() {
        echo "<article>";
        echo "<h2>{$this->titre}</h2>";
        echo "<p class='meta'>Par {$this->auteur} - {$this->dateCreation->format('d/m/Y')}</p>";
        echo "<p class='categorie'>Catégorie : {$this->categorie}</p>";
        echo "<div>{$this->contenu}</div>";
        echo "</article>";
    }
}

class Video extends Post {
    private $url;
    
    public function __construct($titre, $contenu, $auteur, $url) {
        parent::__construct($titre, $contenu, $auteur);
        $this->url = $url;
    }
    
    public function afficher() {
        echo "<article>";
        echo "<h2>{$this->titre}</h2>";
        echo "<p class='meta'>Par {$this->auteur}</p>";
        echo "<iframe src='{$this->url}'></iframe>";
        echo "<div>{$this->contenu}</div>";
        echo "</article>";
    }
}

// Utilisation
$article = new Article("Mon premier article", "Contenu...", "Alice", "Tech");
$article->afficher();

$video = new Video("Ma vidéo", "Description...", "Bob", "https://youtube.com/...");
$video->afficher();
```

## 12. Exercices pratiques

### Exercice 1 : Classe Personne

Créez une classe `Personne` avec :
- Propriétés : `nom`, `prenom`, `age`
- Constructeur
- Méthode `afficher()` qui affiche toutes les infos

### Exercice 2 : Compte bancaire

Créez une classe `CompteBancaire` avec :
- Propriété privée `solde`
- Méthodes : `deposer()`, `retirer()`, `getSolde()`
- Validation : ne pas retirer plus que le solde

### Exercice 3 : Héritage d'animaux

Créez :
- Classe abstraite `Animal` avec méthode abstraite `crier()`
- Classes `Chien`, `Chat`, `Vache` qui héritent et implémentent `crier()`

### Exercice 4 : Formes géométriques

Créez :
- Interface `Forme` avec `calculerAire()` et `calculerPerimetre()`
- Classes `Carre`, `Rectangle`, `Triangle` qui implémentent l'interface

## 13. Points clés à retenir

✅ **Classe** : Modèle définissant propriétés et méthodes  
✅ **Objet** : Instance d'une classe (`new`)  
✅ **`$this`** : Référence à l'instance actuelle  
✅ **Constructeur** : `__construct()` appelé à la création  
✅ **Visibilité** : `public`, `private`, `protected`  
✅ **Héritage** : `extends` pour réutiliser du code  
✅ **`parent::`** : Appeler la méthode/propriété parente  
✅ **`self::`** : Accéder aux membres statiques  
✅ **Interface** : Contrat que les classes doivent respecter  
✅ **Classe abstraite** : Ne peut pas être instanciée, peut avoir des méthodes abstraites  
✅ **Autoloading** : Charger automatiquement les classes

---

**Leçon précédente** : [Accès BD avec PDO](./12-pdo-bdd.md)  
**Prochaine leçon** : [Gestion des erreurs et debugging](./14-erreurs-debugging.md)
