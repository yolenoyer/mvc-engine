<?php

namespace Mvc;


/**
 * Crée un objet à partir d'un tableau associatif.
 * Chaque clé du tableau est accessible via une propriété homonyme.
 */
class ObjectFromArray
{
	public $array;

	public function __construct(array $arr)
	{
		$this->array = $arr;
	}

	public function __get($key)
	{
		if (isset($this->array[$key])) {
			$value = $this->array[$key];
			if (is_array($value)) {
				return new ObjectFromArray($value);
			} else {
				return $value;
			}
		}
		return null;
	}

	public function __set($key, $value)
	{
		$this->array[$key] = $value;
	}

}

