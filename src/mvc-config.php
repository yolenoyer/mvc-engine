<?php

(function() {

	$projectPath = realpath(__DIR__.'/..');

	\Mvc\Config::setParameters([
		'project.path'           => $projectPath,
		'templating.templateDir' => "$projectPath/src/App/views",
		'database.connection' => [
			'type' => 'mysql',
		   	'host' => 'localhost',
			'dbname' => 'mvcengine',
			'username' => 'root',
			'password' => '',
		],
	]);

})();

@include "mvc-extra.php";

