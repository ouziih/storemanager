<?php

// CREATE TABLE produits (
//     id              SERIAL PRIMARY KEY,
//     nom             VARCHAR(50) NOT NULL,
//     prix_vente      NUMERIC(12, 2) NOT NULL CHECK (prix_vente >= 0),
//     quantite_stock  INTEGER NOT NULL DEFAULT 0 CHECK (quantite_stock >= 0)
// );

class Produit
{
    private ?int $id = null;
    private string $nom;
    private float $prix_vente;
    private int $quantite_stock;

    public function __construct(string $nom, float $prix_vente, int $quantite_stock = 0, ?int $id = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->setPrixVente($prix_vente);
        $this->setQuantiteStock($quantite_stock);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getPrixVente(): float { return $this->prix_vente; }
    public function setPrixVente(float $prix_vente): void
    {
        if ($prix_vente >= 0) {
            $this->prix_vente = $prix_vente;
        }
    }

    public function getQuantiteStock(): int { return $this->quantite_stock; }
    public function setQuantiteStock(int $quantite_stock): void
    {
        if ($quantite_stock >= 0) {
            $this->quantite_stock = $quantite_stock;
        }
    }
}
