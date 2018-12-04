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
					return new Response('Not found', 404); // Not Found
				} else {
					return new Response($entity->toArray(), 200); // OK
				}

			case 'POST':
				$data = $this->request->getBodyData();
				if (!$this->schema->convertValues($data)) {
					return new Response('Invalid data set', 400); // Bad Request
				}
				$entity = $this->em->newEntity($data);
				$this->em->persist($entity);
				return new Response();

			case 'PUT':
				return new Response('To be done...', 418, 'text/plain'); // Teapot

			case 'DELETE':
				return new Response('To be done...', 418, 'text/plain'); // Teapot

			default:
				return new Response('Unrecognized HTTP method', 405, 'text/plain'); // Method Not Allowed
		}
	}
}

