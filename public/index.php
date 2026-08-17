<?php

// Autoloader : indispensable AVANT session_start(), sinon PHP ne connait pas
// encore les classes Entity au moment de deserialiser la session (panier),
// et on obtient des __PHP_Incomplete_Class au lieu des vrais objets.
spl_autoload_register(function (string $class): void {
    $paths = [
        dirname(__DIR__)."/src/Model/Entity/$class.php",
        dirname(__DIR__)."/src/Model/Repositoriy/$class.php",
        dirname(__DIR__)."/src/Service/$class.php",
        dirname(__DIR__)."/src/Controller/$class.php",
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once dirname(__DIR__)."/src/Core/SessionManager.php";
require_once dirname(__DIR__)."/src/Core/Database.php";
SessionManager::initSession();
SessionManager::setSession("currentUser",new Utilisateur("vendeur@store.sn", "secret", "VENTE",1));
SessionManager::init();
require_once dirname(__DIR__)."/src/Core/Router.php";
Router::route();