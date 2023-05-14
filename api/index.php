<?php
date_default_timezone_set('Europe/Ulyanovsk');
$type = $_REQUEST['type'];
$locales = explode(' ', $_REQUEST['text']);
$path_c = '../config.json';
$config = [];

$path = '../videos.json';
$json_v = json_decode(file_get_contents($path), 1);

$json_command = json_decode(file_get_contents('../commands.json'), 1);
echo '<pre>';
if ($type=='locale'){

   	foreach ($json_command as $phrase=>$command){
       if (strpos($_REQUEST['text'],$phrase)!==false) {
		   $config['command'] = $command;
		   if ($phrase=='таймер' && intval($locales[1])) $config['command'] = str_replace('()',"($locales[1])",$command);
	   }
    }
	var_dump($json_v);
	// для каждого слова из команды
	foreach ($locales as $locale) {
		// поиск видео для слова из команды
		foreach ($json_v as $name=>$video){
            if (in_array($locale, explode(' ',$name))) $config['locale'] = $name;
        }
    }
}

$filetime = filectime('../image.png');//windows
$testtime = file_get_contents('../status.ini');
if ($filetime!=$testtime)  {
	$config['command'] = 'reloadImage';
	file_put_contents('../status.ini', $filetime);
}
var_dump($filetime);
var_dump($testtime);
var_dump($config);
if ($config) file_put_contents($path_c, json_encode($config));
echo 'ok';