<?php

namespace Mvc\Controller;

use \Mvc\Http\Request;
use \Mvc\Http\Response;
use \Mvc\Routing\Route;
use \Mvc\Assert;


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


	/**
	 * Retourne la route.
	 *
	 * @return Route
	 */
	public function getRoute(): Route {
		return $this->request->route;
	}


	/**
	 * Renvoie la valeur d'un parmètre de route obligatoire.
	 *
	 * @param string $param_name  Nom du paramètre à récupérer
	 *
	 * @return mixed
	 */
	public function getMandatoryRouteParameter($param_name)
	{
		$value = $this->routeParameters->$param_name;
		Assert::mustBeNotNull($value,
			"Route '{$this->getRoute()}': the '$param_name' parameter must be defined"
		);
		return $value;
	}


	/**
	 * À implémenter dans les classes enfant.
	 *
	 * @return Response
	 */
	public abstract function getResponse(): Response;
}

