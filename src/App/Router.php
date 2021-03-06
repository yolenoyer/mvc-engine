<?php

namespace App;


/**
 * Routeur principal de l'application.
 */
class Router extends \Mvc\Routing\Router
{
	public function __construct()
	{
		$this->addRoutes(
			[
				'/'              => 'HomeController',
				'/show-name'     => 'ShowNameController',
				'/show-name/:id' => 'ShowNameController',
				'/pays/:id' =>
					[
						'controller' => 'ShowCountryController',
						'parameters' => [ 'title' => 'Bienvenue!' ]
					],
			],
			'\App\Controller'
		);

		$this->addRoutes(
			[
				'/person/:id' =>
					[
						'controller' => 'RestController',
						'parameters' => [ 'entity' => '\App\Entity\Person' ]
					],
				'/person' =>
					[
						'controller' => 'RestController',
						'parameters' => [ 'entity' => '\App\Entity\Person' ]
					],
				'/country/:id' =>
					[
						'controller' => 'RestController',
						'parameters' => [ 'schema' => '\App\Model\CountrySchema' ]
					],
				'/country' =>
					[
						'controller' => 'RestController',
						'parameters' => [ 'schema' => '\App\Model\CountrySchema' ]
					],
				'/rouge' =>
					[
						'controller' => 'StaticTemplateController',
						'parameters' => [
							'template' => 'static-example',
							'parameters' => [ 'css_color' => 'red', 'color_name' => 'rouge', ]
						]
					],
				'/vert' =>
					[
						'controller' => 'StaticTemplateController',
						'parameters' => [
							'template' => 'static-example',
							'parameters' => [ 'css_color' => 'green', 'color_name' => 'vert', ]
						]
					],
				'/bleu/:word' =>
					[
						'controller' => 'StaticTemplateController',
						'parameters' => [
							'template' => 'static-example',
							'parameters' => [ 'css_color' => 'blue', 'color_name' => 'bleu', ]
						]
					],
			],
			'\Mvc\Controller'
		);
	}
}

