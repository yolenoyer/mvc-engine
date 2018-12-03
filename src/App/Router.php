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
			],
			'\App\Controller'
		);

		$this->addRoutes(
			[
				'/country/:id' =>
					[
						'controller' => 'RestController',
						'parameters' => [
							'schema' => '\App\Model\CountrySchema',
						]
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

