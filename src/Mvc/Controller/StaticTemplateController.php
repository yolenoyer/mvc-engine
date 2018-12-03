<?php

namespace Mvc\Controller;

use \Mvc\Http\Request;
use \Mvc\Http\Response;
use \Mvc\Assert;


/**
 * Permet d'afficher des templates sans besoin de code métier.
 * Le paramètre 'template' (à fournir au routeur) permet de définir quel template utiliser.
 */
class StaticTemplateController extends TemplateController
{
	protected $template;
	protected $parameters;


	/**
	 * Constructeur.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->template = $this->getMandatoryRouteParameter('template');
		$this->parameters = $this->routeParameters->parameters;
	}

	/**
	 * Renvoie la réponse HTTP.
	 *
	 * @return Response
	 */
	public function getResponse(): Response
	{
		return $this->getTemplateResponse($this->template, $this->parameters);
	}
	
}

