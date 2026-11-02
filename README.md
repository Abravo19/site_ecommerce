# VERTEX EXPEDITION — site e-commerce (BTS SIO SLAM)

Site e-commerce de sacs à dos techniques et d'équipement de montagne.
HTML / CSS / Bootstrap 5 / JavaScript / PHP (PDO) / MySQL.

## Structure du projet

```
e-commerce/
├── config/
│   ├── db.php               ← connexion BDD (SEUL fichier à modifier par environnement)
│   ├── header.php           ← <head> + barre de navigation (connexion / panier)
│   ├── footer.php
│   ├── functions.php        ← session, authentification, CSRF, messages flash
│   ├── panier_fonctions.php ← logique du panier (session)
│   ├── catalogue.php        ← chargement des articles depuis la BDD
│   └── mail.php             ← mail d'inscription (mail())
├── img/ (logo.png, favicon.svg, articles/, equipe/)
├── assets/ (css/style.css, js/main.js)
├── index.php  apropos.php  articles.php  article.php
├── contact.php  inscription.php  connexion.php  deconnexion.php  panier.php
└── mentions-legales.php
```

## Installation locale (Laragon 8.1.0)

1. Copier le dossier du projet dans `C:\laragon\www\e-commerce`.
2. Démarrer Laragon (Apache + MySQL), ouvrir phpMyAdmin (ou HeidiSQL).
3. Créer une base `vertex_expedition`.
4. Dans cette base, importer `VERTEX_EXPEDITION.sql`.
5. `config/db.php` : par défaut `localhost` / `root` / mot de passe vide (valeurs Laragon).
6. Ouvrir http://localhost/e-commerce/

## Déploiement sur l'hébergement

1. Créer une base MySQL et un utilisateur dans le panneau d'hébergement ; noter le nom exact de la base, l'utilisateur, le mot de passe.
2. phpMyAdmin de l'hébergeur : sélectionner la base, importer `VERTEX_EXPEDITION.sql`.
3. Envoyer tous les fichiers (sauf `.git`) dans le dossier web du site (gestionnaire de fichiers ou FTP).
4. Modifier **uniquement** `config/db.php` sur le serveur (hôte, nom de base, utilisateur, mot de passe).
5. Vérifier : pages, ajout au panier, inscription, connexion, console du navigateur sans erreur.

> Ne pas pousser sur GitHub le `config/db.php` contenant les identifiants de l'hébergeur.

## Sécurité

- Requêtes préparées PDO partout , `ATTR_EMULATE_PREPARES` désactivé.
- Mots de passe : SHA-256 avec sel aléatoire par utilisateur.
- Jeton CSRF sur tous les formulaires, échappement HTML (`e()`), redirections limitées aux pages internes.
