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
				$entity = $this->em->find($this->id);

				if (is_null($entity)) {
					return new Response(null, 'application/json', 404);
				} else {
					return new Response($entity->toArray(), $_SERVER['HTTP_ACCEPT'], 200);
				}

			case 'POST':
				$json = Request::getBody();
				$data = json_decode($json, true);
				if (!$this->schema->convertValues($data)) {
					return new Response(null, 'application/json', 400);
				}
				$entity = $this->em->newEntity($data);
				$this->em->persist($entity);
				return new Response(true, 'application/json');

			case 'PUT':
				return new Response('To be done...', 'text/plain', 418);

			case 'DELETE':
				return new Response('To be done...', 'text/plain', 418);

			default:
				return new Response('Unrecognized HTTP method', 'text/plain', 405);
		}
	}
}

