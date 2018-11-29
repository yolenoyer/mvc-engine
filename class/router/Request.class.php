<?php

class Request
{
	public $controller;
	public $params;
	public $route;
	public $headers;


	public static function getHeaders()
	{
		$headers = [];
		if (isset($_SERVER['HTTP_ACCEPT'])) {
			$headers['accept'] = $_SERVER['HTTP_ACCEPT'];
		}
		return new ObjectFromArray($headers);
	}


	public function __construct($route, $params)
	{
		$this->route = $route;
		$this->params = new ObjectFromArray($params);
		$this->controller = new $route->controllerName($this);
		$this->headers = self::getHeaders();
		$this->method = \Get::Method();
		$this->url = \Get::RelativeUrl();
	}
}

