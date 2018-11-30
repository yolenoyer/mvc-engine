<?php

namespace App\Controller;

use \Mvc\Controller\TemplateController;
use \Mvc\Http\Response;


class ShowNameController extends TemplateController
{
	public function getResponse(): Response
	{
		return $this->getTemplateResponse('show-name', [
			'firstname' => $_POST['firstname'] ?? 'Anonyme',
			'lastname'  => $_POST['lastname']  ?? 'Anonyme',
			'template' => $this->routeParameters->template,
		]);
	}
}

