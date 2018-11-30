<?php

namespace Controller;


/**
 * Classe de base pour tous les contrôleurs renvoyant un template.
 */
abstract class TemplateController extends Controller
{

	/**
	 * Renvoie un template processé, contenant les paramètres fournis ainsi qu'un objet 'request'
	 * additionnel.
	 *
	 * @param string $template_name  Nom de template
	 * @param array $params          Paramètres à fournir au template
	 *
	 * @return string
	 */
	protected function getTemplateOutput(string $template_name, array $params=[]): string {
		$params = array_merge([], $params);

		$params['request'] = $this->request;

		$params['app'] = [
			'project_path' => \App::get('projectPath'),
			'url_root' => \App::get('urlRoot'),
		];

		$params = new \ObjectFromArray($params);
		$processor = \Templating\Processor::getInstance();
		$output = $processor->generate($template_name, $params);

		return $output;
	}


	/**
	 * Renvoie une réponse html à partir d'un template (headers compris).
	 *
	 * @param string $template_name  Nom de template
	 * @param array $params          Paramètres à fournir au template
	 * @param int $code              Code à renvoyer
	 *
	 * @return \Http\Response
	 */
	protected function getTemplateResponse(
		string $template_name,
		array $params=[],
		int $code=200
	): \Http\Response {
		$output = $this->getTemplateOutput($template_name, $params);
		return new \Http\Response($output, 'text/html', $code);
	}

}

