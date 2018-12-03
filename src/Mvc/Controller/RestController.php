<?php

namespace Mvc\Controller;

use \Mvc\Http\Response;
use \Mvc\Http\Request;
use \Mvc\Model\EntityManager;


/**
 * Gère en Rest les interactions avec un schéma donné.
 */
class RestController extends Controller
{
	protected $id;
	protected $schema;
	protected $em;


	/**
	 * Constructeur.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->id = $this->request->urlParams->id;
		$SchemaClass = $this->getMandatoryRouteParameter('schema');
		$this->schema = new $SchemaClass();
		$this->em = new EntityManager($this->schema);
	}


	/**
	 * Renvoie la réponse.
	 *
	 * @return Response
	 */
	public function getResponse(): Response
	{
		switch ($this->request->method) {
		case 'GET':
			$data = $this->em->findEntity($this->id);
			if (is_null($data)) {
				return new Response(null, 'application/json', 404);
			} else {
				return new Response($data->toArray(), $this->request->headers->accept, 200);
			}
		case 'POST':
			$json = Request::getRawBody();
			$data = json_decode($json, true);
			if (!$this->schema->convertValues($data)) {
				return new Response(null, 'application/json', 400);
			}
			$entity = $this->em->createEntity($data);
			$entity->persist();
			return new Response(true, 'application/json');
		}
	}
}

