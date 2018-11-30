<?php

namespace Mvc;


/**
 * Permet de récupérer des informations globales sur le projet (et l'url en cours).
 */
class App {

	// Le dossier réel contenant le projet complet:
	private $projectPath;

	// Url racine du projet (par rapport au dossier www):
	private $urlRoot;

	// Url relative au projet:
	private $relativeUrl;



	/**
	 * Contructeur.
	 */
	public function __construct() {
		$this->projectPath = realpath(__DIR__.'/../..');

		$this->urlRoot = Util::joinPaths(
			substr($this->projectPath, strlen($_SERVER['DOCUMENT_ROOT']))
		);

		$this->relativeUrl =
			substr($_SERVER['REQUEST_URI'], strlen($this->urlRoot));
	}


	/**
	 * Récupère une instance singleton.
	 *
	 * @return App
	 */
	public static function getInstance(): App
	{
		static $app = null;
		if (is_null($app)) {
			$app = new App();
		}
		return $app;
	}



	/**
	 * Récupère une propriété.
	 *
	 * @param string $prop
	 *
	 * @return mixed
	 */
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



	/**
	 * Renvoie un tableau contenant toutes les propriétés (utilisé pour passer ces infos dans les
	 * templates).
	 *
	 * @return array
	 */
	public static function getVars(): array
	{
		$app = self::getInstance();
		return [
			'projectpath' => $app->getProjectPath(),
			'urlRoot' => $app->getUrlRoot(),
		];
	}




	/**
	 * Renvoie le dossier réel contenant le projet complet.
	 *
	 * @return string
	 */
	public function getProjectPath(): string {
		return $this->projectPath;
	}

	/**
	 * Renvoie l'url racine du projet (par rapport au dossier www).
	 *
	 * @return string
	 */
	public function getUrlRoot(): string {
		return $this->urlRoot;
	}

	/**
	 * Récupère l'url relative au projet.
	 *
	 * @return string
	 */
	public function getRelativeUrl(): string {
		return $this->relativeUrl;
	}

}

