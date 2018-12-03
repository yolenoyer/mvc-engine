<?php

namespace App\Controller;

use \Mvc\Controller\TemplateController;
use \Mvc\Http\Request;
use \Mvc\Http\Response;
use \Mvc\Model\EntityManager;


class ShowCountryController extends TemplateController
{
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->em = new EntityManager(new \App\Model\CountrySchema());
	}


	public function getResponse(): Response
	{
		$id = $this->request->urlParams->id;
		$entity = $this->em->find($id);
		if (is_null($entity)) {
			return new Response('Pays non-trouvé...', 'text/html', 404);
		}
		$params = [
			'title' => $this->routeParameters->title,
			'country' => $entity->toArray(),
		];
		return $this->getTemplateResponse('show-country', $params, 200);
	}
}

