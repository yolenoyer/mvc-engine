<?php

class AppRouter extends \Routing\Router
{
	public function __construct()
	{
		parent::__construct([
			'/'              => '\Controller\HomeController',
			'/show-name'     => '\Controller\ShowNameController',
			'/show-name/:id' => '\Controller\ShowNameController',
		]);
	}
}

