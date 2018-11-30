<?php

namespace App;


/**
 * Routeur principal de l'application.
 */
class Router extends \Mvc\Routing\Router
{
	public function __construct()
	{
		parent::__construct([
			'/'              => '\App\Controller\HomeController',
			'/show-name'     => '\App\Controller\ShowNameController',
			'/show-name/:id' => '\App\Controller\ShowNameController',
			'/test'          =>
				[
					'\App\Controller\ShowNameController', [
						'template' => 'mypage'
					]
			   	],
		]);
	}
}

