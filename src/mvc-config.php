<?php

(function() {

	$projectPath = realpath(__DIR__.'/..');

	\Mvc\Container::setParameters([
		'project.path'           => $projectPath,
		'templating.templateDir' => "$projectPath/src/App/views",
	]);

})();

