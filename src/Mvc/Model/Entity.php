<?php

namespace Mvc\Model;

use \Mvc\Assert;


/**
 * Représente une instance de schéma.
 */
class Entity
{
	protected $schema;
	protected $data;

	/**
	 * Constructeur.
	 *
	 * @param Schema $schema  Schéma rattaché
	 * @param array $data     Liste des valeurs de chaque colonne de l'entité
	 */
	public function __construct(Schema $schema, array $data)
	{
		$this->schema = $schema;
		$this->schema->mustBeValidData($data);

		$this->data = [];
		foreach ($this->schema->getColumnNames() as $column_name) {
			$this->data[$column_name] = $data[$column_name];
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
	 * Renvoie la valeur d'une colonne donnée.
	 *
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function get(string $column_name)
	{
		$this->mustBeValidColumnName($column_name);
		return $this->data[$column_name];
	}


	/**
	 * Définit la valeur d'une colonne.
	 *
	 * @param string $column_name
	 * @param mixed $value
	 *
	 * @return Entity  Pour chainage
	 */
	public function set(string $column_name, $value): Entity
	{
		$this->mustBeValidColumnName($column_name);
		$column = $this->schema->getColumn($column_name);
		$column->mustBeValidValue($value);
		$this->data[$column_name] = $value;
		return $this;
	}


	/**
	 * Renvoie la valeur contenue dans la clé primaire de l'entité.
	 *
	 * @return mixed
	 */
	public function getId()
	{
		$this->schema->mustHavePrimaryKey();
		$id_column = $this->schema->getPrimaryKey();
		$column_name = $id_column->getName();
		return $this->data[$column_name];
	}
	

	/**
	 * S'assure qu'un nom de colonne est valide.
	 *
	 * @param string $column_name
	 */
	public function mustBeValidColumnName(string $column_name)
	{
		Assert::mustBeTrue($this->schema->hasColumn($column_name),
			"The column '$column_name' does not exist in the '{$this->schema->getName()}' schema."
		);
	}

}

