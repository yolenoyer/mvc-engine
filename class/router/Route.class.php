<?php

class Route
{
	public $route;
	public $controllerName;
	public $subpaths;


	public function __construct(string $route, string $controller_name)
	{
		$this->route = $route;
		$this->subpaths = explode('/', $route);
		$this->controllerName = $controller_name;
	}


	public function match(string $route)
	{
		$params = [];
		$subpaths = explode('/', $route);

		if (count($this->subpaths) != count($subpaths)) {
			return false;
		}

		foreach ($this->subpaths as $i => $model) {
			$to_compare = $subpaths[$i];

			if (self::isVariable($model)) {
				$varname = substr($model, 1);
				$params[$varname] = $to_compare;
			} elseif ($model != $to_compare) {
				return false;
			}
		}

		return new Request($this, $params);
	}


	public static function isVariable($s)
	{
		return strlen($s) >= 2 && $s[0] === ':';
	}


}

