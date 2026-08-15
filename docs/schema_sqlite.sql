
PRAGMA foreign_keys = ON;


CREATE TABLE utilisateurs (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    nom             TEXT NOT NULL,
    email           TEXT NOT NULL UNIQUE,
    mot_de_passe    TEXT NOT NULL,
    role            TEXT NOT NULL CHECK (role IN ('ADMIN', 'VENTE', 'STOCK', 'INVENTAIRE')),
    cree_le         TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE clients (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    prenom          TEXT NOT NULL,
    nom             TEXT NOT NULL,
    telephone       TEXT NOT NULL,
    email           TEXT,
    limite_credit   NUMERIC NOT NULL DEFAULT 0 CHECK (limite_credit >= 0),
    cree_le         TEXT NOT NULL DEFAULT (datetime('now'))
);


CREATE TABLE fournisseurs (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    nom             TEXT NOT NULL,
    telephone       TEXT NOT NULL,
    adresse         TEXT NOT NULL,
    email           TEXT,
    cree_le         TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE produits (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    nom             TEXT NOT NULL,
    prix_vente      NUMERIC NOT NULL CHECK (prix_vente >= 0),
    quantite_stock  INTEGER NOT NULL DEFAULT 0 CHECK (quantite_stock >= 0),
    cree_le         TEXT NOT NULL DEFAULT (datetime('now'))
);


CREATE TABLE commandes (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id       INTEGER NOT NULL REFERENCES clients(id),
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id),
    date_creation   TEXT NOT NULL DEFAULT (datetime('now')),
    montant_total   NUMERIC NOT NULL CHECK (montant_total >= 0),
    montant_verse   NUMERIC NOT NULL DEFAULT 0 CHECK (montant_verse >= 0),
    mode_reglement  TEXT NOT NULL CHECK (mode_reglement IN ('Wave', 'Orange Money', 'Especes', 'Virement'))
);

CREATE TABLE lignes_commande (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    commande_id     INTEGER NOT NULL REFERENCES commandes(id) ON DELETE CASCADE,
    produit_id      INTEGER NOT NULL REFERENCES produits(id),
    quantite        INTEGER NOT NULL CHECK (quantite > 0),
    prix_unitaire   NUMERIC NOT NULL CHECK (prix_unitaire >= 0)
);


CREATE TABLE dettes (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    commande_id     INTEGER NOT NULL UNIQUE REFERENCES commandes(id),
    client_id       INTEGER NOT NULL REFERENCES clients(id),
    date_creation   TEXT NOT NULL DEFAULT (datetime('now')),
    montant_initial NUMERIC NOT NULL CHECK (montant_initial >= 0),
    statut          TEXT NOT NULL DEFAULT 'NON_SOLDEE'
                    CHECK (statut IN ('NON_SOLDEE', 'PARTIELLEMENT_SOLDEE', 'SOLDEE'))
);

CREATE TABLE paiements (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    dette_id        INTEGER NOT NULL REFERENCES dettes(id) ON DELETE CASCADE,
    date_paiement   TEXT NOT NULL DEFAULT (datetime('now')),
    montant         NUMERIC NOT NULL CHECK (montant > 0),
    mode_paiement   TEXT NOT NULL CHECK (mode_paiement IN ('Wave', 'Orange Money', 'Especes', 'Virement'))
);

CREATE TABLE approvisionnements (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    fournisseur_id  INTEGER NOT NULL REFERENCES fournisseurs(id),
    utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id),
    reference_bl    TEXT NOT NULL UNIQUE,
    date_commande   TEXT NOT NULL DEFAULT (datetime('now')),
    date_reception  TEXT,
    statut          TEXT NOT NULL DEFAULT 'EN_COURS'
                    CHECK (statut IN ('EN_COURS', 'RECU', 'PARTIEL'))
);

CREATE TABLE lignes_approvisionnement (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT,
    approvisionnement_id INTEGER NOT NULL REFERENCES approvisionnements(id) ON DELETE CASCADE,
    produit_id          INTEGER NOT NULL REFERENCES produits(id),
    quantite_commandee  INTEGER NOT NULL CHECK (quantite_commandee > 0),
    quantite_recue      INTEGER CHECK (quantite_recue >= 0),
    cout_unitaire       NUMERIC NOT NULL CHECK (cout_unitaire >= 0)
);

