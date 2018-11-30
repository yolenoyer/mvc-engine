<?php

namespace Mvc;


class Util
{

	public static function joinPaths(...$args): string {
		$paths = array();

		foreach (func_get_args() as $arg) {
			if ($arg !== '') { $paths[] = str_replace('\\', '/', $arg); }
		}

		return preg_replace('#/+#','/',join('/', $paths));
	}


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


	public static function arrayToXml($data): string {
		$xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
		self::_array_to_xml($data, $xml_data);
		return $xml_data->asXML();
	}
	
}

