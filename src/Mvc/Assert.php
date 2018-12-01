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
	 * @param $cond     Condition à vérifier
	 * @param $message  Message à transmettre en cas d'exception
	 */
	public static function isTrue($cond, $message)
	{
		if (!$cond) {
			throw new \Mvc\Exception($message);
		}
	}
}

