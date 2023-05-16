<?php

/**
 * Обработка поступающих голосовых команд и выдача команд для
 */

include '../utils/func.php';
date_default_timezone_set('Europe/Ulyanovsk');
$type = $_REQUEST['type'];
$locales = explode(' ', $_REQUEST['text']);
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
		foreach ($json_v as $name=>$video){
            // If the locale is found in the video name, set the locale in the config array
            if (in_array($locale, explode(' ',$name)))
				$config['locale'] = $name;
        }
    }
}

if ($type=='map'){
	$json_map[$_REQUEST['chunk']] = $_REQUEST['checked'];
	file_put_contents('../map.json', json_encode($json_map));
}
 // Get the file creation time of the image.png file
$filetime = filectime('../image.png');//windows
 // Get the contents of the status.ini file
$testtime = file_get_contents('../status.ini');
 // If the file creation time is different from the contents of the status.ini file
if ($filetime!=$testtime)  {
	$config['command'] = 'reloadImage';
 	// Write the file creation time to the status.ini file
	file_put_contents('../status.ini', $filetime);
}
 // If the config array is not empty, write it to the config.json file
if ($config) file_put_contents('../config.json', json_encode($config));
echo 'ok';