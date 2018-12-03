<?php

require __DIR__.'/../vendor/autoload.php';


$country_schema = new \App\Model\CountrySchema();


$em = new \Mvc\Model\EntityManager($country_schema);
$em->createEntity([
	'name' => 'Espagne',
	'population' => 50000000,
	'capital' => 'Madrid',
	'language' => 'Espagnol',
]);
$em->createEntity([
	'name' => 'Grèce',
	'population' => 35000000,
	'capital' => 'Athènes',
	'language' => 'Grec',
]);


$entity = $em->findEntity('Grèce');


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

