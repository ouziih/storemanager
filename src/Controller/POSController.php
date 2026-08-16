<?php

class POSController{
    public static function vente():void{
        $datas = [
            "clients" => ClientRepository::findAll(),
            "produits" => ProduitRepository::findAll()
        ];
        require_once(dirname(__DIR__)."/Views/Pos/index.php");
    }

    public static function enregistrementCommande():void{
        if ($_POST["btnAction"] == 'saveSession') {
            VenteService::addPanier($_POST);
            header("Location: htth://localhost:8001");
            exit;
        }
        if ($_POST["btnAction"] == 'save') {
            VenteService::saveCommande($_SESSION["panier"]);
            header("Location: htth://localhost:8001");
            exit;
        }
    }
};