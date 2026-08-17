<?php

require_once dirname(__DIR__)."/Model/Entity/Lignes_commande.php";


class VenteService{
    public static function addPanier(array $ligneForm):void{
        $produit = ProduitRepository::findById((int)$ligneForm['idproduit']);
        if ($produit->getQuantiteStock() >= (int)$ligneForm["qte"]) {
               $ligneCommande = new Lignes_commande(null,$produit,$ligneForm['qte'],$produit->getPrixVente());
        
        $montant = SessionManager::getSession("montant");
        $montant+=$ligneCommande->getPrixUnitaire()*$ligneCommande->getQuantite();
        SessionManager::setSession("montant",$montant);
        $panier = SessionManager::getSession("panier");
        $panier[]=$ligneCommande;
        SessionManager::setSession("panier",$panier);
        }
        else {
            SessionManager::setSession("errors","quantité restant: {$produit->getQuantiteStock()} ");
        }

    }

    public static function saveCommande(array $lignesCommandes):void{
        $client = ClientRepository::findById($_POST["idclient"]);
        $utilisateur = SessionManager::getSession("currentUser");
        $commande = new Commande($client,$utilisateur,SessionManager::getSession("montant"),(float)$_POST['montantVerse'],$_POST["reglement"],date('Y-m-d'));
        if ($commande->estUneDette() && $commande->getResteAPayer() > $client->getLimiteCredit()) {
            SessionManager::setSession("errors", "Limite de crédit dépassée !");
            return;
        }
        try {
            Database::getInstance()->beginTransaction();
            $sql = "INSERT INTO commandes(client_id,utilisateur_id,date_creation,montant_total,montant_verse,mode_reglement)
                    VALUES(:client_id,:utilisateur_id,:date_creation,:montant_total,:montant_verse,:mode_reglement)
                    ";
            $idCommande = Database::modify($sql,[
                "client_id"=>$client->getId(),
                "utilisateur_id"=>$utilisateur->getId(),
                "date_creation"=>$commande->getDateCreation(),
                "montant_total"=>$commande->getMontantTotal(),
                "montant_verse"=>$commande->getMontantVerse(),
                "mode_reglement"=>$commande->getModeReglement()
            ]);
            
            $sql1 = "INSERT INTO lignes_commande(commande_id,produit_id,quantite,prix_unitaire) 
                    VALUES(:commande_id,:produit_id,:quantite,:prix_unitaire)";

            $sql2 = "UPDATE produits 
                     SET quantite_stock = quantite_stock - :quantite_stock 
                     WHERE id = :id";
            foreach ($lignesCommandes as $ligneCommande) {
                $idLigne = Database::modify($sql1,[
                    "commande_id"=>$idCommande,
                    "produit_id"=>$ligneCommande->getProduit()->getId(),
                    "quantite"=>$ligneCommande->getQuantite(),
                    "prix_unitaire"=>$ligneCommande->getPrixUnitaire()
                ]);
                $ligneCommande->setId($idLigne);
                 Database::modify($sql2,[
                    "quantite_stock"=>$ligneCommande->getQuantite(),
                    "id"=>$ligneCommande->getProduit()->getId()
                ]);

            }
            $commande->setId($idCommande);
            
            if($commande->estUneDette()){
                $sql = "INSERT INTO dettes (commande_id, client_id, date_creation, montant_initial) 
                        VALUES (:commande_id, :client_id, :date_creation, :montant_initial)";
                $idDette = Database::modify($sql,[
                    "commande_id"=>$idCommande,
                    "client_id"=>$client->getId(),
                    "date_creation"=>date('Y-m-d'),
                    "montant_initial"=>$commande->getResteAPayer()
                ]);

                $sql = "INSERT INTO paiements (dette_id,date_paiement,montant,mode_paiement) 
                        VALUES(:dette_id,:date_paiement,:montant,:mode_paiement)";

                Database::modify($sql,[
                    "dette_id"=>$idDette,
                    "date_paiement"=>date('Y-m-d'),
                    "montant"=>$commande->getMontantVerse(),
                    "mode_paiement"=>$commande->getModeReglement()                    
                ]);
            }


            Database::getInstance()->commit();
            SessionManager::setSession("panier", []);
            SessionManager::setSession("montant", 0);
            SessionManager::setSession("success", "La vente POS a été validée avec succès !");

        } catch (\Throwable $th) {
            Database::getInstance()->rollBack();
            SessionManager::setSession("errors", "Échec de la vente : " . $th->getMessage());
        }
    }
};