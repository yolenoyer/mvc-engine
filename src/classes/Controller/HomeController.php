<?php

namespace Controller;


class HomeController extends TemplateController
{
	public function getResponse(): \Http\Response
	{
		return $this->getTemplateResponse('home');
	}
	
}

