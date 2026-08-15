<?php

// CREATE TABLE lignes_commande (
//     id              SERIAL PRIMARY KEY,
//     commande_id     INTEGER NOT NULL REFERENCES commandes(id),
//     produit_id      INTEGER NOT NULL REFERENCES produits(id),
//     quantite        INTEGER NOT NULL CHECK (quantite > 0),
//     prix_unitaire   NUMERIC(12, 2) NOT NULL CHECK (prix_unitaire >= 0)
// );

class Lignes_commande
{
    private ?int $id = null;
    private ?Commande $commande; 
    private Produit $produit;   
    private int $quantite;
    private float $prix_unitaire;

    public function __construct(?Commande $commande, Produit $produit, int $quantite, float $prix_unitaire, ?int $id = null)
    {
        $this->id = $id;
        $this->commande = $commande;
        $this->produit = $produit;
        $this->setQuantite($quantite);
        $this->setPrixUnitaire($prix_unitaire);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getCommande(): Commande { return $this->commande; }
    public function getProduit(): Produit { return $this->produit; }

    public function getQuantite(): int { return $this->quantite; }
    public function setQuantite(int $quantite): void
    {
        if ($quantite > 0) {
            $this->quantite = $quantite;
        }
    }

    public function getPrixUnitaire(): float { return $this->prix_unitaire; }
    public function setPrixUnitaire(float $prix_unitaire): void
    {
        if ($prix_unitaire >= 0) {
            $this->prix_unitaire = $prix_unitaire;
        }
    }

    public function getSousTotal(): float
    {
        return $this->quantite * $this->prix_unitaire;
    }
}
