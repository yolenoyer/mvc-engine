<?php

class HomeController extends BaseController
{
	public function getResponse(): string
	{
		return $this->getTemplateResponse('home');
	}
	
}

