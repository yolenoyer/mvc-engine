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
				'/'              => 'HomeController',
				'/show-name'     => 'ShowNameController',
				'/show-name/:id' => 'ShowNameController',
				'/test'          => [
					'controller' => 'ShowNameController',
					'parameters' => [ 'template' => 'mypage' ]
				],
			],
			'\App\Controller'
		);
	}
}

