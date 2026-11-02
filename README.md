# VERTEX EXPEDITION - Projet E-commerce

Boutique en ligne de sacs à dos et matériel de montagne.
Technologies : HTML, CSS, Bootstrap 5, JavaScript, PHP (PDO) et MySQL.

## Structure du projet

```
site_ecommerce/
├── config/
│   ├── db.php               # Connexion à la base de données
│   ├── header.php           # En-tête HTML et menu de navigation
│   ├── footer.php           # Pied de page
│   ├── functions.php        # Fonctions utiles (session, auth, sécurité)
│   ├── panier_fonctions.php # Fonctions de gestion du panier
│   ├── catalogue.php        # Récupération des produits en BDD
│   └── mail.php             # Envoi du mail de bienvenue
├── img/
├── assets/
├── index.php, apropos.php, articles.php, article.php
├── contact.php, inscription.php, connexion.php, deconnexion.php, panier.php
├── admin.php
└── mentions-legales.php
```

## Installation en local (Laragon)

1. Placer le projet dans `C:\laragon\www\site_ecommerce`.
2. Démarrer Apache et MySQL dans Laragon, puis ouvrir phpMyAdmin.
3. Créer une base de données `vertex_expedition` et importer le fichier `VERTEX_EXPEDITION.sql`.
4. Vérifier les identifiants dans `config/db.php` (par défaut `localhost`, `root`, mot de passe vide).
5. Ouvrir `http://localhost/site_ecommerce/`.

## Mise en ligne sur serveur

1. Créer la base MySQL sur l'hébergeur et importer `VERTEX_EXPEDITION.sql` via phpMyAdmin.
2. Envoyer les fichiers du site par FTP.
3. Mettre à jour les identifiants de connexion dans `config/db.php`.
