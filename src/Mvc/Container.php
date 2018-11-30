<?php

namespace Mvc;


/**
 * Permet un accès global à l'application (configuration, et autre futurement).
 */
class Container
{
	private $parameters = [];


	/**
	 * Renvoie une instance unique (singleton) de Container.
	 *
	 * @return Container
	 */
	public static function getInstance(): Container
	{
		static $container = null;
		if (is_null($container)) {
			$container = new Container();
		}
		return $container;
	}
	


	/**
	 * Définit un paramètre de configuration.
	 *
	 * @param string $key   Nom du paramètre
	 * @param mixed $value  Valeur à configurer
	 *
	 * @return Container  Pour chainage
	 */
	public function setParameter(string $key, $value)
	{
		$this->parameters[$key] = $value;
		return $this;
	}


	/**
	 * Définit plusieurs paramètres en même temps.
	 *
	 * @param array $parameters  Tableau de clés/valeurs
	 *
	 * @return Container  Pour chainage
	 */
	public function setParameters(array $parameters)
	{
		$this->parameters = array_merge($this->parameters, $parameters);
		return $this;
	}
	


	/**
	 * Renvoie une valeur de configuation.
	 *
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public function getParameter(string $key)
	{
		return $this->parameters[$key] ?? null;
	}
	
}

