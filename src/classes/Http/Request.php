<?php

namespace Http;


/**
 * Représente la requête HTTP, en fournissant des détails additionnels spécifiques à l'application,
 * comme les informations de routing liés à cette requête, le contrôleur correspondant...
 */
class Request
{
	public $controller;
	public $params;
	public $route;
	public $headers;
	public $method;
	public $url;


	public function __construct($route, $params)
	{
		$this->route = $route;
		$this->params = new \ObjectFromArray($params);
		$this->controller = new $route->controllerName($this);
		$this->headers = self::getHeaders();
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->url = \App::get('relativeUrl');
	}


	private static function getHeaders()
	{
		$headers = [];
		if (isset($_SERVER['HTTP_ACCEPT'])) {
			$headers['accept'] = $_SERVER['HTTP_ACCEPT'];
		}
		return new \ObjectFromArray($headers);
	}
}

