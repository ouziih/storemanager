<?php

// CREATE TABLE utilisateurs (
//     id              SERIAL PRIMARY KEY,
//     email           VARCHAR(50) NOT NULL UNIQUE,
//     mot_de_passe    VARCHAR(100) NOT NULL,
//     role            role_utilisateur NOT NULL
//     );

class Utilisateur
{
    private ?int $id = null;
    private string $email;
    private string $mot_de_passe;
    private string $role;

    public function __construct(string $email, string $mot_de_passe, string $role, ?int $id = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->setRole($role);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getMotDePasse(): string { return $this->mot_de_passe; }
    public function setMotDePasse(string $mot_de_passe): void { $this->mot_de_passe = $mot_de_passe; }

    public function getRole(): string { return $this->role; }
    public function setRole(string $role): void
    {
        $rolesValides = ['ADMIN', 'VENTE', 'STOCK', 'INVENTAIRE'];
        if (in_array(strtoupper($role), $rolesValides)) {
            $this->role = strtoupper($role);
        }
    }
}
