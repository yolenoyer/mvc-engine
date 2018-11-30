<?php

namespace Routing;


/**
 * Décrit un lien entre un modèle d'URL et un contrôleur.
 */
class Route
{
	public $templateUrl;
	public $controllerName;
	public $templateUrlParts;


	public function __construct(string $templateUrl, string $controller_name)
	{
		$this->setTemplateUrl($templateUrl);
		$this->controllerName = $controller_name;
	}


	public function setTemplateUrl(string $templateUrl): Route
	{
		$this->templateUrl = $templateUrl;
		$this->templateUrlParts = explode('/', $templateUrl);
		return $this;
	}
	

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

		return new \Http\Request($this, $url_params);
	}


	public static function isVariable(string $s): bool
	{
		return strlen($s) >= 2 && $s[0] === ':';
	}


}

