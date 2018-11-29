<?php

class Db {
	public $pdo = null;


	public function __construct() {
		$this->log = Logger::getLogger('my-logger');
	}


	public static function getInstance()
	{
		static $db = null;

		if (is_null($db)) {
			$db = new Db();
			$db->connect();
		}

		return $db;
	}
	

	public function connect()
	{
		$dsn = 'mysql:host=localhost;dbname=formationsm2i';
		$username = 'root';
		$password = '';

		try {
			$this->pdo = new PDO($dsn, $username, $password, [
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			]);
		}
		catch(Exception $e) {
			$this->log->error($e->getMessage());
			throw $e;
		}
	}


	public function getAllStudents()
	{
		$req = $this->pdo->query('SELECT * FROM stagiaire');
		return $req->fetchAll(PDO::FETCH_CLASS, "Student");
	}
	

	public function getStudent($id)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM stagiaire WHERE Identifiant=:id');
		$stmt->execute([
			'id' => $id
		]);
		$res = $stmt->fetchAll(PDO::FETCH_CLASS, "Student");
		if (count($res) === 0) {
			return null;
		} else {
			return $res[0];
		}
	}
	
}

