<!-- CREATE TABLE fournisseurs (
    id              SERIAL PRIMARY KEY,
    nom             VARCHAR(150) NOT NULL,
    telephone       VARCHAR(30) NOT NULL,
    adresse         VARCHAR(50) NOT NULL,
    email           VARCHAR(50) 
); -->
<?php

class FournisseurRepository
{
    public static function saveUpdate(Fournisseur $fournisseur): void
    {
        if ($fournisseur->getId() == null) {
            $sql = "INSERT INTO fournisseurs(nom, telephone, adresse, email) 
                    VALUES(:nom, :telephone, :adresse, :email)";

            $id = Database::modify(
                $sql,
                [
                    'nom' => $fournisseur->getNom(),
                    'telephone' => $fournisseur->getTelephone(),
                    'adresse' => $fournisseur->getAdresse(),
                    'email' => $fournisseur->getEmail()
                ]
            );
            $fournisseur->setId($id);
        } else {
            $sql = "UPDATE fournisseurs 
                    SET nom = :nom, telephone = :telephone, adresse = :adresse, email = :email
                    WHERE id = :id";
            Database::modify(
                $sql,
                [
                    'nom' => $fournisseur->getNom(),
                    'telephone' => $fournisseur->getTelephone(),
                    'adresse' => $fournisseur->getAdresse(),
                    'email' => $fournisseur->getEmail(),
                    'id' => $fournisseur->getId()
                ]
            );
        }
    }

    public static function findById(int $id): ?Fournisseur
    {
        $sql = "SELECT * FROM fournisseurs WHERE id = :id";
        $row = Database::select($sql, ["id" => $id]);
        if (!empty($row)) {
            $fournisseur = new Fournisseur($row['nom'], $row['telephone'], $row['adresse'], $row['email'], $id);
            return $fournisseur;
        }
        return null;
    }

    public static function findAll(): array
    {
        $sql = "SELECT * FROM fournisseurs";
        $rows = Database::select($sql, [], false);
        $fournisseurs = [];
        foreach ($rows as $row) {
            $fournisseurs[] = new Fournisseur($row['nom'], $row['telephone'], $row['adresse'], $row['email'], $row['id']);
        }
        return $fournisseurs;
    }
}
