<?php

/**
 * Обработка поступающих голосовых команд и выдача команд для
 */

include '../utils/func.php';
date_default_timezone_set('Europe/Ulyanovsk');
$type = $_REQUEST['type'];
$locales = empty($_REQUEST['text'])?[]:explode(' ', $_REQUEST['text']);
 // Initialize the config array
$config = [];

$path = '../videos.json';
 // Get the contents of the videos.json file and decode the JSON into an array
$json_v = json_decode(file_get_contents($path), 1);

$json_command = json_decode(file_get_contents('../commands.json'), 1);
$image_command = json_decode(file_get_contents('../images.json'), 1);
$json_map = json_decode(file_get_contents('../map.json'), 1);
if ($type=='locale'){
     // Loop through each phrase and command in the commands.json file
   	foreach ($json_command as $phrase=>$command){
       // If the phrase is found in the locales parameter
       if (strpos($_REQUEST['text'],$phrase)!==false) {
           $config['command'] = selectCommand(compact(['phrase', 'command', 'locales']));
       }
    }

   	foreach ($image_command as $phrase=>$image){
   	    if (strpos($_REQUEST['text'],$phrase)!==false) {
		   $config['command'] = "loadDemo('".$image."');";
	   }
    }
	// для каждого слова из команды
	foreach ($locales as $locale) {
 		// Loop through each video name and URL in the json_v array
		foreach ($json_v as $video=>$name){
            // If the locale is found in the video name, set the locale in the config array
            if (in_array($locale, explode(' ',$name)))
				$config['locale'] = $video;
        }
    }
}

if ($type=='map'){
	$json_map[$_REQUEST['chunk']] = $_REQUEST['checked'];
	file_put_contents('../map.json', json_encode($json_map,JSON_PRETTY_PRINT));
}


if ($type=='videos'){
    $new_videos = $_REQUEST['videos'];
    var_dump($new_videos);
    foreach ($new_videos as $video=>$key){
        if ($key) $json_v[$video] = $key;
        else unset($json_v[$video]);
    }
    file_put_contents('../videos.json', json_encode($json_v,JSON_PRETTY_PRINT));
}


if ($type=='init'){
    $init = $_REQUEST['init'];
    var_dump($init);
    saveJson('../init.json', $init);
}


 // If the config array is not empty, write it to the config.json file
if ($config) file_put_contents('../config.json', json_encode($config));
echo 'ok';