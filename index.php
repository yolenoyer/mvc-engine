<?php

try {
	require 'src/bootstrap.php';
}
catch (\Throwable $e) {
	http_response_code(500);
	echo "<pre>\n";
	echo $e;
}

