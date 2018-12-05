<?php

namespace App\Entity;


/**
 * @Entity
 */
class Person
{
	/**
	 * @Column
	 * @Primary
	 * @AutoIndent
	 * @Type(integer)
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

