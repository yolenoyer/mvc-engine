<?php

namespace Mvc\Annotation;


/**
 * Représente une propriété de classe décorée.
 */
class DecoratedProperty
{
	public $reflectProp;
	protected $docComment;


	/**
	 * Constructeur.
	 *
	 * @param \ReflectionProperty $reflect_prop
	 */
	public function __construct(\ReflectionProperty $reflect_prop)
	{
		$this->reflectProp = $reflect_prop;
		$comments = $this->reflectProp->getDocComment();
		$this->docComment = new DocComment($comments);
	}


	/**
	 * Renvoie le nom de la propriété.
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->reflectProp->getName();
	}


	/**
	 * Renvoie le contenu de @Type.
	 *
	 * @return 
	 */
	public function getType(): ?string
	{
		$type_anno = $this->docComment->getOneAnnotation('type');
		if (is_null($type_anno)) {
			return null;
		}
		$type_anno->mustHaveNParameters(1);
		return $type_anno->getParameter(0);
	}


	/**
	 * Renvoie true si la propriété est définie comme une propriété
	 * (annotation @Property).
	 *
	 * @return bool
	 */
	public function isProperty(): bool
	{
		return $this->docComment->hasAnnotation('property');
	}


	/**
	 * Renvoie true si la propriété est définie comme une clé primaire
	 * (annotation @Primary).
	 *
	 * @return bool
	 */
	public function isPrimary(): bool
	{
		return $this->docComment->hasAnnotation('primary');
	}


	/**
	 * Renvoie true si la propriété est définie avec un auto indent.
	 * (Annotation @AutoIndent).
	 *
	 * @return bool
	 */
	public function isAutoIndent(): bool
	{
		return $this->docComment->hasAnnotation('autoindent');
	}
}

