<?php

$project_getters = [
	'ProjectRoot' => function() {
		return realpath(__DIR__.'/..');
	},
	'UrlRoot' => function() {
		return Util::joinPaths(
			substr(\Get::ProjectRoot(), strlen($_SERVER['DOCUMENT_ROOT']))
		);;
	},
	'RelativeUrl' => function() {
		$url = $_SERVER['REQUEST_URI'];
		return substr($url, strlen(\Get::UrlRoot()));
	},
	'Method' => function() {
		return $_SERVER['REQUEST_METHOD'];
	},
];


class Get {
	protected static function getNamedSingleton($name, $function)
	{
		static $singletons = [];
		if (!isset($singletons[$name])) {
			$singletons[$name] = $function();
		}
		return $singletons[$name];
	}

	public static function __callStatic($name, $args)
	{
		global $project_getters;
		foreach ($project_getters as $getter_name => $getter) {
			if ($name == $getter_name) {
				return self::getNamedSingleton($name, $getter);
			}
		}
	}
}

