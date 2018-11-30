<?php

namespace Controller;


class ShowNameController extends TemplateController
{
	public function getResponse(): \Http\Response
	{
		return $this->getTemplateResponse('show-name', [
			'firstname' => $_POST['firstname'] ?? 'Anonyme',
			'lastname'  => $_POST['lastname']  ?? 'Anonyme',
		]);
	}
}

