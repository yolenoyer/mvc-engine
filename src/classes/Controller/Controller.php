<?php

namespace Controller;


abstract class Controller
{
	protected $request;


	public function __construct(\Http\Request $request)
	{
		$this->request = $request;
	}


	public abstract function getResponse(): \Http\Response;
}

