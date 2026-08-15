<?php

// CREATE TABLE dettes (
//     id              SERIAL PRIMARY KEY,
//     commande_id     INTEGER NOT NULL UNIQUE REFERENCES commandes(id),
//     client_id       INTEGER NOT NULL REFERENCES clients(id),
//     date_creation   DATE NOT NULL DEFAULT CURRENT_DATE,
//     montant_initial NUMERIC(12, 2) NOT NULL CHECK (montant_initial >= 0),
//     statut          statut_dette NOT NULL DEFAULT 'NON_SOLDEE'
// );

class Dette
{
    private ?int $id = null;
    private Commande $commande; 
    private Client $client;    
    private string $date_creation;
    private float $montant_initial;
    private string $statut;

    public function __construct(Commande $commande, Client $client, float $montant_initial, string $statut = 'NON_SOLDEE', ?string $date_creation = null, ?int $id = null)
    {
        $this->id = $id;
        $this->commande = $commande;
        $this->client = $client;
        $this->montant_initial = $montant_initial;
        $this->setStatut($statut);
        $this->date_creation = $date_creation ?? date('Y-m-d');
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getCommande(): Commande { return $this->commande; }
    public function getClient(): Client { return $this->client; }
    public function getDateCreation(): string { return $this->date_creation; }
    public function getMontantInitial(): float { return $this->montant_initial; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): void
    {
        $statutsValides = ['NON_SOLDEE', 'PARTIELLEMENT_SOLDEE', 'SOLDEE'];
        if (in_array(strtoupper($statut), $statutsValides)) {
            $this->statut = strtoupper($statut);
        }
    }
}
