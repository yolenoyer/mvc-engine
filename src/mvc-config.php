<?php

use \Mvc\App;


(function() {

	$projectPath = App::get('projectPath');

	\Mvc\Container::setParameters([
		'templating.templateDir' => "$projectPath/src/App/views",
	]);

})();

