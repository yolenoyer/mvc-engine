<?php

namespace Mvc\Model;


/**
 * Permet de gérer une collection d'entités.
 */
class EntityManager
{
	protected $schema;
	protected $entities = [];


	/**
	 * Constructeur.
	 *
	 * @param Schema $schema  Schéma à gérer
	 */
	public function __construct(Schema $schema)
	{
		$this->schema = $schema;
	}


	/**
	 * Crée une nouvelle entité, qui doit correspondre au schéma du manager.
	 *
	 * @param array $data  Données rattachées à la nouvelle entité
	 */
	public function createEntity(array $data): Entity
	{
		$entity = $this->schema->createEntity($data);
		array_push($this->entities, $entity);
		return $entity;
	}


	/**
	 * Trouve une entité par son id.
	 *
	 * @param mixed $id
	 *
	 * @return Entity|null
	 */
	public function findEntity($id)
	{
		$schema = $this->schema;
		$primary = $schema->getPrimaryKey()->getName();

		$db = \Mvc\Database\Database::getInstance();
		$pdo = $db->getPdo();

		$prepared_query = "SELECT * FROM `{$schema->getName()}` WHERE `$primary`=?";
		$stmt = $pdo->prepare($prepared_query);

		$stmt->execute([ $id ]);
		$fetch = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		if (empty($fetch)) {
			return null;
		}
		$data = $fetch[0];

		$schema->convertValues($data);

		return $this->createEntity($data);
	}
	
}

