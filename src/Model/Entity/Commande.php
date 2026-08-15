<?php

// CREATE TABLE commandes (
//     id              SERIAL PRIMARY KEY,
//     client_id       INTEGER NOT NULL REFERENCES clients(id),
//     utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id),
//     date_creation   DATE NOT NULL DEFAULT CURRENT_DATE,
//     montant_total   NUMERIC(12, 2) NOT NULL CHECK (montant_total >= 0),
//     montant_verse   NUMERIC(12, 2) NOT NULL DEFAULT 0 CHECK (montant_verse >= 0),
//     mode_reglement  mode_paiement NOT NULL
// );

class Commande
{
    private ?int $id = null;
    private Client $client;
    private Utilisateur $utilisateur;
    private string $date_creation;
    private float $montant_total;
    private float $montant_verse;
    private string $mode_reglement;

   
    public function __construct(
        Client $client, 
        Utilisateur $utilisateur, 
        float $montant_total, 
        float $montant_verse, 
        string $mode_reglement,
        ?string $date_creation = null 
    ) {
        $this->client = $client;
        $this->utilisateur = $utilisateur;
        $this->montant_total = $montant_total;
        $this->montant_verse = $montant_verse;
        $this->mode_reglement = $mode_reglement;
        $this->date_creation = $date_creation ?? date('Y-m-d');
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function getClient(): Client 
    {
        return $this->client;
    }

    public function setClient(Client $client): void 
    {
        $this->client = $client;
    }

    public function getUtilisateur(): Utilisateur 
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): void 
    {
        $this->utilisateur = $utilisateur;
    }

    public function getDateCreation(): string 
    {
        return $this->date_creation;
    }

    public function getMontantTotal(): float 
    {
        return $this->montant_total;
    }

    public function setMontantTotal(float $montant_total): void 
    {
        if ($montant_total >= 0) {
            $this->montant_total = $montant_total;
        }
    }

    public function getMontantVerse(): float 
    {
        return $this->montant_verse;
    }

    public function setMontantVerse(float $montant_verse): void 
    {
        if ($montant_verse >= 0) {
            $this->montant_verse = $montant_verse;
        }
    }

    public function getModeReglement(): string 
    {
        return $this->mode_reglement;
    }

    public function setModeReglement(string $mode_reglement): void 
    {
        $modesValides = ['Wave', 'Orange Money', 'Especes', 'Virement'];
        if (in_array($mode_reglement, $modesValides)) {
            $this->mode_reglement = $mode_reglement;
        }
    }

    public function getResteAPayer(): float
    {
        return max(0.0, $this->montant_total - $this->montant_verse);
    }

  
    public function estUneDette(): bool
    {
        return $this->getResteAPayer() > 0;
    }
}
