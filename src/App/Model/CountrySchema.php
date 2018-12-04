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
			->addColumnFromDef('name', [ 'type' => 'string', 'primary' => true ])
			->addColumnFromDef('population', [ 'type' => 'integer' ])
			->addColumnFromDef('capital', [ 'type' => 'string' ])
			->addColumnFromDef('language', [ 'type' => 'string' ])
		;
	}
}

