<?php

namespace Controller;


class HomeController extends BaseController
{
	public function getResponse(): \Http\Response
	{
		return $this->getTemplateResponse('home');
	}
	
}

