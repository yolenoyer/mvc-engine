<?php

/**
 * Routeur principal de l'appication.
 */
class AppRouter extends \Routing\Router
{
	public function __construct()
	{
		parent::__construct([
			'/'              => '\Controller\HomeController',
			'/show-name'     => '\Controller\ShowNameController',
			'/show-name/:id' => '\Controller\ShowNameController',
			'/test' => [ '\Controller\ShowNameController', [
				'template' => 'mypage'
			] ],
		]);
	}
}

