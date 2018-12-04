<?php

namespace App\Entity;


/**
 * @Entity
 */
class Person
{
	/**
	 * @Property
	 * @Type(integer)
	 * @Primary
	 */
	public $id;

	/**
	 * @Property
	 * @Type(string)
	 */
	public $name;

	/**
	 * @Property
	 * @Type(string)
	 */
	public $address;
}

