<?php

namespace Mvc\Annotation;

use \Mvc\Assert;


/**
 * Gère une liste d'annotations.
 */
class DocComment
{
	protected $annotations = [];


	/**
	 * Constructeur.
	 */
	public function __construct(string $input)
	{
		$this->parse($input);
	}


	/**
	 * Ajoute une annotation.
	 *
	 * @param Annotation $annotation
	 *
	 * @return DocComment  Pour chainage
	 */
	public function addAnnotation(Annotation $annotation): DocComment
	{
		$name = strtolower($annotation->getName());
		if (!isset($this->annotations[$name])) {
			$this->annotations[$name] = [];
		}
		$this->annotations[$name][] = $annotation;
		return $this;
	}


	/**
	 * Cherche des annotations par leur nom, et renvoie un tableau des annotations trouvées.
	 *
	 * @param string $anno_name  Nom d'annotation à chercher
	 *
	 * @return array  Tableau d'annotations
	 */
	public function getAnnotations(string $anno_name): array
	{
		return $this->annotations[strtolower($anno_name)] ?? [];
	}


	/**
	 * Renvoie true si une annotation est trouvée.
	 *
	 * @param string $anno_name  Nom d'annotation à chercher
	 *
	 * @return bool
	 */
	public function hasAnnotation(string $anno_name): bool
	{
		return isset($this->annotations[$anno_name])
		   	&& !empty($this->annotations[$anno_name]);
	}


	/**
	 * Raccourci pour trouver la première annotation portant le nom donné.
	 * Renvoie null si non-trouvé.
	 *
	 * @param string $anno_name  Nom d'annotation à chercher
	 *
	 * @return Annotation|null
	 */
	public function getOneAnnotation(string $anno_name): ?Annotation
	{
		$annos = $this->getAnnotations($anno_name);
		return empty($annos) ? null : $annos[0];
		
	}


	/**
	 * Parse un doc comment.
	 *
	 * @param string $input
	 */
	protected function parse(string $input)
	{
		$lines = self::filterDocComment($input);
		foreach ($lines as $line) {
			$annotation = Annotation::createFromString($line);
			if ($annotation) {
				$this->addAnnotation($annotation);
			}
		}
	}


	/**
	 * Supprime les caractères de commentaires, conserve seulement les lignes commençant par un
	 * arobase.
	 *
	 * @param string $input  Texte à filtrer
	 *
	 * @return array  Tableau de lignes filtrées
	 */
	protected static function filterDocComment(string $input): array
	{
		$lines = array_map(function($line) {
			return preg_replace('/^\s*(\/?\*+\s\s*|\*\/\s*$)|\r|\n/', '', $line);
		}, explode("\n", $input));

		$lines = array_filter($lines, function($line) {
			return !empty($line) && $line[0] === '@';
		});

		return $lines;
	}
}

