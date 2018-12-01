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
	 * @param string $controller_namespace  Namespace du controlleur
	 */
	public function __construct(array $routes=null, string $controller_namespace='') {
		if (!is_null($routes)) {
			$this->addRoutes($routes, $controller_namespace);
		}
	}


	/**
	 * Ajoute plusieurs nouvelles routes.
	 *
	 * @param array $routes
	 * @param string $controller_namespace  Namespace du controlleur
	 */
	public function addRoutes(array $routes, string $controller_namespace=''): Router
	{
		foreach ($routes as $route => $controller_definition) {
			$this->addRoute($route, $controller_definition, $controller_namespace);
		}
		return $this;
	}


	/**
	 * Ajoute une nouvelle route.
	 *
	 * @param string $route  Url
	 * @param array|string $controller_definition
	 * @param string $controller_namespace  Namespace du controlleur
	 */
	public function addRoute(string $route, $controller_definition, string $controller_namespace=''): Router
	{
		$this->routes[] = new Route($route, $controller_definition, $controller_namespace);
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

