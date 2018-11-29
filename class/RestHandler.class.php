<?php

class RestHandler
{

	public static function getResponse($data, string $format, int $code=200)
	{
		switch ($format) {

			case 'application/xml':
				$ret = Util::arrayToXml($data);
				break;

			case 'text/html':
			case 'text/plain':
				try {
					$ret = (string) $data;
				}
				catch (Exception $e) {
					$ret = '';
				}
				break;

			default:
				$format = 'application/json';
				/* no break */

			case 'application/json':
				$ret = json_encode($data);

		}

		http_response_code($code);
		header("Content-Type: $format");

		return $ret;
	}


	public static function get404()
	{
		return self::getResponse('', 'text/plain', 404);
	}
	
}

