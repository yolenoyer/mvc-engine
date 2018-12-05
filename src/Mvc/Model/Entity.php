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

		$this->data = [];
		foreach ($this->schema->getColumnNames() as $column_name) {
			$this->data[$column_name] = $data[$column_name] ?? null;
		}

		$this->mustBeValidData();
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
	 * Définit plusieurs colonnes à la fois (tableau associatif).
	 *
	 * @param array $data
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value) {
			$this->set($key, $value);
		}
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
	 * Vérifie qu'une colonne a bien été définie.
	 * Si toutes les colonnes sont définies (à part les colonnes autoindent), l'entité est
	 * considérée comme "fully defined", et peut être éventuellement persistée comme nouvelle entité.
	 *
	 * @param string $column_name
	 *
	 * @return bool
	 */
	public function columnIsSet(string $column_name): bool
	{
		return isset($this->data[$column_name]) && !is_null($this->data[$column_name]);
	}
	

	/**
	 * Vérifie si les données fournies collent au schéma.
	 * Les données peuvent être incomplètes.
	 * Envoie une exception si ce n'est pas le cas.
	 *
	 * @param array $data
	 */
	public function mustBeValidData($mustBeFull=false)
	{
		foreach ($this->schema->getColumns() as $schema_column) {
			if ($schema_column->isAutoIndent()) {
				continue;
			}
			$column_name = $schema_column->getName();
			if (!$this->columnIsSet($column_name)) {
				if ($mustBeFull) {
					Assert::throwAssert(
						"Missing entity column '$column_name', unable to match the '{$this->schema->getName()}' schema."
					);
				} else {
					continue;
				}
			}
			$schema_column->mustBeValidValue($this->data[$column_name]);
		}
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

