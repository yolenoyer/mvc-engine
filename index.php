<?php

require_once 'class/Get.class.php';
require_once 'autoload.php';



$router = new Router();
$router->add([
	'/'              => 'HomeController',
	'/show-name'     => 'ShowNameController',
	'/show-name/:id' => 'ShowNameController',
]);



$url = Get::RelativeUrl();
$request = $router->find($url);

if ($request === false) {
	$request = $router->find('/');
}

echo $request->controller->getResponse();


