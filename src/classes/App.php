<?php

class App {

	private $projectPath;
	private $urlRoot;
	private $relativeUrl;


	public function __construct() {
		$this->projectPath = realpath(__DIR__.'/../..');

		$this->urlRoot = Util::joinPaths(
			substr($this->projectPath, strlen($_SERVER['DOCUMENT_ROOT']))
		);

		$this->relativeUrl =
			substr($_SERVER['REQUEST_URI'], strlen($this->urlRoot));
	}


	public static function getInstance(): App
	{
		static $app = null;
		if (is_null($app)) {
			$app = new App();
		}
		return $app;
	}



	public static function get(string $prop)
	{
		static $getters = [
			'projectPath' => 'getProjectPath',
			'urlRoot' => 'getUrlRoot',
			'relativeUrl' => 'getRelativeUrl',
		];

		$app = self::getInstance();
		$getter = $getters[$prop];
		return $app->$getter();
	}



	public static function getVars(): array
	{
		$app = self::getInstance();
		return [
			'projectpath' => $app->getProjectPath(),
			'urlRoot' => $app->getUrlRoot(),
		];
	}




	public function getProjectPath() {
		return $this->projectPath;
	}

	public function getUrlRoot() {
		return $this->urlRoot;
	}

	public function getRelativeUrl() {
		return $this->relativeUrl;
	}

}

