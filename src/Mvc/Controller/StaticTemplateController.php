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
	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	/**
	 * Renvoie la réponse HTTP.
	 *
	 * @return Response
	 */
	public function getResponse(): Response
	{
		$template = $this->routeParameters->template;
		Assert::mustBeNotNull($template,
			"Route '{$this->getRoute()}': the 'template' parameter must be defined"
		);
		$parameters = $this->routeParameters->parameters ?? [];
		return $this->getTemplateResponse($template, $parameters);
	}
	
}

