CREATE DATABASE IF NOT EXISTS vertex_expedition
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE vertex_expedition;

SET NAMES utf8mb4;


CREATE TABLE discipline (
    id_discipline   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle         VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE categorie (
    id_categorie    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code            VARCHAR(30)  NOT NULL UNIQUE,   -- ex: 'expedition', 'fastpacking'
    libelle         VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE couleur (
    id_couleur      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_couleur     VARCHAR(50) NOT NULL UNIQUE,
    code_hexa       CHAR(7) NULL                    -- ex: '#1A1A1A'
) ENGINE=InnoDB;

CREATE TABLE client (
    id_client               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom                     VARCHAR(100) NOT NULL,
    prenom                  VARCHAR(100) NOT NULL,
    pseudo                  VARCHAR(50)  NULL,
    email                   VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe_hash       VARCHAR(255) NOT NULL,
    sel_mdp                 VARCHAR(64)  NULL,       -- requis seulement si SHA-256 (voir note en tête de fichier)
    id_discipline           INT UNSIGNED NOT NULL,
    consentement_newsletter TINYINT(1) NOT NULL DEFAULT 0,
    date_inscription        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role                    ENUM('client','admin') NOT NULL DEFAULT 'client',
    CONSTRAINT fk_client_discipline
        FOREIGN KEY (id_discipline) REFERENCES discipline(id_discipline)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE adresse (
    id_adresse      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_client       INT UNSIGNED NOT NULL,
    type_adresse    ENUM('livraison','facturation') NOT NULL DEFAULT 'livraison',
    rue             VARCHAR(200) NOT NULL,
    complement      VARCHAR(200) NULL,
    code_postal     VARCHAR(10)  NOT NULL,
    ville           VARCHAR(100) NOT NULL,
    pays            VARCHAR(100) NOT NULL DEFAULT 'France',
    telephone       VARCHAR(20)  NULL,
    CONSTRAINT fk_adresse_client
        FOREIGN KEY (id_client) REFERENCES client(id_client)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE produit (
    id_produit          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_categorie        INT UNSIGNED NOT NULL,
    reference           VARCHAR(30)  NOT NULL UNIQUE,
    slug                VARCHAR(150) NOT NULL UNIQUE,
    nom                 VARCHAR(150) NOT NULL,
    tag                 VARCHAR(100) NULL,
    badge               VARCHAR(100) NULL,
    prix                DECIMAL(10,2) NOT NULL,
    prix_promo          DECIMAL(10,2) NULL,
    volume_litres       SMALLINT UNSIGNED NULL,
    poids_grammes       SMALLINT UNSIGNED NULL,
    materiau            VARCHAR(150) NULL,
    etancheite          VARCHAR(100) NULL,
    usage_temperature   VARCHAR(100) NULL,
    image_principale    VARCHAR(255) NULL,
    description_courte  TEXT NULL,
    description_longue  TEXT NULL,
    note_moyenne        DECIMAL(2,1) NOT NULL DEFAULT 0,
    nombre_avis         INT UNSIGNED NOT NULL DEFAULT 0,
    quantite_stock      INT UNSIGNED NOT NULL DEFAULT 0,
    date_creation       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produit_categorie
        FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT chk_produit_prix CHECK (prix >= 0),
    CONSTRAINT chk_produit_prix_promo CHECK (prix_promo IS NULL OR prix_promo >= 0),
    CONSTRAINT chk_produit_note CHECK (note_moyenne BETWEEN 0 AND 5)
) ENGINE=InnoDB;

CREATE INDEX idx_produit_categorie ON produit(id_categorie);
CREATE INDEX idx_produit_prix ON produit(prix);

CREATE TABLE caracteristique_produit (
    id_caracteristique  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_produit          INT UNSIGNED NOT NULL,
    libelle_cle         VARCHAR(100) NOT NULL,     -- ex: 'Armature'
    valeur              VARCHAR(255) NOT NULL,     -- ex: 'Tubulaire aluminium 7075 démontable'
    CONSTRAINT fk_caracteristique_produit
        FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE produit_couleur (
    id_produit  INT UNSIGNED NOT NULL,
    id_couleur  INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_produit, id_couleur),
    CONSTRAINT fk_prodcoul_produit
        FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_prodcoul_couleur
        FOREIGN KEY (id_couleur) REFERENCES couleur(id_couleur)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE panier (
    id_panier       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_client       INT UNSIGNED NOT NULL UNIQUE,   -- un panier actif par client
    date_creation   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_panier_client
        FOREIGN KEY (id_client) REFERENCES client(id_client)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE ligne_panier (
    id_ligne_panier INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_panier       INT UNSIGNED NOT NULL,
    id_produit      INT UNSIGNED NOT NULL,
    id_couleur      INT UNSIGNED NULL,
    quantite        SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    CONSTRAINT fk_lignepanier_panier
        FOREIGN KEY (id_panier) REFERENCES panier(id_panier)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_lignepanier_produit
        FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_lignepanier_couleur
        FOREIGN KEY (id_couleur) REFERENCES couleur(id_couleur)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT chk_lignepanier_quantite CHECK (quantite > 0),
    UNIQUE (id_panier, id_produit, id_couleur)
) ENGINE=InnoDB;


CREATE TABLE commande (
    id_commande     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_client       INT UNSIGNED NOT NULL,
    id_adresse      INT UNSIGNED NOT NULL,
    date_commande   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut          ENUM('en_attente','payee','expediee','livree','annulee') NOT NULL DEFAULT 'en_attente',
    montant_total   DECIMAL(10,2) NOT NULL DEFAULT 0,
    CONSTRAINT fk_commande_client
        FOREIGN KEY (id_client) REFERENCES client(id_client)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_commande_adresse
        FOREIGN KEY (id_adresse) REFERENCES adresse(id_adresse)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT chk_commande_montant CHECK (montant_total >= 0)
) ENGINE=InnoDB;

CREATE INDEX idx_commande_client ON commande(id_client);

CREATE TABLE ligne_commande (
    id_ligne_commande   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_commande         INT UNSIGNED NOT NULL,
    id_produit          INT UNSIGNED NOT NULL,
    id_couleur          INT UNSIGNED NULL,
    quantite            SMALLINT UNSIGNED NOT NULL,
    prix_unitaire       DECIMAL(10,2) NOT NULL,     -- prix figé au moment de l'achat (ne pas relire produit.prix a posteriori)
    CONSTRAINT fk_lignecommande_commande
        FOREIGN KEY (id_commande) REFERENCES commande(id_commande)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_lignecommande_produit
        FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_lignecommande_couleur
        FOREIGN KEY (id_couleur) REFERENCES couleur(id_couleur)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT chk_lignecommande_quantite CHECK (quantite > 0),
    CONSTRAINT chk_lignecommande_prix CHECK (prix_unitaire >= 0)
) ENGINE=InnoDB;

CREATE TABLE avis (
    id_avis         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_produit      INT UNSIGNED NOT NULL,
    id_client       INT UNSIGNED NOT NULL,
    note            TINYINT UNSIGNED NOT NULL,
    commentaire     TEXT NULL,
    date_avis       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_avis_produit
        FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_avis_client
        FOREIGN KEY (id_client) REFERENCES client(id_client)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT chk_avis_note CHECK (note BETWEEN 1 AND 5),
    UNIQUE (id_produit, id_client)   -- un seul avis par client et par produit
) ENGINE=InnoDB;


INSERT INTO categorie (code, libelle) VALUES
    ('expedition',  "Sacs d'Expédition"),
    ('fastpacking',  'Fastpacking & Trail'),
    ('voyage',       'Sacs Duffel Étanche'),
    ('refuge',       'Abris & Bivouac');

INSERT INTO discipline (libelle) VALUES
    ('Alpinisme & Haute Montagne'),
    ('Fastpacking, Trail & Randonnée rapide'),
    ('Expéditions & Trekking engagé'),
    ('Voyage & Aventure en autonomie'),
    ("Bivouac & Camp d'altitude");

CREATE USER IF NOT EXISTS 'vertex_app'@'localhost' IDENTIFIED BY 'CHANGE_ME_STRONG_PASSWORD';

GRANT SELECT, INSERT, UPDATE, DELETE ON vertex_expedition.* TO 'vertex_app'@'localhost';

REVOKE FILE, PROCESS, SUPER, CREATE, DROP, ALTER, GRANT OPTION ON *.* FROM 'vertex_app'@'localhost';

FLUSH PRIVILEGES;

