<?php

if (file_exists('config.json')){
	header('Content-Type: application/json; charset=utf-8');
	$data = file_get_contents('config.json');
	echo $data;
	unlink('config.json');
} else http_response_code(404);

?>
