<?php

namespace Mvc\Controller;

use \Mvc\ObjectFromArray;
use \Mvc\Http\Response;
use \Mvc\Util;
// TODO:
// use \Mvc\Templating\Processor;


/**
 * Classe de base pour tous les contrôleurs renvoyant un template.
 */
abstract class TemplateController extends Controller
{

	/**
	 * Renvoie un template processé, contenant les paramètres fournis ainsi qu'un objet 'request'
	 * additionnel.
	 *
	 * @param string $template_name    Nom de template
	 * @param ObjectFromArray $params  Paramètres à fournir au template
	 *
	 * @return string
	 */
	protected function getTemplateOutput(string $template_name, $params=null): string {
		if (is_null($params)) {
			$params = new ObjectFromArray([]);
		} else {
			$params = new ObjectFromArray($params->array);
		}

		$params->request = $this->request;

		$params->app = [
			'project_path' => Util::getProjectPath(),
			'url_root' => Util::getUrlRoot(),
		];

		$processor = \Mvc\Templating\Processor::getInstance();
		$output = $processor->process($template_name, $params);

		return $output;
	}


	/**
	 * Renvoie une réponse html à partir d'un template (headers compris).
	 *
	 * @param string $template_name    Nom de template
	 * @param ObjectFromArray $params  Paramètres à fournir au template
	 * @param int $code                Code à renvoyer
	 *
	 * @return \Mvc\Http\Response
	 */
	protected function getTemplateResponse(
		string $template_name,
		$params=[],
		int $code=200
	): Response {
		if (is_array($params)) {
			$params = new ObjectFromArray($params);
		}

		$output = $this->getTemplateOutput($template_name, $params);
		return new Response($output, 'text/html', $code);
	}

}

