
<?php

require_once dirname(__DIR__)."/Entity/Client.php";

class ClientRepository
{

    public static function saveUpdate(Client $client): void
    {
        if ($client->getId() == null) {
            $sql = "INSERT INTO clients(prenom,nom,telephone,email,limite_credit) 
                VALUES(:prenom, :nom, :telephone, :email, :limite_credit)";



            $id = Database::modify(
                $sql,
                [
                    'prenom' => $client->getPrenom(),
                    'nom' => $client->getNom(),
                    'telephone' => $client->getTelephone(),
                    'email' => $client->getEmail(),
                    'limite_credit' => $client->getLimiteCredit()
                ]
            );
            $client->setId($id);
        } else {
            $sql = "UPDATE clients 
                    SET prenom = :prenom, nom = :nom, telephone = :telephone, 
                        email = :email, limite_credit = :limite_credit
                    WHERE id = :id";
            Database::modify(
                $sql,
                [
                    'prenom' => $client->getPrenom(),
                    'nom' => $client->getNom(),
                    'telephone' => $client->getTelephone(),
                    'email' => $client->getEmail(),
                    'limite_credit' => $client->getLimiteCredit(),
                    'id' => $client->getId()
                ]
            );
        }
    }

    public static function findById(int $id): ?Client
    {

        $sql = "SELECT * FROM clients where id = :id";
        $row = Database::select($sql, ["id" => $id]);
        if (!empty($row)) {
            $client = new Client($row['prenom'], $row['nom'], $row['telephone'], $row['email'], (float)$row['limite_credit'],$id);
            return $client;
        }
        return null;
    }

    public static function findAll():array{
        $sql = "SELECT * FROM clients";
        $rows = Database::select($sql, [],false);
        $clients = [];
        foreach ($rows as $row) {
            $clients[]=new Client($row['prenom'], $row['nom'], $row['telephone'], $row['email'], (float)$row['limite_credit'],$row['id']);
        }
        return $clients;
    }
};
