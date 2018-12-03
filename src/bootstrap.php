<?php

require __DIR__.'/../vendor/autoload.php';



// Configuration globale:
require "mvc-config.php";

// Création du routeur:
$router = new \App\Router();

$url = \Mvc\Util::getRelativeUrl();

// Recherche de la route appropriée:
$request = $router->find($url);

if (is_null($request)) {
	$request = $router->find('/');
}

// Réponse:
$response = $request->controller->getResponse();
$response->send();

