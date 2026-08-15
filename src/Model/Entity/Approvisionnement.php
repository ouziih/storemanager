<?php

// CREATE TABLE approvisionnements (
//     id              SERIAL PRIMARY KEY,
//     fournisseur_id  INTEGER NOT NULL REFERENCES fournisseurs(id),
//     utilisateur_id  INTEGER NOT NULL REFERENCES utilisateurs(id),
//     reference_bl    VARCHAR(50) NOT NULL UNIQUE,
//     date_commande   DATE NOT NULL DEFAULT CURRENT_DATE,
//     date_reception  DATE,
//     statut          statut_appro NOT NULL DEFAULT 'EN_COURS'
// );

class Approvisionnement
{
    private ?int $id = null;
    private Fournisseur $fournisseur; 
    private Utilisateur $utilisateur; 
    private string $reference_bl;
    private string $date_commande;
    private ?string $date_reception;
    private string $statut;

    public function __construct(Fournisseur $fournisseur, Utilisateur $utilisateur, string $reference_bl, string $statut = 'EN_COURS', ?string $date_reception = null, ?string $date_commande = null, ?int $id = null)
    {
        $this->id = $id;
        $this->fournisseur = $fournisseur;
        $this->utilisateur = $utilisateur;
        $this->reference_bl = $reference_bl;
        $this->setStatut($statut);
        $this->date_reception = $date_reception;
        $this->date_commande = $date_commande ?? date('Y-m-d');
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getFournisseur(): Fournisseur { return $this->fournisseur; }
    public function getUtilisateur(): Utilisateur { return $this->utilisateur; }
    public function getReferenceBl(): string { return $this->reference_bl; }
    public function getDateCommande(): string { return $this->date_commande; }

    public function getDateReception(): ?string { return $this->date_reception; }
    public function setDateReception(?string $date_reception): void { $this->date_reception = $date_reception; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): void
    {
        $statutsValides = ['EN_COURS', 'RECU', 'PARTIEL'];
        if (in_array(strtoupper($statut), $statutsValides)) {
            $this->statut = strtoupper($statut);
        }
    }
}
