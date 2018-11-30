<?php

require __DIR__.'/../vendor/autoload.php';


$router = new \AppRouter();

$url = App::get('relativeUrl');
$request = $router->find($url);

if (is_null($request)) {
	$request = $router->find('/');
}

$response = $request->controller->getResponse();
$response->send();

