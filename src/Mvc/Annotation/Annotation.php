<?php

namespace Mvc\Annotation;


/**
 * Représente une annotation.
 * Parse des annotations de la forme:
 *   "@MyAnnotation"
 *   "@MyAnnotation(param1, param2, ...)"
 */
class Annotation
{
	/**
	 * Nom de l'annotation
	 */
	protected $name;

	/**
	 * Liste des paramètres de l'annotation
	 */
	protected $parameters = [];


	/**
	 * Constructeur.
	 *
	 * @param string $name       Nom de l'annotation
	 * @param array $parameters  Liste des paramètres de l'annotation
	 */
	public function __construct(string $name, array $parameters=[])
	{
		$this->name = $name;
		$this->parameters = $parameters;
	}


	/**
	 * Parse la chaine fournie, et crée l'annotation correspondante.
	 * Si le parse échoue, renvoie null.
	 *
	 * @param string $input  Chaine à parser
	 *
	 * return ?Annotation
	 */
	public static function createFromString(string $input): ?Annotation
	{
		// Parse une ligne de type: "@MyAnnot(param1, param2, ...)"
		$success = preg_match('/@(\w+)(?:\s*\((.*)\))?/', $input, $matches);

		if (!$success) {
			return null;
		}

		// Récupère le nom de l'annotation:
		$anno_name = $matches[1];

		// Récupère et sépare les paramètres:
		$parameters = $matches[2] ?? '';
		$parameters = array_map(function($param) {
			return trim($param);
		}, explode(',', $parameters));

		return new Annotation($anno_name, $parameters);
	}


	/*
	 * Getter for name
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/*
	 * Getter for parameters
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}


	/**
	 * Renvoie le nième paramètre.
	 *
	 * @param integer $n
	 *
	 * @return string
	 */
	public function getParameter(int $n): string
	{
		return $this->parameters[$n];
	}


	/**
	 * S'assure que l'annotation possède un certain nombre de paramètres.
	 *
	 * @param int $n
	 * @param string $message
	 *
	 * @return 
	 */
	public function mustHaveNParameters(int $n, $message=null)
	{
		if (count($this->parameters) != $n) {
			if (is_null($message)) {
				$message = "Annotation {$this->name} must have $n parameter(s)";
			}
			Assert::throwAssert($message);
		}
	}
}

