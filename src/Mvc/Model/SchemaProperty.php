<?php

namespace Mvc\Model;

use \Mvc\Assert;


/**
 * Décrit une propriété de schéma.
 */
class SchemaProperty
{
	protected $name;
	protected $type;
	protected $_isPrimaryKey;
	protected $schema;


	/**
	 * Constructeur.
	 *
	 * @param Schema $schema     Schéma auquel est rattaché cette propriété
	 * @param string $name       Nom de la propriété
	 * @param array $definition  Définition
	 */
	public function __construct(Schema $schema, string $name, array $definition)
	{
		$this->name = $name;
		$this->type = $definition['type'] ?? 'string';
		$this->_isPrimaryKey = !!($definition['primary'] ?? false);
		$this->schema = $schema;
	}


	/**
	 * Représentation chainée.
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return "{$this->schema->getName()}->{$this->name}";
	}
	

	/*
	 * Getter for name
	 */
	public function getName(): string
	{
		return $this->name;
	}
	
	/*
	 * Setter for name
	 */
	public function setName(string $name): SchemaProperty
	{
		$this->name = $name;
		return $this;
	}

	/*
	 * Getter for type
	 */
	public function getType(): string
	{
		return $this->type;
	}
	
	/*
	 * Setter for type
	 */
	public function setType($type): SchemaProperty
	{
		$this->type = $type;
		return $this;
	}

	/*
	 * Getter for isPrimaryKey
	 */
	public function isPrimaryKey(): bool
	{
		return $this->_isPrimaryKey;
	}
	
	/*
	 * Setter for isPrimaryKey
	 */
	public function setIsPrimaryKey($isPrimaryKey): SchemaProperty
	{
		$this->_isPrimaryKey = $isPrimaryKey;
		return $this;
	}

	/*
	 * Getter for schema
	 */
	public function getSchema(): Schema
	{
		return $this->schema;
	}
	
	/*
	 * Setter for schema
	 */
	public function setSchema(Schema $schema): SchemaProperty
	{
		$this->schema = $schema;
		return $this;
	}
	

	/**
	 * Envoie une exception si la valeur donnée n'est pas valide pour cette propriété.
	 *
	 * @param mixed $value
	 */
	public function mustBeValidValue($value)
	{
		$type = gettype($value);
		Assert::mustHaveType($value, $this->type,
			"Wrong type ('$type') for the property '{$this}': must be '{$this->type}'"
		);
	}
	

}

