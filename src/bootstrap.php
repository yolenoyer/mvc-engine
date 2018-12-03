<?php

require __DIR__.'/../vendor/autoload.php';


$country_schema = new \App\Model\CountrySchema();

$country = $country_schema->createInstance([
	'name' => 'Espagne',
	'population' => 50000000,
	'capital' => 'Madrid',
	'language' => 'Espagnol',
]);

$country->set('population', 78);

echo '<pre>';


$myschema = new \Mvc\Model\Schema('myschema', [
	'x' => [ 'type' => 'integer' ],
	'y' => [ 'type' => 'integer' ],
	'name' => [ 'type' => 'string' ],
]);

$o = $myschema->createInstance([
	'name' => 'hello',
	'x' => 10,
	'y' => 20,
]);

print_r($o->toArray());

die;


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

