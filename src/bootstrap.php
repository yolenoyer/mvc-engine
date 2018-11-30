<?php

require __DIR__.'/../vendor/autoload.php';



$router = new \Routing\Router();
$router->add([
	'/'              => '\Controller\HomeController',
	'/show-name'     => '\Controller\ShowNameController',
	'/show-name/:id' => '\Controller\ShowNameController',
]);



$url = \Get::RelativeUrl();
$request = $router->find($url);

if (is_null($request)) {
	$request = $router->find('/');
}

$response = $request->controller->getResponse();
$response->send();

