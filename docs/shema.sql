
CREATE TYPE role_utilisateur AS ENUM ('ADMIN', 'VENTE', 'STOCK', 'INVENTAIRE');
CREATE TYPE statut_appro AS ENUM ('EN_COURS', 'RECU', 'PARTIEL');
CREATE TYPE statut_dette AS ENUM ('NON_SOLDEE', 'PARTIELLEMENT_SOLDEE', 'SOLDEE');
CREATE TYPE mode_paiement AS ENUM ('Wave', 'Orange Money', 'Especes', 'Virement');


CREATE TABLE utilisateurs (
    id              SERIAL PRIMARY KEY,
    email           VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(100) NOT NULL,
    role            role_utilisateur NOT NULL
    );

CREATE TABLE clients (
    id              SERIAL PRIMARY KEY,
    prenom          VARCHAR(100) NOT NULL,
    nom             VARCHAR(100) NOT NULL,
    telephone       VARCHAR(30) NOT NULL,
    email           VARCHAR(50) NOT NULL,
    limite_credit   NUMERIC(12, 2) NOT NULL DEFAULT 0 CHECK (limite_credit >= 0)
);


CREATE TABLE fournisseurs (
    id              SERIAL PRIMARY KEY,
    nom             VARCHAR(150) NOT NULL,
    telephone       VARCHAR(30) NOT NULL,
    adresse         VARCHAR(50) NOT NULL,
    email           VARCHAR(50) 
);


CREATE TABLE produits (
    id              SERIAL PRIMARY KEY,
    nom             VARCHAR(50) NOT NULL,
    prix_vente      NUMERIC(12, 2) NOT NULL CHECK (prix_vente >= 0),
    quantite_stock  INTEGER NOT NULL DEFAULT 0 CHECK (quantite_stock >= 0)
    );


CREATE TABLE commandes (
    id              SERIAL PRIMARY KEY,
    client_id       INTEGER NOT NULL REFERENCES clients(id),
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id),
    date_creation   DATE NOT NULL DEFAULT CURRENT_DATE,
    montant_total   NUMERIC(12, 2) NOT NULL CHECK (montant_total >= 0),
    montant_verse   NUMERIC(12, 2) NOT NULL DEFAULT 0 CHECK (montant_verse >= 0),
    mode_reglement  mode_paiement NOT NULL
);

CREATE TABLE lignes_commande (
    id              SERIAL PRIMARY KEY,
    commande_id     INTEGER NOT NULL REFERENCES commandes(id),
    produit_id      INTEGER NOT NULL REFERENCES produits(id),
    quantite        INTEGER NOT NULL CHECK (quantite > 0),
    prix_unitaire   NUMERIC(12, 2) NOT NULL CHECK (prix_unitaire >= 0)
);


CREATE TABLE dettes (
    id              SERIAL PRIMARY KEY,
    commande_id     INTEGER NOT NULL UNIQUE REFERENCES commandes(id),
    client_id       INTEGER NOT NULL REFERENCES clients(id),
    date_creation   DATE NOT NULL DEFAULT CURRENT_DATE,
    montant_initial NUMERIC(12, 2) NOT NULL CHECK (montant_initial >= 0),
    statut          statut_dette NOT NULL DEFAULT 'NON_SOLDEE'
);

CREATE TABLE paiements (
    id              SERIAL PRIMARY KEY,
    dette_id        INTEGER NOT NULL REFERENCES dettes(id),
    date_paiement   DATE NOT NULL DEFAULT CURRENT_DATE,
    montant         NUMERIC(12, 2) NOT NULL CHECK (montant > 0),
    mode_paiement   mode_paiement NOT NULL
);


CREATE TABLE approvisionnements (
    id              SERIAL PRIMARY KEY,
    fournisseur_id  INTEGER NOT NULL REFERENCES fournisseurs(id),
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id),
    reference_bl    VARCHAR(50) NOT NULL UNIQUE,
    date_commande   DATE NOT NULL DEFAULT CURRENT_DATE,
    date_reception  DATE,
    statut          statut_appro NOT NULL DEFAULT 'EN_COURS'
);

CREATE TABLE lignes_approvisionnement (
    id                  SERIAL PRIMARY KEY,
    approvisionnement_id INTEGER NOT NULL REFERENCES approvisionnements(id),
    produit_id          INTEGER NOT NULL REFERENCES produits(id),
    quantite_commandee  INTEGER NOT NULL CHECK (quantite_commandee > 0),
    quantite_recue      INTEGER CHECK (quantite_recue >= 0),
    cout_unitaire       NUMERIC(12, 2) NOT NULL CHECK (cout_unitaire >= 0)
);


