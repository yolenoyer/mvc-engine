<?php

namespace Mvc\Database;

use \Mvc\Container;


/**
 * Gère la connexion à une base de données (MySql).
 */
class Database
{
	private $pdo;


	/**
	 * Constructeur.
	 *
	 * @param array $connection  Paramètres de connexion
	 */
	public function __construct(array $connection)
	{
		try {
			$dsn = "{$connection['type']}:host={$connection['host']};dbname={$connection['dbname']}";
			$this->pdo = new \PDO($dsn, $connection['username'], $connection['password'], [
				\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			]);
		}
		catch (\PDOException $e) {
			throw new \Mvc\Exception("Connection to database failed.");
		}
	}


	/**
	 * Retourne une instance unique de Database.
	 *
	 * @return Database
	 */
	public static function getInstance(): Database
	{
		static $db = null;
		if (is_null($db)) {
			$connection = Container::getMandatoryParameter('database.connection');
			$db = new Database($connection);
		}
		return $db;
	}


	/*
	 * Getter for pdo
	 */
	public function getPdo(): \PDO
	{
		return $this->pdo;
	}
}

