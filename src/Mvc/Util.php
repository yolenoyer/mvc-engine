<?php

namespace Mvc;

use \Mvc\Config;


/**
 * Méthodes statiques utiles.
 */
class Util
{
	/**
	 * Renvoie le chemin racine du projet.
	 *
	 * @return string
	 */
	public static function getProjectPath(): string
	{
		static $project_path = null;
		if (is_null($project_path)) {
			$project_path = Config::getMandatoryParameter('project.path');
		}
		return $project_path;
	}
	
	/**
	 * Renvoie la racine url du projet.
	 *
	 * @return string
	 */
	public static function getUrlRoot(): string
	{
		static $url_root = null;
		if (is_null($url_root)) {
			$url_root = self::joinPaths(
				substr(self::getProjectPath(), strlen($_SERVER['DOCUMENT_ROOT']))
			);
		}
		return $url_root;
	}


	/**
	 * Renvoie l'url relative de la requête en cours.
	 *
	 * @return string
	 */
	public static function getRelativeUrl(): string
	{
		static $relative_url = null;
		if (is_null($relative_url)) {
			$relative_url = substr($_SERVER['REQUEST_URI'], strlen(self::getUrlRoot()));
		}
		return $relative_url;
	}


	/**
	 * Joint des chemins entre eux.
	 *
	 * @param ...$args
	 *
	 * @return string
	 */
	public static function joinPaths(...$args): string {
		$paths = array();

		foreach (func_get_args() as $arg) {
			if ($arg !== '') { $paths[] = str_replace('\\', '/', $arg); }
		}

		return preg_replace('#/+#','/',join('/', $paths));
	}


	/**
	 * Interne: utilisé par self::arrayToXml().
	 */
	private static function _array_to_xml($data, &$xml_data) {
		foreach( $data as $key => $value ) {
			if (is_numeric($key)) {
				$key = 'item'.$key; //dealing with <0/>..<n/> issues
			}
			if (is_object($value)) {
				$value = get_object_vars($value);
			}
			if (is_array($value)) {
				$subnode = $xml_data->addChild($key);
				self::_array_to_xml($value, $subnode);
			} else {
				$xml_data->addChild("$key", htmlspecialchars("$value"));
			}
		}
	}


	/**
	 * Convertit récursivement un tableau en document XML.
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public static function arrayToXml($data): string {
		$xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
		self::_array_to_xml($data, $xml_data);
		return $xml_data->asXML();
	}
	
}

