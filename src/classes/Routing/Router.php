<?php

namespace Routing;


class Router
{
	public $routes = [];


	public function __construct(array $routes=null) {
		if (!is_null($routes)) {
			$this->add($routes);
		}
	}


	public function add($route, string $controller_name=null): Router
	{
		if (is_array($route)) {
			foreach($route as $r => $c) {
				$this->add($r, $c);
			}
		} else {
			$this->routes[] = new Route($route, $controller_name);
		}

		return $this;
	}


	public function find($url)
	{
		foreach ($this->routes as $route) {
			$request = $route->match($url);
			if (!is_null($request)) {
				return $request;
			}
		}
		return null;
	}

}

