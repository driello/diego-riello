# 📚 M10-Cours programmation PHP - Sommaire



Ce cours vous accompagne de zéro jusqu'à la création d'applications web complètes et sécurisées. Chaque leçon contient des explications claires, des exemples de code commentés et des exercices pratiques.

---

## 🎯 Objectifs du cours

À la fin de ce cours, vous serez capable de :
- ✅ Maîtriser la syntaxe de base de PHP
- ✅ Créer des applications web dynamiques
- ✅ Gérer des formulaires et des sessions
- ✅ Interagir avec une base de données MySQL
- ✅ Développer en orienté objet
- ✅ Sécuriser vos applications
- ✅ Déployer vos projets en ligne

---

## 📖 Plan du cours

### 🔰 Partie 1 : Fondamentaux

1. **[Introduction et Installation](./01-introduction-installation.md)**
   - Qu'est-ce que PHP ?
   - Installation (XAMPP, Laragon)
   - Premier script PHP
   - Configuration de base

2. **[Syntaxe de base](./02-syntaxe-base.md)**
   - Balises PHP
   - Commentaires
   - Echo et print
   - Concaténation et interpolation

3. **[Variables et types](./03-variables-types.md)**
   - Déclaration de variables
   - Types scalaires (string, int, float, bool)
   - Type juggling et casting
   - Constantes

4. **[Opérateurs et expressions](./04-operateurs-expressions.md)**
   - Opérateurs arithmétiques
   - Opérateurs de comparaison
   - Opérateurs logiques
   - Opérateur ternaire et null coalescing

5. **[Structures de contrôle](./05-structures-controle.md)**
   - if / else / elseif
   - switch
   - Boucles (for, foreach, while, do-while)
   - break et continue

### 🛠️ Partie 2 : Structures de données et fonctions

6. **[Fonctions](./06-fonctions.md)**
   - Définition et appel
   - Paramètres et valeurs de retour
   - Portée des variables (scope)
   - Fonctions anonymes et fléchées

7. **[Tableaux](./07-tableaux.md)**
   - Tableaux indexés et associatifs
   - Tableaux multidimensionnels
   - Fonctions de manipulation (array_map, array_filter, etc.)

8. **[Chaînes de caractères](./08-chaines-caracteres.md)**
   - Manipulation de chaînes
   - Fonctions utiles (strlen, substr, str_replace, etc.)
   - Expressions régulières (aperçu)

### 🌐 Partie 3 : Web et bases de données

9. **[Superglobales et formulaires](./09-superglobaux-formulaires.md)**
   - $_GET, $_POST, $_SERVER, $_REQUEST
   - Validation de formulaires
   - Protection CSRF

10. **[Sessions et cookies](./10-sessions-cookies.md)**
    - Gestion des sessions
    - Authentification utilisateur
    - Cookies et "Remember me"

11. **[Fichiers et I/O](./11-fichiers-io.md)**
    - Lecture et écriture de fichiers
    - Upload de fichiers
    - Manipulation de CSV et JSON

12. **[PDO et bases de données](./12-pdo-bdd.md)**
    - Connexion avec PDO
    - Requêtes préparées
    - CRUD complet (Create, Read, Update, Delete)
    - Transactions

### 🏗️ Partie 4 : POO et concepts avancés

13. **[Programmation orientée objet (bases)](./13-poo-bases.md)**
    - Classes et objets
    - Propriétés et méthodes
    - Héritage et interfaces
    - Classes abstraites
    - Autoloading

14. **[Gestion des erreurs et debugging](./14-erreurs-debugging.md)**
    - Types d'erreurs
    - try/catch/finally
    - Exceptions personnalisées
    - Debugging avec var_dump, print_r, Xdebug
    - Logging

### 🔒 Partie 5 : Sécurité et déploiement

15. **[Sécurité essentielle](./15-securite.md)**
    - Protection contre les injections SQL
    - Prévention XSS (htmlspecialchars)
    - Protection CSRF
    - Hachage de mots de passe (password_hash)
    - Validation et filtrage des données
    - Sécurité des sessions et uploads

16. **[Déploiement minimal](./16-deploiement.md)**
    - Hébergeurs (mutualisé, VPS, cloud)
    - Configuration Apache (.htaccess)
    - Configuration Nginx
    - Introduction à Composer
    - Variables d'environnement (.env)
    - SSL avec Let's Encrypt

### 🎓 Partie 6 : Pratique et ressources

17. **[Exercices et corrigés](./17-exercices-corriges.md)**
    - Formulaire de contact complet
    - Système d'authentification
    - Application CRUD (gestion de tâches)
    - Solutions détaillées

18. **[Ressources et suite](./18-ressources.md)**
    - Documentation officielle
    - Livres recommandés
    - Cours en ligne
    - Frameworks (Laravel, Symfony, Slim)
    - Outils de développement
    - Communautés et forums
    - Projets pratiques pour progresser

---

## 🚀 Comment utiliser ce cours ?

### Parcours recommandé

1. **Suivez l'ordre des leçons** - Le cours est progressif
2. **Pratiquez chaque concept** - Testez tous les exemples
3. **Faites les exercices** - Ils consolident vos acquis
4. **Créez vos propres projets** - C'est la meilleure façon d'apprendre
5. **Revenez sur les leçons** - Relisez quand nécessaire

### Prérequis

- 💻 Un ordinateur (Windows, macOS ou Linux)
- 🌐 Des bases en HTML/CSS (recommandé mais pas obligatoire)
- 🧠 De la curiosité et de la motivation !

### Durée estimée

- ⏱️ **Lecture du cours** : 15-20 heures
- 🛠️ **Pratique et exercices** : 30-40 heures
- 🎯 **Total pour maîtriser les bases** : ~50-60 heures

---

## 📝 Conventions utilisées

### Symboles

- ✅ Point important à retenir
- ❌ Erreur à éviter
- 💡 Astuce ou conseil
- ⚠️ Attention
- 📦 Package ou outil
- 🔒 Sécurité
- ⚡ Performance

### Code

Les exemples de code sont présentés avec la syntaxe complète :

```php
<?php
// Ceci est un exemple de code
echo "Hello World!";
?>
```

Les commentaires expliquent chaque partie importante.

---

## 🎯 Après ce cours

Une fois ce cours terminé, vous pourrez :

### 1. Créer des projets complets
- Sites web dynamiques
- Applications CRUD
- Systèmes d'authentification
- Formulaires complexes

### 2. Continuer votre apprentissage
- **Frameworks** : Laravel, Symfony
- **Tests** : PHPUnit, TDD
- **APIs REST** : Création et consommation
- **DevOps** : Docker, CI/CD

### 3. Contribuer et apprendre des autres
- Lire du code open source
- Contribuer sur GitHub
- Participer aux communautés

---

## 📚 Structure d'une leçon type

Chaque leçon contient :

1. **Introduction** - Contexte et objectifs
2. **Concepts théoriques** - Explications claires
3. **Exemples commentés** - Code complet et fonctionnel
4. **Bonnes pratiques** - Ce qu'il faut faire/éviter
5. **Exercices pratiques** - Pour s'entraîner
6. **Points clés à retenir** - Résumé de la leçon
7. **Navigation** - Liens vers leçons précédente/suivante

---

## 🛠️ Configuration recommandée

### Environnement de développement

**Option 1 : XAMPP** (Windows, macOS, Linux)
- Facile à installer
- Interface graphique
- Apache + MySQL + PHP inclus

**Option 2 : Laragon** (Windows uniquement)
- Moderne et rapide
- Gestion facile des versions
- Intégration Composer, Node.js

**Option 3 : Installation manuelle**
- PHP 8.0+
- Apache ou Nginx
- MySQL 8.0+ ou MariaDB
- Composer

### Éditeur de code

**Visual Studio Code** (recommandé)
- Gratuit et performant
- Extensions PHP excellentes
- Débogage intégré

**Extensions VS Code recommandées** :
- PHP Intelephense
- PHP Debug
- PHP Namespace Resolver
- Better Comments

---

## 💪 Conseils pour réussir

### Do's ✅
- Pratiquez tous les jours, même 30 minutes
- Testez chaque exemple de code
- Créez vos propres variations
- Cherchez à comprendre, pas à mémoriser
- Posez des questions sur les forums
- Lisez la documentation officielle
- Faites des erreurs et apprenez d'elles

### Don'ts ❌
- Ne copiez pas sans comprendre
- N'essayez pas d'apprendre trop vite
- Ne négligez pas la sécurité
- Ne sautez pas les exercices
- N'abandonnez pas face aux erreurs
- Ne comparez pas votre progression à celle des autres

---

## 🆘 Besoin d'aide ?

### Ressources d'aide

- 📖 **Documentation PHP** : [php.net](https://www.php.net/)
- 💬 **Stack Overflow** : [stackoverflow.com/questions/tagged/php](https://stackoverflow.com/questions/tagged/php)
- 🎓 **OpenClassrooms** : Forums d'entraide en français
- 📺 **Grafikart** : Tutoriels vidéo en français

### Erreurs courantes

Les débutants rencontrent souvent :
- Oubli du point-virgule `;`
- Balises PHP manquantes `<?php ?>`
- Variables mal nommées (`$nom_variable` pas `$Nom Variable`)
- Sessions non démarrées (`session_start()`)
- Erreurs de connexion PDO
- Oubli de `htmlspecialchars()` → XSS

Consultez la **[Leçon 14](./14-erreurs-debugging.md)** pour le debugging.

---

## 🎓 Certification et portfolio

### Créez votre portfolio

À mesure que vous progressez, créez un portfolio avec :
- ✅ Vos projets personnels
- ✅ Code source sur GitHub
- ✅ Démos en ligne
- ✅ Documentation de vos projets

### Suggestions de projets

**Débutant** :
- Formulaire de contact
- Livre d'or
- Calculatrice

**Intermédiaire** :
- Blog avec commentaires
- Gestionnaire de tâches
- Galerie de photos

**Avancé** :
- Réseau social simplifié
- Plateforme e-commerce
- API REST complète

---

## 📜 Licence et utilisation



✅ Vous pouvez :
- Utiliser ce cours pour apprendre
- Partager les liens vers les leçons
- Vous en inspirer pour vos projets

❌ Merci de ne pas :
- Republier ce contenu comme le vôtre
- Utiliser ce contenu à des fins commerciales sans autorisation

---

## 🙏 Remerciements

Si vous avez des suggestions, des corrections ou des questions :
- Consultez d'abord la **[Leçon 18 - Ressources](./18-ressources.md)**
- Posez vos questions sur les forums PHP
- Partagez vos réussites avec la communauté

---

## 🚀 Prêt à commencer ?

**Commencez par la première leçon** :

👉 **[Leçon 1 : Introduction et Installation](./01-introduction-installation.md)**

---

**Bon courage et bon code ! 💻✨**
