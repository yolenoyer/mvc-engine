<?php

namespace Mvc\Http;

use Mvc\ObjectFromArray;


/**
 * Représente la requête HTTP, en fournissant des détails additionnels spécifiques à l'application,
 * comme les informations de routing liés à cette requête, le contrôleur correspondant...
 */
class Request
{
	public $controller;
	public $urlParams;
	public $route;
	public $headers;
	public $method;
	public $url;


	/**
	 * Constructeur.
	 *
	 * @param \Routing\Route $route  Route à partir de laquelle on crée cette requête
	 * @param array $url_params      Paramètres de l'url, correspondant aux variables
	 *                               spécifiques de la route
	 */
	public function __construct(\Mvc\Routing\Route $route, array $url_params)
	{
		$this->route = $route;
		$this->urlParams = new ObjectFromArray($url_params);
		$this->headers = self::generateHeaders();
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->url = \Mvc\Util::getRelativeUrl();
		$controller_name = $route->getControllerName();
		$this->controller = new $controller_name($this);
	}


	/**
	 * Renvoie les paramètres optionnels donnés au routeur, et destinés à l'initialisation du
	 * contrôleur.
	 *
	 * @return \ObjectFromArray
	 */
	public function getRouteControllerParameters(): ObjectFromArray
	{
		return $this->route->controllerDefinition->getParameters();
	}


	/**
	 * Renvoie des informations simplifiées sur les headers de la requête.
	 *
	 * @return \ObjectFromArray
	 */
	private static function generateHeaders(): ObjectFromArray
	{
		$headers = [];
		if (isset($_SERVER['HTTP_ACCEPT'])) {
			$headers['accept'] = $_SERVER['HTTP_ACCEPT'];
		}
		return new ObjectFromArray($headers);
	}
}

