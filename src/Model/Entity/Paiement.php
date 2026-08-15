<?php

// CREATE TABLE paiements (
//     id              SERIAL PRIMARY KEY,
//     dette_id        INTEGER NOT NULL REFERENCES dettes(id),
//     date_paiement   DATE NOT NULL DEFAULT CURRENT_DATE,
//     montant         NUMERIC(12, 2) NOT NULL CHECK (montant > 0),
//     mode_paiement   mode_paiement NOT NULL
// );

class Paiement
{
    private ?int $id = null;
    private Dette $dette;
    private string $date_paiement;
    private float $montant;
    private string $mode_paiement;

    public function __construct(Dette $dette, float $montant, string $mode_paiement, ?string $date_paiement = null, ?int $id = null)
    {
        $this->id = $id;
        $this->dette = $dette;
        $this->setMontant($montant);
        $this->setModePaiement($mode_paiement);
        $this->date_paiement = $date_paiement ?? date('Y-m-d');
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getDette(): Dette { return $this->dette; }
    public function getDatePaiement(): string { return $this->date_paiement; }

    public function getMontant(): float { return $this->montant; }
    public function setMontant(float $montant): void
    {
        if ($montant > 0) {
            $this->montant = $montant;
        }
    }

    public function getModePaiement(): string { return $this->mode_paiement; }
    public function setModePaiement(string $mode_paiement): void
    {
        $modesValides = ['Wave', 'Orange Money', 'Especes', 'Virement'];
        if (in_array($mode_paiement, $modesValides)) {
            $this->mode_paiement = $mode_paiement;
        }
    }
}
