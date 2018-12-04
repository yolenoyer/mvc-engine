<?php

namespace Mvc\Database;

use \Mvc\Model\Schema;
use \Mvc\Model\Entity;


/**
 * Permet de gérer une collection d'entités.
 */
class EntityManager
{
	protected $schema;
	protected $db;
	protected $pdo;


	/**
	 * Constructeur.
	 *
	 * @param Schema $schema  Schéma à gérer
	 */
	public function __construct(Schema $schema)
	{
		$this->schema = $schema;
		$this->db = \Mvc\Database\Database::getInstance();
		$this->pdo = $this->db->getPdo();
	}


	/**
	 * Crée une nouvelle entité, avec les données fournies qui doivent correspondre au schéma du
	 * manager.
	 *
	 * @param array $data  Données à rattacher à la nouvelle entité
	 *
	 * @return Entity
	 */
	public function newEntity(array $data): Entity
	{
		return $this->schema->newEntity($data);
	}


	/**
	 * Persiste une entité dans la base de données.
	 *
	 * @param Entity $entity
	 */
	public function persist(Entity $entity)
	{
		$column_names = $this->schema->getColumnNames();
		$column_list = join(',', array_map(function($column_name) {
			return "`$column_name`";
		}, $column_names));
		$placeholders = join(',', array_fill(0, count($column_names), '?'));

		$prepared_query = "INSERT INTO `{$this->schema->getName()}` ($column_list) VALUES($placeholders)";
		$stmt = $this->pdo->prepare($prepared_query);

		$params = [];
		foreach ($column_names as $column_name) {
			array_push($params, $entity->get($column_name));
		}

		$stmt->execute($params);
	}


	/**
	 * Trouve une entité par son id.
	 *
	 * @param mixed $id
	 *
	 * @return Entity|null
	 */
	public function find($id)
	{
		$primary = $this->schema->getPrimaryKey()->getName();

		$prepared_query = "SELECT * FROM `{$this->schema->getName()}` WHERE `$primary`=?";
		$stmt = $this->pdo->prepare($prepared_query);

		$stmt->execute([ $id ]);
		$fetch = $stmt->fetch(\PDO::FETCH_ASSOC);
		if ($fetch === false) {
			return null;
		}

		$this->schema->convertValues($fetch);

		return $this->schema->newEntity($fetch);
	}

}

