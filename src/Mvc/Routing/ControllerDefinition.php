<?php

namespace Mvc\Routing;

use \Mvc\ObjectFromArray;


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
	 */
	public function __construct($definition)
	{
		$parameters = [];

		if (is_string($definition)) {
			$this->name = $definition;
		} elseif (is_array($definition)) {
			$this->name = $definition[0];
			$parameters = $definition[1] ?? [];
		} else {
			throw new Exception("Routeur: erreur de configuration");
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

