<?php

namespace Mvc\Controller;

use \Mvc\Http\Response;
use \Mvc\Http\Request;
use \Mvc\Database\EntityManager;
use \Mvc\Model\Schema;
use \Mvc\Assert;


/**
 * Gère en Rest les interactions avec un schéma donné dans les paramètres de la route.
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
		$SchemaClass = $this->routeParameters->schema;
		if (!is_null($SchemaClass)) {
			$this->schema = new $SchemaClass();
		} else {
			$EntityClass = $this->routeParameters->entity;
			if (is_null($EntityClass)) {
				Assert::throwAssert(
					"Route '{$this->getRoute()}': either the 'schema' parameter or the 'entity' parameter must be defined"
				);
			}
			$this->schema = Schema::getSchemaFromEntity($EntityClass);
		}
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
				try {
					$entity = $this->em->newEntity($data);
					$entity->mustBeValidData(true); // true = valide+complet (pas de colonne manquante)
					$this->em->persist($entity);
				}
				catch (\Mvc\Exception $e) {
					return new Response('Invalid data set: '.$e->getMessage(), 400); // Bad Request
				}
				return new Response();

			case 'PUT':
				$entity = $this->em->find($this->id);

				if (is_null($entity)) {
					return new Response('Not found', 404); // Not Found
				}

				$data = $this->request->getBodyData();
				if (!$this->schema->convertValues($data)) {
					return new Response('Invalid data set', 400); // Bad Request
				}
				try {
					$entity->setData($data);
				}
				catch (\Mvc\Exception $e) {
					return new Response('Invalid data', 400); // Bad Request
				}
				$this->em->update($entity);
				return new Response();

			case 'DELETE':
				return new Response('To be done...', 418, 'text/plain'); // Teapot

			default:
				return new Response('Unrecognized HTTP method', 405, 'text/plain'); // Method Not Allowed
		}
	}
}

