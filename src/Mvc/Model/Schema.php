<?php

namespace Mvc\Model;

use \Mvc\Assert;


/**
 * Décrit un type de modèle.
 */
class Schema
{
	protected $name;
	protected $columns = [];
	protected $primaryKey = null;


	/**
	 * Constructeur.
	 */
	public function __construct(string $name, array $definitions=[])
	{
		$this->name = $name;
		$this->addColumnsFromDef($definitions);
	}


	/**
	 * Interne: renvoie le nom auto-généré à partir d'un nom de classe.
	 *
	 * @param string $class_name
	 *
	 * @return string
	 */
	private static function getSchemaName(string $class_name): string
	{
		$split = explode('\\', $class_name);
		return strtolower($split[count($split)-1]);
	}


	/**
	 * Renvoie un nouveau schéma à partir d'une classe annotée.
	 *
	 * @param string $class_name
	 *
	 * @return Schema
	 */
	public static function getSchemaFromEntity(string $class_name): Schema
	{
		$schema = new Schema(self::getSchemaName($class_name));
		$reflect_class = new \ReflectionClass($class_name);
		$properties = $reflect_class->getProperties(\ReflectionProperty::IS_PUBLIC);
		foreach ($properties as $property_refl) {
			$column = SchemaColumn::createFromClassProperty($property_refl, $schema);
			if (!is_null($column)) {
				$schema->addColumn($column);
			}
		}
		return $schema;
	}


	/**
	 * Représentation chainée.
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->name;
	}


	/**
	 * Ajoute une colonne dans la définition du schéma.
	 *
	 * @param string $name       Nom de la nouvelle colonne
	 * @param array $definition  Définition
	 *
	 * @return Schema  Pour chainage
	 */
	public function addColumn(SchemaColumn $column): Schema
	{
		array_push($this->columns, $column);

		// Définition éventuelle de la clé primaire:
		if ($column->isPrimaryKey()) {
			Assert::mustBeNull($this->primaryKey,
				"Error in schema construction ('{$this->name}'): multiple primary keys are not supported"
			);
			$this->primaryKey = $column;
		}

		return $this;
	}


	/**
	 * Ajoute une colonne dans la définition du schéma.
	 *
	 * @param string $name       Nom de la nouvelle colonne
	 * @param array $definition  Définition
	 *
	 * @return Schema  Pour chainage
	 */
	public function addColumnFromDef(string $name, array $definition): Schema
	{
		$this->addColumn(new SchemaColumn($this, $name, $definition));
		return $this;
	}


	/**
	 * Ajoute plusieurs colonnes à la fois.
	 *
	 * @param array $definitions
	 *
	 * @return Schema  Pour chainage
	 */
	public function addColumnsFromDef(array $definitions): Schema
	{
		foreach ($definitions as $column_name => $definition) {
			$this->addColumnFromDef($column_name, $definition);
		}
		return $this;
	}


	/*
	 * Getter for columns
	 */
	public function getColumns(): array
	{
		return $this->columns;
	}


	/**
	 * Renvoie toutes les colonnes qui ne sont pas autoindent.
	 *
	 * @return array
	 */
	public function getNoAutoColumns(): array
	{
		return array_filter($this->getColumns(), function($column) {
			return !$column->isAutoIndent();
		});
	}


	/**
	 * Renvoie le nom des colonnes qui ne sont pas autoindent.
	 *
	 * @return array
	 */
	public function getNoAutoColumnsNames(): array
	{
		return array_map(function($column) {
			return $column->getName();
		}, $this->getNoAutoColumns());
	}


	/**
	 * Cherche une colonne par son nom.
	 *
	 * @param string $column_name
	 *
	 * @return SchemaColumn
	 */
	public function getColumn(string $column_name): SchemaColumn
	{
		foreach ($this->columns as $column) {
			if ($column->getName() === $column_name) {
				return $column;
			}
		}
		throw new \Mvc\Exception("Unknown column name: '$column_name'.");
	}


	/**
	 * Renvoie true si la colonne existe.
	 *
	 * @param string $column_name  Nom de colonne à tester
	 *
	 * @return bool
	 */
	public function hasColumn(string $column_name): bool
	{
		foreach ($this->columns as $column) {
			if ($column->getName() == $column_name) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Renvoie la liste des noms de toutes les colonnes.
	 *
	 * @return array
	 */
	public function getColumnNames(): array
	{
		return array_map(function($column) {
			return $column->getName();
		}, $this->columns);
	}


	/**
	 * Crée une instance de ce schéma.
	 *
	 * @param array $data  Données du modèle
	 *
	 * @return Entity
	 */
	public function newEntity(array $data): Entity
	{
		return new Entity($this, $data);
	}


	/**
	 * Tente de convertir les données fournies vers le bon type.
	 * TODO: settype() est beaucoup trop tolérant!
	 *
	 * @param array &$data
	 *
	 * @return bool  Renvoie false si échec
	 */
	public function convertValues(&$data)
	{
		if (!is_array($data)) {
			return false;
		}
		$success = true;
		foreach ($this->columns as $column) {
			$column_name = $column->getName();
			if (!isset($data[$column_name]) || is_null($data[$column_name])) {
				continue;
			}
			if (!$column->convertValue($data[$column_name])) {
				$success = false;
			}
		}
		return $success;
	}


	/*
	 * Getter for name
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/*
	 * Getter for primaryKey
	 */
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}


	/**
	 * Renvoie le nom de la clé primaire, ou null si inexistant.
	 *
	 * @return string|null
	 */
	public function getPrimaryKeyName(): ?string
	{
		if (is_null($this->primaryKey)) {
			return null;
		}
		return $this->primaryKey->getName();
	}


	/**
	 * S'assure que le schéma possède une clé primaire.
	 */
	public function mustHavePrimaryKey()
	{
		Assert::mustBeNotNull($this->primaryKey,
			"The schema '{$this}' must have a primary key column"
		);
	}
}

