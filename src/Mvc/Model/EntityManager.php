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

		// Données factices:
		$this->createEntity([
			'name' => 'Espagne',
			'population' => 50000000,
			'capital' => 'Madrid',
			'language' => 'Espagnol',
		]);
		$this->createEntity([
			'name' => 'France',
			'population' => 65000000,
			'capital' => 'Paris',
			'language' => 'Français',
		]);
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
		foreach ($this->entities as $entity) {
			if ($entity->getId() === $id) {
				return $entity;
			}
		}
		return null;
	}
	
}

