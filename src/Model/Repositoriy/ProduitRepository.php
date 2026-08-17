

<?php

// CREATE TABLE produits (
//     id              SERIAL PRIMARY KEY,
//     nom             VARCHAR(50) NOT NULL,
//     prix_vente      NUMERIC(12, 2) NOT NULL CHECK (prix_vente >= 0),
//     quantite_stock  INTEGER NOT NULL DEFAULT 0 CHECK (quantite_stock >= 0)
// );
require_once dirname(__DIR__)."/Entity/Produit.php";


class ProduitRepository
{
    public static function saveUpdate(Produit $produit): void
    {
        if ($produit->getId() == null) {
            $sql = "INSERT INTO produits(nom, prix_vente, quantite_stock) 
                    VALUES(:nom, :prix_vente, :quantite_stock)";

            $id = Database::modify(
                $sql,
                [
                    'nom' => $produit->getNom(),
                    'prix_vente' => $produit->getPrixVente(),
                    'quantite_stock' => $produit->getQuantiteStock()
                ]
            );
            $produit->setId($id);
        } else {
            $sql = "UPDATE produits 
                    SET nom = :nom, prix_vente = :prix_vente, quantite_stock = :quantite_stock
                    WHERE id = :id";
            Database::modify(
                $sql,
                [
                    'nom' => $produit->getNom(),
                    'prix_vente' => $produit->getPrixVente(),
                    'quantite_stock' => $produit->getQuantiteStock(),
                    'id' => $produit->getId()
                ]
            );
        }
    }

    public static function findById(int $id): ?Produit
    {
        $sql = "SELECT * FROM produits WHERE id = :id";
        $row = Database::select($sql, ["id" => $id]);
        if (!empty($row)) {
            $produit = new Produit($row['nom'], (float)$row['prix_vente'], (int)$row['quantite_stock'], $id);
            return $produit;
        }
        return null;
    }

    public static function findAll(): array
    {
        $sql = "SELECT * FROM produits";
        $rows = Database::select($sql, [], false);
        $produits = [];
        foreach ($rows as $row) {
            $produits[] = new Produit($row['nom'], (float)$row['prix_vente'], (int)$row['quantite_stock'], $row['id']);
        }
        return $produits;
    }
}
