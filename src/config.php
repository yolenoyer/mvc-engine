<?php

use \Mvc\App;

(function() {

	$projectPath = App::get('projectPath');

	$container = \Mvc\Container::getInstance();
	$container->setParameters([
		'templating.templateDir' => "$projectPath/src/App/views",
	]);

})();

