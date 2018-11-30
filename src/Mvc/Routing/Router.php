<?php

namespace Mvc\Routing;


/**
 * Routeur générique.
 */
class Router
{
	public $routes = [];


	/**
	 * Constructeur.
	 *
	 * @param array|null $routes  Routes initiales à ajouter avec addRoutes()
	 */
	public function __construct(array $routes=null) {
		if (!is_null($routes)) {
			$this->addRoutes($routes);
		}
	}


	/**
	 * Ajoute plusieurs nouvelles routes.
	 *
	 * @param array $routes
	 */
	public function addRoutes(array $routes): Router
	{
		foreach ($routes as $r => $c) {
			$this->addRoute($r, $c);
		}
		return $this;
	}


	/**
	 * Ajoute une nouvelle route.
	 *
	 * @param string $route
	 * @param array|string $controller_definition
	 */
	public function addRoute($route, $controller_definition): Router
	{
		$this->routes[] = new Route($route, $controller_definition);
		return $this;
	}
	


	/**
	 * Chercher une route qui matche avec l'url donné.
	 *
	 * @param string $url
	 *
	 * @return Request|null
	 */
	public function find(string $url)
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

