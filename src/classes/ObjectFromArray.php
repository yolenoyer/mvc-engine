<?php

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

