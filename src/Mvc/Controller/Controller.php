<?php

namespace Mvc\Controller;

use \Mvc\Http\Request;
use \Mvc\Http\Response;


/**
 * Classe de base pour tous les contrôleurs.
 */
abstract class Controller
{
	// Requête:
	protected $request;

	// Paramètres internes fournis au routeur:
	protected $routeParameters;


	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->routeParameters = $request->getRouteControllerParameters();
	}


	public abstract function getResponse(): Response;
}

