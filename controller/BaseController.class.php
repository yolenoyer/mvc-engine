<?php

abstract class BaseController
{
	public function __construct(Request $request, string $base_template_name='base')
	{
		$this->request = $request;
		$this->baseTemplateName = $base_template_name;
	}

	public function getTemplateOutput(string $template_name, array $params=[]): string {
		$params = array_merge([], $params);
		$params['request'] = $this->request;
		$params = new ObjectFromArray($params);

		ob_start();
		require "template/{$template_name}.php";
		$content = ob_get_contents();
		ob_end_clean();

		ob_start();
		require "template/{$this->baseTemplateName}.php";
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Renvoie une réponse html (headers compris).
	 *
	 * @param string $template_name  Nom de template
	 * @param array $params          Paramètres à fournir au template
	 * @param int $code              Code à renvoyer
	 *
	 * @return string
	 */
	public function getTemplateResponse(
		string $template_name,
		array $params=[],
		int $code=200
	): string {
		$output = $this->getTemplateOutput($template_name, $params);
		return RestHandler::getResponse($output, 'text/html', $code);
	}

	abstract function getResponse();
}

