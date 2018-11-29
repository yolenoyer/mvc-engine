<?php

namespace Autoload;

function try_dir($dir, $class)
{
	$file = $dir . '/' . $class . '.class.php';
	if (file_exists($file)) {
		require_once $file;
		return true;
	}
	return false;
}

spl_autoload_register(function($class) {
	$dirs = [
		'class',
		'class/router',
		'class/util',
		'controller',
		'models',
	];

	foreach ($dirs as $dir) {
		$dir = \Get::ProjectRoot() . '/' . $dir;
		if (try_dir($dir, $class)) {
			return;
		}
	}
});

include __DIR__.'/vendor/autoload.php';

