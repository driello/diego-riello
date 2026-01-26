# Leçon 14 : Gestion des erreurs et debugging

## 1. Types d'erreurs en PHP

PHP distingue plusieurs niveaux d'erreurs :

| Niveau | Description | Exemple |
|--------|-------------|---------|
| `E_ERROR` | Erreur fatale, arrête l'exécution | Appel de fonction inexistante |
| `E_WARNING` | Avertissement, continue l'exécution | `fopen()` sur fichier inexistant |
| `E_NOTICE` | Notice, erreur mineure | Variable non définie |
| `E_PARSE` | Erreur de syntaxe | Oubli d'un `;` |
| `E_STRICT` | Suggestions pour améliorer le code | - |
| `E_DEPRECATED` | Fonctionnalité obsolète | Utilisation de fonctions dépréciées |

## 2. Configuration de l'affichage des erreurs

### En développement

```php
<?php
// Afficher toutes les erreurs
ini_set('display_errors', '1');
error_reporting(E_ALL);
```

### En production

```php
<?php
// Cacher les erreurs, mais les logger
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', '/path/to/error.log');
error_reporting(E_ALL);
```

### Dans php.ini

```ini
; Développement
display_errors = On
error_reporting = E_ALL

; Production
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log
```

## 3. Gestion personnalisée des erreurs

### `set_error_handler()`

```php
<?php
function gestionnaireErreurs($niveau, $message, $fichier, $ligne) {
    $types = [
        E_ERROR => 'Erreur',
        E_WARNING => 'Avertissement',
        E_NOTICE => 'Notice',
    ];
    
    $type = $types[$niveau] ?? 'Erreur inconnue';
    
    echo "<div style='color:red;'>";
    echo "<strong>$type</strong> : $message<br>";
    echo "Fichier : $fichier, Ligne : $ligne";
    echo "</div>";
    
    // Logger l'erreur
    error_log("[$type] $message in $fichier:$ligne");
    
    return true; // Empêche le gestionnaire par défaut
}

set_error_handler('gestionnaireErreurs');

// Test
echo $variableInexistante; // Déclenchera notre gestionnaire personnalisé
```

## 4. Exceptions

Les **exceptions** permettent une gestion structurée des erreurs.

### Lancer une exception

```php
<?php
function diviser($a, $b) {
    if ($b == 0) {
        throw new Exception("Division par zéro impossible");
    }
    return $a / $b;
}

try {
    echo diviser(10, 2); // 5
    echo diviser(10, 0); // Déclenche une exception
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
```

### Blocs try, catch, finally

```php
<?php
try {
    // Code susceptible de générer une exception
    $fichier = fopen('inexistant.txt', 'r');
    if (!$fichier) {
        throw new Exception("Impossible d'ouvrir le fichier");
    }
    
} catch (Exception $e) {
    // Gestion de l'erreur
    echo "Erreur : " . $e->getMessage();
    
} finally {
    // Toujours exécuté, même en cas d'exception
    echo "Nettoyage...";
}
```

### Exceptions personnalisées

```php
<?php
class ValidationException extends Exception {
    private $champ;
    
    public function __construct($message, $champ) {
        parent::__construct($message);
        $this->champ = $champ;
    }
    
    public function getChamp() {
        return $this->champ;
    }
}

function validerEmail($email) {
    if (empty($email)) {
        throw new ValidationException("L'email est obligatoire", "email");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException("L'email est invalide", "email");
    }
    
    return true;
}

try {
    validerEmail("email_invalide");
} catch (ValidationException $e) {
    echo "Erreur de validation sur le champ '{$e->getChamp()}' : {$e->getMessage()}";
}
```

### Capturer plusieurs types d'exceptions

```php
<?php
try {
    // Code...
} catch (ValidationException $e) {
    echo "Erreur de validation : " . $e->getMessage();
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur générale : " . $e->getMessage();
}
```

### PHP 7+ : Captures multiples

```php
<?php
try {
    // Code...
} catch (ValidationException | DatabaseException $e) {
    echo "Erreur : " . $e->getMessage();
}
```

## 5. Méthodes utiles des exceptions

```php
<?php
try {
    throw new Exception("Message d'erreur");
} catch (Exception $e) {
    echo $e->getMessage();    // Message d'erreur
    echo $e->getCode();       // Code d'erreur (0 par défaut)
    echo $e->getFile();       // Fichier où l'exception a été levée
    echo $e->getLine();       // Numéro de ligne
    echo $e->getTrace();      // Trace d'exécution (tableau)
    echo $e->getTraceAsString(); // Trace en chaîne
}
```

## 6. Debugging avec `var_dump()` et `print_r()`

### `var_dump()` : Affiche le type et la valeur

```php
<?php
$nombre = 42;
$tableau = ['a', 'b', 'c'];
$objet = new stdClass();

var_dump($nombre);  // int(42)
var_dump($tableau); // array(3) { [0]=> string(1) "a" ... }
var_dump($objet);   // object(stdClass)#1 (0) {}
```

### `print_r()` : Affichage plus lisible

```php
<?php
$tableau = ['nom' => 'Alice', 'age' => 30];
print_r($tableau);
// Array
// (
//     [nom] => Alice
//     [age] => 30
// )
```

### Afficher proprement dans le navigateur

```php
<?php
echo "<pre>";
print_r($tableau);
echo "</pre>";
```

## 7. Debugging avancé

### `debug_backtrace()` : Trace d'appels

```php
<?php
function niveau3() {
    print_r(debug_backtrace());
}

function niveau2() {
    niveau3();
}

function niveau1() {
    niveau2();
}

niveau1();
// Affiche la pile d'appels : niveau1 -> niveau2 -> niveau3
```

### `debug_print_backtrace()` : Version formatée

```php
<?php
function test() {
    debug_print_backtrace();
}

test();
```

### Arrêter l'exécution

```php
<?php
$variable = "test";
var_dump($variable);
die(); // ou exit();

echo "Ce code ne sera jamais exécuté";
```

## 8. Logger les erreurs

### Fonction `error_log()`

```php
<?php
// Écrire dans le log système
error_log("Erreur personnalisée");

// Écrire dans un fichier spécifique
error_log("Erreur : utilisateur non trouvé", 3, "/var/log/app.log");

// Envoyer par email
error_log("Erreur critique !", 1, "admin@example.com");
```

### Classe Logger personnalisée

```php
<?php
class Logger {
    private $logFile;
    
    public function __construct($logFile) {
        $this->logFile = $logFile;
    }
    
    public function log($niveau, $message) {
        $date = date('Y-m-d H:i:s');
        $ligne = "[$date] [$niveau] $message\n";
        file_put_contents($this->logFile, $ligne, FILE_APPEND);
    }
    
    public function info($message) {
        $this->log('INFO', $message);
    }
    
    public function warning($message) {
        $this->log('WARNING', $message);
    }
    
    public function error($message) {
        $this->log('ERROR', $message);
    }
}

// Utilisation
$logger = new Logger('app.log');
$logger->info("Application démarrée");
$logger->error("Erreur lors de la connexion à la base de données");
```

## 9. Xdebug (extension de debugging)

### Installation

```bash
# Debian/Ubuntu
sudo apt install php-xdebug

# Via PECL
pecl install xdebug
```

### Configuration (php.ini)

```ini
[xdebug]
zend_extension=xdebug.so
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
```

### Fonctionnalités

- **Breakpoints** : Arrêter l'exécution à des points précis
- **Step debugging** : Exécuter le code ligne par ligne
- **Inspection de variables** : Voir les valeurs en temps réel
- **Call stack** : Visualiser la pile d'appels
- **Code coverage** : Analyser les tests

### Fonction `xdebug_break()`

```php
<?php
$total = 0;
for ($i = 0; $i < 10; $i++) {
    $total += $i;
    if ($i == 5) {
        xdebug_break(); // Breakpoint programmatique
    }
}
```

## 10. Assertions

Les **assertions** vérifient des conditions pendant le développement.

```php
<?php
// Activer les assertions
ini_set('assert.active', '1');
ini_set('assert.exception', '1'); // Lever une exception si faux

function diviser($a, $b) {
    assert($b != 0, "Le diviseur ne peut pas être zéro");
    return $a / $b;
}

try {
    echo diviser(10, 0);
} catch (AssertionError $e) {
    echo "Assertion échouée : " . $e->getMessage();
}
```

## 11. Exemple pratique : Gestionnaire d'erreurs global

```php
<?php
class ErrorHandler {
    private $logFile;
    
    public function __construct($logFile) {
        $this->logFile = $logFile;
        
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }
    
    public function handleError($niveau, $message, $fichier, $ligne) {
        $this->log("ERROR", "$message in $fichier:$ligne");
        
        if (ini_get('display_errors')) {
            echo "<div style='color:red; padding:10px; border:1px solid red;'>";
            echo "<strong>Erreur</strong> : $message<br>";
            echo "Fichier : $fichier, Ligne : $ligne";
            echo "</div>";
        }
        
        return true;
    }
    
    public function handleException($exception) {
        $this->log("EXCEPTION", $exception->getMessage() . " in " . 
                   $exception->getFile() . ":" . $exception->getLine());
        
        if (ini_get('display_errors')) {
            echo "<div style='color:red; padding:10px; border:2px solid red;'>";
            echo "<strong>Exception non capturée</strong><br>";
            echo $exception->getMessage() . "<br>";
            echo "Fichier : " . $exception->getFile() . ", Ligne : " . $exception->getLine();
            echo "</div>";
        } else {
            echo "Une erreur est survenue. Veuillez contacter l'administrateur.";
        }
    }
    
    public function handleShutdown() {
        $error = error_get_last();
        
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR])) {
            $this->log("FATAL", $error['message'] . " in " . 
                       $error['file'] . ":" . $error['line']);
        }
    }
    
    private function log($niveau, $message) {
        $date = date('Y-m-d H:i:s');
        $ligne = "[$date] [$niveau] $message\n";
        file_put_contents($this->logFile, $ligne, FILE_APPEND);
    }
}

// Initialisation
$errorHandler = new ErrorHandler('errors.log');

// Test
throw new Exception("Ceci est une exception de test");
```

## 12. Exercices pratiques

### Exercice 1 : Gestionnaire d'erreurs simple

Créez un gestionnaire d'erreurs personnalisé qui affiche les erreurs avec un style CSS.

### Exercice 2 : Validation avec exceptions

Créez une fonction qui valide un formulaire d'inscription et lève des exceptions personnalisées pour chaque erreur.

### Exercice 3 : Logger

Créez une classe `Logger` avec les méthodes `debug()`, `info()`, `warning()`, `error()` et `critical()`.

### Exercice 4 : Try-Catch

Créez une fonction qui lit un fichier et gère les erreurs avec try-catch.

## 13. Points clés à retenir

✅ **Affichage** : `display_errors = On` en développement, `Off` en production  
✅ **Error reporting** : `error_reporting(E_ALL)` pour tout afficher  
✅ **Exceptions** : `throw new Exception()`, `try/catch/finally`  
✅ **Exceptions personnalisées** : Hériter de `Exception`  
✅ **Debugging** : `var_dump()`, `print_r()`, `debug_backtrace()`  
✅ **Logging** : `error_log()` ou classe Logger personnalisée  
✅ **Xdebug** : Extension puissante pour le debugging avancé  
✅ **Gestionnaires** : `set_error_handler()`, `set_exception_handler()`  
✅ **Production** : Logger les erreurs, ne jamais les afficher à l'utilisateur  
✅ **Méthodes** : `getMessage()`, `getFile()`, `getLine()`, `getTrace()`

---

**Leçon précédente** : [POO (bases)](./13-poo-bases.md)  
**Prochaine leçon** : [Sécurité essentielle](./15-securite.md)
