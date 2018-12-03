<?php

namespace Mvc\Model;

use \Mvc\Assert;


class Entity
{
	protected $schema;
	protected $data;

	/**
	 * Constructeur.
	 *
	 * @param array $properties  Liste des propriétés publiques du modèle
	 */
	public function __construct(Schema $schema, array $data)
	{
		$this->schema = $schema;
		$this->schema->mustBeValidData($data);

		$this->data = [];
		foreach ($this->schema->getPropertyNames() as $prop_name) {
			$this->data[$prop_name] = $data[$prop_name];
		}
	}


	/**
	 * Renvoie le modèle sous forme de tableau associatif.
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->data;
	}


	/**
	 * Renvoie la valeur d'une propriété donnée.
	 *
	 * @param string $prop_name
	 *
	 * @return mixed
	 */
	public function get(string $prop_name)
	{
		$this->mustBeValidPropertyName($prop_name);
		return $this->data[$prop_name];
	}


	/**
	 * Définit la valeur d'une propriété.
	 *
	 * @param string $prop_name
	 * @param mixed $value
	 *
	 * @return Entity  Pour chainage
	 */
	public function set(string $prop_name, $value): Entity
	{
		$this->mustBeValidPropertyName($prop_name);
		$property = $this->schema->getProperty($prop_name);
		$property->mustBeValidValue($value);
		$this->data[$prop_name] = $value;
		return $this;
	}
	

	/**
	 * S'assure qu'un nom de propriété est valide.
	 *
	 * @param string $prop_name
	 */
	public function mustBeValidPropertyName(string $prop_name)
	{
		Assert::mustBeTrue($this->schema->hasProperty($prop_name),
			"The property '$prop_name' does not exist in the '{$this->schema->getName()}' schema."
		);
	}
	
}

