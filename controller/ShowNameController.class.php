<?php

class ShowNameController extends BaseController
{
	public function getResponse(): string
	{
		return $this->getTemplateResponse('show-name', [
			'firstname' => $_POST['firstname'] ?? 'Anonyme',
			'lastname'  => $_POST['lastname']  ?? ''
		]);
	}
}

