<?php

// CREATE TABLE lignes_approvisionnement (
//     id                  SERIAL PRIMARY KEY,
//     approvisionnement_id INTEGER NOT NULL REFERENCES approvisionnements(id),
//     produit_id          INTEGER NOT NULL REFERENCES produits(id),
//     quantite_commandee  INTEGER NOT NULL CHECK (quantite_commandee > 0),
//     quantite_recue      INTEGER CHECK (quantite_recue >= 0),
//     cout_unitaire       NUMERIC(12, 2) NOT NULL CHECK (cout_unitaire >= 0)
// );

class Lignes_approvisionnement
{
    private ?int $id = null;
    private Approvisionnement $approvisionnement; 
    private Produit $produit;                     
    private int $quantite_commandee;
    private ?int $quantite_recue;
    private float $cout_unitaire;

    public function __construct(Approvisionnement $approvisionnement, Produit $produit, int $quantite_commandee, float $cout_unitaire, ?int $quantite_recue = null, ?int $id = null)
    {
        $this->id = $id;
        $this->approvisionnement = $approvisionnement;
        $this->produit = $produit;
        $this->setQuantiteCommandee($quantite_commandee);
        $this->setQuantiteRecue($quantite_recue);
        $this->setCoutUnitaire($cout_unitaire);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getApprovisionnement(): Approvisionnement { return $this->approvisionnement; }
    public function getProduit(): Produit { return $this->produit; }

    public function getQuantiteCommandee(): int { return $this->quantite_commandee; }
    public function setQuantiteCommandee(int $quantite_commandee): void
    {
        if (
            $quantite_commandee > 0) {
            $this->quantite_commandee = $quantite_commandee;
        }
    }

    public function getQuantiteRecue(): ?int { return $this->quantite_recue; }
    public function setQuantiteRecue(?int $quantite_recue): void
    {
        if ($quantite_recue === null || $quantite_recue >= 0) {
            $this->quantite_recue = $quantite_recue;
        }
    }

    public function getCoutUnitaire(): float { return $this->cout_unitaire; }
    public function setCoutUnitaire(float $cout_unitaire): void
    {
        if ($cout_unitaire >= 0) {
            $this->cout_unitaire = $cout_unitaire;
        }
    }

    public function getCoutTotalPourvu(): float
    {
        return ($this->quantite_recue ?? 0) * $this->cout_unitaire;
    }
}
