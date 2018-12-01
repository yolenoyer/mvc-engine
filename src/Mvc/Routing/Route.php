<?php

namespace Mvc\Routing;

use \Mvc\Http\Request;


/**
 * Décrit un lien entre un modèle d'URL et un contrôleur.
 */
class Route
{
	public $templateUrl;
	public $controllerDefinition;
	public $templateUrlParts;


	/**
	 * Constructeur.
	 *
	 * @param string $templateUrl     Template d'url (contenant des variables optionnelles)
	 * @param $controller_definition  Définition du contrôleur à utiliser (chaine, ou tableau
	 *      si l'on veut fournir des paramètres au contrôleur)
	 */
	public function __construct(string $templateUrl, $controller_definition, string $controller_namespace='')
	{
		$this->setTemplateUrl($templateUrl);
		$this->controllerDefinition = new ControllerDefinition($controller_definition, $controller_namespace);
	}


	/**
	 * Définit le template d'url pour cette route.
	 *
	 * @param string $templateUrl  Ex: /products/cars/:id
	 *
	 * @return Route  Chaînage
	 */
	public function setTemplateUrl(string $templateUrl): Route
	{
		$this->templateUrl = $templateUrl;
		$this->templateUrlParts = explode('/', $templateUrl);
		return $this;
	}
	

	/**
	 * Vérifie si une url correspond bien au template d'url de cette route.
	 * Si c'est le cas, renvoie un objet requête, possédant une instance du contrôleur à utiliser.
	 *
	 * @param string $url  Url à tester
	 *
	 * @return Request|null
	 */
	public function match(string $url)
	{
		$url_params = [];
		$url_parts = explode('/', $url);

		if (count($this->templateUrlParts) != count($url_parts)) {
			return null;
		}

		foreach ($this->templateUrlParts as $i => $template_url_part) {
			$url_part = $url_parts[$i];

			if (self::isVariable($template_url_part)) {
				$varname = substr($template_url_part, 1);
				$url_params[$varname] = $url_part;
			} elseif ($template_url_part != $url_part) {
				return null;
			}
		}

		return new Request($this, $url_params);
	}


	/**
	 * Renvoie le nom du contrôleur associé à cette route.
	 *
	 * @return string
	 */
	public function getControllerName(): string
	{
		return $this->controllerDefinition->getName();
	}
	


	/**
	 * Vérifie si une chaine correspond à un nom de variable (doit commencer par ':' et posséder au
	 * moins un caractère supplémentaire).
	 *
	 * @param string $s  Chaine à tester
	 *
	 * @return bool
	 */
	public static function isVariable(string $s): bool
	{
		return strlen($s) >= 2 && $s[0] === ':';
	}


}

