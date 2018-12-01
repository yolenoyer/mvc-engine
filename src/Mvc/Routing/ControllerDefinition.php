<?php

namespace Mvc\Routing;

use \Mvc\ObjectFromArray;
use \Mvc\Assert;


/**
 * Décrit une configuration de routage.
 */
class ControllerDefinition
{
	// Nom du controlleur:
	private $name;

	// Paramètres passés au constructeur:
	private $parameters;


	/**
	 * Constructeur.
	 *
	 * @param mixed $definition  La définition peut être:
	 *     - une chaîne simple contenant le nom d'un contrôleur
	 *     - un tableau contenant le nom d'un contrôleur et une liste de paramètres à fournir au
	 *       contrôleur
	 * @param string $controller_namespace  Namespace du controlleur
	 */
	public function __construct($definition, string $controller_namespace='')
	{
		$parameters = [];

		if (is_string($definition)) {
			$name = $definition;
		} elseif (is_array($definition)) {
			$name = $definition['controller'];
			$parameters = $definition['parameters'] ?? [];
		} else {
			throw new Exception("Routeur: erreur de configuration");
		}

		Assert::mustBeNotEmpty($name, "Router: empty controller name");
		if ($name[0] == '\\') {
			$this->name = $name;
		} else {
			$this->name = "$controller_namespace\\$name";
		}

		$this->parameters = new ObjectFromArray($parameters);
	}


	/*
	 * Getter for name
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/*
	 * Getter for parameters
	 */
	public function getParameters(): ObjectFromArray
	{
		return $this->parameters;
	}

}

