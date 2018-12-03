<?php

namespace App\Model;

use \Mvc\Model\Schema;


/**
 * Représente un pays.
 */
class CountrySchema extends Schema
{
	/**
	 * Constructeur.
	 */
	public function __construct() {
		parent::__construct('country');
		$this
			->addProperty('name', [ 'type' => 'string', 'primary' => true ])
			->addProperty('population', [ 'type' => 'integer' ])
			->addProperty('capital', [ 'type' => 'string' ])
			->addProperty('language', [ 'type' => 'string' ])
		;
	}
}

