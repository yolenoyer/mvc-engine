<?php

class Router
{
	public $routes = [];


	public function add($route, string $controller_name=null)
	{
		if (is_array($route)) {
			foreach($route as $r => $c) {
				$this->add($r, $c);
			}
		} else {
			$this->routes[] = new Route($route, $controller_name);
		}
	}


	public function find($route_to_test)
	{
		foreach ($this->routes as $route) {
			$request = $route->match($route_to_test);
			if ($request !== false) {
				return $request;
			}
		}
		return false;
	}
	
}

