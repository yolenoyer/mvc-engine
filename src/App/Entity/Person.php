<?php

namespace App\Entity;


/**
 * @Entity
 */
class Person
{
	/**
	 * @Column
	 * @Type(integer)
	 * @Primary
	 */
	public $id;

	/**
	 * @Column
	 * @Type(string)
	 */
	public $name;

	/**
	 * @Column
	 * @Type(string)
	 */
	public $address;
}

