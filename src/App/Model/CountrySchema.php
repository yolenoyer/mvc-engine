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
			->addPropertyFromDef('name', [ 'type' => 'string', 'primary' => true ])
			->addPropertyFromDef('population', [ 'type' => 'integer' ])
			->addPropertyFromDef('capital', [ 'type' => 'string' ])
			->addPropertyFromDef('language', [ 'type' => 'string' ])
		;
	}
}

