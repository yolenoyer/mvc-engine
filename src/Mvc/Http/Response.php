<?php

namespace Mvc\Http;

use \Mvc\Util;


/**
 * Décrit une réponse HTTP à envoyer.
 */
class Response
{
	private $data;
	private $mimeType;
	private $code;
	private $body;


	/**
	 * Constructeur.
	 *
	 * @param mixed $data       Données à envoyer
	 * @param string $mimeType  Type mime
	 * @param int $code         Status HTTP
	 */
	public function __construct($data, string $mimeType, int $code=200)
	{
		$this->setContent($data, $mimeType);
		$this->setCode($code);
	}



	/**
	 * Définit le contenu et le mimetype en un coup.
	 *
	 * @param $data
	 * @param $mimeType
	 *
	 * @return Response  Pour chaînage
	 */
	public function setContent($data, string $mimeType): Response
	{
		$this->data = $data;
		$this->mimeType = $mimeType;
		$this->updateBody();
		return $this;
	}



	/**
	 * Définit le contenu.
	 *
	 * @param $data
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
	public function getMimeType(): string
	{
		return $this->mimeType;
	}

	/**
	 * Définit le type mime.
	 *
	 * @param string $mimeType
	 *
	 * @return Response  Pour chaînage
	 */
	public function setMimeType($mimeType): Response
	{
		$this->mimeType = $mimeType;
		$this->updateBody();
		return $this;
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
				$this->body = (string)$this->data;
				return;

			case 'application/json':
			default:
				$this->mimeType = 'application/json';
				$this->body = json_encode($this->data);
		}
	}

}

