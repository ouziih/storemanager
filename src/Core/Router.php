<?php

class Router{
    private static array $routes = [
        '/commande' => [
            'controller' => 'POSController.php',
            'classe'      => 'POSController',
            'methode'    => 'vente'
        ],
        '/commande/save' => [
            'controller' => 'POSController.php',
            'classe'      => 'POSController',
            'methode'    => 'enregistrementCommande'
        ]

    ];

    private function __construct() {}

    private static function getUri():string{
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    } 

    

    public static function route():void{
        $uri = self::getUri();
        if(isset(self::$routes[$uri])){
            $controller = self::$routes[$uri]['controller'];
            $classe = self::$routes[$uri]['classe'];
            require_once dirname(__DIR__)."/Controller/$controller";
            $action = self::$routes[$uri]['methode'];
            $classe::$action(); 
        }
        else {
            echo "PAGE 404";
        }
    }

};