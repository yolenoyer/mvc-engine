<?php

namespace Mvc\Model;

use \Mvc\Assert;


/**
 * Décrit un type de modèle.
 */
class Schema
{
	protected $name;
	protected $properties = [];


	/**
	 * Constructeur.
	 */
	public function __construct(string $name, array $definitions=[])
	{
		$this->name = $name;
		$this->addProperties($definitions);
	}


	/**
	 * Ajoute une propriété dans la définition du schéma.
	 *
	 * @param string $name       Nom de la nouvelle propriété
	 * @param array $definition  Définition
	 *
	 * @return Schema  Pour chainage
	 */
	public function addProperty(string $name, array $definition): Schema
	{
		array_push($this->properties, new SchemaProperty($this, $name, $definition));
		return $this;
	}


	/**
	 * Ajoute plusieurs propriétés à la fois.
	 *
	 * @param array $definitions
	 *
	 * @return Schema  Pour chainage
	 */
	public function addProperties(array $definitions): Schema
	{
		foreach ($definitions as $prop_name => $definition) {
			$this->addProperty($prop_name, $definition);
		}
		return $this;
	}


	/*
	 * Getter for properties
	 */
	public function getProperties(): array
	{
		return $this->properties;
	}


	/**
	 * Cherche une propriété par son nom.
	 *
	 * @param string $prop_name
	 *
	 * @return SchemaProperty
	 */
	public function getProperty(string $prop_name): SchemaProperty
	{
		foreach ($this->properties as $property) {
			if ($property->getName() === $prop_name) {
				return $property;
			}
		}
		throw new \Mvc\Exception("Unknown property name: '$prop_name'.");
	}


	/**
	 * Renvoie true si la propriété existe.
	 *
	 * @param string $prop_name  Nom de propriété à tester
	 *
	 * @return bool
	 */
	public function hasProperty(string $prop_name): bool
	{
		foreach ($this->properties as $property) {
			if ($property->getName() == $prop_name) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Renvoie la liste des noms de toutes les propriétés.
	 *
	 * @return array
	 */
	public function getPropertyNames(): array
	{
		return array_map(function($prop) {
			return $prop->getName();
		}, $this->properties);
	}


	/**
	 * Crée une instance de ce schéma.
	 *
	 * @param array $data  Données du modèle
	 *
	 * @return Entiy
	 */
	public function createInstance(array $data): Entity
	{
		return new Entity($this, $data);
	}


	/**
	 * Vérifie si les données fournies collent au schéma.
	 * Envoie une exception si ce n'est pas le cas.
	 *
	 * @param array $data
	 */
	public function mustBeValidData(array $data)
	{
		foreach ($this->properties as $property) {
			$prop_name = $property->getName();
			Assert::mustKeyExist($data, $prop_name,
				"Missing entity property '$prop_name', unable to match the '{$this->name}' schema."
			);
			$property->mustBeValidValue($data[$prop_name]);
		}
	}


	/*
	 * Getter for name
	 */
	public function getName()
	{
		return $this->name;
	}

}

