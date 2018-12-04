<?php

namespace Mvc;


/**
 * Gère les assertions.
 */
class Assert
{
	/**
	 * Envoie une exception.
	 *
	 * @param string $message  Message à envoyer
	 */
	public static function throwAssert(string $message)
	{
		throw new \Mvc\Exception($message);
	}


	/**
	 * S'assure qu'une condition donnée est vraie.
	 *
	 * @param mixed $cond      Condition à vérifier
	 * @param string $message  Message à transmettre en cas d'exception
	 */
	public static function mustBeTrue($cond, string $message)
	{
		if (!$cond) {
			self::throwAssert($message);
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
	 * S'assure que la valeur indiquée est nulle.
	 *
	 * @param mixed $value     Valeur à vérifier
	 * @param string $message  Message à transmettre en cas d'exception
	 */
	public static function mustBeNull($value, string $message)
	{
		self::mustBeTrue(is_null($value), $message);
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


	/**
	 * S'assure qu'une clé existe dans un tableau.
	 *
	 * @param array $arr
	 * @param string $key
	 * @param string $message
	 */
	public static function mustKeyExist(array $arr, string $key, string $message)
	{
		self::mustBeTrue(isset($arr[$key]), $message);
	}
	

	/**
	 * S'assure que la valeur donnée possède le bon type.
	 *
	 * @param mixed $value
	 * @param string $type
	 * @param string $message
	 */
	public static function mustHaveType($value, string $type, string $message)
	{
		self::mustBeTrue(gettype($value) === $type, $message);
	}
	
}

