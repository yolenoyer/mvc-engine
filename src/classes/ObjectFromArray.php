<?php

/**
 * Crée un object à partir d'un tableau associatif.
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
			return $this->array[$key];
		}
	}
	
	public function __set($key, $value)
	{
		$this->array[$key] = $value;
	}
	
}

