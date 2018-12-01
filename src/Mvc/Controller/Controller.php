<?php

namespace Mvc\Controller;

use \Mvc\Http\Request;
use \Mvc\Http\Response;
use \Mvc\Routing\Route;


/**
 * Classe de base pour tous les contrôleurs.
 */
abstract class Controller
{
	// Requête:
	protected $request;

	// Paramètres internes fournis au routeur:
	protected $routeParameters;


	/**
	 * Constructeur.
	 *
	 * @param Request $request  Requête ayant conduit à l'instanciation de ce contrôleur
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->routeParameters = $request->getRouteControllerParameters();
	}


	/*
	 * Getter for request
	 */
	public function getRequest(): Request {
		return $this->request;
	}


	/*
	 * Retourne la route.
	 *
	 * @return Route
	 */
	public function getRoute(): Route {
		return $this->request->route;
	}
	

	/**
	 * À implémenter dans les classes enfant.
	 *
	 * @return Response
	 */
	public abstract function getResponse(): Response;
}

