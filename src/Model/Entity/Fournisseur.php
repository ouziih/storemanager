<?php

// CREATE TABLE fournisseurs (
//     id              SERIAL PRIMARY KEY,
//     nom             VARCHAR(150) NOT NULL,
//     telephone       VARCHAR(30) NOT NULL,
//     adresse         VARCHAR(50) NOT NULL,
//     email           VARCHAR(50) 
// );

class Fournisseur
{
    private ?int $id = null;
    private string $nom;
    private string $telephone;
    private string $adresse;
    private ?string $email;

    public function __construct(string $nom, string $telephone, string $adresse, ?string $email = null, ?int $id = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->email = $email;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getTelephone(): string { return $this->telephone; }
    public function setTelephone(string $telephone): void { $this->telephone = $telephone; }

    public function getAdresse(): string { return $this->adresse; }
    public function setAdresse(string $adresse): void { $this->adresse = $adresse; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): void { $this->email = $email; }
}
