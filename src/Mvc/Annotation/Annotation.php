<?php

namespace Mvc\Annotation;


/**
 * Représente une annotation.
 */
class Annotation
{
	protected $name;
	protected $parameters = [];


	/**
	 * Constructeur.
	 *
	 * @param string $name       Nom de l'annotation
	 * @param array $parameters  Liste des paramètres de l'annoation
	 */
	public function __construct(string $name, array $parameters=[])
	{
		$this->name = $name;
		$this->parameters = $parameters;
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

