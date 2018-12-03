<?php

namespace Mvc\Http;

use \Mvc\Util;


/**
 * Décrit une réponse HTTP à envoyer.
 */
class Response
{
	private $data;
	private $accept;
	private $mimeType;
	private $code;
	private $body;

	static $supportedMimeTypes = [
		'application/json',
		'text/html',
		'text/plain',
		'application/xml',
	];


	/**
	 * Constructeur.
	 *
	 * @param mixed $data     Données à envoyer
	 * @param string $accept  Types mime demandés
	 * @param int $code       Status HTTP
	 */
	public function __construct($data='', int $code=200, $accept=null)
	{
		$this->setCode($code);

		if (is_null($accept)) {
			$accept = $_SERVER['HTTP_ACCEPT'];
		}
		$this->setContent($data, $accept);
	}



	/**
	 * Définit le contenu et le mimetype en un coup.
	 *
	 * @param mixed $data
	 * @param string $accept
	 *
	 * @return Response  Pour chaînage
	 */
	public function setContent($data, string $accept): Response
	{
		$this->data = $data;
		$this->setAccept($accept); // $this->body est mis à jour ici
		return $this;
	}



	/**
	 * Définit le contenu.
	 *
	 * @param mixed $data
	 *
	 * @return Response  Pour chaînage
	 */
	public function setData($data): Response
	{
		$this->data = $data;
		$this->updateBody();
		return $this;
	}

	/**
	 * Renvoie le contenu actuel.
	 *
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}



	/**
	 * Renvoie le type mime;
	 *
	 * @return string
	 */
	public function getAccept(): string
	{
		return $this->accept;
	}

	/**
	 * Définit le type mime.
	 *
	 * @param string $accept
	 *
	 * @return Response  Pour chaînage
	 */
	public function setAccept(string $accept): Response
	{
		$this->accept = $accept;
		$this->updateMimeType();
		$this->updateBody();
		return $this;
	}



	/**
	 * Met à jour le type mime, suivant la valeur de $this->accept.
	 */
	private function updateMimeType()
	{
		$this->mimeType = self::getBestSupportedMimeType(self::$supportedMimeTypes, $this->accept);
		if (is_null($this->mimeType)) {
			$this->setCode(406); // Not Acceptable
		}
	}



	/**
	 * Renvoie le statut HTTP.
	 *
	 * @return int
	 */
	public function getCode(): int
	{
		return $this->code;
	}

	/**
	 * Définit le statut HTTP.
	 *
	 * @return Response  Pour chaînage
	 */
	public function setCode(int $code): Response
	{
		$this->code = $code;
		return $this;
	}



	/**
	 * Renvoie le body (définit par le contenu et le type mime).
	 *
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->body;
	}



	/**
	 * Envoie effectivement la réponse, avec les headers.
	 */
	public function send()
	{
		http_response_code($this->code);
		header("Content-Type: {$this->mimeType}");
		echo $this->body;
	}



	/**
	 * Met à jour le body, suivant le contenu et le type mime.
	 */
	private function updateBody()
	{
		switch ($this->mimeType) {
			case 'application/xml':
				$this->body = Util::arrayToXml($this->data);
				return;

			case 'text/html':
			case 'text/plain':
				if (is_array($this->data)) {
					$this->body = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
					if ($this->mimeType === 'text/html') {
						$this->body = '<pre>'.$this->body.'</pre>';
					}
				} elseif (is_object($this->data)) {
					break;
				} else {
					try {
						$this->body = (string)$this->data;
					}
					catch (\Error $e) {
					}
				}
				return;

			case 'application/json':
				$this->body = json_encode($this->data);
				return;
		}

		$this->body = '';
	}



	// From https://stackoverflow.com/a/1087498/3271687
	public static function getBestSupportedMimeType(array $mimeTypes = null, $accept=null)
   	{
		// Values will be stored in this array
		$AcceptTypes = Array ();

		if (is_null($accept)) {
			$accept = $_SERVER['HTTP_ACCEPT'];
		}
		// Accept header is case insensitive, and whitespace isn’t important
		$accept = strtolower(str_replace(' ', '', $accept));
		// divide it into parts in the place of a ","
		$accept = explode(',', $accept);
		foreach ($accept as $a) {
			// the default quality is 1.
			$q = 1;
			// check if there is a different quality
			if (strpos($a, ';q=')) {
				// divide "mime/type;q=X" into two parts: "mime/type" i "X"
				list($a, $q) = explode(';q=', $a);
			}
			// mime-type $a is accepted with the quality $q
			// WARNING: $q == 0 means, that mime-type isn’t supported!
			$AcceptTypes[$a] = $q;
		}
		arsort($AcceptTypes);

		// if no parameter was passed, just return parsed data
		if (!$mimeTypes) return $AcceptTypes;

		$mimeTypes = array_map('strtolower', (array)$mimeTypes);

		// let’s check our supported types:
		foreach ($AcceptTypes as $mime => $q) {
			if ($q && in_array($mime, $mimeTypes)) return $mime;
		}
		if (isset($AcceptTypes['*/*'])) {
			return $mimeTypes[0];
		}
		// no mime-type found
		return null;
	}
}

