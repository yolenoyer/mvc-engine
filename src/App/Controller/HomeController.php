<?php

namespace App\Controller;

use \Mvc\Controller\TemplateController;
use \Mvc\Http\Response;


class HomeController extends TemplateController
{
	public function getResponse(): Response
	{
		return $this->getTemplateResponse('home');
	}
	
}

