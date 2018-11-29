<?php

/**
 * Classe de base pour tous les contrôleurs.
 */
abstract class BaseController
{
	public function __construct(Request $request, string $base_template_name='base')
	{
		$this->request = $request;
		$this->baseTemplateName = $base_template_name;
	}


	/**
	 * Renvoie un template processé, contenant les paramètres fournis ainsi qu'un objet 'request'
	 * additionnel.
	 *
	 * @param string $template_name  Nom de template
	 * @param array $params          Paramètres à fournir au template
	 *
	 * @return string
	 */
	public function getTemplateOutput(string $template_name, array $params=[]): string {
		$params = array_merge([], $params);

		$params['request'] = $this->request;

		$params['app'] = [
			'project_root' => \Get::ProjectRoot(),
			'url_root' => \Get::UrlRoot(),
		];

		$params = new ObjectFromArray($params);

		$generator = TemplateGenerator::getInstance();

		return $generator->generate($template_name, $params);
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

