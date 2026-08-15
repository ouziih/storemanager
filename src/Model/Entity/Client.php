<?php

// CREATE TABLE clients (
//     id              SERIAL PRIMARY KEY,
//     prenom          VARCHAR(100) NOT NULL,
//     nom             VARCHAR(100) NOT NULL,
//     telephone       VARCHAR(30) NOT NULL,
//     email           VARCHAR(50) NOT NULL,
//     limite_credit   NUMERIC(12, 2) NOT NULL DEFAULT 0 CHECK (limite_credit >= 0)
// );

class Client
{
    private ?int $id = null;
    private string $prenom;
    private string $nom;
    private string $telephone;
    private string $email;
    private float $limite_credit;

    public function __construct(string $prenom, string $nom, string $telephone, string $email, float $limite_credit = 0.0, ?int $id = null)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->setLimiteCredit($limite_credit);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getPrenom(): string { return $this->prenom; }
    public function getNom(): string { return $this->nom; }
    public function getTelephone(): string { return $this->telephone; }
    public function getEmail(): string { return $this->email; }

    public function getLimiteCredit(): float { return $this->limite_credit; }
    public function setLimiteCredit(float $limite_credit): void
    {
        if ($limite_credit >= 0) {
            $this->limite_credit = $limite_credit;
        }
    }
}
