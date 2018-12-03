<?php

namespace Mvc\Controller;


/**
 * Gère en Rest les interactions avec un schéma donné.
 */
class RestController extends Controller
{
	protected $baseUrl;

	/**
	 * Constructeur.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$baseUrl = $this->getMandatoryRouteParameter('baseUrl');
	}
}

