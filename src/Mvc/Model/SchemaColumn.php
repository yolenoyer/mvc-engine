<?php

namespace Mvc\Model;

use \Mvc\Assert;
use \Mvc\Annotation\DocComment;


/**
 * Décrit une colonne de schéma.
 */
class SchemaColumn
{
	protected $name;
	protected $type;
	protected $_isPrimaryKey;
	protected $schema;


	/**
	 * Constructeur.
	 *
	 * @param Schema $schema     Schéma auquel est rattaché cette colonne
	 * @param string $name       Nom de la colonne
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
	 * Crée une nouvelle instance de SchemaColumn à partir d'une propriété décorée.
	 * Renvoie null si l'annotation '@Column' n'est pas définie.
	 * Envoie une exception si les annotations sont incorrectes ou insuffisantes.
	 *
	 * @param \ReflectionProperty $reflect_prop  Reflection d'une propriété de classe
	 * @param Schema $schema  Schéma auquel va être attaché la nouvelle colonne
	 *
	 * @return SchemaColumn | null
	 */
	public static function createFromClassProperty(
		\ReflectionProperty $reflect_prop,
		Schema $schema
	): ?SchemaColumn
	{
		$comments = $reflect_prop->getDocComment();
		$doc_comment = new DocComment($comments);

		// Doit posséder l'annotation '@Column':
		if (!$doc_comment->hasAnnotation('column')) {
			return null;
		}

		// Nom de la colonne:
		$column_name = $reflect_prop->getName();

		// Type:
		$type_annotation = $doc_comment->getOneAnnotation('type');
		Assert::mustBeNotNull($type_annotation,
			"Schema '{$schema->getName()}': the property '$column_name' must have a '@Type()' annotation"
		);
		$type_annotation->mustHaveNParameters(1);
		$type = $type_annotation->getParameter(0);

		// Clé primaire:
		$is_primary = $doc_comment->hasAnnotation('primary');

		// Autoindent:
		$is_autoindent = $doc_comment->hasAnnotation('autoindent');

		$definition = [
			'type' => $type,
			'primary' => $is_primary,
			'autoindent' => $is_autoindent,
		];

		return new SchemaColumn($schema, $column_name, $definition);
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
	public function setName(string $name): SchemaColumn
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
	public function setType($type): SchemaColumn
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
	public function setIsPrimaryKey($isPrimaryKey): SchemaColumn
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
	public function setSchema(Schema $schema): SchemaColumn
	{
		$this->schema = $schema;
		return $this;
	}
	

	/**
	 * Envoie une exception si la valeur donnée n'est pas valide pour cette colonne.
	 *
	 * @param mixed $value
	 */
	public function mustBeValidValue($value)
	{
		$type = gettype($value);
		Assert::mustHaveType($value, $this->type,
			"Wrong type ('$type') for the column '{$this}': must be '{$this->type}'"
		);
	}
	

}

