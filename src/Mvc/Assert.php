<?php

namespace Mvc;


/**
 * Gère les assertions.
 */
class Assert
{
	/**
	 * S'assure qu'une condition donnée est vraie.
	 *
	 * @param mixed $cond      Condition à vérifier
	 * @param string $message  Message à transmettre en cas d'exception
	 */
	public static function mustBeTrue($cond, string $message)
	{
		if (!$cond) {
			throw new \Mvc\Exception($message);
		}
	}


	/**
	 * S'assure qu'une condition donnée est fausse.
	 *
	 * @param mixed $cond      Condition à vérifier
	 * @param string $message  Message à transmettre en cas d'exception
	 */
	public static function mustBeFalse($cond, string $message)
	{
		self::mustBeTrue(!$cond, $message);
	}


	/**
	 * S'assure que la valeur indiquée n'est pas nulle.
	 *
	 * @param mixed $value     Valeur à vérifier
	 * @param string $message  Message à transmettre en cas d'exception
	 */
	public static function mustBeNotNull($value, string $message)
	{
		self::mustBeTrue(!is_null($value), $message);
	}


	/**
	 * S'assure que la chaine indiquée n'est pas vide.
	 *
	 * @param string $value    Chaine à vérifier
	 * @param string $message  Message à transmettre en cas d'exception
	 */
	public static function mustBeNotEmpty(string $value, string $message)
	{
		self::mustBeTrue($value !== '', $message);
	}

}

