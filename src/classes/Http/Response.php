<?php

namespace Http;


class Response
{
	private $data;
	private $mimeType;
	private $code;
	private $body;


	public function __construct($data, string $mimeType, int $code=200)
	{
		$this->setContent($data, $mimeType);
		$this->setCode($code);
	}



	public function setContent($data, string $mimeType)
	{
		$this->data = $data;
		$this->mimeType = $mimeType;
		$this->updateBody();
		return $this;
	}



	public function setData($data)
	{
		$this->data = $data;
		$this->updateBody();
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}



	public function getMimeType()
	{
		return $this->mimeType;
	}

	public function setMimeType($mimeType)
	{
		$this->mimeType = $mimeType;
		$this->updateBody();
		return $this;
	}



	public function getCode()
	{
		return $this->code;
	}

	public function setCode($code)
	{
		$this->code = $code;
		return $this;
	}



	public function getBody()
	{
		return $this->body;
	}



	public function send()
	{
		http_response_code($this->code);
		header("Content-Type: {$this->mimeType}");
		echo $this->body;
	}



	private function updateBody()
	{
		switch ($this->mimeType) {
			case 'application/xml':
				$this->body = \Util::arrayToXml($this->data);
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

