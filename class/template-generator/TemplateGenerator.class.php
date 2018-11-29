<?php

class TemplateGenerator
{
	public function __construct(string $templates_dir)
	{
		$this->templatesDir = $templates_dir;
	}


	/**
	 * Retourne une instance unique de TemplateGenerator (singleton).
	 *
	 * @return TemplateGenerator
	 */
	static function getInstance(): TemplateGenerator {
		static $instance = null;
		if (is_null($instance)) {
			$instance = new TemplateGenerator(\Get::ProjectRoot() . '/template');
		}
		return $instance;
	}


	/**
	 * Retourne un nom de fichier template à partir de son nom.
	 *
	 * @param string $template_name  Nom de template
	 *
	 * @return string
	 */
	function getTemplateFile(string $template_name): string
	{
		return "{$this->templatesDir}/{$template_name}.php.template";
	}


	/**
	 * Processe le contenu d'une chaine.
	 *
	 * @param string $output  Données à processer
	 * @param $params         Paramètres accessibles
	 *
	 * @return string
	 */
	public static function process(string $output, ObjectFromArray $params)
	{
		return preg_replace_callback('/\[\[([^[]*)\]\]/', function($matches) use($params) {
			$tag = trim($matches[1]);

			$parts = explode('.', $tag);

			$data = $params;
			foreach ($parts as $part) {
				$data = $data->$part;
			}
			
			return $data;
		}, $output);
	}



	/**
	 * Processe un template.
	 *
	 * @param string $template_name  Nom du template
	 * @param $params                Paramètres à fournir au template
	 *
	 * @return string
	 */
	function generate(string $template_name, ObjectFromArray $params): string
	{
		ob_start();
		require $this->getTemplateFile($template_name);
		$content = ob_get_contents();
		ob_end_clean();

		// TODO: permettre l'héritage dans les templates:
		ob_start();
		require $this->getTemplateFile('base');
		$output = ob_get_contents();
		ob_end_clean();

		$output = self::process($output, $params);

		return $output;
	}

}

