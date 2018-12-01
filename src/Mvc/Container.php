<?php

namespace Mvc;

use \Mvc\Assert;


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
	 * Vérifie l'existence d'un paramètre.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public static function hasParameter(string $key): bool
	{
		$parameters = self::getParameters();
		return isset($parameters[$key]);
	}



	/**
	 * Renvoie une valeur de configuration, ou null si non-trouvé.
	 *
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public static function getParameter(string $key)
	{
		$container = self::getInstance();
		return $container->parameters[$key] ?? null;
	}


	/**
	 * Renvoie une valeur de configuration, ou pousse une exception si non-trouvé.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public static function getMandatoryParameter(string $key)
	{
		self::assertHasParameter($key);
		$parameters = self::getParameters();
		return $parameters[$key];
	}


	/**
	 * Renvoie l'ensemble des paramètres.
	 *
	 * @return array
	 */
	public static function getParameters(): array
	{
		$container = self::getInstance();
		return $container->parameters;
	}


	/**
	 * Définit un paramètre de configuration.
	 *
	 * @param string $key   Nom du paramètre
	 * @param mixed $value  Valeur à configurer
	 *
	 * @return Container  Pour chainage
	 */
	public static function setParameter(string $key, $value)
	{
		$container = self::getInstance();
		$container->parameters[$key] = $value;
		return $container;
	}


	/**
	 * Définit plusieurs paramètres en même temps.
	 *
	 * @param array $parameters  Tableau de clés/valeurs
	 *
	 * @return Container  Pour chainage
	 */
	public static function setParameters(array $parameters)
	{
		$container = self::getInstance();
		$container->parameters = array_merge($container->parameters, $parameters);
		return $container;
	}


	/**
	 * Vérifie qu'un paramètre existe ou envoie une exception.
	 *
	 * @param string $key
	 */
	public static function assertHasParameter(string $key)
	{
		Assert::mustBeTrue(
			self::hasParameter($key),
			"Missing mandatory parameter in configuration: '$key'"
		);
	}

}

